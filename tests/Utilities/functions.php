<?php

function create($class, $attributes = [], $times = null)
{
    return factory($class, $times)->create($attributes);
}

function make($class, $attributes = [], $times = null)
{
    return factory($class, $times)->make($attributes);
}

function createUser($overrides = [], $amount = 1){
    $users = factory(\App\User::class, $amount)->create($overrides);
    if (count($users) == 1) {
        return $users->first();
    }
    return $users;
}