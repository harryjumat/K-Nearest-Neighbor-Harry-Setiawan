<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'tweet');
$sheet->setCellValue('C1', 'klasifikasi_manual');
$sheet->setCellValue('D1', 'klasifikasi_sistem');
foreach ($result as $k => $v) {
    $sheet->setCellValue('A($str_id)', $str_id);
    $sheet->setCellValue('B($str_id)', $output);
    $sheet->setCellValue('C($str_id)', ' ');
    $sheet->setCellValue('D($str_id)', 'Belum Diketahui');
}

$filename = 'sample-' . time() . '.xlsx';
// Redirect output to a client's web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');

$writer = new Xlsx($spreadsheet);
$writer->save('Data_Uji.xlsx');
