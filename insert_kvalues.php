<?php

$nilai_k	= $_POST['nilai_k'];
// $n_positif    = $_POST['n_positif'];
// $n_negatif    = $_POST['n_negatif'];
// $n_netral    = $_POST['n_netral'];


$positif_data_latih = mysqli_query($koneksi,"SELECT*FROM documents WHERE code_sentiment = 's1'")  or die(mysqli_error($koneksi)); 
$sum_positif_data_latih = mysqli_num_rows($positif_data_latih);

$negatif_data_latih = mysqli_query($koneksi,"SELECT*FROM documents WHERE code_sentiment = 's2'")  or die(mysqli_error($koneksi)); 
$sum_negatif_data_latih = mysqli_num_rows($negatif_data_latih);

$netral_data_latih = mysqli_query($koneksi,"SELECT*FROM documents WHERE code_sentiment = 's3'")  or die(mysqli_error($koneksi)); 
$sum_netral_data_latih = mysqli_num_rows($netral_data_latih);

if ($sum_positif_data_latih >= $sum_negatif_data_latih && $sum_positif_data_latih >= $sum_netral_data_latih) {
 	$max = $sum_positif_data_latih;
 }else if($sum_negatif_data_latih >= $sum_positif_data_latih && $sum_negatif_data_latih >= $sum_netral_data_latih) {
 	$max = $sum_negatif_data_latih;
 }else if($sum_netral_data_latih >= $sum_positif_data_latih && $sum_netral_data_latih >= $sum_negatif_data_latih) {
 	$max = $sum_netral_data_latih;
 }

$n_positif = ($nilai_k * $sum_positif_data_latih) / $max; 
$n_negatif = ($nilai_k * $sum_negatif_data_latih) / $max; 
$n_netral = ($nilai_k * $sum_netral_data_latih) / $max; 


$cek = mysqli_query($koneksi,"SELECT*FROM kvalues_baru where nilai_k = '$nilai_k'")  or die(mysqli_error($koneksi)); 
$cek_k = mysqli_num_rows($cek);

if ($cek_k == 0 ) {
	$sql = mysqli_query($koneksi, "INSERT INTO kvalues_baru VALUES(NULL,'$nilai_k','$n_positif','$n_negatif','$n_netral')") or die(mysqli_error($koneksi));
}else{
	$sql = mysqli_query($koneksi, "UPDATE kvalues_baru SET n_positif = '$n_positif', n_negatif = '$n_negatif', n_netral = '$n_netral' WHERE nilai_k = '$nilai_k'") or die(mysqli_error($koneksi));
}

if($sql){
	echo '<script>alert("Berhasil menambahkan data!"); document.location="index.php";</script>';
}else{
	echo '<script>alert("Gagal menambahkan data!"); document.location="index.php";</script>';
}
?>