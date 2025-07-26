<?php

use App\Models\Work;
use Illuminate\Support\Facades\Route;

Route::get('/works/{work}', function(Work $work) {
  return [
    'id'               => $work->id,
    'name'             => $work->name,
    'price'            => $work->price,
    'work_image_low'   => $work->work_image_low, 
  ];
});
