<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment('Wengel for World - Spreading the Gospel everywhere.');
})->purpose('Display an inspiring quote');
