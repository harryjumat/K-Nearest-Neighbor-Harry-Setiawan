<?php

   mysqli_query($koneksi,"TRUNCATE sum_q_cross_product");
   $resBobot = mysqli_query($koneksi,"SELECT SUM(result) AS jumlah FROM q_cross_product")  or die(mysqli_error($koneksi)); 
   while($rowbobot = mysqli_fetch_array($resBobot))
   {
      $jumlah = $rowbobot['jumlah']; // jumlah dot produk Dokumen ke n
      $bulatkan = round($jumlah, 4);
      $masukkanhasil2 = mysqli_query($koneksi,"INSERT INTO sum_q_cross_product (result) VALUES ( '$bulatkan')") or die(mysqli_error($koneksi));
   } //end while $rowbobot 
?>