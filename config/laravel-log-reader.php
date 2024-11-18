<?php

return [
    'api_route_path' => 'staff/api/logs',
    'view_route_path' => 'staff/logs',
    'admin_panel_path' => 'staff/dashboard',
    'middleware' => ['web', 'auth:staff', 'able:manage_setting']
];
