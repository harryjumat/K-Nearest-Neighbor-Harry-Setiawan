<?php
// PROSES PERHITUNGAN QUERY CROSS PRODUCT
mysqli_query($koneksi,"TRUNCATE q_cross_product");

$resBobot = mysqli_query($koneksi,"SELECT  Term, Weight FROM q_index ORDER BY Id")  or die(mysqli_error($koneksi)); 
$n = mysqli_num_rows($resBobot);
while($rowbobot = mysqli_fetch_array($resBobot))
{
   $term = $rowbobot['Term'];

   $resNTerm = mysqli_query($koneksi,"SELECT Weight FROM q_index WHERE Term = '$term'")  or die(mysqli_error($koneksi)); 
   $rowNTerm = mysqli_fetch_array($resNTerm);
   $bobot = $rowNTerm['Weight']; // Bobot Dokumen
   //pemangkatan  
   $pangkat = $bobot*$bobot; // pemangkatan query cross product
   $bulatkan = round($pangkat, 4);

   $masukkanhasi4 = mysqli_query($koneksi,"INSERT INTO q_cross_product (term, result) VALUES ('$term', '$bulatkan')") or die(mysqli_error($koneksi));      
 }
// PROSES AKHIR PERHITUNGAN QUERY CROSS PRODUCT
?>