<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v0')->group(function() {
    /**
     * Middleware to ensure the client version is supported.
     */
    Route::middleware(['client.version', 'set.locale'])->group(function () {
        require __DIR__ . '/api/admin/admin.php';
    });
});

/**
 * Block any request to lower version of the API.
 * Change the version as needed.
 * 
 * Notes for v0: As the lowest is v0, this route is intentionally commented out while v1 isn't yet released.
 * Don't forget to uncomment it when v1 is ready to be released.
 */
// Route::any('v0/{any}', function() {
//     return response()->json([
//         'message' => 'API version 0 is deprecated. Please use version 1.'
//     ], 410);
// })->where('any', '.*');

/**
 * Block any request to higher version of the API.
 * Change the version as needed.
 */
Route::any('v1/{any}', function() {
    return response()->json([
        'message' => 'API version 1 is not available yet. Please use version 0.'
    ], 410);
})->where('any', '.*');
