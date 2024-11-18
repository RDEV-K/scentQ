<?php

namespace App\Traits;

use App\Models\User;

trait SetNameTrait
{
    public function setName(User $user, string $name): void
    {
        $user->update([
            'first_name' => $name ?? 'Anonymous',
        ]);
    }
}
