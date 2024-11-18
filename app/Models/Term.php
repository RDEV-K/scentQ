<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $guarded = ['id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = $this->getPrimaryDatabase();
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

    function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id', 'id');
    }

    function metas()
    {
        return $this->morphMany(Meta::class, 'holder');
    }

    function reviews()
    {
        return $this->belongsToMany(Review::class, 'review_term_relation');
    }
}
