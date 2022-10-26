<?php

use App\Http\Controllers\API\AboutController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EdcationController;
use App\Http\Controllers\API\ExperinceController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\SkillController;
use App\Http\Controllers\API\TestimonialController;
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



Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AboutController::class)->group(function () {
    Route::get('about', 'edit');
    Route::post('update/about/{about}', 'update');
});

Route::controller(ServiceController::class)->group(function () {
    Route::get('services', 'index');
    Route::post('store/services', 'store');
    Route::post('update/services/{service}', 'update');
    Route::get('delete/services/{service}', 'delete');
});

Route::controller(SkillController::class)->group(function () {
    Route::get('skills', 'index');
    Route::post('store/skills', 'store');
    Route::post('update/skills/{skill}', 'update');
    Route::get('delete/skills/{skill}', 'delete');
});

Route::controller(EdcationController::class)->group(function () {
    Route::get('educations', 'index');
    Route::post('store/educations', 'store');
    Route::post('update/educations/{education}', 'update');
    Route::get('delete/educations/{education}', 'delete');
});

Route::controller(ExperinceController::class)->group(function () {
    Route::get('experiences', 'index');
    Route::post('store/experiences', 'store');
    Route::post('update/experiences/{experience}', 'update');
    Route::get('delete/experiences/{experience}', 'delete');
});

Route::controller(ProjectController::class)->group(function () {
    Route::get('projects', 'index');
    Route::get('project/{project}', 'show');
    Route::post('store/projects', 'store');
    Route::post('update/projects/{project}', 'update');
    Route::get('delete/projects/{project}', 'delete');
});

Route::controller(TestimonialController::class)->group(function () {
    Route::get('testimonials', 'index');
    Route::get('testimonials/{testimonial}', 'show');
    Route::post('store/testimonials', 'store');
    Route::post('update/testimonials/{testimonial}', 'update');
    Route::get('delete/testimonials/{testimonial}', 'delete');
});

Route::controller(MessageController::class)->group(function () {
    Route::get('messages', 'index');
    Route::get('messages/toggle/{message}', 'toggleStatus');
    Route::get('delete/message/{message}', 'delete');
});
