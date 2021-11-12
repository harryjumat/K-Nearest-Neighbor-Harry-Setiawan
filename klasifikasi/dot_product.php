<?php

// PROSES PERHITUNGAN CROSS PRODUCT UNTUK D KE N
mysqli_query($koneksi,"TRUNCATE cross_product");
$resn = mysqli_query($koneksi,"SELECT doc_id FROM documents ORDER BY doc_id ASC;")  or die(mysqli_error($koneksi)); 
while($hasil = mysqli_fetch_array($resn))
{
  $dok_id = $hasil['doc_id'];

  $resBobot = mysqli_query($koneksi,"SELECT DocId, Weight FROM tbindex WHERE DocId = '$dok_id'")  or die(mysqli_error($koneksi)); 
  while($rowbobot = mysqli_fetch_array($resBobot))
  {
      $Bobot = $rowbobot['Weight'];
      //pemangkatan
      $Pangkat = $Bobot*$Bobot; // pemangkatan nilai tf-idf dari data training
      $bulatkan = round($Pangkat, 4);
      $masukkanhasil3 = mysqli_query($koneksi,"INSERT INTO cross_product VALUES (NULL,'$dok_id', '$bulatkan')") or die(mysqli_error($koneksi));            
  } //end while $rowbobot 
}
// PROSES AKHIR PERHITUNGAN CROSS PRODUCT UNTUK D KE N
?>