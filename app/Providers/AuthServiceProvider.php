<?php

namespace App\Providers;

use App\Entities\Network;
use App\Entities\Permission;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

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
    public function boot(GateContract $gate, Request $request)
    {
        $this->registerPolicies();
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        $gate->before(function($user) use ($request)
        {
            $permisssions = Permission::all();
            foreach ($permisssions as $permisssion)
            {

                Gate::define($permisssion->slug, function ($user) use ($permisssion) {
                    $can = $user->hasPermission($permisssion);
                    return $can;
                });
            }
            if ($user->isSuperAdmin()){
                return true;
            }
        });
    }
}
