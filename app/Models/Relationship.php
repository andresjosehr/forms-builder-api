<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'entity_id',
        'related_entity_id',
        'relation_type_id'
    ];

    public function relationshipType() {
        return $this->belongsTo(RelationType::class, 'relation_type_id', 'id');
    }

    public function entity() {
        return $this->belongsTo(Entity::class);
    }
}
