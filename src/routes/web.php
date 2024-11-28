<?php

use Custom\Yajra\Http\Controllers\YajraController;
use Illuminate\Support\Facades\Route;

Route::get('yajra', [YajraController::class, 'index']);
