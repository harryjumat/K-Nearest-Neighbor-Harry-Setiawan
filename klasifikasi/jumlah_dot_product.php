<?php
// PROSES PERHITUNGAN HASIL JUMLAH DOT PRODUCT

mysqli_query($koneksi,"TRUNCATE sum_cross_product");
$resn = mysqli_query($koneksi,"SELECT DISTINCT doc_id FROM cross_product")  or die(mysqli_error($koneksi)); 
while($hasil = mysqli_fetch_array($resn))
{
    $id_dok = $hasil['doc_id'];

    $resBobot = mysqli_query($koneksi,"SELECT SUM(result) AS jumlah FROM cross_product WHERE doc_id= '$id_dok'")  or die(mysqli_error($koneksi)); 
    while($rowbobot = mysqli_fetch_array($resBobot))
    {
        $jumlah = $rowbobot['jumlah']; // jumlah cross produk Dokumen ke n
        $bulatkan = round($jumlah, 4);
        $masukkanhasil2 = mysqli_query($koneksi,"INSERT INTO sum_cross_product ( doc_id, result) VALUES ('$id_dok', '$bulatkan')") or die(mysqli_error($koneksi));            
    } //end while $rowbobot 
}
// PROSES PERHITUNGAN HASIL AKHIR JUMLAH DOT PRODUCT
?>