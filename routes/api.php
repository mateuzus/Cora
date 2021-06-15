<?php

use App\Http\Controllers\Api\ApiAuthController;



use App\Http\Controllers\App\AnswerGivedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group(['prefix'=>"app"], function(){
    Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api'); //teste
    Route::group(['middleware'=>"auth:api"], function(){
        Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api'); //teste

        Route::get('dashboard', 'App\DashboardController@dashboard');

        //rotas do aplicativo
        Route::get('listings', 'App\ListingController@index'); //teste
        Route::get('questions/{list_id}', 'App\QuestionController@index'); //teste
        Route::post('answergiven/{question_id}', 'App\AnswerGivedController@store'); //teste

    });

});


Route::group(['prefix'=>'v1'], function (){

    Route::get('dashboard', 'App\DashboardController@dashboard');

    Route::group(['namespace'=>"App"], function(){
        Route::get('report/reportQuestions/{user_id}', 'Report\ReportQuestionController@show');
    });

    Route::resource('roles', "RolesController");
    Route::resource('departments', "DepartmentsController");
    Route::resource('stores', "StoresController");

    Route::resource('font_data', "FontDatasController");
    Route::resource('flows', "FlowsController");
    Route::resource('flow_rules', "FlowRulesController");
    Route::resource('operationstandart', "OperationStandartsController");
    Route::resource('operationstandarttasks', "OperationStandartTasksController");
    Route::resource('routine', "RoutinesController");
    Route::resource('routinetasks', "RoutineTasksController");

    Route::resource('rolePermissions', "RolePermissionsController");
    Route::resource('teams', "TeamsController");


Route::group(['prefix'=>"system"], function (){
    //rotas do aplicativo
    Route::get('listings', 'App\ListingController@index'); //teste
    Route::get('questions/{list_id}', 'App\QuestionController@index'); //teste
    Route::post('answergiven/{question_id}', 'App\AnswerGivedController@store'); //teste
});

});



// API EXTERNA



Route::group(['prefix'=>'v1'], function (){
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::group(['middleware'=>"auth:api"], function(){
        Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api'); //teste
        //rotas do aplicativo
        Route::get('listings', [\App\Http\Controllers\Api\ListingController::class, 'index']);
        Route::post('listings', [\App\Http\Controllers\Api\ListingController::class, 'store']);
        Route::get('users', [\App\Http\Controllers\Api\UsersController::class, 'index']);
        Route::get('flow', [\App\Http\Controllers\Api\FlowsController::class, 'index']);
        Route::get('pops', [\App\Http\Controllers\Api\OperationStandartsController::class, 'index']);
        Route::get('routines', [\App\Http\Controllers\Api\RoutinesController::class, 'index']);
//        Route::get('questions', [\App\Http\Controllers\Api\QuestionController::class, 'index']);
        Route::post('questions', [\App\Http\Controllers\Api\QuestionController::class, 'store']);

    });

});





