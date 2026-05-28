<?php

use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pindahin semua route yang butuh login ke sini
    Route::get('/dashboarad', [PengaduanController::class, 'dashboarad'])->name('dashboarad');

    Route::get('/calendar', function () {
        return view('pages.calender', ['title' => 'Calendar']);
    })->name('calendar');
    Route::get('/dashboard', [PengaduanController::class, 'dashboardMasyarakat'])
        ->middleware(['auth'])
        ->name('dashboard');
});
// profile pages

Route::get('/profile', function () {
    return view('pages.profile', ['title' => 'Profile']);
})->name('profile');

// form pages
Route::get('/form-elements', function () {
    return view('pages.form.form-elements', ['title' => 'Form Elements']);
})->name('form-elements');

// tables pages
Route::get('/basic-tables', function () {
    return view('pages.tables.basic-tables', ['title' => 'Basic Tables']);
})->name('basic-tables');

// pages

Route::get('/blank', function () {
    return view('pages.blank', ['title' => 'Blank']);
})->name('blank');

// error pages
Route::get('/error-404', function () {
    return view('pages.errors.error-404', ['title' => 'Error 404']);
})->name('error-404');

// chart pages
Route::get('/line-chart', function () {
    return view('pages.chart.line-chart', ['title' => 'Line Chart']);
})->name('line-chart');

Route::get('/bar-chart', function () {
    return view('pages.chart.bar-chart', ['title' => 'Bar Chart']);
})->name('bar-chart');

// authentication pages
Route::get('/signin', function () {
    return view('pages.auth.signin', ['title' => 'Sign In']);
})->name('signin');

Route::get('/signup', function () {
    return view('pages.auth.signup', ['title' => 'Sign Up']);
})->name('signup');

// ui elements pages
Route::get('/alerts', function () {
    return view('pages.ui-elements.alerts', ['title' => 'Alerts']);
})->name('alerts');

Route::get('/avatars', function () {
    return view('pages.ui-elements.avatars', ['title' => 'Avatars']);
})->name('avatars');

Route::get('/badge', function () {
    return view('pages.ui-elements.badges', ['title' => 'Badges']);
})->name('badges');

Route::get('/buttons', function () {
    return view('pages.ui-elements.buttons', ['title' => 'Buttons']);
})->name('buttons');

Route::get('/image', function () {
    return view('pages.ui-elements.images', ['title' => 'Images']);
})->name('images');

Route::get('/videos', function () {
    return view('pages.ui-elements.videos', ['title' => 'Videos']);
})->name('videos');

Route::get('/CRUD', [PengaduanController::class, 'index'])->name('crud');

Route::get('/form-pengaduan', function () {
    return view('masyarakat.form-pengaduan', ['title' => 'Form Pengaduan']);
})->name('form-pengaduan');

Route::post('/pengaduan/store', [PengaduanController::class, 'store'])->name('pengaduan.store');
Route::resource('pengaduan', PengaduanController::class);
Route::get('/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'edit'])
    ->name('pengaduan.editp');
Route::delete('/pengaduan/{pengaduan}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
Route::get('/pengaduan-saya', [PengaduanController::class, 'pengaduanSaya'])
    ->name('pengaduan.saya');
Route::get('/pengaduan-saya', [PengaduanController::class, 'indexMasyarakat'])
    ->name('pengaduan.masyarakat');

Route::get('/pengaduan/{id}/preview', [PengaduanController::class, 'preview'])
    ->name('pengaduan.preview');
Route::patch('/pengaduan/{id}/respond', [PengaduanController::class, 'respond'])->name('pengaduan.respond');


Route::get('/pengaduan-selesai', [PengaduanController::class, 'selesai'])
    ->name('pengaduan.selesai');
require __DIR__ . '/auth.php';
