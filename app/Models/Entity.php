<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'label',
        'code',
        'built_creation_layout_1',
        'built_edition_layout_1',

        'built_creation_layout_2',
        'built_edition_layout_2',

        'frontend_path',
        'app_id'
    ];

    public function fields() {
        return $this->hasMany(Field::class);
    }

    public function relationships() {
        return $this->hasMany(Relationship::class);
    }

    public function app(){
        return $this->belongsTo(App::class);
    }

    public function steps(){
        return $this->hasMany(Step::class);
    }
}
