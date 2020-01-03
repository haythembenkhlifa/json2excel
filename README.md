# json2excel package

Merge from json with excel,csv

## functionality:

-Merge json with Excel file
-Merge Json with Csv file
-Can convert nested json to flat array

### Installing

composer require haythem/json2excel

## Deployment

use haythem\json2excel\functionality\JsonToExcelMerge;

\$jsontoexcelmerge = new JsonToExcelMerge();

// to make nested json flat array use

$flat_json = $jsontoexcelmerge->jsonToFlatJson(\$nested_json);

//to merge a Json file with Excel file

$merged_excel_file_name = $jsontoexcelmerge->mergeToExcel($json_file_content, $excel_file_content,"value if data not found", "seprator");

//to merge a Json file with Csv file

$merged_csv_file_name = $jsontoexcelmerge->mergeToCsv($json_file_content, $csv_file_content,"value if data not found", "seprator");

#Example

##Nested json to Flat array

{
"name" : "Haythem",
"age" : 30,
"address": {
"number" : 10,
"street" : "somewhere",
"other" : {
"province" : "Tx",
"postal_code":"2020"
}  
 }
}

Resullt:

array:1 [▼
0 => array:6 [▼
"name" => "Haythem"
"age" => 30
"address.number" => 10
"address.street" => "somewhere"
"address.other.province" => "Tx"
"address.other.postal_code" => "2020"
]
]

## Merge Json with and Excel file

Before

json :

{
"mark1": 12,
"mark2": 19.99
}

Excel file :
