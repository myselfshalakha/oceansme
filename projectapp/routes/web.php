<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Mail\LoiEmail;
use Illuminate\Support\Facades\Mail;
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


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('test/email', [App\Http\Controllers\HomeController::class, 'test_email'])->name('test_email');
Auth::routes();

Route::match(['get','post'],'/jobevents/{param?}','App\Http\Controllers\HomeController@job_events')->name('home.jobevents');
Route::match(['get','post'],'/department/{param?}','App\Http\Controllers\HomeController@get_departments')->name('home.department');
Route::match(['get','post'],'/register/{param?}','App\Http\Controllers\AccountsController@index')->name('candidate.registerview');
Route::match(['get','post'],'/registeruser/','App\Http\Controllers\AccountsController@candidateRegister')->name('candidate.register');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/email/verify', [App\Http\Controllers\VerificationController::class, 'show'])->name('verification.notice');
    /* Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\VerificationController::class, 'verify'])->name('verification.verify')->middleware(['signed']); */
	Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
		$request->fulfill();
		return redirect('/admin/dashboard')->with('success', 'Your email verified successfully.');   ;
	})->middleware(['signed'])->name('verification.verify');
    Route::post('/email/resend', [App\Http\Controllers\VerificationController::class, 'resend'])->name('verification.resend');
});
//only authenticated can access this group
Route::group(['middleware' => ['auth']], function() {
    //only verified account can access with this group
	//Route::group(['middleware' => ['verified']], function() {
		Route::middleware(['auth'])->prefix('admin')->group(function () {
			Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
			Route::match(['get','post'],'/post/{param?}','App\Http\Controllers\PostsController@postAction')->name('admin.post');
			Route::match(['get','post'],'/department/{param?}','App\Http\Controllers\DepartmentController@departmentAction')->name('admin.department');
			Route::match(['get','post'],'/company/{param?}','App\Http\Controllers\CompanyController@companyAction')->name('admin.company');
			Route::match(['get','post'],'/events/{param?}','App\Http\Controllers\EventController@eventsAction')->name('admin.events')->middleware('page.lock');
			Route::match(['get','post'],'/schedule/{param?}','App\Http\Controllers\EventController@eventsScheduleAction')->name('admin.schedule');
			Route::match(['get','post'],'/agency/{param?}','App\Http\Controllers\AgencyController@agencyAction')->name('admin.agency');
			Route::match(['get','post'],'/country/{param?}','App\Http\Controllers\CountryController@countryAction')->name('admin.country');
			Route::match(['get','post'],'/state/{param?}','App\Http\Controllers\StateController@stateAction')->name('admin.state');
			Route::match(['get','post'],'/city/{param?}', 'App\Http\Controllers\CityController@cityAction')->name('admin.city');
			Route::match(['get','post'],'/profile/{param?}', 'App\Http\Controllers\UserController@profileAction')->name('admin.profile');
			Route::match(['get','post'],'/users/{role_name}/{action}/', 'App\Http\Controllers\UserController@roleuserAction')->name('admin.users');
			Route::match(['get','post'],'/users/{param?}', 'App\Http\Controllers\UserController@userlistAction')->name('admin.users');
		});
	//});
});
// Clear application cache:
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return 'Application cache has been cleared';
});

//Clear route cache:
Route::get('/route-cache', function() {
	Artisan::call('route:cache');
    return 'Routes cache has been cleared';
});

//Clear config cache:
Route::get('/config-cache', function() {
 	Artisan::call('config:cache');
 	return 'Config cache has been cleared';
}); 

// Clear view cache:
Route::get('/view-clear', function() {
    Artisan::call('view:clear');
    return 'View cache has been cleared';
});

Route::get('run__queue', function () {

    \Artisan::call('queue:work --once');
    \Artisan::call('queue:work --once');
    \Artisan::call('queue:work --once');
    \Artisan::call('queue:work --once');
    \Artisan::call('queue:work --once');

    dd("Queue work");

});


Route::get('run__migrations', function () {

    Artisan::call('migrate');

    dd("Migration work");

});
