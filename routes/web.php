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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/leads-create', [LeadController::class, 'create'])->name('leads.create');
    Route::post('/leads-store', [LeadController::class, 'store'])->name('leads.store');
    Route::get('/leads-list', [LeadController::class, 'list'])->name('leads.list');
    Route::get('/leads-all-company', [LeadController::class, 'allByCompany'])->name('leads.all.company');
    Route::get('/leads-converted-list', [LeadController::class, 'listConverted'])->name('leads.converted.list');
    Route::get('/leads-show/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::get('/leads-edit/{lead}', [LeadController::class, 'edit'])->name('leads.edit');
    Route::patch('/leads-update/{lead}', [LeadController::class, 'update'])->name('leads.update');
    Route::delete('/leads-destroy/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');

    Route::get('/tags-list', [TagController::class, 'list'])->name('tags.list');
    Route::post('/tags-store', [TagController::class, 'store'])->name('tags.store');
    Route::patch('/tags-update/{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/tags-destroy/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

    Route::get('/companies-list', [CompanyController::class, 'list'])->name('companies.list');
    Route::post('/companies-store', [CompanyController::class, 'store'])->name('companies.store');
    Route::patch('/companies-update/{company}', [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('/companies-destroy/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy');

    Route::get('/interactions-create/{lead}', [InteractionController::class, 'create'])->name('interactions.create');
    Route::post('/interactions-store', [InteractionController::class, 'store'])->name('interactions.store');
    Route::get('/interactions-list', [InteractionController::class, 'list'])->name('interactions.list');
    Route::get('/interactions-show/{interaction}', [InteractionController::class, 'show'])->name('interactions.show');
    Route::get('/interactions-edit/{interaction}', [InteractionController::class, 'edit'])->name('interactions.edit');
    Route::patch('/interactions-update/{interaction}', [InteractionController::class, 'update'])->name('interactions.update');
    Route::delete('/interactions-destroy/{interaction}', [InteractionController::class, 'destroy'])->name('interactions.destroy');

    Route::get('/interaction-types-list', [InteractionTypeController::class, 'list'])->name('interactionTypes.list');
    Route::post('/interaction-types-store', [InteractionTypeController::class, 'store'])->name('interactionTypes.store');
    Route::patch('/interaction-types-update/{interactionType}', [InteractionTypeController::class, 'update'])->name('interactionTypes.update');
    Route::delete('/interaction-types-destroy/{interactionType}', [InteractionTypeController::class, 'destroy'])->name('interactionTypes.destroy');


    Route::get('/investiments-list', [InvestimentController::class, 'list'])->name('investiments.list');
    Route::get('/investiments-create', [InvestimentController::class, 'create'])->name('investiments.create');
    Route::get('/investiments-edit/{investiment}', [InvestimentController::class, 'edit'])->name('investiments.edit');

    Route::patch('/investiments-update/{investiment}', [InvestimentController::class, 'update'])->name('investiments.update');
    Route::post('/investiments-store', [InvestimentController::class, 'store'])->name('investiments.store');
    Route::delete('/investiments-destroy/{investiment}', [InvestimentController::class, 'destroy'])->name('investiments.destroy');
    Route::get('/export-all-investiments', [InvestimentController::class, 'exportCSV'])->name('investiments.export.csv');
});




require __DIR__.'/auth.php';
