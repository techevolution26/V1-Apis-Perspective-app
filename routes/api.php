<?php

// dd('🔍 api.php loaded');
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PerceptionController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TopicFollowController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here’s where you can register API routes for your application. These
| are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public (no auth)
// Route::get('/ping', fn () => 'pong');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Protected (requires Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // Current user profile
    Route::get('/user',  [UserController::class, 'show']);
    Route::put('/user',  [UserController::class, 'update']);
    Route::get('/users/{id}/topics',    [ProfileController::class, 'topics']);

    // Users (public profiles)
    Route::get('/users/{id}',  [UserController::class, 'showPublic']);
    Route::get('/users/{id}/followers', [FollowController::class, 'followers']);
    Route::get('/users/{id}/following', [FollowController::class, 'following']);
    Route::post('/user/profile', [ProfileController::class, 'updateProfile']);

    // Follow / Unfollow
    Route::post('/users/{id}/follow',   [FollowController::class, 'follow']);
    Route::delete('/users/{id}/follow', [FollowController::class, 'unfollow']);

    // Perceptions (tweets)
    Route::get('/perceptions',  [PerceptionController::class, 'index']);
    Route::post('/perceptions', [PerceptionController::class, 'store']);

    // Route::get('/perceptions/{id}',  [PerceptionController::class, 'show']);
    Route::put('/perceptions/{id}',  [PerceptionController::class, 'update']);
    Route::delete('/perceptions/{id}',  [PerceptionController::class, 'destroy']);

    // Comments
    Route::post('/perceptions/{id}/comments', [CommentController::class, 'store']);
    // Route::post('/perceptions/{perception}/comments', [CommentController::class,'store']);
    // Route::get('/perceptions/{id}/comments', [CommentController::class, 'index']);

    // Likes
    Route::post('/perceptions/{id}/like',   [LikeController::class, 'store']);
    Route::delete('/perceptions/{id}/like', [LikeController::class, 'destroy']);

    // Topics
    // Route::get('/topics',  [TopicController::class, 'index']);
    // Route::get('/topics/{id}',  [TopicController::class, 'show']);
    Route::get('/topics/{id}/perceptions', [PerceptionController::class, 'byTopic']);
    Route::post('/topics/{id}/follow',   [TopicFollowController::class, 'follow']);
    Route::delete('/topics/{id}/follow',   [TopicFollowController::class, 'unfollow']);

    // Notifications
    Route::get('/notifications',    [NotificationController::class, 'index']);
    Route::put('/notifications/{id}/read',  [NotificationController::class, 'markRead']);

    // Comment Replies
    Route::post('/comments/{comment}/replies', [CommentReplyController::class, 'store']);
    // Route::get('/search', [SearchController::class, 'search']);
});


// Public Routes(no auth)
Route::get('/topics', [TopicController::class, 'index']);
Route::get('/topics/{id}',  [TopicController::class, 'show']);
Route::get('/perceptions/{id}', [PerceptionController::class, 'show']);
Route::get('/users/{id}', [ProfileController::class, 'show']);
Route::get('/perceptions/{id}/comments', [CommentController::class, 'index']);
Route::get('/users/{id}/perceptions', [ProfileController::class, 'perceptions']);
Route::get('/users/{id}/followers', [FollowController::class, 'followers']);
Route::get('/users/{id}/following', [FollowController::class, 'following']);
Route::get('/comments/{comment}/replies', [CommentReplyController::class, 'index']);
Route::get('/search', [SearchController::class, 'search']);
