<?php
require 'vendor/autoload.php';

$koneksi = mysqli_connect("localhost", "root", "", "db_kuliah_ai_aa");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Isi Text');
$sheet->setCellValue('A1', 'Source');

$jokowi = mysqli_query($koneksi, "select * from tbl_data_tweet");
$start = 2;
while ($row = mysqli_fetch_array($jokowi)) {
    $sheet->setCellValue('A' . $start, $row['isi_text']);
    $sheet->setCellValue('B' . $start, $row['source']);
    $start++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('twitter_jokowi.xlsx');
