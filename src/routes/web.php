
<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use haythem\json2excel\functionality\JsonToExcelMerge;






Route::get('test', function () {
    $json = file_get_contents(__DIR__ . "\sample.json");
    $file_xlsx = Storage::disk('json2excel')->get('test.xlsx');
    $file_csv = Storage::disk('json2excel')->get('csv.csv');


    $jsontoexcelmerge = new JsonToExcelMerge();
    //return $jsontoexcelmerge->jsonToFlatJson($json);
    //return $jsontoexcelmerge->mergeToCsv($json, $file_csv);
    //return $jsontoexcelmerge->mergeToExcel($json, $file_xlsx, 1, "xlsx");
});
