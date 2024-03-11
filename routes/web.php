<?php

use App\Http\Controllers\BlogCommentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmojiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Auth\RegisteredUserController;


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

Route::get('/', [DashboardController::class, 'index'])->middleware(["auth", "verified"])->name("home");
Route::middleware('auth')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::get('/dashboard', function () {
    return redirect(RouteServiceProvider::HOME);
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::middleware('auth')->controller(EmojiController::class)->group(function () {
    Route::get('/system/emoji/all', 'index')->name('emoji-manager');
    Route::post('/system/emoji', 'store')->name('store-emoji');
    Route::get('/system/emoji/delete/{emoji}', 'destroy')->name('delete-emoji');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard/staff', [DashboardController::class, 'showStaffDashboard'])->name('dashboards.staff');
    Route::get('/dashboard/tutor', [DashboardController::class, 'showTutorDashboard'])->name('dashboards.tutor');
    Route::redirect('/dashboard/student', '/blogs/self', 301)->name('dashboards.student');

    Route::get('/reports/stundets-with-no-tutor', [UserController::class, 'showStudentsWithNoTutor'])->name('reports.students-with-no-tutor');
    Route::get('/reports/inactive-students', [UserController::class, 'inactiveStudents'])->name('reports.inactive-students');
    Route::get('/reports/all-inactive-students', [UserController::class, 'allInactiveStudents'])->name('reports.all-inactive-students');
});

Route::middleware('auth')->group(function () {
    Route::get('/users/account-manager', [UserController::class, 'showUsers'])->name('account-manager');
    Route::get('/users/account-manager/search', [UserController::class, 'searchUsers'])->name('account-manager.search');
    Route::put('/users/suspend/{user}', [UserController::class, 'suspendUser'])->name('suspend-user');
    Route::put('/users/unsuspend/{user}', [UserController::class, 'unsuspendUser'])->name('unsuspend-user');
    Route::get('/users/edit-tutor/{user}', [UserController::class, 'editTutor'])->name('edit-tutor');
    Route::put('/users/edit-tutor/{user}', [UserController::class, 'updateTutor'])->name('update-tutor');
    Route::get('/users/profile/{user}', [UserController::class, 'showUserProfile'])->name('user-profile');

    Route::put('/users/toggle-select', [UserController::class, 'toggleSelectUser'])->name('users.toggle-select');
    Route::get('/users/unselect-all', [UserController::class, 'unselectAll'])->name('users.unselect-all');
    Route::get('/users/bulk-allocate', [UserController::class, 'createBulkAllocation'])->name('users.create-bulk-allocation');
    Route::put('/users/bulk-allocate', [UserController::class, 'storeBulkAllocation'])->name('users.store-bulk-allocation');
});

Route::middleware('auth')->group(function () {
    Route::get('/blogs/self', [BlogController::class, 'showBlogsAuthoredOrReceived'])->name('blog-page');
    Route::get('/blogs/student/{id}', [BlogController::class, 'showBlogsBetweenTutorAndStudent'])->name('blog-page-by-studentId');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('create-blog');
    Route::post('/blogs/store', [BlogController::class, 'store'])->name('store-blog');
    Route::get('/blogs/detail/{blog}', [BlogController::class, 'blogDetail'])->name('blog-detail');
    Route::delete('/blogs/delete/{blog}', [BlogController::class, 'deleteBlog'])->name('delete-blog');

    Route::post('/blog-comments', [BlogCommentController::class, 'store'])->name('store-blogcomment');
    Route::delete('/blog-comments/{comment}', [BlogCommentController::class, 'destroy'])->name('delete-blogcomment');

    Route::post('/reactions/react', [BlogController::class, 'reactBlog'])->name('react-blog');
});

//schedule
Route::get('/schedule/manager', [\App\Http\Controllers\ScheduleController::class, 'manager'])->name('schedule.manager');
Route::get('/schedule/filter', [\App\Http\Controllers\ScheduleController::class, 'filter'])->name('schedule.filter');
Route::put('/schedule/status/{schedule}', [\App\Http\Controllers\ScheduleController::class, 'updateStatus'])->name('schedules.status.update');
Route::put('/schedule/updateNotification/{id}', [\App\Http\Controllers\ScheduleController::class, 'updateNotification'])->name('schedule.updateNotification')->middleware('auth');
Route::resource('schedule', \App\Http\Controllers\ScheduleController::class)->middleware('auth');
// Route::delete('share/{id}', [\App\Http\Controllers\ScheduleUserController::class, 'destroy'])->name('share.destroy');
Route::resource('share', \App\Http\Controllers\ScheduleUserController::class)->middleware('auth');


// browser info
Route::any('/store-browser-info', [BrowserInfoController::class, 'store'])->name('StoreBrowserInfo');
