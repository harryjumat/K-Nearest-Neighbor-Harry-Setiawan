<?php

$document	= $_POST['document'];
$code_sentiment    = $_POST['code_sentiment'];
$sql = mysqli_query($koneksi, "INSERT INTO documents VALUES(NULL,'$document','$code_sentiment')") or die(mysqli_error($koneksi));

if($sql){
	echo '<script>alert("Berhasil menambahkan data!"); document.location="index.php?halaman=data_latih";</script>';
}else{
	echo '<script>alert("Gagal menambahkan data!"); document.location="index.php?halaman=data_latih";</script>';
}
?>