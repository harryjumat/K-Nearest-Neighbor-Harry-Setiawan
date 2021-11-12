<?php
// PROSES PERHITUNGAN DOT PRODUCT UNTUK D KE N

     $kv =  mysqli_query($koneksi,"SELECT * FROM kvalues_baru order by id_kvalues DESC LIMIT 1");
          $kv_data = mysqli_fetch_array($kv);

            $nilai_k = $kv_data['nilai_k'];
            $n_positif = $kv_data['n_positif'];
            $n_negatif = $kv_data['n_negatif'];
            $n_netral = $kv_data['n_netral'];

     $cosim_positif = 0;
            $cosim_s1 = mysqli_query($koneksi,"SELECT*FROM result_cosine join documents on result_cosine.doc_id = documents.doc_id WHERE documents.code_sentiment = 's1' order by result_cosine.result DESC LIMIT $n_positif")  or die(mysqli_error($koneksi)); 
            while($data_cosim_s1 = mysqli_fetch_array($cosim_s1))
            {

             $cosim_positif += $data_cosim_s1['result'];
             
           }

           $cosim_negatif = 0;
           $cosim_s2 = mysqli_query($koneksi,"SELECT*FROM result_cosine join documents on result_cosine.doc_id = documents.doc_id WHERE documents.code_sentiment = 's2' order by result_cosine.result DESC LIMIT $n_negatif")  or die(mysqli_error($koneksi)); 
           while($data_cosim_s2 = mysqli_fetch_array($cosim_s2))
           {
            $cosim_negatif += $data_cosim_s2['result'];
            
          }


           $cosim_netral = 0;
           $cosim_s3 = mysqli_query($koneksi,"SELECT*FROM result_cosine join documents on result_cosine.doc_id = documents.doc_id WHERE documents.code_sentiment = 's3' order by result_cosine.result DESC LIMIT $n_netral")  or die(mysqli_error($koneksi)); 
           while($data_cosim_s3 = mysqli_fetch_array($cosim_s3))
           {
            $cosim_netral += $data_cosim_s3['result'];
            
          }

          $cosim_top_n = 0;
          $cosim_data_latih = mysqli_query($koneksi,"SELECT*FROM result_cosine order by result DESC LIMIT $nilai_k")  or die(mysqli_error($koneksi)); 
          while($data_cosim_data_latih = mysqli_fetch_array($cosim_data_latih))
          {
            $cosim_top_n += $data_cosim_data_latih['result'];
            
          }
        
        $p_positif = 0;
        $p_negatif = 0;
        $p_netral = 0;

         if ($cosim_positif > 0 && $cosim_negatif > 0 && $cosim_netral > 0 && $cosim_top_n){
        $p_positif = $cosim_positif / $cosim_top_n;
        $p_negatif = $cosim_negatif / $cosim_top_n;
        $p_netral = $cosim_netral / $cosim_top_n;
        }

        if ($p_positif >= $p_negatif && $p_positif >= $p_netral) {
        	$sentiment = 's1';

        	$masukkanhasil = mysqli_query($koneksi,"INSERT INTO hasil_klasifikasi VALUES (NULL,'$id_uji','$kalimat_asli', '$cosim_positif', '$cosim_negatif','$cosim_netral', '$cosim_top_n', '$p_positif','$p_negatif','$p_netral','$sentiment')") or die(mysqli_error($koneksi));
        }
        else if ($p_negatif >= $p_positif && $p_negatif >= $p_netral) {
          $sentiment = 's2';

          $masukkanhasil = mysqli_query($koneksi,"INSERT INTO hasil_klasifikasi VALUES (NULL,'$id_uji','$kalimat_asli', '$cosim_positif', '$cosim_negatif','$cosim_netral', '$cosim_top_n', '$p_positif','$p_negatif','$p_netral','$sentiment')") or die(mysqli_error($koneksi));
        }
       else if ($p_netral >= $p_positif && $p_netral >= $p_negatif) {
           $sentiment = 's3';

          $masukkanhasil = mysqli_query($koneksi,"INSERT INTO hasil_klasifikasi VALUES (NULL,'$id_uji','$kalimat_asli', '$cosim_positif', '$cosim_negatif','$cosim_netral', '$cosim_top_n', '$p_positif','$p_negatif','$p_netral','$sentiment')") or die(mysqli_error($koneksi));
        }

?>