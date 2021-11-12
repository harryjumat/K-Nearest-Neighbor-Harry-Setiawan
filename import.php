<!-- import excel ke mysql -->
<!-- www.malasngoding.com -->

<?php 
// menghubungkan dengan koneksi
include 'koneksi/koneksi.php';
// menghubungkan dengan library excel reader
include "excel_reader2.php";
?>

<?php
// upload file xls
$target = basename($_FILES['file']['name']) ;
move_uploaded_file($_FILES['file']['tmp_name'], $target);

// beri permisi agar file xls dapat di baca
chmod($_FILES['file']['name'],0777);

// mengambil isi file xls
$data = new Spreadsheet_Excel_Reader($_FILES['file']['name'],false);
// menghitung jumlah baris data yang ada
$jumlah_baris = $data->rowcount($sheet_index=0);

// jumlah default data yang berhasil di import
$berhasil = 0;
for ($i=2; $i<=$jumlah_baris; $i++){

	// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
	$id_uji    = $data->val($i, 1);
	$document   = $data->val($i, 2);
	$aspek  = $data->val($i, 3);
	$klasifikasi_manual   = $data->val($i, 2);
	$klasifikasi_sistem  = $data->val($i, 3);

	if($document != "" && $aspek != "" && $klasifikasi_manual != "" && $klasifikasi_sistem != ""){
		// input data ke database (table data_pegawai)
		mysqli_query($koneksi,"INSERT into data_pegawai values('$id_uji','$document','$aspek','$klasifikasi_manual','$klasifikasi_sistem')");
		$berhasil++;
	}
}

// hapus kembali file .xls yang di upload tadi
unlink($_FILES['file']['name']);

// alihkan halaman ke index.php
echo '<script>alert("Berhasil import data!"); document.location="index.php?halaman=data_uji";</script>';
?>