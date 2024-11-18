<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    protected $guarded = ['id'];

    function terms()
    {
        return $this->hasMany(Term::class, 'taxonomy_id', 'id');
    }

    function metas()
    {
        return $this->morphMany(Meta::class, 'holder');
    }
}
