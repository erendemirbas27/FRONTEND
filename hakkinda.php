<?php 
session_start();
include("db.php");
include("navbar.php");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hakkında - GameWiki</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: linear-gradient(135deg, #1f1c2c, #928dab);
      color: white;
    }



    .container {
      max-width: 900px;
      margin: 30px auto;
      padding: 20px;
      background-color: rgba(0, 0, 0, 0.6);
      border-radius: 12px;
    }

    h1 {
      font-size: 32px;
      border-bottom: 2px solid #888;
      padding-bottom: 10px;
    }

    .section {
      margin-top: 30px;
    }

    .tech-badges {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .tech-badges span {
      background-color: #444;
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 14px;
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 24px;
      }


      .container {
        margin: 20px 10px;
        padding: 15px;
      }
    }
  </style>
</head>
<body>



<div class="container">
  <h1>GameWiki Projesi Hakkında</h1>

  <div class="section">
    <p>
      GameWiki, popüler oyunlar hakkında bilgi sunmak amacıyla geliştirilmiş bir içerik platformudur.
      Ziyaretçilere oyunlar hakkında kısa bilgiler, görseller, detaylı açıklamalar ve kullanıcı yorumları sunmayı amaçlar.
    </p>
  </div>

  <div class="section">
    <h2>Proje Amacı</h2>
    <p>
      Bu proje, hem oyun kültürünü paylaşmak hem de web geliştirme alanında deneyim kazanmak için hazırlanmıştır.
      Kullanıcı dostu arayüzü ve modern yapısıyla ziyaretçilere kaliteli bir deneyim sunmayı hedeflemektedir.
    </p>
  </div>

  <div class="section">
    <h2>Kullanılan Teknolojiler</h2>
    <div class="tech-badges">
      <span>HTML5</span>
      <span>CSS3</span>
      <span>PHP</span>
      <span>JavaScript </span>
      <span>VS Code</span>
      <span>XAMPP CONTROL PANEL</span>
    </div>
  </div>

  <div class="section">
    <h2>Geliştirici Notu</h2>
    <p>
      Bu projeyi kendi ilgim doğrultusunda ve web geliştirme becerilerimi geliştirmek için oluşturdum.
      Her türlü geri bildirime açığım ve bu projeyi daha ileri taşımak için çalışmalarım sürecek.
    </p>
  </div>
</div>

</body>
</html>
