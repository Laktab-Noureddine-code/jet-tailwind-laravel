<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImprimanteController;
use App\Http\Controllers\OrdinateurController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PeripheriqueController;
use App\Http\Controllers\trashController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RecrutementController;
use App\Http\Controllers\TelephoneController;
use App\Http\Controllers\UtilisateurController;
use App\Mail\TestMail;
use App\Models\Affectation;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

// Root route - redirect to dashboard if authenticated, or login if not
Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware("auth")->group(function () {
    // Redirection de la racine vers le tableau de bord

    // Route du tableau de bord
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    // 

    Route::get('getChartData', [DashboardController::class, 'getChartData'])->middleware('is_admin:admin');
    Route::get('getAffectationStats', [DashboardController::class, 'getAffectationStats'])->middleware('is_admin:admin');
    Route::get('/getAffectationByMonth', [DashboardController::class, 'getAffectationByMonth'])->middleware('is_admin:admin');

    // ? ordinateurs
    Route::resource('/ordinateurs', OrdinateurController::class)->middleware('is_admin:admin');

    // ? imprimantes
    Route::resource('/imprimantes', ImprimanteController::class)->middleware('is_admin:admin');

    // ? Périphériques
    Route::get('/materiel/{num_serie}', [AffectationController::class, 'getMaterielInfo'])->middleware('is_admin:admin')->name('materiel.info');
    Route::resource('/peripheriques', PeripheriqueController::class)->middleware('is_admin:admin');

    // ! affectations
    Route::resource('/affectation', AffectationController::class)->middleware('is_admin:admin');
    // Route::get('/affectation/getByNum', [AffectationController::class, 'getByNum'])->name('getByNum');
    Route::post('/affectation/storeExists', [AffectationController::class, 'storeExists'])->middleware('is_admin:admin')->name('storeExists');
    Route::post('/upload/{affectation}', [AffectationController::class, 'upload'])->middleware('is_admin:admin')->name('upload');
    // ajouter pour un utilisateur exist
    Route::get('/affectation/userExists/{user}', [AffectationController::class, 'userExists'])->middleware('is_admin:admin')->name('userExists');

    // ! utilisateur
    Route::resource('/utilisateur', UtilisateurController::class)->middleware('is_admin:admin');

    // ! download pdf
    Route::get('/downloadPdf/{affectation}', [PdfController::class, 'generatePdf'])->name('generatePdf');


    // dashboard
    Route::get('/affectation/getByNum/{num_serie}', [AffectationController::class, 'getByNum'])->name('getByNum');



    // types
    Route::resource('/type', TypeController::class)->middleware('is_admin:admin');



    // settings
    Route::get('/settings', function () {
        return view('settings.index');
    })->middleware('is_admin:admin')->name('settings');

    // trash
    Route::get('/trash', [trashController::class, 'index'])->name('trash.index');
    Route::delete('/trash/{type}/{id}', [trashController::class, 'forceDelete'])->name('trash.forceDelete');
    // account management
    Route::resource('accounts', AccountController::class)->middleware('is_admin:admin');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('recrutements', RecrutementController::class)->middleware('is_admin:user');
    Route::resource('notifications', NotificationController::class)->middleware('is_admin:admin');
    Route::post('/notifications/{notification}/valider', [NotificationController::class, 'valider'])->name('notifications.valider');
    Route::get('/telephones', [TelephoneController::class, 'index'])->name('telephones.index');
    Route::get('/telephones/{id}/edit', [TelephoneController::class, 'edit'])->name('telephones.edit');
    Route::put('/telephones/{telephone}', [TelephoneController::class, 'update'])->name('telephones.update');
    Route::delete('/telephones/{telephone}', [TelephoneController::class, 'destroy'])->name('telephones.destroy');
    Route::post('/affectation/{affectation}/send-email', [AffectationController::class, 'sendEmail'])->name('send.affectation.email');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
