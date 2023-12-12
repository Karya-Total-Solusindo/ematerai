<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Traits\HasRoles;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        Gate::define('viewLogViewer', function (?User $user) {
            if($user->hasRole('Admin') === true){
                return $user->hasRole('Admin') === true;
            }else{
                abort(401);
            }
            //dd($user->hasRole('Admin'));
            // return true if the user is allowed access to the Log Viewer
        });
    }
}
