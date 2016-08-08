<?php
Route::get('characteristics/{characteristic}', '\Ry\Caracteres\Http\Controllers\PublicController@getCharacteristic')->where("characteristic", ".+");
Route::controller('caracteres/json', 'PublicJsonController');
