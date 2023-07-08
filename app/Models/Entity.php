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
        'built_creation',
        'built_edition',
        'layout',

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
