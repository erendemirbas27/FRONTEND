<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>İletişim - GameWiki</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: linear-gradient(135deg, #1f1c2c, #928dab);
      color: white;
    }

    header {
      background-color: #121212;
      padding: 15px;
      text-align: center;
    }

    nav {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 15px;
    }

    nav a {
      text-decoration: none;
      color: #ccc;
      font-weight: bold;
    }

    nav a:hover {
      color: #fff;
    }

    .container {
      max-width: 700px;
      margin: 40px auto;
      background-color: rgba(0, 0, 0, 0.6);
      padding: 30px;
      border-radius: 10px;
    }

    h1 {
      font-size: 28px;
      margin-bottom: 10px;
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    input, textarea {
      padding: 12px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
    }

    input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    @media (max-width: 600px) {
      .container {
        margin: 20px;
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<header>
  <nav>
    <a href="index.php">Ana Sayfa</a>
    <a href="#">Oyunlar</a>
    <a href="hakkinda.php">Hakkında</a>
    <a href="iletisim.html">İletişim</a>
  </nav>
</header>

<div class="container">
  <h1>Bizimle İletişime Geç</h1>
  <p style="text-align: center;">Her türlü öneri, geri bildirim ya da sorularınız için aşağıdaki formu doldurabilirsiniz.</p>
  
  <form action="index.php" method="post">
    <input type="text" name="isim" placeholder="Adınız" required>
    <input type="email" name="email" placeholder="E-posta Adresiniz" required>
    <textarea name="mesaj" rows="5" placeholder="Mesajınız" required></textarea>
    <input type="submit" value="Gönder">
  </form>
</div>

</body>
</html>
