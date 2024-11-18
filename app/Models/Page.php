<?php

namespace App\Models;

use App\Helpers\MenuAble;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use MenuAble;
    protected $guarded = ['id'];
    protected $casts = ['sections' => 'array'];

    function metas()
    {
        return $this->morphMany(Meta::class, 'holder');
    }

    function getItemText()
    {
        return $this->title;
    }

    function getItemUrl()
    {
        return route('page', $this->slug);
    }
}
