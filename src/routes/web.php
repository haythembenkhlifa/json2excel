
<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use haythem\json2excel\functionality\JsonToExcelMerge;






Route::get('test', function () {

    dd();
    $json = '{
			"mark1": 12,
			"mark2": 19.99
			}';
    // $file_xlsx = Storage::disk('public')->get('edited.xlsx');
    $file_csv = Storage::disk('public')->get('csv.csv');


    $jsontoexcelmerge = new JsonToExcelMerge();
    //return $jsontoexcelmerge->jsonToFlatJson($json);
    return $jsontoexcelmerge->mergeToCsv($json, $file_csv, "Not Yet", ",");
    //return $jsontoexcelmerge->mergeToExcel($json, $file_xlsx,"Not Yet", "xlsx");
});
