<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::post("/run/{id}", "IndexController@test_post");
Route::post("/jobs/run/{id}", "JobsController@run_post")->where('id', '[0-9]+');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get("/", "InvenController@index");
    Route::get("/inventories", "InvenController@index")->name("inventories");
    Route::get("/inventories/add", "InvenController@add")->name("inventories_add");
    Route::post("/inventories/add", "InvenController@add_post");
    Route::get("/inventories/edit/{id}", "InvenController@edit")->name("inventories_edit");
    Route::post("/inventories/edit/{id}", "InvenController@edit_post");

    Route::get("/template", "TemplateController@index")->name("template");
    Route::get("/template/add", "TemplateController@add")->name("template_add");
    Route::post("/template/add", "TemplateController@add_post");
    Route::get("/template/edit/{id}", "TemplateController@edit")->name("template_edit");
    Route::post("/template/edit/{id}", "TemplateController@edit_post");
    Route::get("/template/vars/{id}", "TemplateController@vars")->name("template_vars");

    Route::get("/jobs", "JobsController@index")->name("jobs");
    Route::post("/jobs", "JobsController@post");
    Route::get("/jobs/run/{id}", "JobsController@run")->name("job_run");
});
