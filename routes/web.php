<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImovelController;

Route::get('/', [ImovelController::class, 'index'])->name('imoveis.index');
Route::post('/imoveis', [ImovelController::class, 'store'])->name('imoveis.store');
Route::get('/imoveis/{id}/edit', [ImovelController::class, 'edit'])->name('imoveis.edit');
Route::put('/imoveis/{id}', [ImovelController::class, 'update'])->name('imoveis.update');
Route::delete('/imoveis/{id}', [ImovelController::class, 'destroy'])->name('imoveis.destroy');
