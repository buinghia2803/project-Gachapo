<?php

namespace App\Helpers;

class CommonHelper
{
    public static function displayText(string $text = null)
    {
        $limit = 150;
        $str = $text;
        if(strlen($text) > $limit) {
            $str = substr($text, 0, $limit) . '...';
        }
        return $str;
    }

    /**
     * Format Time
     * @param string $time
     * @param string $format
     * @return string
     */
    public static function formatTime($time, $format = 'Y年m月d日')
    {
        return date($format, strtotime($time));
    }

    /**
     * Format Price
     * @param number $price
     * @param string $zero_string
     * @param string $unit
     * @return string
     */
    public static function formatPrice($price, $zero_string = null, $unit = '円')
    {
        if ($zero_string != null && $price == 0) {
            return $zero_string;
        }
        return number_format($price, 0, '.', ',').$unit;
    }

    /**
     * ExportCsv
     * @param array $data: EG $data = [ 'file_name' => '', 'fields' => [], 'data' => []]
     * @return string
     */
    public static function ExportCsv($data)
    {
        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Encoding" => 'UTF-8',
            "Content-Disposition" => "attachment; filename=".$data['file_name'].".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $callback = function() use($data) {
            $file = fopen('php://output', 'w');
            // mb_convert_encoding($file, 'UTF-16LE', 'UTF-8');
            fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
            fputcsv($file, $data['fields']);
            if (isset($data['header'])) {
                fputcsv($file, $data['header']);
            }
            foreach($data['data'] as $dataRow) {
                fputcsv($file,  $dataRow);
            }
            fclose($file);
        };
        return \Response::stream($callback, 200, $headers);
    }

    /**
     * Read Excel at file path and return Excel data
     * @param string $path File path. $file->getPathName()
     * @param array $colums EG $colums = [ 'name' => $columNumber ]. $columNumber [ A: 1 | B: 2 | C: 3 | ... ]
     * @return array
     */
    public static function readExcel($path, $colums = [])
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        $data = [];
        for ($i = 1; $i <= $highestRow; $i++) {
            $item = [];
            foreach($colums as $key => $colum) {
                $cellData = $worksheet->getCellByColumnAndRow($colum, $i)->getValue();
                $item[$key] = $cellData;
            }
            $data[] = $item;
        }
        return $data;
    }
}
