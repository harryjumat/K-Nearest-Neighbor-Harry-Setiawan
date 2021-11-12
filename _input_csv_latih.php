<?php
include 'koneksi.php';


	$fileName = $_FILES["file"]["tmp_name"];

	if ($_FILES["file"]["size"] > 0) {

		$file = fopen($fileName, "r");

		while (($column = fgetcsv($file, 100000000, ",")) !== FALSE) {
			$sqlInsert = "INSERT into documents (doc_id,document,aspek,code_sentiment)
			values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "')";
			$result = mysqli_query($koneksi, $sqlInsert);

// alihkan halaman ke index.php
			echo '<script>alert("Berhasil import data!"); document.location="index.php?halaman=data_latih";</script>';
		}
	}
