


# json2excel package

Merge from json with excel,csv

## functionality:

-Merge json with Excel file
-Merge Json with Csv file
-Can flat a nested json

### Installing

composer require haythem/json2excel

## Deployment

use haythem\json2excel\functionality\JsonToExcelMerge;


$jsontoexcelmerge = new JsonToExcelMerge();

// to make nested json flat use

$flat_json = $jsontoexcelmerge->jsonToFlatJson($nested_json);

//to merge a Json file with Excel file  

$merged_excel_file_name = $jsontoexcelmerge->mergeToExcel($json_file_content, $excel_file_content,"value if data not found", "seprator");

//to merge a Json file with Csv file  

$merged_csv_file_name = $jsontoexcelmerge->mergeToCsv($json_file_content, $csv_file_content,"value if data not found", "seprator");

#Example

