<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FlowRepository::class, \App\Repositories\FlowRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NetworkRepository::class, \App\Repositories\NetworkRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StoreRepository::class, \App\Repositories\StoreRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoleRepository::class, \App\Repositories\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FlowItemRepository::class, \App\Repositories\FlowItemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OperatorRepository::class, \App\Repositories\OperatorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ListingRepository::class, \App\Repositories\ListingRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\QuestionRepository::class, \App\Repositories\QuestionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AnswerRepository::class, \App\Repositories\AnswerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AnswerGivenRepository::class, \App\Repositories\AnswerGivenRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AdapterNetworkConnectionRepository::class, \App\Repositories\AdapterNetworkConnectionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AuditRepository::class, \App\Repositories\AuditRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OperationStandartRepository::class, \App\Repositories\OperationStandartRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OperationStandartStoresRepository::class, \App\Repositories\OperationStandartStoresRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OperationStandartDepartmentRepository::class, \App\Repositories\OperationStandartDepartmentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OperationStandartRolesRepository::class, \App\Repositories\OperationStandartRolesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoutineRepository::class, \App\Repositories\RoutineRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoutineDepartmentsRepository::class, \App\Repositories\RoutineDepartmentsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoutineRolesRepository::class, \App\Repositories\RoutineRolesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoutineStoreRepository::class, \App\Repositories\RoutineStoreRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoutineDepartmentRepository::class, \App\Repositories\RoutineDepartmentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoutineRoleRepository::class, \App\Repositories\RoutineRoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\DepartmentRepository::class, \App\Repositories\DepartmentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OperationStandartTaskRepository::class, \App\Repositories\OperationStandartTaskRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoutineTaskRepository::class, \App\Repositories\RoutineTaskRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PermissionRepository::class, \App\Repositories\PermissionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RolePermissionsRepository::class, \App\Repositories\RolePermissionsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProductRepository::class, \App\Repositories\ProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TeamRepository::class, \App\Repositories\TeamRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserTeamRepository::class, \App\Repositories\UserTeamRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserDepartmentRepository::class, \App\Repositories\UserDepartmentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FontDataRepository::class, \App\Repositories\FontDataRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FontDataDetailRepository::class, \App\Repositories\FontDataDetailRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FlowStoresRepository::class, \App\Repositories\FlowStoresRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FlowRolesRepository::class, \App\Repositories\FlowRolesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FlowDepartmentsRepository::class, \App\Repositories\FlowDepartmentsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FlowTeamRepository::class, \App\Repositories\FlowTeamRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OperationStandartTeamRepository::class, \App\Repositories\OperationStandartTeamRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoutineTeamRepository::class, \App\Repositories\RoutineTeamRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FlowItemActionsRepository::class, \App\Repositories\FlowItemActionsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FlowRulesRepository::class, \App\Repositories\FlowRulesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NetworkConfigRepository::class, \App\Repositories\NetworkConfigRepositoryEloquent::class);
        //:end-bindings:
    }
}
