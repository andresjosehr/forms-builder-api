<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label',
        'code',
        'built_creation',
        'built_edition',
        'field_type_id',
        'input_type_id',
        'related_entity_id',
        'searchable',
        'visible',
        'step',
        'editable',
        'entity_id'
    ];

    public function options() {
        return $this->hasMany(FieldOption::class);
    }

    public function sqlProperties() {
        return $this->hasOne(SqlProperty::class);
    }

    public function relationshipProperties() {
        return $this->hasOne(RelationshipProperty::class, 'field_id', 'id');
    }

    public function inputType() {
        return $this->belongsTo(InputType::class);
    }

    public function fieldType(){
        return $this->belongsTo(FieldType::class);
    }

    public function validations(){
        return $this->belongsToMany(Validation::class)->withPivot('value');
    }

    public function entity(){
        return $this->belongsTo(Entity::class);
    }

    public function relatedEntity(){
        return $this->belongsTo(Entity::class, 'related_entity_id', 'id');
    }


}
