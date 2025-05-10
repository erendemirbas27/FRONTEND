<?php
session_start();

include('db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini al ve temizle
    $kullanici_adi = $conn->real_escape_string($_POST['kullanici_adi']);
    $sifre = $_POST['sifre'];

    // Şifre uzunluğunu kontrol et
    if (strlen($sifre) < 8) {
        echo "<script>alert('Şifreniz en az 8 karakter olmalıdır.'); window.history.back();</script>";
        exit;
    }

    // Veritabanındaki kullanıcıyı doğrulama
    $stmt = $conn->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ?");
    $stmt->bind_param("s", $kullanici_adi);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($sifre, $user['sifre'])) {
            // Başarılı giriş
            $_SESSION['kullanici_id'] = $user['id'];
            $_SESSION['kullanici_adi'] = $user['kullanici_adi'];
            
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Geçersiz şifre.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Kullanıcı bulunamadı.'); window.history.back();</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giriş Yap</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #1e1e2f, #2f2f47);
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: #2c2c3c;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #ffffff;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: none;
            border-radius: 6px;
            background-color: #444;
            color: white;
            font-size: 1rem;
        }

        .login-container input[type="submit"] {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 6px;
            background-color: #4CAF50;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .login-container .links {
            text-align: center;
            margin-top: 1rem;
        }

        .login-container .links a {
            color: #bbb;
            text-decoration: none;
            font-size: 0.9rem;
            margin: 0 5px;
        }

        .login-container .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Giriş Yap</h2>
        <form method="post">
            <input type="text" name="kullanici_adi" placeholder="Kullanıcı Adı" required>
            <input type="password" name="sifre" placeholder="Şifre" required>
            <input type="submit" value="Giriş Yap">
        </form>
        <div class="links">
            <a href="register.php">Kayıt Ol</a> | 
            <a href="index.php">Ana Sayfa</a>
        </div>
    </div>
</body>
</html>