<?php

if ($_GET['type'] == 'uji') {
	$id_uji = $_POST['id_uji'];
	$sql = mysqli_query($koneksi, "DELETE FROM data_uji where id_uji = '$id_uji'") or die(mysqli_error($koneksi));

	if($sql){
		echo '<script>alert("Berhasil merubah data!"); document.location="index.php?halaman=data_uji";</script>';
	}else{
		echo '<script>alert("Gagal merubah data!"); document.location="index.php?halaman=data_uji";</script>';
	}

}else if ($_GET['type'] == 'latih') {

	$doc_id = $_POST['doc_id'];
	$sql = mysqli_query($koneksi, "DELETE FROM documents where doc_id = '$doc_id'") or die(mysqli_error($koneksi));

	if($sql){
		echo '<script>alert("Berhasil merubah data!"); document.location="index.php?halaman=data_latih";</script>';
	}else{
		echo '<script>alert("Gagal merubah data!"); document.location="index.php?halaman=data_latih";</script>';
	}

}



?>