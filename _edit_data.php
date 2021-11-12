<?php

if ($_GET['type'] == 'uji') {
	$id_uji = $_POST['id_uji'];
	$document	= $_POST['document'];
	$code_sentiment    = $_POST['code_sentiment'];
	$sql = mysqli_query($koneksi, "UPDATE  data_uji set document = '$document', klasifikasi_manual = '$code_sentiment' where id_uji = '$id_uji'") or die(mysqli_error($koneksi));

	if($sql){
		echo '<script>alert("Berhasil merubah data!"); document.location="index.php?halaman=data_uji";</script>';
	}else{
		echo '<script>alert("Gagal merubah data!"); document.location="index.php?halaman=data_uji";</script>';
	}

}else if ($_GET['type'] == 'latih') {

	$doc_id = $_POST['doc_id'];
	$document	= $_POST['document'];
	$code_sentiment    = $_POST['code_sentiment'];
	$sql = mysqli_query($koneksi, "UPDATE documents set document = '$document', code_sentiment = '$code_sentiment' where doc_id = '$doc_id'") or die(mysqli_error($koneksi));

	if($sql){
		echo '<script>alert("Berhasil merubah data!"); document.location="index.php?halaman=data_latih";</script>';
	}else{
		echo '<script>alert("Gagal merubah data!"); document.location="index.php?halaman=data_latih";</script>';
	}

}



?>