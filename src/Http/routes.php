<?php
Route::any("/ry/caracteres/admin/{action}", "AdminController@controller_action")->where("action", ".*");
Route::get('characteristics/{characteristic}', '\Ry\Caracteres\Http\Controllers\PublicController@getCharacteristic')->where("characteristic", ".+");
Route::any('caracteres/json/{action}', 'PublicJsonController@controller_json')->where("action", ".*");
