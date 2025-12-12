<?php

use App\Http\Controllers\Api\PaymentCallbackController;
use Illuminate\Support\Facades\Route;

Route::post('midtrans-callback', [PaymentCallbackController::class, 'receive']);