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
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BigAffectationController;
use App\Http\Controllers\MaterielController;

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
    Route::delete('/affectationDel/{affectation}', [AffectationController::class, 'destroyInShow'])->middleware('is_admin:admin')->name('destroyInShow'); 
    Route::post('/upload/{affectation}', [AffectationController::class, 'upload'])->middleware('is_admin:admin')->name('upload');
    // Alternative direct upload route for IIS server
    Route::post('/upload-direct/{affectation}', [AffectationController::class, 'uploadDirect'])->middleware('is_admin:admin')->name('upload.direct');
    // Route to delete uploaded files
    Route::delete('/delete-file/{affectation}', [AffectationController::class, 'deleteFile'])->middleware('is_admin:admin')->name('delete.file');
    // Route pour télécharger les fichiers de manière sécurisée
    Route::get('/download-file/{affectation}', [AffectationController::class, 'downloadFile'])->name('download.file');
    Route::get('/download-big-file/{bigAffectation}', [AffectationController::class, 'downloadBigFile'])->name('download.big.file');
    // ajouter pour un utilisateur exist
    Route::get('/affectation/userExists/{user}', [AffectationController::class, 'userExists'])->middleware('is_admin:admin')->name('userExists');

    // ! utilisateur
    Route::resource('/utilisateur', UtilisateurController::class)->middleware('is_admin:admin');

    // ! download pdf
    Route::get('/downloadPdf/{affectation}', [PdfController::class, 'generatePdf'])->name('generatePdf');
    Route::post('/generateMultiPdf', [PdfController::class, 'generateMultiPdf'])->name('generateMultiPdf');
    Route::post('/generateBigAffectation', [PdfController::class, 'generateBigAffectation'])->name('generateBigAffectation');

    // dashboard
    Route::get('/affectation/getByNum/{num_serie}', [AffectationController::class, 'getByNum'])->name('getByNum');

    // types
    Route::resource('/type', TypeController::class)->middleware('is_admin:admin');

    // settings

    // trash
    Route::get('/trash', [trashController::class, 'index'])->name('trash.index');
    Route::delete('/trash/{type}/{id}', [trashController::class, 'forceDelete'])->name('trash.forceDelete');
    // account management
    Route::resource('accounts', AccountController::class)->middleware('is_admin:admin');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('notifications', NotificationController::class)->middleware('is_admin:admin');
    Route::post('/notifications/{notification}/valider', [NotificationController::class, 'valider'])->name('notifications.valider');
    Route::get('/telephones', [TelephoneController::class, 'index'])->name('telephones.index');
    Route::get('/telephones/create', [TelephoneController::class, 'create'])->name('telephones.create');
    Route::post('/telephones', [TelephoneController::class, 'store'])->name('telephones.store');
    Route::get('/telephones/{id}/edit', [TelephoneController::class, 'edit'])->name('telephones.edit');
    Route::put('/telephones/{telephone}', [TelephoneController::class, 'update'])->name('telephones.update');
    Route::delete('/telephones/{telephone}', [TelephoneController::class, 'destroy'])->name('telephones.destroy');
    Route::post('/affectation/{affectation}/send-email', [AffectationController::class, 'sendEmail'])->name('send.affectation.email');
    Route::post('/affectationMateriels/{bigAffectation}/send-email', [AffectationController::class, 'sendEmailMateriels'])->name('send.affectations.email');
    Route::resource('recrutements', RecrutementController::class);
    Route::post('/big-affectation/{bigAffectation}/upload', [BigAffectationController::class, 'uploadFile'])->name('upload.big.file');
    // Route::get('/big-affectation/{bigAffectation}/download', [BigAffectationController::class, 'downloadFile'])->name('download.big.file');
    // Route::delete('/big-affectation/{bigAffectation}/delete-file', [BigAffectationController::class, 'deleteFile'])->name('delete.big.file');
    Route::delete('/big-affectation/{bigAffectation}', [PdfController::class, 'deleteBigAffectation'])->name('delete.big.affectation');

    Route::get('/not_read' ,[NotificationController::class ,'not_read'])->name('notifications.not_read');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
