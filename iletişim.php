<?php
session_start();
require_once 'db.php'; // Veritabanı bağlantısı
include("navbar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini al ve temizle
    $ad_soyad = trim($_POST['isim']);
    $email = trim($_POST['email']);
    $mesaj = trim($_POST['mesaj']);
    
    // Validasyon
    if (empty($ad_soyad) || empty($email) || empty($mesaj)) {
        echo "<script>alert('Lütfen tüm alanları doldurun!'); window.history.back();</script>";
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Geçersiz e-posta formatı!'); window.history.back();</script>";
        exit;
    }
    
    if (strlen($mesaj) < 10) {
        echo "<script>alert('Mesajınız en az 10 karakter olmalıdır!'); window.history.back();</script>";
        exit;
    }

    // Veritabanına ekle
    try {
        $stmt = $conn->prepare("INSERT INTO iletisim (adsoyad, email, mesaj) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $ad_soyad, $email, $mesaj);
        
        if ($stmt->execute()) {
            echo "<script>
                alert('Mesajınız başarıyla gönderildi!');
                window.location.href = 'index.php';
            </script>";
        } else {
            throw new Exception("Veritabanı hatası: " . $stmt->error);
        }
    } catch (Exception $e) {
        echo "<script>
            alert('Hata oluştu: " . addslashes($e->getMessage()) . "');
            window.history.back();
        </script>";
    } finally {
        if (isset($stmt)) $stmt->close();
        $conn->close();
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>İletişim - GameWiki</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #1f1c2c, #928dab);
      color: white;
    }
    .contact-container {
      background-color: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(10px);
    }
    input, textarea {
      background-color: rgba(255, 255, 255, 0.1);
      color: white;
      transition: all 0.3s;
    }
    input:focus, textarea:focus {
      background-color: rgba(255, 255, 255, 0.2);
      outline: none;
      box-shadow: 0 0 0 2px #4CAF50;
    }
    input::placeholder, textarea::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }
  </style>
</head>
<body class="min-h-screen">


<main class="container mx-auto px-4 py-8">
  <div class="contact-container max-w-2xl mx-auto p-8 rounded-xl shadow-2xl">
    <h1 class="text-3xl font-bold text-center mb-4">Bizimle İletişime Geç</h1>
    <p class="text-center text-gray-300 mb-8">Her türlü öneri, geri bildirim ya da sorularınız için aşağıdaki formu doldurabilirsiniz.</p>
    
    <form method="post" class="space-y-6">
      <div>
        <input type="text" name="isim" placeholder="Adınız Soyadınız" required
               class="w-full px-4 py-3 rounded-lg border-none">
      </div>
      <div>
        <input type="email" name="email" placeholder="E-posta Adresiniz" required
               class="w-full px-4 py-3 rounded-lg border-none">
      </div>
      <div>
        <textarea name="mesaj" rows="5" placeholder="Mesajınız" required
                  class="w-full px-4 py-3 rounded-lg border-none"></textarea>
      </div>
      <button type="submit" 
              class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition">
        Mesajı Gönder
      </button>
    </form>
  </div>
</main>

</body>
</html>
<?php include("footer.php");?>