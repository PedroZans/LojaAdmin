<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\Api\MunicipioIbgeController;
use App\Http\Controllers\Api\IbgeController;





Route::put('/teste-put', function (Request $request) {
    return response()->json(['message' => 'Requisição PUT recebida!']);
});

 // IBGE routes
 Route::prefix('v1')->group(function () {
    Route::prefix('ibge')->group(function () {
        Route::get('municipios-rj', [MunicipioIbgeController::class, 'getMunicipiosRJ']);
        Route::get('municipios', [IbgeController::class, 'importarMunicipios']);
    });
});



    // Test route
    Route::get('/v1/test', function () {
        return response()->json(['message' => 'Success']);
    })->middleware('car.token');

// Public routes (if any)

    Route::prefix('v1')->group(function () {
    Route::get('/produtos', [ProdutoController::class, 'index']);
    Route::post('/produtos', [ProdutoController::class, 'store']);
    Route::get('/produtos/{id}', [ProdutoController::class, 'show']);
    Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->middleware('car.token');
    Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);

});



