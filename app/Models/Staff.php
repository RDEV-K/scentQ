<?php

namespace App\Models;

use App\Notifications\StaffResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    function getAvatarAttribute($avatar)
    {
        if (empty($avatar)) {
            $avatar = 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '.jpg?s=200&d=mm';
        }
        return $avatar;
    }

    function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /**
     * @param mixed $cap
     * @param bool $and
     * @return bool
     */
    public function hasCap($cap, $and = true)
    {
        if (empty($this->role_id)) return true; // It is super admin :)
        if (!isset($this->role)) return false;
        if (!is_array($this->role->caps)) return false;

        if (is_array($cap)) {
            if ($and) {
                $intersection = array_intersect($this->role->caps, $cap);
                if (count($intersection) == count($cap)) return true;
            } else {
                return (bool)array_intersect($this->role->caps, $cap);
            }
        } else {
            if (in_array($cap, $this->role->caps)) return true;
        }

        return false;

    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new StaffResetPassword($token));
    }
}
