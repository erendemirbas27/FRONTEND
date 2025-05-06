<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "gamewiki";

// Bağlantı oluştur
$conn = new mysqli($host, $user, $pass, $dbname);

// Hata kontrolü
if ($conn->connect_error) {
    die("Veritabanına bağlanılamadı: " . $conn->connect_error);
}


// Karakter setini ayarla
$conn->set_charset("utf8");
?>
