<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GroupController;


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


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

  Route::post('/registerS', [AuthController::class, 'registerS']);
  Route::post('/login', [AuthController::class, 'login']);

  Route::group(['middleware' => 'auth:api'], function ($router) {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/allUser', [AuthController::class, 'allUser'])->middleware(['auth:api', 'admin']);
    Route::get('/profile', [AuthController::class, 'profile']);




  //Files
  Route::post('upload', [FileController::class, 'upload']);
  Route::get('showFilesfor1/{groupId}', [FileController::class, 'showFiles']);
  Route::get('showFile1/{fileId}', [FileController::class, 'showFile1']);
  Route::get('downloadFile/{fileId}', [FileController::class, 'downloadFile']);



  Route::post('{groupId}/reserveFile/{fileId}', [FileController::class, 'reserveFile']);
  Route::post('{groupId}/freeFile/{fileId}', [FileController::class, 'freeFile']);
  Route::post('ReportByUserId/{userId}', [FileController::class, 'ReportByUserId'])->middleware(['auth:api', 'admin']);
  Route::post('ReportByFileId/{fileId}', [FileController::class, 'ReportByFileId']);
  Route::post('readFile/{fileId}', [FileController::class, 'readFile']);
  //Route::post('reserveFile/{id}', [FileController::class, 'reserveFile']);
  Route::post('reserveFiles/{groupId}', [FileController::class, 'reserveFiles']);
  Route::get('indexFiles', [FileController::class, 'indexFiles'])->middleware(['auth:api', 'admin']);

  Route::get('showLog', [FileController::class, 'showLog'])->middleware(['auth:api', 'admin']);


 //Add Group
   Route::post('AddGroup', [GroupController::class, 'AddGroup']);
   Route::post('/Deletegroup/{groupId}', [GroupController::class, 'destroy']);
   Route::get('indexGroup', [GroupController::class, 'indexGroup']);
   Route::get('indexGroupbyPer', [GroupController::class, 'indexGroupbyPer']);
   Route::get('GroupsFor1User', [GroupController::class, 'GroupsFor1User']);


   Route::post('/{groupId}/add-user/{userId}', [GroupController::class, 'addUserToGroup']);
   Route::post('/{groupId}/delete-user/{userId}', [GroupController::class, 'removeUserFromGroup']);





});
});
