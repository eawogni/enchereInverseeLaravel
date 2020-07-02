<?php

namespace App\Providers;

use App\Administrateur;
use App\Role;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        /**
         * Porte de vérification si l'utilisateur authentifié est un administrateur
         */
        Gate::define('administrer', function(User $user){
            return $user->hasRole('admin');
        });
    }
}
