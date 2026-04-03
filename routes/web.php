<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    // If user is logged in, redirect to their dashboard
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'System Administrator') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('blood-bank.dashboard');
    }
    // Otherwise show the landing page
    return view('landing');
})->name('home');

// Public access to blood bank for testing (remove authentication requirement)
Route::get('/blood-bank/dashboard', \App\Livewire\BloodBank\Dashboard::class)->name('blood-bank.dashboard');
Route::get('/blood-bank/inventory', \App\Livewire\BloodBank\InventoryManagement::class)->name('blood-bank.inventory');
Route::get('/blood-bank/donors', \App\Livewire\BloodBank\DonorManagement::class)->name('blood-bank.donors');
Route::get('/blood-bank/distributions', \App\Livewire\BloodBank\DistributionManagement::class)->name('blood-bank.distributions');
Route::get('/blood-bank/partners', \App\Livewire\BloodBank\PartnerEstablishments::class)->name('blood-bank.partners');
Route::get('/blood-bank/alerts', \App\Livewire\BloodBank\AlertManagement::class)->name('blood-bank.alerts');

// Admin routes (no email verification required for admin)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/establishments', \App\Livewire\Admin\EstablishmentManagement::class)->name('establishments');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
