<?php

use Illuminate\Routing\Router;
use Bikaraan\BForm\Http\Controllers\FormController;
use Bikaraan\BForm\Http\Controllers\BFormController;
use Bikaraan\BForm\Http\Controllers\FieldController;
use Bikaraan\BForm\Http\Controllers\PatternController;
use Bikaraan\BForm\Http\Controllers\UserDataController;
use Bikaraan\BForm\Http\Controllers\PatterFieldController;

Route::group([
    'prefix' => config('admin.extensions.bform.config.prefix', 'bform'),
    'as' => 'bform.',
], function (Router $router) {

    $router->get('/', BFormController::class . '@index');

    $router->resource('patterns', PatternController::class);
    $router->resource('pattern/{pattern_id}/fields', PatterFieldController::class, ['as' => 'pattern'])->names([
        'index' => 'pattern.fields.index',
    ]);
    $router->resource('forms', FormController::class);
    $router->resource('fields', FieldController::class);
    $router->resource('user-data', UserDataController::class);
});
