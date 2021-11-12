<div class="container-fluid">
    <!-- <h1 class="mt-4">Ambil Data Twitter</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Ambil Data Twitter</li>
    </ol> -->
    <!-- CARD -->
    <div class="col-xl-8 col-md-6" style="margin-left: -10px;">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <h5><u>Perhatian:</u></h5>
                <ul>
                    <li>Masukkan Kata Kunci Pertama dan Kata Kunci Kedua</li>
                    <li>Pilih Ambil Data untuk Memproses Pengambilan Data Tweet</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card shadow mb-8 col-md-8 col-md-7">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-table mr-1"></i>
            Ambil Data Uji
        </div>
        <div class="card-body">

            <div class="row">
                <form class="form-inline" method="post">
                    <div class="form-group col-sm-4">
                        <label>Kata Kunci:</label>
                        <input type="text" class="form-control" style="margin-right: 400px;" name="keyword1" placeholder="shopee, shopeecare, shopeeid">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" style="margin-top: 20px;" name="Submit"><i class="fa fa-plus-circle"></i> Ambil Data</button>
                    &nbsp;<a href="export_csv.php" type="button" class="btn btn-success" style="margin-top: 20px;" name="Submit"><i class="fa fa-plus-circle"></i> Export to CSV</a>


                    <?php
                    // load library TwitterOAuth
                    require_once __DIR__ . '/twitteroauth/autoload.php';
                    include "config.php";
                    include "stopword.php";

                    use Abraham\TwitterOAuth\TwitterOAuth;
                    // menentukan keyword yang akan di cari
                    if (isset($_POST['Submit'])) {

                        //AGAR AUTO INCREMEN DARI 0 LAGI
                        // $resetid = $db->query('ALTER TABLE tb_tweet_satu AUTO_INCREMENT=0');
                        // $resetid2 = $resetid->execute();

                        $keyword1 = $_POST['keyword1'];
                        // $keyword2 = $_POST['keyword2'];
                        // membuka koneksi
                        $conn = new TwitterOAuth(api_key, secret_key, token, secret_token);

                        // mengambil tweet berdasarkan keyword yang di tentukan
                        // anda bisa merubah jumlah tweet yang akan di tampilkanb dengan merubah angka pada count
                        $tweets1 = $conn->get('search/tweets', array('q' => $keyword1, 'count' => 45));
                        // $tweets2 = $conn->get('search/tweets', array('q' => $keyword2, 'count' => 10000));

                        $flag = 0;
                        $str_id = 1;
                        foreach ($tweets1->statuses as $tweet) {
                            $text = $tweet->text;
                            $user = $tweet->user->screen_name;

                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $db_name = "improved_knn";
                            try {
                                $db = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);

                                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                //echo "Connected Successfully";
                            } catch (PDOException $e) {
                                echo "Connection failed" . $e->getMessage();
                            }
                            //load library TwitterOAuth
                            require_once __DIR__ . '/sastrawi/vendor/autoload.php';

                            $sql = "SELECT * FROM slangword";
                            $stmt = $db->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->fetchAll();
                            $arr_slang = array();

                            //CASE FOLDING
                            $str_kecil = strtolower($text);

                            // HILANGKAN SPESIAL KARAKTER DAN URL
                            $regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";
                            $str_url = preg_replace($regex, ' ', $str_kecil);

                            //Hapus Hashtag Twitter
                            $Hapus_hashtag = preg_replace('/(?:^|\s)#(\w+)/', ' ', $str_url);

                            //Hapus Username Twitter
                            $Hapus_username = preg_replace('/(?:^|\s)@(\w+)/', ' ', $Hapus_hashtag);

                            // HAPUS TANDA BACA
                            $s = preg_replace('/[^a-z]+/i', ' ', $Hapus_username);

                            //HAPUS SLANGWORD
                            $rem_slang = explode(" ", $s);
                            $x = str_replace(array_keys($arr_slang), $arr_slang, $s);

                            //hapus stopword
                            $rem_stopword = explode(" ", $x);
                            $str_data = array();
                            foreach ($rem_stopword as $value) {
                                if (!in_array($value, $dataStopWord)) {
                                    $str_data[] = " " . $value;
                                }
                            }
                            $query1 = implode(" ", $str_data);


                            // STEMMING
                            $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
                            $stemmer  = $stemmerFactory->createStemmer();

                            $output = $stemmer->stem($query1);
                            try {
                                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sql = "INSERT INTO datauji_scrap (tweet) VALUE (:tweet)";

                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(':tweet', $output);
                                $stmt->execute();

                                if ($flag == 0) {
                                    echo '<br><br>Data tweet bersih berhasil disimpan ke dalam tabel "Tabel Tweet".';
                                    $flag++;
                                }
                            } catch (exception $e) {
                                echo '<pre>';
                                echo '</pre>';
                            }
                        }
                    }
                    ?>
                    <table class="table table-striped" width="100%" cellspacing="0" id="table">
                        <thead>
                            <!--  -->
                            <tr>
                                <th>Id</th>
                                <th>Tweet</th>
                                <th>Klasifikasi Manual</th>
                                <th>Klasifikasi Sistem</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                            $result = mysqli_query($koneksi, "SELECT * FROM datauji_scrap ORDER BY id ASC");
                            while ($tweet = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . $tweet['id'] . "</td>";
                                echo "<td>" . $tweet['tweet'] . "</td>";
                                echo "<td>" . $tweet['klasifikasi_manual'] . "</td>";
                                echo "<td>" . $tweet['klasifikasi_sistem'] . "</td>";
                            }
                            ?>
                        </tbody>
                    </table>
            </div>
        </div>

    </div>