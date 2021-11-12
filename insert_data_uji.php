<?php

$document	= $_POST['document'];
$code_sentiment    = $_POST['code_sentiment'];
$sql = mysqli_query($koneksi, "INSERT INTO data_uji VALUES(NULL,'$document','$code_sentiment','Belum Diketahui')") or die(mysqli_error($koneksi));

if($sql){
	echo '<script>alert("Berhasil menambahkan data!"); document.location="index.php?halaman=data_uji";</script>';
}else{
	echo '<script>alert("Gagal menambahkan data!"); document.location="index.php?halaman=data_uji";</script>';
}
?>