<?php
/**
 * User: widdy
 * Date: 2019/11/1
 * Time: 23:45
 */

Route::group([
    'prefix' => config('gui.route.prefix'),
    'namespace' => 'ChastePhp\LaravelGUI\Controllers'
], function ($router) {
    Route::get('/', 'IndexController@index');
    Route::post('/execute', 'IndexController@execute');
});
