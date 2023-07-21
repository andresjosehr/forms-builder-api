<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class GlobalController extends Controller
{
    public function getOptionsForSelect(){

        $data = [];

        $data['input_types'] = \App\Models\InputType::all();
        $data['relation_types'] = \App\Models\RelationType::all();
        $data['sql_property_types'] = \App\Models\SqlPropertyType::all();
        $data['validations'] = \App\Models\Validation::all();
        $data['entities'] = \App\Models\Entity::where('layout', 1)->get();

        return ApiResponseController::response('Consulta Exitosa', 200, $data);

    }


    static public function translateToEnglish($objetToTranslate){
        $apiKey = getenv('OPENAI_API_KEY');

        $client = OpenAI::client($apiKey);

        $objectString = json_encode($objetToTranslate);
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un algoritmo de traduccion de español a ingles. Un arreglo de objetos con las siguientes propiedades: id, name, label, table. Usaras el valor del atributo name, lo traduciras al ingles y lo pondras como valor en la propiedad label. Ejemplo // Sin traducir [{ "id": 2, "name": "", "label": "Casa", "table": "fields" }, { "id": 3, "name": "", "label": "Sol", "table": "entities" } ] // Traducido [{ "id": 2, "name": "House", "label": "Casa", "table": "fields" }, { "id": 3, "name": "Sun", "label": "Sol", "table": "entities" } ]'],
                ['role' => 'user', 'content' => $objectString],
            ],
        ]);

        return $response->choices[0]->message->content;
    }

    public function checkLog(){
        // Return log.txt content from storage/logs
        return file_get_contents(storage_path('app/public/z-build.log'));
    }
}
