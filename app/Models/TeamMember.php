<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = [
        'image_full_path'
    ];

    public function getImageFullPathAttribute()
    {
        return asset($this->img_url);
    }
}
