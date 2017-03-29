<?php

// 登录注册
Route::group(['prefix' => 'auth', 'namespace' => 'Ckryo\AdminAuth\Controllers'], function () {
    Route::resource('login', 'LoginController', ['only' => ['store']]);

});