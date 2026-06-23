<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::controller(PublicController::class)->group(function () {
    Route::get('/', 'landing')->name('public.landing');
    Route::get('/jobs', 'jobs')->name('public.jobs');
    Route::get('/jobs/{job}', 'jobDetail')->name('public.job-detail');
    Route::get('/about', 'about')->name('public.about');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTE GROUP
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // Candidates CRUD (admin-only)
    Route::get('/candidates', [AdminController::class, 'candidatesIndex'])->name('admin.candidates.index');
    Route::get('/candidates/create', [AdminController::class, 'candidateCreate'])->name('admin.candidates.create');
    Route::post('/candidates', [AdminController::class, 'candidateStore'])->name('admin.candidates.store');
    Route::get('/candidates/{id}', [AdminController::class, 'candidateShow'])->name('admin.candidates.show');
    Route::get('/candidates/{id}/edit', [AdminController::class, 'candidateEdit'])->name('admin.candidates.edit');
    Route::put('/candidates/{id}', [AdminController::class, 'candidateUpdate'])->name('admin.candidates.update');
    Route::delete('/candidates/{id}', [AdminController::class, 'candidateDestroy'])->name('admin.candidates.destroy');

    // Companies Management + Verification
    Route::get('/companies', [AdminController::class, 'companiesIndex'])->name('admin.companies.index');
    Route::get('/companies/{id}', [AdminController::class, 'companyShow'])->name('admin.companies.show');
    Route::post('/companies/{id}/verify', [AdminController::class, 'companyVerify'])->name('admin.companies.verify');
    Route::post('/companies/{id}/reject', [AdminController::class, 'companyReject'])->name('admin.companies.reject');
    Route::delete('/companies/{id}', [AdminController::class, 'companyDestroy'])->name('admin.companies.destroy');

    // Job Postings CRUD
    Route::get('/job-postings', [AdminController::class, 'jobPostingsIndex'])->name('admin.job-postings.index');
    Route::get('/job-postings/create', [AdminController::class, 'jobPostingCreate'])->name('admin.job-postings.create');
    Route::post('/job-postings', [AdminController::class, 'jobPostingStore'])->name('admin.job-postings.store');
    Route::get('/job-postings/{id}', [AdminController::class, 'jobPostingShow'])->name('admin.job-postings.show');
    Route::get('/job-postings/{id}/edit', [AdminController::class, 'jobPostingEdit'])->name('admin.job-postings.edit');
    Route::put('/job-postings/{id}', [AdminController::class, 'jobPostingUpdate'])->name('admin.job-postings.update');
    Route::delete('/job-postings/{id}', [AdminController::class, 'jobPostingDestroy'])->name('admin.job-postings.destroy');

    // Placements CRUD
    Route::get('/placements', [AdminController::class, 'placementsIndex'])->name('admin.placements.index');
    Route::get('/placements/create', [AdminController::class, 'placementCreate'])->name('admin.placements.create');
    Route::post('/placements', [AdminController::class, 'placementStore'])->name('admin.placements.store');
    Route::post('/placements/{id}/status', [AdminController::class, 'placementUpdateStatus'])->name('admin.placements.status');
    Route::delete('/placements/{id}', [AdminController::class, 'placementDestroy'])->name('admin.placements.destroy');

    // Skills Management
    Route::get('/skills', [AdminController::class, 'skillsIndex'])->name('admin.skills.index');
    Route::post('/skills', [AdminController::class, 'skillStore'])->name('admin.skills.store');
    Route::delete('/skills/{id}', [AdminController::class, 'skillDestroy'])->name('admin.skills.destroy');
});

/*
|--------------------------------------------------------------------------
| COMPANY ROUTE GROUP
|--------------------------------------------------------------------------
*/

// Unverified/Pending page
Route::middleware(['auth', 'role:company'])->group(function () {
    Route::get('/company/pending', [CompanyController::class, 'pending'])->name('company.pending');
});

// Verified routes
Route::middleware(['auth', 'role:company', 'company.verified'])->prefix('company')->group(function () {
    // Dashboard
    Route::get('/', [CompanyController::class, 'dashboard'])->name('company.dashboard');

    // Job Postings CRUD (own only)
    Route::get('/job-postings', [CompanyController::class, 'jobPostingsIndex'])->name('company.job-postings.index');
    Route::get('/job-postings/create', [CompanyController::class, 'jobPostingCreate'])->name('company.job-postings.create');
    Route::post('/job-postings', [CompanyController::class, 'jobPostingStore'])->name('company.job-postings.store');
    Route::get('/job-postings/{id}', [CompanyController::class, 'jobPostingShow'])->name('company.job-postings.show');
    Route::get('/job-postings/{id}/edit', [CompanyController::class, 'jobPostingEdit'])->name('company.job-postings.edit');
    Route::put('/job-postings/{id}', [CompanyController::class, 'jobPostingUpdate'])->name('company.job-postings.update');
    Route::delete('/job-postings/{id}', [CompanyController::class, 'jobPostingDestroy'])->name('company.job-postings.destroy');

    // View Candidate Pools
    Route::get('/candidates', [CompanyController::class, 'viewCandidates'])->name('company.candidates.index');
    Route::get('/candidates/{id}', [CompanyController::class, 'showCandidate'])->name('company.candidates.show');
});
