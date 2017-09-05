<?php
Route::controller("/ry/caracteres/admin", "AdminController");
Route::get('characteristics/{characteristic}', '\Ry\Caracteres\Http\Controllers\PublicController@getCharacteristic')->where("characteristic", ".+");
Route::controller('caracteres/json', 'PublicJsonController');
