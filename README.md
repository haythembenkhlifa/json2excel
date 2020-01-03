# json2excel package

Merge json with excel,csv

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

## JSON

```json
{
  "name": "Haythem",
  "age": 30,
  "address": {
    "number": 10,
    "street": "somewhere",
    "other": {
      "province": "Tx",
      "postal_code": "2020"
    }
  }
}
```

Resullt:

```json
array:1 [
0 => array:6 [
"name" => "Haythem"
"age" => 30
"address.number" => 10
"address.street" => "somewhere"
"address.other.province" => "Tx"
"address.other.postal_code" => "2020"
]
]
```

## Merge Json with and Excel file

## JSON

```json
{
  "mark1": 12,
  "mark2": 19.99
}
```

Before:

![alt text](https://raw.githubusercontent.com/haythembenkhlifa/json2excel/master/src/images/excelbefore.PNG)

After:

![alt text](https://raw.githubusercontent.com/haythembenkhlifa/json2excel/master/src/images/excelafter.PNG)

## Merge Json with and Csv file

## JSON

```json
{
  "mark1": 12,
  "mark2": 19.99
}
```

Before:

![alt text](https://raw.githubusercontent.com/haythembenkhlifa/json2excel/master/src/images/csvbefore.PNG)

Afetr:

![alt text](https://raw.githubusercontent.com/haythembenkhlifa/json2excel/master/src/images/csvafter.PNG)

### mark1;mark2;mark3;name;grade

### 12;19,99;Not Yet;Haythem;6
