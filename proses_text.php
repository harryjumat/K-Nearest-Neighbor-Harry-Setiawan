  <?php
    include 'koneksi.php';
    error_reporting(0);
    // ====PROSES CASE FOLDING====
    // ambil data dari tabel documents
    mysqli_query($koneksi, "TRUNCATE case_folding");
    $query = mysqli_query($koneksi, "SELECT * FROM documents") or die(mysqli_error($koneksi));
    while ($row = mysqli_fetch_array($query)) {
        $id_dok         = $row['doc_id'];
        $kalimat_asli   = $row['document'];
        $kode_sentiment = $row['code_sentiment'];

        //rubah alfabet besar menjadi kecil
        $kalimat = strtolower($kalimat_asli);

        //hilangkan tanda baca
        $kalimat = str_replace("'", " ", $kalimat);
        $kalimat = str_replace("-", " ", $kalimat);
        $kalimat = str_replace(")", " ", $kalimat);
        $kalimat = str_replace("(", " ", $kalimat);
        $kalimat = str_replace("\"", " ", $kalimat);
        $kalimat = str_replace("/", " ", $kalimat);
        $kalimat = str_replace("=", " ", $kalimat);
        $kalimat = str_replace(".", " ", $kalimat);
        $kalimat = str_replace(",", " ", $kalimat);
        $kalimat = str_replace(":", " ", $kalimat);
        $kalimat = str_replace(";", " ", $kalimat);
        $kalimat = str_replace("!", " ", $kalimat);
        $kalimat = str_replace("?", " ", $kalimat);
        $kalimat = str_replace("`", " ", $kalimat);
        $kalimat = str_replace("~", " ", $kalimat);
        $kalimat = str_replace("@", " ", $kalimat);
        $kalimat = str_replace("#", " ", $kalimat);
        $kalimat = str_replace("$", " ", $kalimat);
        $kalimat = str_replace("%", " ", $kalimat);
        $kalimat = str_replace("^", " ", $kalimat);
        $kalimat = str_replace("&", " ", $kalimat);
        $kalimat = str_replace("*", " ", $kalimat);
        $kalimat = str_replace("_", " ", $kalimat);
        $kalimat = str_replace("+", " ", $kalimat);
        $kalimat = str_replace("[", " ", $kalimat);
        $kalimat = str_replace("]", " ", $kalimat);
        $kalimat = str_replace("<", " ", $kalimat);
        $kalimat = str_replace(">", " ", $kalimat);
        //Hapus Hashtag Twitter
        $$kalimat = preg_replace('/(?:^|\s)#(\w+)/', ' ', $kalimat);

        //Hapus Username Twitter
        $kalimat = preg_replace('/(?:^|\s)@(\w+)/', ' ', $kalimat);
        //masukkan ke tabel case_folding	
        $masukkan = mysqli_query($koneksi, "INSERT INTO case_folding VALUES(NULL,'$kalimat','$id_dok','$kode_sentiment')");
    }
    // ===AKHIR DARI CASE FOLDING===


    // ===PROSES TOKENISASI===
    mysqli_query($koneksi, "TRUNCATE token"); //kosongkan isi field
    $query = mysqli_query($koneksi, "SELECT * FROM case_folding") or die(mysqli_error($koneksi));
    while ($row = mysqli_fetch_array($query)) {
        $kalimat_asli   = $row['case_folding'];
        $id_dok         = $row['doc_id'];
        $kode_sentiment = $row['code_sentiment'];

        // menghitung jumlah dan memecah kata dalam kalimat
        $token = str_word_count(strtolower($kalimat_asli), 1);
        foreach ($token as $key => $hasil_token) {
            $masukkan2 = mysqli_query($koneksi, "INSERT INTO token VALUES(NULL,'$hasil_token','$id_dok', '$kode_sentiment')");
        }
    }
    // ===AKHIR PROSES TOKENISASI===


    // ===PROSES FILTERING===
    class Filtering
    {
        private $stopwords = array("ada", "adalah", "adanya", "adapun", "agak", "agaknya", "agar", "akan", "akankah", "akhir", "akhiri", "akhirnya", "aku", "akulah", "amat", "amatlah", "anda", "andalah", "antar", "antara", "antaranya", "apa", "apaan", "apabila", "apakah", "apalagi", "apatah", "artinya", "asal", "asalkan", "atas", "atau", "ataukah", "ataupun", "awal", "awalnya", "bagai", "bagaikan", "bagaimana", "bagaimanakah", "bagaimanapun", "bagi", "bagian", "bahkan", "bahwa", "bahwasanya", "baik", "bakal", "bakalan", "balik", "banyak", "bapak", "baru", "bawah", "beberapa", "begini", "beginian", "beginikah", "beginilah", "begitu", "begitukah", "begitulah", "begitupun", "bekerja", "belakang", "belakangan", "belum", "belumlah", "benar", "benarkah", "benarlah", "berada", "berakhir", "berakhirlah", "berakhirnya", "berapa", "berapakah", "berapalah", "berapapun", "berarti", "berawal", "berbagai", "berdatangan", "beri", "berikan", "berikut", "berikutnya", "berjumlah", "berkali-kali", "berkata", "berkehendak", "berkeinginan", "berkenaan", "berlainan", "berlalu", "berlangsung", "berlebihan", "bermacam", "bermacam-macam", "bermaksud", "bermula", "bersama", "bersama-sama", "bersiap", "bersiap-siap", "bertanya", "bertanya-tanya", "berturut", "berturut-turut", "bertutur", "berujar", "berupa", "besar", "betul", "betulkah", "biasa", "biasanya", "bila", "bilakah", "bisa", "bisakah", "boleh", "bolehkah", "bolehlah", "buat", "bukan", "bukankah", "bukanlah", "bukannya", "bulan", "bung", "cara", "caranya", "cukup", "cukupkah", "cukuplah", "cuma", "dahulu", "dalam", "dan", "dapat", "dari", "daripada", "datang", "dekat", "demi", "demikian", "demikianlah", "dengan", "depan", "di", "dia", "diakhiri", "diakhirinya", "dialah", "diantara", "diantaranya", "diberi", "diberikan", "diberikannya", "dibuat", "dibuatnya", "didapat", "didatangkan", "digunakan", "diibaratkan", "diibaratkannya", "diingat", "diingatkan", "diinginkan", "dijawab", "dijelaskan", "dijelaskannya", "dikarenakan", "dikatakan", "dikatakannya", "dikerjakan", "diketahui", "diketahuinya", "dikira", "dilakukan", "dilalui", "dilihat", "dimaksud", "dimaksudkan", "dimaksudkannya", "dimaksudnya", "diminta", "dimintai", "dimisalkan", "dimulai", "dimulailah", "dimulainya", "dimungkinkan", "dini", "dipastikan", "diperbuat", "diperbuatnya", "dipergunakan", "diperkirakan", "diperlihatkan", "diperlukan", "diperlukannya", "dipersoalkan", "dipertanyakan", "dipunyai", "diri", "dirinya", "disampaikan", "disebut", "disebutkan", "disebutkannya", "disini", "disinilah", "ditambahkan", "ditandaskan", "ditanya", "ditanyai", "ditanyakan", "ditegaskan", "ditujukan", "ditunjuk", "ditunjuki", "ditunjukkan", "ditunjukkannya", "ditunjuknya", "dituturkan", "dituturkannya", "diucapkan", "diucapkannya", "diungkapkan", "dong", "dua", "dulu", "empat", "enggak", "enggaknya", "entah", "entahlah", "guna", "gunakan", "hal", "hampir", "hanya", "hanyalah", "hari", "harus", "haruslah", "harusnya", "hendak", "hendaklah", "hendaknya", "hingga", "ia", "ialah", "ibarat", "ibaratkan", "ibaratnya", "ibu", "ikut", "ingat", "ingat-ingat", "ingin", "inginkah", "inginkan", "ini", "inikah", "inilah", "itu", "itukah", "itulah", "jadi", "jadilah", "jadinya", "jangan", "jangankan", "janganlah", "jauh", "jawab", "jawaban", "jawabnya", "jelas", "jelaskan", "jelaslah", "jelasnya", "jika", "jikalau", "juga", "jumlah", "jumlahnya", "justru", "kala", "kalau", "kalaulah", "kalaupun", "kalian", "kami", "kamilah", "kamu", "kamulah", "kan", "kapan", "kapankah", "kapanpun", "karena", "karenanya", "kasus", "kata", "katakan", "katakanlah", "katanya", "ke", "keadaan", "kebetulan", "kecil", "kedua", "keduanya", "keinginan", "kelamaan", "kelihatan", "kelihatannya", "kelima", "keluar", "kembali", "kemudian", "kemungkinan", "kemungkinannya", "kenapa", "kepada", "kepadanya", "kesampaian", "keseluruhan", "keseluruhannya", "keterlaluan", "ketika", "khususnya", "kini", "kinilah", "kira", "kira-kira", "kiranya", "kita", "kitalah", "kok", "kurang", "lagi", "lagian", "lah", "lain", "lainnya", "lalu", "lama", "lamanya", "lanjut", "lanjutnya", "lebih", "lewat", "lima", "luar", "macam", "maka", "makanya", "makin", "malah", "malahan", "mampu", "mampukah", "mana", "manakala", "manalagi", "masa", "masalah", "masalahnya", "masih", "masihkah", "masing", "masing-masing", "mau", "maupun", "melainkan", "melakukan", "melalui", "melihat", "melihatnya", "memang", "memastikan", "memberi", "memberikan", "membuat", "memerlukan", "memihak", "meminta", "memintakan", "memisalkan", "memperbuat", "mempergunakan", "memperkirakan", "memperlihatkan", "mempersiapkan", "mempersoalkan", "mempertanyakan", "mempunyai", "memulai", "memungkinkan", "menaiki", "menambahkan", "menandaskan", "menanti", "menanti-nanti", "menantikan", "menanya", "menanyai", "menanyakan", "mendapat", "mendapatkan", "mendatang", "mendatangi", "mendatangkan", "menegaskan", "mengakhiri", "mengapa", "mengatakan", "mengatakannya", "mengenai", "mengerjakan", "mengetahui", "menggunakan", "menghendaki", "mengibaratkan", "mengibaratkannya", "mengingat", "mengingatkan", "menginginkan", "mengira", "mengucapkan", "mengucapkannya", "mengungkapkan", "menjadi", "menjawab", "menjelaskan", "menuju", "menunjuk", "menunjuki", "menunjukkan", "menunjuknya", "menurut", "menuturkan", "menyampaikan", "menyangkut", "menyatakan", "menyebutkan", "menyeluruh", "menyiapkan", "merasa", "mereka", "merekalah", "merupakan", "meski", "meskipun", "meyakini", "meyakinkan", "minta", "mirip", "misal", "misalkan", "misalnya", "mula", "mulai", "mulailah", "mulanya", "mungkin", "mungkinkah", "nah", "naik", "namun", "nanti", "nantinya", "nyaris", "nyatanya", "oleh", "olehnya", "pada", "padahal", "padanya", "pak", "paling", "panjang", "pantas", "para", "pasti", "pastilah", "penting", "pentingnya", "per", "percuma", "perlu", "perlukah", "perlunya", "pernah", "persoalan", "pertama", "pertama-tama", "pertanyaan", "pertanyakan", "pihak", "pihaknya", "pukul", "pula", "pun", "punya", "rasa", "rasanya", "rata", "rupanya", "saat", "saatnya", "saja", "sajalah", "saling", "sama", "sama-sama", "sambil", "sampai", "sampai-sampai", "sampaikan", "sana", "sangat", "sangatlah", "satu", "saya", "sayalah", "se", "sebab", "sebabnya", "sebagai", "sebagaimana", "sebagainya", "sebagian", "sebaik", "sebaik-baiknya", "sebaiknya", "sebaliknya", "sebanyak", "sebegini", "sebegitu", "sebelum", "sebelumnya", "sebenarnya", "seberapa", "sebesar", "sebetulnya", "sebisanya", "sebuah", "sebut", "sebutlah", "sebutnya", "secara", "secukupnya", "sedang", "sedangkan", "sedemikian", "sedikit", "sedikitnya", "seenaknya", "segala", "segalanya", "segera", "seharusnya", "sehingga", "seingat", "sejak", "sejauh", "sejenak", "sejumlah", "sekadar", "sekadarnya", "sekali", "sekali-kali", "sekalian", "sekaligus", "sekalipun", "sekarang", "sekarang", "sekecil", "seketika", "sekiranya", "sekitar", "sekitarnya", "sekurang-kurangnya", "sekurangnya", "sela", "selain", "selaku", "selalu", "selama", "selama-lamanya", "selamanya", "selanjutnya", "seluruh", "seluruhnya", "semacam", "semakin", "semampu", "semampunya", "semasa", "semasih", "semata", "semata-mata", "semaunya", "sementara", "semisal", "semisalnya", "sempat", "semua", "semuanya", "semula", "sendiri", "sendirian", "sendirinya", "seolah", "seolah-olah", "seorang", "sepanjang", "sepantasnya", "sepantasnyalah", "seperlunya", "seperti", "sepertinya", "sepihak", "sering", "seringnya", "serta", "serupa", "sesaat", "sesama", "sesampai", "sesegera", "sesekali", "seseorang", "sesuatu", "sesuatunya", "sesudah", "sesudahnya", "setelah", "setempat", "setengah", "seterusnya", "setiap", "setiba", "setibanya", "setidak-tidaknya", "setidaknya", "setinggi", "seusai", "sewaktu", "siap", "siapa", "siapakah", "siapapun", "sini", "sinilah", "soal", "soalnya", "suatu", "sudah", "sudahkah", "sudahlah", "supaya", "tadi", "tadinya", "tahu", "tahun", "tak", "tambah", "tambahnya", "tampak", "tampaknya", "tandas", "tandasnya", "tanpa", "tanya", "tanyakan", "tanyanya", "tapi", "tegas", "tegasnya", "telah", "tempat", "tengah", "tentang", "tentu", "tentulah", "tentunya", "tepat", "terakhir", "terasa", "terbanyak", "terdahulu", "terdapat", "terdiri", "terhadap", "terhadapnya", "teringat", "teringat-ingat", "terjadi", "terjadilah", "terjadinya", "terkira", "terlalu", "terlebih", "terlihat", "termasuk", "ternyata", "tersampaikan", "tersebut", "tersebutlah", "tertentu", "tertuju", "terus", "terutama", "tetap", "tetapi", "tiap", "tiba", "tiba-tiba", "tidak", "tidakkah", "tidaklah", "tiga", "tinggi", "toh", "tunjuk", "turut", "tutur", "tuturnya", "ucap", "ucapnya", "ujar", "ujarnya", "umum", "umumnya", "ungkap", "ungkapnya", "untuk", "usah", "usai", "waduh", "wah", "wahai", "waktu", "waktunya", "walau", "walaupun", "wong", "yaitu", "yakin", "yakni", "yang");



        public function getToken($token, $id_dok, $kode_sentiment, $nbrwords2 = 5)
        {

            $koneksi = mysqli_connect("localhost", "root", "", "improved_knn");
            global $koneksi;

            $id_dokumen = $id_dok;
            $kode = $kode_sentiment;
            $filter = str_word_count($token, 1);
            array_walk($filter, array(
                $this,
                'filter'
            ));
            $filter = array_diff($filter, $this->stopwords);
            $wordCount = array_count_values($filter);
            arsort($wordCount);

            $jumlah = count($wordCount);
            foreach ($wordCount as $key => $hasil) {
                $masukkan3 = mysqli_query($koneksi, "INSERT INTO filtering (term, doc_id, code_sentiment) VALUES('$key','$id_dokumen','$kode')") or die(mysqli_error($koneksi));
            }
            $wordCount = array_slice($wordCount, 0, $nbrwords2);
            return array_keys($wordCount);
        }
        private function filter(&$hasil, $key)
        {
            $hasil = strtolower($hasil);
        }
        private function setStopwords()
        {
            $this->stopwords = array();
        }
    }

    mysqli_query($koneksi, "TRUNCATE filtering");
    // objek dari class Filtering
    $test = new Filtering();
    $query = mysqli_query($koneksi, "SELECT * FROM token") or die(mysqli_error($koneksi));
    while ($row = mysqli_fetch_array($query)) {
        $token          = $row['term'];
        $id_dok         = $row['doc_id'];
        $kode_sentiment = $row['code_sentiment'];
        $proses         = $test->getToken($token, $id_dok, $kode_sentiment, 9); //kirim data
    }
    // ===AKHIR PROSES FILTERING===


    // ===PROSES STEMMING===
    mysqli_query($koneksi, "TRUNCATE stemming");
    include "klasifikasi/stemming.php"; //memanggil file dari luar file ini
    $query = mysqli_query($koneksi, "SELECT * FROM filtering") or die(mysqli_error($koneksi));
    while ($row = mysqli_fetch_array($query)) {
        $kata             = $row['term'];
        $id_dok           = $row['doc_id'];
        $kode_sentiment   = $row['code_sentiment'];
        $hasil            = stemming($kata); //proses stemming
        if ($hasil != "") { //jika hasil stemming tidak kosong maka masukkan
            $masukkan4 = mysqli_query($koneksi, "INSERT INTO stemming VALUES(NULL,'$hasil','$id_dok','$kode_sentiment')");
        }
    }
    // ===AKHIR PROSES STEMMING===


    // ===PROSES PERHITUNGAN TF===
    //ambil semua data(teks) 
    mysqli_query($koneksi, "TRUNCATE tbindex");
    //pengad
    $tweet = mysqli_query($koneksi, "SELECT * FROM documents ORDER BY doc_id") or die(mysqli_error($koneksi));

    $query = mysqli_query($koneksi, "SELECT * FROM stemming ORDER BY id") or die(mysqli_error($koneksi));
    while ($row = mysqli_fetch_array($query)) {
        $id_dok       = $row['doc_id'];
        $token        = $row['term'];
        $proses_token = explode(" ", trim($token));  // proses menghilangkan ganda
        // kirim data dari tabel stemming
        foreach ($proses_token as $j => $value) {
            //jika Term tidak null atau nil, tidak kosong                        
            if ($proses_token[$j] != "") {
                //cek data pada kolom Count                          
                $rescount = mysqli_query($koneksi, "SELECT Count FROM tbindex  WHERE Term = '$proses_token[$j]' AND DocId = $id_dok") or die(mysqli_error($koneksi));
                $num_rows = mysqli_num_rows($rescount);

                //jika sudah ada DocId dan Term tersebut , naikkan 
                count(array(+1));

                if ($num_rows > 0) {
                    $rowcount = mysqli_fetch_array($rescount); //tampilkan data                                             
                    $count = $rowcount['Count']; // ambil data jumlah banyaknya kata (TF) dari kolom Count
                    $count++; //jumlahkan jika kata lebih dari 1

                    mysqli_query($koneksi, "UPDATE tbindex SET Count = $count WHERE Term = '$proses_token[$j]' AND DocId = $id_dok") or die(mysqli_error($koneksi));
                }
                //jika belum ada, langsung simpan ke tbindex                 
                else {
                    mysqli_query($koneksi, "INSERT INTO tbindex (Term, DocId, Count, Weight) VALUES ('$proses_token[$j]', $id_dok, 1, 0)") or die(mysqli_error($koneksi));
                }
            } //end if
        } //end foreach
    } // end while  
    // ===AKHIR PROSES PERHITUNGAN TF===


    // ===PROSES PERHITUNGAN TF-IDF PER KATA TIAP DOKUMEN===
    $resn = mysqli_query($koneksi, "SELECT DISTINCT DocId FROM tbindex");
    $n = mysqli_num_rows($resn); //cek jumlah total tweet

    //hitung bobot untuk setiap Term dalam setiap DocId
    $resBobot = mysqli_query($koneksi, "SELECT * FROM tbindex ORDER BY Id");
    $num_rows = mysqli_num_rows($resBobot);

    while ($rowbobot = mysqli_fetch_array($resBobot)) {
        $term = $rowbobot['Term'];
        $tf   = $rowbobot['Count'];
        $id   = $rowbobot['Id'];

        //berapa jumlah dokumen yang mengandung term tersebut?, N
        $resNTerm = mysqli_query($koneksi, "SELECT Count(*) as N FROM tbindex  WHERE Term = '$term'");
        $rowNTerm = mysqli_fetch_array($resNTerm);
        $NTerm    = $rowNTerm['N']; // nilai df

        //Hitung TF-IDF
        //$w = tf * log (n/df)
        $w      = ($tf * log10($n / $NTerm));
        $tf_idf = round($w, 4); //pembulatan 

        //update bobot dari term tersebut
        $resUpdateBobot = mysqli_query($koneksi, "UPDATE tbindex SET weight = $tf_idf WHERE Id = $id");
    } //end while $rowbobot
    // ===PROSES PERHITUNGAN TF-IDF PER KATA TIAP DOKUMEN===



    // cek
    if ($resUpdateBobot) {
    ?>
      <script language="JavaScript">
          alert('Successfully');
          document.location = 'index.php?halaman=data_latih';
      </script>
  <?php
    } else {
    ?>
      <script language="JavaScript">
          alert('Failed');
          document.location = 'index.php?halaman=data_latih';
      </script>
  <?php
    }

    /* Kalo TRUNCATE buat ngosongin isi tabel, kalo DELETE buat hapus salah satu row (isi) tabel. 
    Bedanya kalo ngosongin tabel dengan cara DELETE semua isinya, ketika tabel diinsert kembali primary key nya bakal dilajutin. 
    Contoh ketika sebelum dikosongin ada 3 data, setelah dikosongin kemudian diinsert lagi primary key otomatis terisi angka 4. 
    Karena biasanya primary key disetting auto increment dan ga perlu diisi waktu insert data (row). 
    Beda dengan TRUNCATE yang bakal mulai dari 0 lagi.
    
    Perintah SELECT DISTINCT digunakan untuk menampilkan nilai yang berbeda.
    Di dalam sebuah tabel, kolom sering berisi banyak nilai duplikat; Dan terkadang Anda hanya ingin membuat daftar nilai yang berbeda.
    Perintah SELECT DISTINCT digunakan untuk menampilkan hanya nilai yang berbeda dari suatu data.
    */



    ?>