<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\InvestimentController;

use App\Http\Controllers\InteractionTypeController;
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
Route::get('/leads-converted-list', [LeadController::class, 'listConverted'])->middleware(['auth', 'verified'])->name('leads.converted.list');
Route::get('/leads-show/{lead}', [LeadController::class, 'show'])->middleware(['auth', 'verified'])->name('leads.show');
Route::get('/leads-edit/{lead}', [LeadController::class, 'edit'])->middleware(['auth', 'verified'])->name('leads.edit');
Route::patch('/leads-update/{lead}', [LeadController::class, 'update'])->middleware(['auth', 'verified'])->name('leads.update');
Route::delete('/leads-destroy/{lead}', [LeadController::class, 'destroy'])->middleware(['auth', 'verified'])->name('leads.destroy');

Route::get('/tags-list', [TagController::class, 'list'])->middleware(['auth', 'verified'])->name('tags.list');
Route::post('/tags-store', [TagController::class, 'store'])->middleware(['auth', 'verified'])->name('tags.store');
Route::patch('/tags-update/{tag}', [TagController::class, 'update'])->middleware(['auth', 'verified'])->name('tags.update');
Route::delete('/tags-destroy/{tag}', [TagController::class, 'destroy'])->middleware(['auth', 'verified'])->name('tags.destroy');

Route::get('/companies-list', [CompanyController::class, 'list'])->middleware(['auth', 'verified'])->name('companies.list');
Route::post('/companies-store', [CompanyController::class, 'store'])->middleware(['auth', 'verified'])->name('companies.store');
Route::patch('/companies-update/{company}', [CompanyController::class, 'update'])->middleware(['auth', 'verified'])->name('companies.update');
Route::delete('/companies-destroy/{company}', [CompanyController::class, 'destroy'])->middleware(['auth', 'verified'])->name('companies.destroy');

Route::get('/interactions-create/{lead}', [InteractionController::class, 'create'])->middleware(['auth', 'verified'])->name('interactions.create');
Route::post('/interactions-store', [InteractionController::class, 'store'])->middleware(['auth', 'verified'])->name('interactions.store');
Route::get('/interactions-list', [InteractionController::class, 'list'])->middleware(['auth', 'verified'])->name('interactions.list');
Route::get('/interactions-show/{interaction}', [InteractionController::class, 'show'])->middleware(['auth', 'verified'])->name('interactions.show');
Route::get('/interactions-edit/{interaction}', [InteractionController::class, 'edit'])->middleware(['auth', 'verified'])->name('interactions.edit');
Route::patch('/interactions-update/{interaction}', [InteractionController::class, 'update'])->middleware(['auth', 'verified'])->name('interactions.update');
Route::delete('/interactions-destroy/{interaction}', [InteractionController::class, 'destroy'])->middleware(['auth', 'verified'])->name('interactions.destroy');

Route::get('/interaction-types-list', [InteractionTypeController::class, 'list'])->middleware(['auth', 'verified'])->name('interactionTypes.list');
Route::post('/interaction-types-store', [InteractionTypeController::class, 'store'])->middleware(['auth', 'verified'])->name('interactionTypes.store');
Route::patch('/interaction-types-update/{interactionType}', [InteractionTypeController::class, 'update'])->middleware(['auth', 'verified'])->name('interactionTypes.update');
Route::delete('/interaction-types-destroy/{interactionType}', [InteractionTypeController::class, 'destroy'])->middleware(['auth', 'verified'])->name('interactionTypes.destroy');


Route::get('/investiments-list', [InvestimentController::class, 'list'])->middleware(['auth', 'verified'])->name('investiments.list');
Route::get('/investiments-create', [InvestimentController::class, 'create'])->middleware(['auth', 'verified'])->name('investiments.create');
Route::post('/investiments-store', [InvestimentController::class, 'store'])->middleware(['auth', 'verified'])->name('investiments.store');
Route::get('/export-all-investiments', [InvestimentController::class, 'exportCSV'])->middleware(['auth', 'verified'])->name('investiments.export.csv');


require __DIR__.'/auth.php';
