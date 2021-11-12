<?php
include 'koneksi.php';


$fileName = $_FILES["file"]["tmp_name"];

if ($_FILES["file"]["size"] > 0) {

	$file = fopen($fileName, "r");

	while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
		$sqlInsert = "INSERT into data_uji (id_uji,document,klasifikasi_manual,klasifikasi_sistem)
			values ('" . $column[0] . "','" . $column[1] . "','" . $column[3] . "','" . $column[4] . "')";
		$result = mysqli_query($koneksi, $sqlInsert);

		// alihkan halaman ke index.php
		echo '<script>alert("Berhasil import data!"); document.location="index.php?halaman=data_uji";</script>';
	}
}
