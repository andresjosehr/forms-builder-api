<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelationshipProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_id',
        'related_entity_id',
        'related_field_id',
        'relation_type_id'
    ];

    public function relationType() {
        return $this->belongsTo(RelationType::class);
    }
}
