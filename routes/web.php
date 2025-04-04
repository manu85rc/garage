<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\PrintController;



use App\Http\Controllers\EstacionamientoController;

Route::get('/', [EstacionamientoController::class, 'index'])->name('estacionamiento.index');
Route::post('/estacionamiento', [EstacionamientoController::class, 'store'])->name('estacionamiento.store');
Route::get('/estacionamiento/{id}/edit', [EstacionamientoController::class, 'edit'])->name('estacionamiento.edit');
Route::put('/estacionamiento/{id}', [EstacionamientoController::class, 'update'])->name('estacionamiento.update');
Route::get('/estacionamiento/{id}/facturar', [EstacionamientoController::class, 'facturar'])->name('estacionamiento.facturar');
Route::post('/estacionamiento/{id}/facturar', [EstacionamientoController::class, 'procesarFactura'])->name('estacionamiento.procesar-factura');

Route::get('/estacionamiento/caja', [EstacionamientoController::class, 'caja'])->name('estacionamiento.caja');
Route::post('/estacionamiento/editcaja', [EstacionamientoController::class, 'editCaja'])->name('estacionamiento.edit.caja');
Route::get('/hora', function () {
    return view('hora');
});






Route::get('/imprimir-pdf', [PrintController::class, 'imprimirPdf'])->name('imprimir.pdf');



// Route::get('/', function () {
//     return view('dashboard');
// });

Route::get('/index', function () {
    return view('garage');
});



Route::get('/ticket', function () {
    return view('ticket'); // ticket bonito
});

// Route::get('/ticket2', function () {

    
//     return view('ticket2'); // ticket bonito

// });
Route::get('/ticket2', [PrintController::class, 'imprimirPdf'])->name('imprimir.pdf');
