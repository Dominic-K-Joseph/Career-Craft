<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Employer\JobController;
use App\Http\Controllers\Employer\EmployerDashboardController;
use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\Seeker\SeekerController;
use App\Http\Controllers\Seeker\JobController as SeekerJobController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ChatBotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// login  for employer ,seeker and admin
Route::get('/', [AuthController::class, 'checkLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

//logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// forgot password
Route::get('forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot.password');
Route::post('forgot-password', [AuthController::class, 'resetPassword'])->name('forgot.password.submit');

// Register Page
Route::get('/register', function () {
    $locations = DB::table('tbl_location')
        ->where('status', 1)
        ->orderBy('id')
        ->get();

    return view('register', compact('locations'));
})->name('register.form');

Route::post('/register', [AuthController::class, 'register'])->name('register.submit');


// seeker
Route::prefix('seeker')
    ->name('seeker.')
    ->middleware(['seeker.auth'])
    ->group(function () {

        // Dashboard pages
        Route::view('/index', 'seeker.index')->name('index');
        Route::view('/about', 'seeker.about')->name('about');

        // Profile
        Route::get('/profile', [SeekerController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [SeekerController::class, 'updateProfile'])->name('profile.update');

        // Skills
        Route::post('/skill/remove/{id}', [SeekerController::class, 'removeSkill'])->name('skill.remove');

        // Jobs
        Route::get('/jobs', [SeekerJobController::class, 'index'])->name('jobs');
        Route::post('/job/save', [SeekerJobController::class, 'toggleSaveJob'])->name('job.save');
        Route::post('/job/apply', [SeekerJobController::class, 'applyJob'])->name('job.apply');

        Route::get('/profile/get', [SeekerJobController::class, 'getSeekerProfile'])->name('profile.get');

        // Payment
        Route::get('/payment', [PaymentController::class, 'index'])->name('payment.page');
        Route::post('/create-session', [PaymentController::class, 'createSession'])->name('payment.session');

        // Chatbot
        Route::post('/chatbot/send', [ChatBotController::class, 'send'])
    ->name('chatbot.send');
    });

Route::post('/webhook', [PaymentController::class, 'webhook']);


//employer
Route::prefix('employer')->name('employer.')->group(function () {

    // View route
    Route::view('/index', 'employer.index')->name('index');

    // Dashboard route
    Route::get('/dashboard', [EmployerDashboardController::class, 'dashboard'])
        ->name('dashboard');

    // Resource routes (jobs)
    Route::resource('jobs', JobController::class);

    Route::get('profile', [EmployerController::class, 'edit'])->name('profile.edit');
    Route::post('profile/update', [EmployerController::class, 'update'])->name('profile.update');
});
