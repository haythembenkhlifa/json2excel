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
        Storage::disk("json2excel")->files();
    }
    public function register()
    {
        $this->app->config["filesystems.disks.json2excel"] = [
            'driver' => 'local',
            'root' => storage_path('/json2excel'),
        ];
    }
}
