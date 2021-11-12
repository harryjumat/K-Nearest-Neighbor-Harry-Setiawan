<?php
// PROSES PERHITUNGAN DOT PRODUCT

mysqli_query($koneksi,"TRUNCATE tbdot_product");
$resn = mysqli_query($koneksi,"SELECT doc_id FROM documents ORDER BY doc_id ASC;")  or die(mysqli_error($koneksi)); 
while($hasil = mysqli_fetch_array($resn))
{
    $id_dok = $hasil['doc_id'];

   //hitung bobot untuk setiap Term dalam setiap DocId
   $resBobot = mysqli_query($koneksi,"SELECT Id, Term, Weight FROM q_index ORDER BY Id")  or die(mysqli_error($koneksi)); 
   $n = mysqli_num_rows($resBobot);
   while($rowbobot = mysqli_fetch_array($resBobot))
   {   
        $id    = $rowbobot['Id'];
        $term  = $rowbobot['Term'];
        $bobot = $rowbobot['Weight']; // Bobot Query
        //berapa jumlah dokumen yang mengandung term tersebut?, N
        $resNTerm = mysqli_query($koneksi,"SELECT Weight FROM tbindex  WHERE Term = '$term' AND DocId = $id_dok")  or die(mysqli_error($koneksi)); 
        $rowNTerm = mysqli_fetch_array($resNTerm);
        $bobot_2  = $rowNTerm['Weight']; // Bobot Dokumen
       
        //hitung Dot Product
        $dot_product = $bobot*$bobot_2; // hitung perkalian antara Bobot Query dan Bobot Data Training
        $bulatkan = round($dot_product, 4);

        //update bobot dari term tersebut
        $masukkanhasil = mysqli_query($koneksi,"INSERT INTO tbdot_product (doc_id, term, dot_product) VALUES ('$id_dok','$term', '$bulatkan')") or die(mysqli_error($koneksi));            
    } //end while $rowbobot 
}
// PROSES AKHIR PERHITUNGAN DOT PRODUCT
?>