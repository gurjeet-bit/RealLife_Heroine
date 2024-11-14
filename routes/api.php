<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

    Route::post('/register', [ApiController::class, 'register']);
    Route::post('/login', [ApiController::class, 'login']);
    Route::post('/forgot_password', [ApiController::class,'forgot_password']);
    Route::post('/reset_password', [ApiController::class, 'resetPassword']);
    Route::post('/paths', [ApiController::class, 'getPath']);
    Route::post('/blogs', [ApiController::class, 'getBlog']);
    Route::post('/get-blog-load-More', [ApiController::class, 'getBlogLoadMore']);
    Route::post('/blogDetails/{id}', [ApiController::class, 'getBlogDetails']);
    Route::post('/get_Profile/{user_id}', [ApiController::class, 'getProfile']);
    Route::post('/profile', [ApiController::class, 'profileUpdate']);
    Route::post('/real-ife-video', [ApiController::class, 'getRealLifeVideoData']);
    Route::post('/get-real-ife-video-load-more', [ApiController::class, 'getRealLifeVideoLoadMoreVideos']);
    Route::post('/ourVideoDetails/{id}', [ApiController::class, 'getVideoDetails']);
    Route::post('/get-daily-motivation', [ApiController::class, 'getDailyMotivation']);

    Route::post('/get-author', [ApiController::class, 'getAuthor']);
    Route::post('/get-categories', [ApiController::class, 'getCategories']);
     
    Route::post('/get-courses', [ApiController::class, 'getCourse']);
    Route::post('/get-courses-load-More', [ApiController::class, 'getCourseLoadMore']);

    Route::post('/get-course/{id}', [ApiController::class, 'getCourseDetail']);
    Route::post('/get-lesson-detail/{lesson_id}', [ApiController::class, 'getLessonDetail']);
     Route::post('/get-excercise-detail/{excercise_id}', [ApiController::class, 'getExcerciseDetail']);
     Route::post('/submit-excercise-data/{excercise_id}', [ApiController::class, 'submitedExcercise']);
    Route::post('/get-question/{module_id}/{user_id}', [ApiController::class, 'getQuestionDetail']);
    Route::post('/get-nextLesson', [ApiController::class, 'getNextLesson']);

    // get_response_questionaries
    Route::post('/get_response_questionaries/{user_id}', [ApiController::class, 'getResponseQuestionary']);

    Route::post('/query', [ApiController::class, 'getQuerySubmission']);
    Route::post('/homeProfile/{user_id}', [ApiController::class, 'getHomeProfile']);
    Route::post('/get-recently-viewed-data', [ApiController::class, 'recentlyViewedData']);
    Route::post('/add-report-data', [ApiController::class, 'addReportData']);
    Route::post('/add-second-graph-data', [ApiController::class, 'addSecondReportData']);
    Route::post('/get-report-data', [ApiController::class, 'getReportData']);

    //getChallenge
    Route::post('/get-challenge', [ApiController::class, 'getChallenge']);
    Route::post('/get-challenge-completed', [ApiController::class, 'getChallengeCompleted']);
    
    // Route::post('/get-challenge-column', [ApiController::class, 'getChallengeColumn']);
    Route::post('/get-challenge-response/{user_id}', [ApiController::class, 'getChallengeResponse']);
    Route::post('/decline-challenge', [ApiController::class, 'declineChallenge']);

    Route::post('/save-excercise-document/{lesson_id}', [ApiController::class, 'saveExcerciseDocument']);
    
    // Route::post('/get-save-excercise-document-listq', [ApiController::class, 'saveExcerciseDocumentList']);
    Route::post('/getDocumentList', [ApiController::class, 'saveExcerciseDocumentList']);
    
    Route::post('/getformList', [ApiController::class, 'saveFormList']);
    
    Route::post('/getPodcastList', [ApiController::class, 'getPodcastList']);
    Route::post('/get-podcast-load-more', [ApiController::class, 'getPodcastLoadMoreVideos']);
    Route::post('/podcastDetail/{podcast_id}', [ApiController::class, 'podcastDetail']);
    Route::post('/get-module-list', [ApiController::class, 'getModuleList']);
    
    Route::post('/get-notification', [ApiController::class, 'getNotification']);
    Route::post('/termCondtion', [ApiController::class, 'getTermCondtion']);
    Route::post('/privacyPolicy', [ApiController::class, 'getPrivacyPolicy']);
    Route::post('/logout', [ApiController::class, 'logout']);
    Route::post('/refresh', [ApiController::class, 'refresh']);
    Route::get('/rewards', [ApiController::class, 'rewards']);
    Route::post('/redeem-rewards', [ApiController::class, 'redeemRewards']);
    Route::post('/activity-module', [ApiController::class, 'activityModule']);
    Route::post('/complete-module', [ApiController::class, 'completeModule']);
    Route::post('/viewed_item', [ApiController::class, 'viewed_item']);
    Route::get('/user_courses/{id}', [ApiController::class, 'user_courses']);

 
