<?php

use App\Http\Controllers\Api\StoreController;
use Illuminate\Routing\Router;

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

$route->middleware(['validate-get'])->group(function () use ($route) {
    $route->get('object/get_all_records', [StoreController::class, 'all'])->name('secretlab.all');
    $route->get('object/{myKey}', [StoreController::class, 'get'])->name('secretlab.get');
});
$route->post('object/', [StoreController::class, 'store'])->name('secretlab.store');
