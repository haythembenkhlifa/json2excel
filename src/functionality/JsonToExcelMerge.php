<?php

namespace haythem\json2excel\functionality;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use NestedJsonFlattener\Flattener\Flattener;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as reader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as writer;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;

class JsonToExcelMerge
{
    public $disk;

    public function __construct()
    {
        $this->disk = config('json2excel.disk');
    }


    public function mergeToExcel($json, $excel_file, $default_value_if_empty = "", $extenstion = "xlsx")
    {

        $xlsx_file = $this->validateExcel($excel_file, $this->disk);

        if ((($excel_file) && ($json) && (in_array($extenstion, ["xlsx", "xls"])) && (!empty($this->validateJson($json))) && (!empty($xlsx_file)))) {

            //make an teh json content to an array

            $array = json_decode($json, true);

            $cell_to_update = [];
            $res = array_key_exists("projected-income", $array);

            //Get the duplicated file
            $file = Storage::disk($this->disk)->path($xlsx_file);


            $reader = new reader();

            //  $reader->setReadDataOnly(false);

            $spreadsheet = $reader->load($file);


            Calculation::getInstance($spreadsheet)->disableCalculationCache();
            Calculation::getInstance($spreadsheet)->clearCalculationCache();


            $worksheetData = $reader->listWorksheetInfo($file);

            foreach ($worksheetData as $worksheet) {

                $sheetName = $worksheet['worksheetName'];
                /**  Load $inputFileName to a Spreadsheet Object  **/
                $reader->setLoadSheetsOnly($sheetName);

                $worksheet = $spreadsheet->getActiveSheet();

                foreach ($worksheet->getRowIterator() as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                    $cells = [];
                    foreach ($cellIterator as $cell) {
                        $cell_value = $cell->getValue();
                        if (Str::startsWith($cell_value, '#') && Str::endsWith($cell_value, '#')) {

                            $res = array_key_exists(substr($cell_value, 1, -1), $array);
                            $cordonation = $cell->getCoordinate();
                            $value = $spreadsheet->getActiveSheet()->getCell($cordonation);
                            $cell_to_update[$cordonation] = $value;

                            if ($res) {
                                $array_value = $array[substr($cell_value, 1, -1)];
                                if (is_array($array_value)) {
                                    $array_value =  $links = implode(' ', $array_value);
                                }
                                $spreadsheet->getActiveSheet()->getCell($cordonation)->setValue($array_value);
                            } else {
                                $spreadsheet->getActiveSheet()->getCell($cordonation)->setValue($default_value_if_empty);
                            }
                        }
                    }
                }
            }

            //now we goint to write the updates in a new file
            $writer = new  writer($spreadsheet);
            $writer->setPreCalculateFormulas(true);
            $file_name = Str::uuid() . '.' . $extenstion;
            $writer->save($file_name);
            return $file_name;
            //delete the old file
            Storage::disk($this->disk)->delete($xlsx_file);
        } else {
            return "please make sure to provide a json file or a json string and you must provide an excel file to merge";
        }
    }


    public function mergeToCsv($json, $csv_file, $default_value_if_empty = "null", $separator = ",")
    {

        $csv_file = $this->validateCsv($csv_file, $this->disk);

        if ((($csv_file) && ($json) && (!empty($this->validateJson($json))) && (!empty($csv_file)))) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            $empty_array = [];
            $file = Storage::disk($this->disk)->path($csv_file);
            $array = json_decode($json, true);

            $spreadsheet = $reader->load($file);
            $sheetData   = $spreadsheet->getActiveSheet()->toArray();

            foreach ($sheetData as $row) {
                foreach ($row as $key => $column) {
                    if (Str::startsWith($column, '#') && Str::endsWith($column, '#')) {
                        $res = array_key_exists(substr($column, 1, -1), $array);
                        if ($res) {
                            $array_value = $array[substr($column, 1, -1)];
                            if (is_array($array_value)) {
                                $array_value =  $links = implode(',', $array_value);
                            }
                            $row[$key] = $array_value;
                        } else {
                            $row[$key] = $default_value_if_empty;
                        }
                    }
                }
                array_push($empty_array, $row);
            }
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->fromArray($empty_array, NULL, 'A1');
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setDelimiter($separator);
            $merged_file = Str::uuid() . ".csv";
            $writer->save($merged_file);
            Storage::disk($this->disk)->delete($csv_file);
            return $merged_file;
        } else {
            return "please make sure to provide a json string and you must provide an csv file to merge";
        }
    }




    public function jsonToFlatJson($json)
    {

        try {
            $flat = null;

            $flattener = new Flattener();

            $flattener->setJsonData($json);

            $flat = $flattener->getFlatData();


            if ($flat) {
                return $flat;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            dd("invalid json format");
        }
    }


    public function validateJson($json)
    {
        $json_without_space = trim(preg_replace("/\s\s+/", "", $json));

        try {
            if (Str::startsWith($json_without_space, '{') && Str::endsWith($json_without_space, '}')) {
                return json_decode($json, true);
            }
            return null;
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function validateExcel($excel_file)
    {

        try {
            $file_name = Str::uuid() . ".xlsx";
            Storage::disk($this->disk)->put($file_name, $excel_file);
            return $file_name;
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function validateCsv($csv_file)
    {

        try {
            $file_name = Str::uuid() . ".csv";
            Storage::disk($this->disk)->put($file_name, $csv_file);
            return $file_name;
        } catch (\Throwable $th) {
            return null;
        }
    }
}
