<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('autumn:about', function () {
    $this->info('AUTUMN: Automated Unified Merchandise Network');
});
