<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizItem extends Model
{
    protected $guarded = ['id'];

    function options()
    {
        return $this->hasMany(QuizItemOption::class, 'quiz_item_id', 'id');
    }

    function showIf()
    {
        return $this->belongsTo('App\\Models\\QuizItem', 'show_if_id', 'id');
    }

    function showIfOption()
    {
        return $this->belongsTo(QuizItemOption::class, 'show_if_option_id', 'id');
    }
}
