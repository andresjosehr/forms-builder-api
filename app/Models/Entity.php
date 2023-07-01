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
        'frontend_path',
        'searchable_list',
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
}
