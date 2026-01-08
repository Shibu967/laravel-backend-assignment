<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

Broadcast::channel('active-users', function () {


    if (Auth::guard('admin')->check()) {
        $admin = Auth::guard('admin')->user();
        return [
            'id'   => $admin->id,
            'name' => $admin->name,
            'role' => 'admin',
        ];
    }


    if (Auth::guard('web')->check()) {
        $user = Auth::guard('web')->user();
        return [
            'id'   => $user->id,
            'name' => $user->name,
            'role' => 'customer',
        ];
    }


    return false;
});
