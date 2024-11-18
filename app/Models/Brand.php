<?php

namespace App\Models;

use App\Helpers\MenuAble;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Brand extends Model
{
    use HasFactory, MenuAble, Searchable;

    protected $guarded = ['id'];
    protected $casts = [
        'blogs' => 'array'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = $this->getPrimaryDatabase();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
        ];
    }

    protected function getPrimaryDatabase(): string
    {
        // this system only applies for the UK domain

        $domain = getCurrentDomain();
        $database = 'mysql';

        // If it is scentq.co.uk
        if ($domain === 'scentq.co.uk') {
            $database = 'mysql_primary';
        }

        return $database ?? 'mysql';
    }

    function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    function metas()
    {
        return $this->morphMany(Meta::class, 'holder');
    }

    function getItemText()
    {
        return $this->name;
    }

    function getItemUrl()
    {
        return route('brand', $this->slug);
    }
}
