<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SqlProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'sql_property_type_id',
        'length',
        'field_id',
        'related_entity_id',
        'nullable'
    ];

    public function sqlType() {
        return $this->belongsTo(SqlPropertyType::class, 'sql_property_type_id', 'id');
    }

    public function relatedEntity() {
        return $this->belongsTo(Entity::class, 'related_entity_id', 'id');
    }
}
