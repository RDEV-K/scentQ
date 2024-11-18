<?php

namespace App\Handlers;

class LfmConfigHandler extends \UniSharp\LaravelFilemanager\Handlers\ConfigHandler
{
    public function userField()
    {
        if (auth('staff')->check()) return 'staff-' . auth('staff')->id();
        return 'user-' . auth()->id();
    }
}
