<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['formatted_created_at'];

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

    function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function votes()
    {
        return $this->hasMany(ReviewUserVote::class);
    }

    function terms()
    {
        return $this->belongsToMany(Term::class, 'review_term_relation');
    }

    function getFormattedCreatedAtAttribute()
    {
        return $this->created_at?->format('F d, Y');
    }

    function getReviewerAvatarAttribute($value)
    {
        if (empty($avatar) && $value == 'https://via.placeholder.com/200') {
            $name = trim(collect(explode(' ', $this->reviewer_name))->map(function ($segment) {
                return mb_substr($segment, 0, 1);
            })->join(' '));

            return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=000&background=d1c095';
            // $avatar = 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '.jpg?s=200&d=mm';
        }
        return $value;
    }
}
