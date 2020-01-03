<?php

namespace haythem\json2excel;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class Json2ExcelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'json2excel');
        $this->mergeConfigFrom(
            __DIR__ . '/config/json2excelconfig.php',
            'json2excel'
        );
    }
}
