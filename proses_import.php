<?php
include('koneksi.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

if (isset($_FILES['berkas_excel']['name']) && in_array($_FILES['berkas_excel']['type'], $file_mimes)) {

    $arr_file = explode('.', $_FILES['berkas_excel']['name']);
    $extension = end($arr_file);

    if ('csv' == $extension) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } else {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }

    $spreadsheet = $reader->load($_FILES['berkas_excel']['tmp_name']);

    $sheetData = $spreadsheet->getActiveSheet()->toArray();
    for ($i = 1; $i < count($sheetData); $i++) {
        $document = $sheetData[$i]['1'];
        $klasifikasi_manual = $sheetData[$i]['2'];
        $klasifikasi_sistem = $sheetData[$i]['3'];
        mysqli_query($koneksi, "insert into data_uji (document,klasifikasi_manual,klasifikasi_sistem) values ('$document','$klasifikasi_manual','$klasifikasi_sistem')");
    }
    // alihkan halaman ke index.php
    echo '<script>alert("Berhasil import data!"); document.location="index.php?halaman=data_uji";</script>';
}
