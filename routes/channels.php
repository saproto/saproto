<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
     * Authenticate the user's personal channel...
 */
Broadcast::channel('App.User.*', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('wallstreet-prices.{wallstreetId}', function ($user, $wallstreetId) {
    return Auth::user()->can('tipcie');
});
