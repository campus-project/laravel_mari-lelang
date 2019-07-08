<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('refresh', function () {
    try {
        try {
            Artisan::call('migrate:fresh --seed');
            $this->comment('Migrate successfully!');
        } catch (\Exception $e) {
            $this->comment($e->getMessage());
        }
    } catch (\Exception $e) {
        $this->comment($e->getMessage());
    }
})->describe('Refresh');
