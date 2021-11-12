<?php
include('koneksi.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'id_uji');
$sheet->setCellValue('B1', 'document');
$sheet->setCellValue('C1', 'klasifikasi_manual');
$sheet->setCellValue('D1', 'klasifikasi_sistem');

$query = mysqli_query($koneksi, "select * from datauji_scrap");
$i = 2;
while ($row = mysqli_fetch_array($query)) {
    $sheet->setCellValue('A' . $i, $row['id']);
    $sheet->setCellValue('B' . $i, $row['tweet']);
    $sheet->setCellValue('C' . $i, $row['klasifikasi_manual']);
    $sheet->setCellValue('D' . $i, $row['klasifikasi_sistem']);
    $i++;
}

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$i = $i - 1;
$sheet->getStyle('A1:E' . $i)->applyFromArray($styleArray);


$writer = new Xlsx($spreadsheet);
$writer->save('Data Tweet.xlsx');
echo "<script>window.location = 'Data Tweet.xlsx'</script>";
