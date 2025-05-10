<?php
session_start();
require_once 'db.php'; // Veritabanı bağlantısı

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici_adi = trim($_POST['kullanici_adi']);
    $email = trim($_POST['email']);
    $sifre = trim($_POST['sifre']);
    $sifre_tekrar = trim($_POST['sifre_tekrar']);

    // Hata kontrolleri
    if (empty($kullanici_adi) || empty($email) || empty($sifre)) {
        echo "<script>alert('Hata: Tüm alanları doldurun!'); window.history.back();</script>";
        exit;
    }

    if ($sifre !== $sifre_tekrar) {
        echo "<script>alert('Hata: Şifreler uyuşmuyor!'); window.history.back();</script>";
        exit;
    }

    if (strlen($sifre) < 8) {
        echo "<script>alert('Hata: Şifre en az 8 karakter olmalıdır!'); window.history.back();</script>";
        exit;
    }

    // Kullanıcı/Email var mı kontrolü
    $check_user = $conn->prepare("SELECT id FROM kullanicilar WHERE kullanici_adi = ? OR email = ?");
    $check_user->bind_param("ss", $kullanici_adi, $email);
    $check_user->execute();
    $check_user->store_result();

    if ($check_user->num_rows > 0) {
        echo "<script>alert('Hata: Bu kullanıcı adı veya e-posta zaten kayıtlı!'); window.history.back();</script>";
        exit;
    }

    // Şifreyi hashle ve kaydet
    $sifre_hash = password_hash($sifre, PASSWORD_DEFAULT);
    $insert_user = $conn->prepare("INSERT INTO kullanicilar (kullanici_adi, email, sifre) VALUES (?, ?, ?)");
    $insert_user->bind_param("sss", $kullanici_adi, $email, $sifre_hash);

    if ($insert_user->execute()) {
        echo "<script>alert('Kayıt başarılı! Giriş sayfasına yönlendiriliyorsunuz.'); window.location.href='login.php';</script>";
        exit;
    } else {
        echo "<script>alert('Hata: Kayıt işlemi başarısız!'); window.history.back();</script>";
    }

    $check_user->close();
    $insert_user->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1f1c2c, #928dab);
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Kayıt Ol</h2>
        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="kullanici_adi" class="block font-medium">Kullanıcı Adı</label>
                <input type="text" name="kullanici_adi" id="kullanici_adi" required
                       class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="email" class="block font-medium">E-posta</label>
                <input type="email" name="email" id="email" required
                       class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="sifre" class="block font-medium">Şifre</label>
                <input type="password" name="sifre" id="sifre" required
                       class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="sifre_tekrar" class="block font-medium">Şifreyi Tekrar Gir</label>
                <input type="password" name="sifre_tekrar" id="sifre_tekrar" required
                       class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">
                    Kayıt Ol
                </button>
            </div>
        </form>
        <p class="text-center text-sm text-gray-600 mt-4">
            Zaten hesabınız var mı? <a href="login.php" class="text-blue-600 hover:underline">Giriş Yap</a>
        </p>
    </div>
</body>
</html>
