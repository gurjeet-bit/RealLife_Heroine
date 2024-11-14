<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//   Auth::routes();
Route::get('/clear', function() {
	$exitCode = Artisan::call('cache:clear');
		echo '<h1>Cache facade value cleared</h1>';
	$exitCode = Artisan::call('route:clear');
		echo '<h1>Route cache cleared</h1>';
	$exitCode = Artisan::call('view:clear');
		echo '<h1>View cache cleared</h1>';
	$exitCode = Artisan::call('config:cache');
		return '<h1>Clear Config cleared</h1>';
});

Route::get('/', [ApiController::class, 'loginAdmin']);
Route::get('/dashboard', [ApiController::class, 'dashboard']); 
Route::get('/forgot-password', [ApiController::class, 'forgotpasswordview']); 
Route::get('/reset/{code}/{userid}', [ApiController::class, 'resetpasswords']); 
Route::post('/change-password', [ApiController::class, 'changePassword']);
Route::post('/login1', [ApiController::class, 'login1']);
Route::get('/login', [ApiController::class, 'logoutadmin']);
Route::post('/forgotpassword', [ApiController::class, 'forgotPassword']);
Route::get('/users', [ApiController::class, 'users']);
Route::get('/podcasts', [ApiController::class, 'podcasts']);
Route::get('/blogs', [ApiController::class, 'blogs']);
Route::get('/videos', [ApiController::class, 'videos']);
Route::get('/exercises', [ApiController::class, 'exercises']);
Route::get('/courses', [ApiController::class, 'courses']);
Route::get('/lessons', [ApiController::class, 'lessons']);
Route::get('/motivations', [ApiController::class, 'motivations']);
Route::get('/challenges', [ApiController::class, 'challenges']);
Route::get('/contacts', [ApiController::class, 'contacts']);
Route::get('/assignments', [ApiController::class, 'assignments']);
Route::get('/pages', [ApiController::class, 'pages']);
Route::get('/edit-profile', [ApiController::class, 'settings']);
Route::get('/privacy-policy', [ApiController::class, 'privacypolicy']);
Route::get('/terms-conditions', [ApiController::class, 'termsconditions']);
Route::get('/add-user', [ApiController::class, 'adduser']);
Route::get('/add-course', [ApiController::class, 'addcourse']);
Route::get('/add-assignment', [ApiController::class, 'addassignment']);
Route::get('/add-blog', [ApiController::class, 'addblog']);
Route::get('/send-notifications', [ApiController::class, 'sendnotifications']);
Route::get('/add-lesson', [ApiController::class, 'addlesson']);
Route::get('/add-exercise', [ApiController::class, 'addexercise']);
Route::get('/add-video', [ApiController::class, 'addvideo']);
Route::get('/add-podcast', [ApiController::class, 'addpodcast']);
Route::post('/add-challenge', [ApiController::class, 'addchallenge']);
Route::get('/add-motivation', [ApiController::class, 'addmotivation']);
Route::get('/view-user/{id}', [ApiController::class, 'viewuser']);
Route::get('/view-query/{id}', [ApiController::class, 'viewquery']);
Route::get('/edit-user/{id}', [ApiController::class, 'edituser']);
Route::get('/edit-course/{id}', [ApiController::class, 'editcourse']);
Route::get('/edit-blog/{id}', [ApiController::class, 'editblog']);
Route::get('/edit-lesson/{id}', [ApiController::class, 'editlesson']);
Route::get('/edit-exercise/{id}', [ApiController::class, 'editexercise']);
Route::get('/edit-video/{id}', [ApiController::class, 'editvideo']);
Route::get('/edit-podcast/{id}', [ApiController::class, 'editpodcast']);
Route::get('/edit-motivation/{id}', [ApiController::class, 'editmotivation']);
Route::post('/insertuser', [ApiController::class, 'insertuser']);
Route::post('/sendnoti', [ApiController::class, 'sendnoti']);
Route::post('/insertexercise', [ApiController::class, 'insertexercise']);
Route::post('/insertassignment', [ApiController::class, 'insertassignment']);
Route::post('/delete-user', [ApiController::class, 'deleteuser']);
Route::post('/delete-exercise', [ApiController::class, 'deleteexercise']);
Route::post('/delete-course', [ApiController::class, 'deletecourse']);
Route::post('/delete-blog', [ApiController::class, 'deleteblog']);
Route::post('/delete-lession', [ApiController::class, 'deletelession']);
Route::post('/delete-video', [ApiController::class, 'deletevideo']);
Route::post('/delete-query', [ApiController::class, 'deletequery']);
Route::post('/delete-challenge', [ApiController::class, 'deletechallenge']);
Route::post('/delete-podcast', [ApiController::class, 'deletepodcast']);
Route::post('/delete-motivation', [ApiController::class, 'deletemotivation']);
Route::post('/delete-assignment', [ApiController::class, 'deleteassignment']);
Route::post('/updateadminprofile', [ApiController::class, 'updateadminprofile']);
Route::post('/update_profile_pic', [ApiController::class, 'update_profile_pic']);
Route::post('/update_userprofile_pic', [ApiController::class, 'update_userprofile_pic']);
Route::post('/update-user', [ApiController::class, 'updateuser']);
Route::post('/update-course', [ApiController::class, 'updatecourse']);
Route::post('/update-blog', [ApiController::class, 'updateblog']);
Route::post('/update-lesson', [ApiController::class, 'updatelession']);
Route::post('/update-video', [ApiController::class, 'updatevideo']);
Route::post('/update-challenge', [ApiController::class, 'updatechallenge']);
Route::post('/update-exercise', [ApiController::class, 'updateexercise']);
Route::post('/update-podcast', [ApiController::class, 'updatepodcast']);
Route::post('/update-terms', [ApiController::class, 'updateterms']);
Route::post('/update-privacy', [ApiController::class, 'updateprivacy']);
Route::post('/update-motivation', [ApiController::class, 'updatemotivation']);
Route::post('/insertcourse', [ApiController::class, 'insertcourse']);
Route::post('/insertblog', [ApiController::class, 'insertblog']);
Route::post('/insertpodcast', [ApiController::class, 'insertpodcast']);
Route::post('/insertlession', [ApiController::class, 'insertlession']);
Route::post('/insertvideo', [ApiController::class, 'insertvideo']);
Route::post('/insertmotivation', [ApiController::class, 'insertmotivation']);
Route::post('/update_blog_pic', [ApiController::class, 'update_blog_pic']);
Route::get('/completed_course/{id}', [ApiController::class, 'completed_course']);
Route::get('/user-completed-courses/{id}', [ApiController::class, 'user_viewed_course']);