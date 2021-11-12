<?php

mysqli_query($koneksi,"TRUNCATE sqrt_cross_product");
$resn = mysqli_query($koneksi,"SELECT doc_id, result FROM sum_cross_product")  or die(mysqli_error($koneksi)); 
while($hasil = mysqli_fetch_array($resn))
{
    $id_dok = $hasil['doc_id'];
    $hasil  = $hasil['result'];

    $resBobot = mysqli_query($koneksi,"SELECT result FROM sum_q_cross_product")  or die(mysqli_error($koneksi)); 
    while($rowbobot = mysqli_fetch_array($resBobot))
    {
        $jumlah  = $rowbobot['result']; // jumlah dot produk Dokumen ke n
        $kalikan = $hasil * $jumlah;
        $akar    = sqrt($kalikan);
        $hasi_akar = round($akar, 4);

        $masukkanhasil2 = mysqli_query($koneksi,"INSERT INTO sqrt_cross_product ( doc_id, result_product, result_sqrt) VALUES ('$id_dok', '$kalikan','$hasi_akar')") or die(mysqli_error($koneksi));            
    } //end while $rowbobot 
}
?>