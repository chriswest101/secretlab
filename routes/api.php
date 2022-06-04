<?php

use App\Http\Controllers\Api\StoreController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$route = app(Router::class);

Route::prefix('object')->group(static function () use ($route) {
    $route->get('/get_all_records', [StoreController::class, 'all'])->name('secretlab.all');
    $route->get('/{myKey}', [StoreController::class, 'get'])->name('secretlab.get');
    $route->post('/', [StoreController::class, 'store'])->name('secretlab.store');
});
