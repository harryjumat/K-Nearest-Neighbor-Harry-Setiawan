<?php

mysqli_query($koneksi,"TRUNCATE result_cosine");
$resn = mysqli_query($koneksi,"SELECT doc_id, result_dot_productt FROM result_dot_product")  or die(mysqli_error($koneksi)); 
while($hasil = mysqli_fetch_array($resn))
{
  $id_dok = $hasil['doc_id'];
  $hasil  = $hasil['result_dot_productt'];

   $resBobot = mysqli_query($koneksi,"SELECT result_sqrt FROM sqrt_cross_product WHERE doc_id = $id_dok")  or die(mysqli_error($koneksi)); 
   while($rowbobot = mysqli_fetch_array($resBobot))
   {
	  $jumlah    = $rowbobot['result_sqrt']; // jumlah dot produk Dokumen ke n
    
    if ($jumlah > 0) {
    $bagikan  = $hasil/$jumlah; //cosine similarity
    }else{
     $bagikan  = 0;
    }

	  

    if ($bagikan > 0) {
     $bulatakan = round($bagikan, 4);
    }else{
      $bulatakan = 0;
    }
      
      $masukkanhasil2 = mysqli_query($koneksi,"INSERT INTO result_cosine (doc_id, result) VALUES ('$id_dok', '$bulatakan')") or die(mysqli_error($koneksi));            
   } //end while $rowbobot 
}
?>
