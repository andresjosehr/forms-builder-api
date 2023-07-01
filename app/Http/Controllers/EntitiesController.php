<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Entity;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $entities = $request->entities;


            foreach ($entities as $data) {
                $entity = $this->createOrUpdateEntity($data);
                $this->createOrUpdateFields($entity, $data);
            }

            foreach ($entities as $entityData) {

                $this->createOrUpdateRelationships($entityData, $data);
                $this->updateRelatedEntityId($entityData, $data);
            }

        } catch (\Exception $e) {
            DB::rollback();
            // Laravel error handling
            return throw $e;

        }
        DB::commit();

        $build = $this->buildEntities($entities, $data);

        if ($build) {
            sleep(5);

            shell_exec("rm ".storage_path('app/public/z-build.log'));
        }


        $entities = Entity::with('fields', 'fields.inputType', 'fields.fieldType', 'fields.sqlProperties', 'fields.sqlProperties.sqlType', 'fields.sqlProperties.relatedEntity', 'fields.options', 'fields.validations', 'relationships', 'relationships.entity', 'relationships.relationshipType')->get();
        return ApiResponseController::response('Entity created successfully', 200, $entities);
    }

    private function createOrUpdateEntity($data)
    {
        $entity = $data['id'] ? Entity::find($data['id']) : new Entity();

        $entity->fill([
            'name' => $data['name'],
            'label' => $data['label'],
            'code' => $data['code'],
            'built_edition' => $data['built_edition'],
            'frontend_path' => $data['path'],
            'searchable_list' => $data['searchable_list'],
            'app_id' => $data['app_id']
        ]);

        $entity->save();

        return $entity;
    }

    private function createOrUpdateFields($entity, $data)
    {
        $debug = [];
        if (!$data['fields']) {
            return;
        }

        foreach ($data['fields'] as $field) {
            $debug[] = $this->createOrUpdateField($entity, $field);
        }

        return $debug;
    }

    private function createOrUpdateField($entity, $field)
    {

        $fieldData = [
            'name' => $field['name'],
            'label' => $field['label'],
            'code' => $field['code'],
            'built_edition' => $field['built_edition'],
            'field_type_id' => $field['field_type_id'],
            'input_type_id' => $field['input_type_id'],
            'searchable' => $field['searchable'],
            'visible' => $field['visible'],
            'editable' => $field['editable'],
            'entity_id' => $entity->id
        ];

        $createdField = $entity->fields()->where('id', $field['id'])->first();
        if($createdField){
            $fieldData['built_edition'] = !$createdField->built_edition ? false : $fieldData['built_edition'];
            $createdField->update($fieldData);
        }


        $createdField = $entity->fields()->updateOrCreate(
            ['id' => $field['id']],
            $fieldData
        );


        $this->createOrUpdateOptions($createdField, $field);
        $this->createOrUpdateSqlProperties($createdField, $field);
        $this->syncValidations($createdField, $field);

        return $fieldData['built_edition'];

    }

    private function createOrUpdateOptions($createdField, $field)
    {
        if (!$field['options']) {
            return;
        }

        $createdField->options()->delete();
        foreach (explode(',', $field['options']) as $option) {
            $createdField->options()->create([
                'name' => trim($option),
                'field_id' => $createdField->id
            ]);
        }
    }

    private function createOrUpdateSqlProperties($createdField, $field)
    {
        $createdField->sqlProperties()->updateOrCreate(
            ['field_id' => $createdField->id],
            [
                'sql_property_type_id' => $field['sqlProperties']['sql_property_type_id'],
                'length' => $field['sqlProperties']['length'],
                'nullable' => $field['sqlProperties']['nullable'],
                'field_id' => $createdField->id
            ]
        );
    }


    private function createOrUpdateRelationships($entityData, $data)
    {
        foreach ($entityData['relationships'] as $relationShip) {
            $relatedEntityID = Entity::where('code', $relationShip['related_entity_id'])->where('app_id', $data['app_id'])->first()->id;
            $entityDB = Entity::where('code', $entityData['code'])->where('app_id', $data['app_id'])->first();

            $entityDB->relationships()->updateOrCreate(
                [
                    'id' => $relationShip['id'],
                ],
                [
                    'entity_id' => $entityDB->id,
                    'related_entity_id' => $relatedEntityID,
                    'relation_type_id' => $relationShip['relation_type_id'],
                ]
            );


        }
    }

    private function syncValidations($fieldDB, $data){
        $fieldDB->validations()->sync($data['validations']);
    }

    private function updateRelatedEntityId($entityData, $data)
    {
        foreach ($entityData['fields'] as $field) {
            if ($field['sqlProperties']['related_entity_id']) {
                $relatedEntitySqlId = Entity::where('code', $field['sqlProperties']['related_entity_id'])->where('app_id', $data['app_id'])->first()->id;
                $entityDB = Entity::where('code', $entityData['code'])->where('app_id', $data['app_id'])->first();
                $field = Field::where('code', $field['code'])->where('entity_id', $entityDB->id)->first();

                $field->sqlProperties()->updateOrCreate(
                    ['field_id' => $field->id],
                    [
                        'related_entity_id' => $relatedEntitySqlId
                    ]
                );
            }
        }
    }

    private function buildEntities($entities, $data)
    {
        $build = [];
        foreach ($entities as $entity) {
            $build[] = $this->buildEntity($entity, $data);
        }

        return $build;
    }

    private function buildEntity($entity, $data)
    {
        $entityBD = Entity::where('code', $entity['code'])->where('app_id', $data['app_id'])
            ->with('fields', 'fields.inputType', 'fields.fieldType', 'fields.sqlProperties', 'fields.sqlProperties.sqlType', 'fields.sqlProperties.relatedEntity', 'fields.options', 'relationships', 'relationships.entity', 'relationships.relationshipType')->first();

        $app = App::find($data['app_id']);

        $appPath = "C:/laragon/www/" . $app->code;
        $build = false;
        if ($entity['build']) {


            $build = true;

            $apiUrl = env('APP_URL');

            shell_exec("sh ".storage_path('app/public/build-entity-angular.bash')." $entityBD->id $apiUrl $appPath");

            $entityNameLower = strtolower($entityBD->name);
            $postBuildPath = "$appPath/app/$entityBD->frontend_path/$entityNameLower" . "s";

            shell_exec("sh ".storage_path('app/public/remove-spaces.sh')." '$postBuildPath'");
            shell_exec("sh ".storage_path('app/public/build-entity-laravel.bash')." '$appPath' '$entityBD'");

            $entityBD->update(['built_creation' => true, 'built_edition' => true]);
            $entityBD->fields()->update(['built_creation' => true, 'built_edition' => true]);
        }


        $entityBD->save();

        return $build;
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entities = Entity::with('fields', 'fields.inputType', 'fields.fieldType', 'fields.sqlProperties', 'fields.sqlProperties.sqlType', 'fields.sqlProperties.relatedEntity', 'fields.options', 'fields.validations', 'relationships', 'relationships.entity', 'relationships.relationshipType')->where('app_id', $id)->get();

        return ApiResponseController::response('Entities retrieved successfully', 200, $entities);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEntity($id)
    {
        $entities = Entity::with('fields', 'fields.inputType', 'fields.fieldType', 'fields.sqlProperties', 'fields.sqlProperties.sqlType', 'fields.sqlProperties.relatedEntity', 'fields.options', 'fields.validations', 'relationships', 'relationships.entity', 'relationships.relationshipType')->where('id', $id)->first();

        return ApiResponseController::response('Entities retrieved successfully', 200, $entities);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        // Delete on cascade
        $entity = Entity::find($id);

        $apiUrl = env('APP_URL');
        $appPath = "C:/laragon/www/" . $entity->app->code;

        $output = shell_exec("sh ".storage_path('app/public/delete-entity-angular.bash')." $entity->id $apiUrl $appPath");

        $fields = $entity->fields()->get();

        // foreach ($fields as $field) {
        //     $field->options()->delete();
        //     $field->sqlProperties()->delete();
        // }

        // $entity->fields()->delete();




        // $entityNameLower = strtolower($entity->name);
        // $entityFrontPath = "$appPath/app/$entity->frontend_path/$entityNameLower" . "s";

        // $entity->delete();

        return ApiResponseController::response('Entity deleted successfully', 200, [$output]);
    }





    private function getEnglishNames($entities){
        $entities = Entity::with('fields')->whereIn('label', array_column($entities, 'label'))->where('app_id', $entities[0]['app_id'])->get();

        $data = [];
        $entities->map(function ($entity) use (&$data) {
            $data[] = [
                'id' => $entity->id,
                'name' => '',
                'label' => $entity->label,
                'table' => 'entities'
            ];

            $entity->fields()->get()->map(function ($field) use (&$data) {
                $data[] = [
                    'id' => $field->id,
                    'name' => '',
                    'label' => $field->label,
                    'table' => 'fields'
                ];
            });
        });

        $data = GlobalController::translateToEnglish($data);
        $data = json_decode($data, true);

        foreach ($data as $key => $value) {
            // replace spaces with underscore and lowercase
            $name = strtolower(str_replace(' ', '_', $value['name']));
            DB::table($value['table'])->where('id', $value['id'])->update(['name' => $name]);
        }
    }

    public function deleteField($id){
        $field = Field::find($id);

        // Update entity and set built_edition to false
        $field->entity()->update(['built_edition' => false]);


        $field->options()->delete();
        $field->sqlProperties()->delete();

        $field->delete();

        return ApiResponseController::response('Field deleted successfully', 200);

    }
}
