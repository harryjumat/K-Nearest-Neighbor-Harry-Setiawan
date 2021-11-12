<?php
// PROSES PERHITUNGAN HASIL DOT PRODUCT

mysqli_query($koneksi,"TRUNCATE result_dot_product");
$resn = mysqli_query($koneksi,"SELECT doc_id FROM documents ORDER BY doc_id ASC;")  or die(mysqli_error($koneksi)); 
while($hasil = mysqli_fetch_array($resn))
{
    $id_dok = $hasil['doc_id'];

    $resBobot = mysqli_query($koneksi,"SELECT SUM(dot_product) AS jumlah FROM tbdot_product WHERE doc_id = '$id_dok'")  or die(mysqli_error($koneksi)); 
    while($rowbobot = mysqli_fetch_array($resBobot))
    { 
        $jumlah = $rowbobot['jumlah'];
      if ($jumlah > 0) {
        $bulatkan = round($jumlah, 4);
      }else{
      $bulatakan = 0;
    }

      //masukkan nilai akhir dari perhitungan Dot Product untuk setiap dokumen
      $masukkanhasil2 = mysqli_query($koneksi,"INSERT INTO result_dot_product (doc_id, result_dot_productt) VALUES ('$id_dok', '$jumlah')") or die(mysqli_error($koneksi));            
    } //end while $rowbobot 
    echo "<br>";
}
?>