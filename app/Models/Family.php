<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;
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

    function users()
    {
        return $this->belongsToMany(User::class, 'user_family_relation');
    }

    function quiz_options()
    {
        return $this->belongsToMany(QuizItemOption::class, 'family_quiz_item_option_relation');
    }
}
