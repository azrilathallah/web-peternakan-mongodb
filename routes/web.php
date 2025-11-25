<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.slamet_quail_farm.pages.dashboard');
});
