<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\PortfolioController;

// Ruta de autenticación
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    return back()->withErrors([
        'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
    ])->onlyInput('email');
})->name('login.attempt');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // About Me
    Route::get('/about/edit', [AboutController::class, 'edit'])->name('about.edit');
    Route::put('/about', [AboutController::class, 'update'])->name('about.update');

    // Projects
    Route::resource('projects', ProjectController::class);

    // Certificates
    Route::resource('certificates', CertificateController::class);

    // Tools
    Route::resource('tools', ToolController::class);

    // Careers
    Route::resource('careers', CareerController::class);

    // Portfolio Management
    Route::get('/portfolio/arrange', [PortfolioController::class, 'arrange'])->name('portfolio.arrange');
    Route::post('/portfolio/reorder', [PortfolioController::class, 'reorder'])->name('portfolio.reorder');
});