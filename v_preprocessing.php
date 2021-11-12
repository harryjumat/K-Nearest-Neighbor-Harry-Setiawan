<?php
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


// ambil data slangword
// echo "<br>";
// $sql = "SELECT * FROM slangword";
// $stmt = $db->prepare($sql);
// $stmt->execute();
// $result = $stmt->fetchAll();
// $arr_slang = array();
// foreach ($result as $k => $v) {
//     $arr_slang[$v[0]] = $v[1];
// }

//ambil data tweet dari tb_tweet_satu
// $sql = "SELECT * FROM data_latih";
// $stmt = $db->prepare($sql);
// $stmt->execute();
// $result = $stmt->fetchAll();
//foreach ($result as $k => $v) {


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
    //}
