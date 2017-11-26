<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Comment' => 'App\Policies\CommentPolicy',
        'App\Byte' => 'App\Policies\BytePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // TODO-KGW need to deal with the auth exception for administrators
        // this can be done by role ideally
        Gate::before(function ($user) {
            //if($user->name === 'John Doe') return true;
        });
    }
}
