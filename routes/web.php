<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TagController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/leads-create', [LeadController::class, 'create'])->middleware(['auth', 'verified'])->name('leads.create');
Route::post('/leads-store', [LeadController::class, 'store'])->middleware(['auth', 'verified'])->name('leads.store');

Route::get('/leads-list', [LeadController::class, 'list'])->middleware(['auth', 'verified'])->name('leads.list');

Route::get('/leads-show/{lead}', [LeadController::class, 'show'])->middleware(['auth', 'verified'])->name('leads.show');

Route::get('/leads-edit/{lead}', [LeadController::class, 'edit'])->middleware(['auth', 'verified'])->name('leads.edit');


Route::get('/tags-list', [TagController::class, 'list'])->middleware(['auth', 'verified'])->name('tags.list');

require __DIR__.'/auth.php';
