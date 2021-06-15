<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('mail', "App\Mail\ReportController@getReportQuestionsEndDay");
Route::get('getQuestionsByRole', "App\Mail\ReportController@getQuestionsByRole");
Route::get('syncRoles', "App\Mail\ReportController@syncRoles");

Route::group(['middleware'=>['auth', 'admin']], function (){
    Route::get('/',"HomeController@index")->name("home");
    Route::get('/adapter',"AdapterController@index")->name("adapter.index");

    Route::group(['prefix'=>"adapter",'namespace'=>'Adapter'], function (){
        Route::resource('source', "SourceController");
        Route::resource('adapater_stores', "StoreController");
    });

    Route::resource('users', "UsersController");
    Route::resource('networks', "NetworksController");
    Route::resource('network_configs', "NetworkConfigsController");
    Route::resource('stores', "StoresController");
    Route::resource('departments', 'DepartmentsController');
    Route::resource('roles', "RolesController");
    Route::resource('flows', "FlowsController");
    Route::resource('flow_rules', "FlowRulesController");
    Route::resource('operationstandart', "OperationStandartsController");
    Route::resource('operationstandarttasks', "OperationStandartTasksController");
    Route::resource('routines', "RoutinesController");
    Route::resource('routinetasks', "RoutineTasksController");
    Route::resource('audits', "AuditsController");
    Route::resource('rolePermissions', "RolePermissionsController");
    Route::resource('teams', "TeamsController");
    Route::resource('dashboard', 'DashboardController');
    Route::resource('fontDatas', 'FontDatasController');
    Route::resource('fontDataDetail', 'FontDataDetailsController');

    Route::get('lists_by_user', 'ListingsController@index');
    Route::get('questions/{list_id}', 'QuestionsController@index');
});
