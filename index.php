<?php 
session_start();
include("db.php");
include("navbar.php");

// İletişim formu işleme
if (isset($_POST["isim"], $_POST["email"], $_POST["mesaj"])) {
    $adsoyad = $conn->real_escape_string($_POST["isim"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $mesaj = $conn->real_escape_string($_POST["mesaj"]);

    $stmt = $conn->prepare("INSERT INTO iletisim_mesajlari (ad_soyad, email, mesaj) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $adsoyad, $email, $mesaj);
    
    if ($stmt->execute()) {
        echo "<script>alert('Mesajınız başarıyla iletildi!');</script>";
    } else {
        echo "<script>alert('Mesaj gönderilemedi: ".$conn->error."');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Game Wiki</title>
  <script src="https://kit.fontawesome.com/fb08b6ca2d.js" crossorigin="anonymous"></script>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #1f1c2c, #928dab);
      padding-top: 0;
      padding-top: 0 !important;
      margin: 0;
      padding: 0;
    }



    @media (max-width: 768px) {
      nav {
        flex-direction: column;
        align-items: center;
      }
      .search-bar input {
        width: 100%;
      }
    }

    main {
      padding: 0px 30px 40px;
     
    }

    h1 {
      text-align: center;
      margin-top: 0px;
      margin-bottom: 15px;
      font-size: 2.5rem;
      color: #00ffe1;
      margin-top: 10px;
     
    }

    .card-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .card {
      background-color: #1f1f1f;
      border-radius: 10px;
      overflow: hidden;
      transition: transform 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card img {
      width: 100%;
      height: 180px;
      object-fit:fill;
    }

    .card-content {
      padding: 15px;
    }

    .card-content h3 {
      margin-bottom: 10px;
      font-size: 1.4rem;
      color: #00ffe1;
    }

    .card-content p {
      font-size: 0.95rem;
      color: #ccc;
    }
  </style>
</head>
<body>

<main>
    <h1 style="margin-top: 50px;">Popüler Oyunlar</h1>
  
    <div class="card-container">
     
      <div class="card">
         <a href="kategori/the-witcher-3.html">
        <img src="images/tw3.jpg" alt="The Witcher 3">
        <div class="card-content">
          <h3>The Witcher 3: Wild Hunt</h3>
          <p>Geniş açık dünyası ve derin hikayesiyle unutulmaz bir rol yapma deneyimi sunuyor.</p>
        </a>
        </div>
      </div>
  
      <div class="card">
       <a href="kategori/gta-V.html">
        <img src="https://upload.wikimedia.org/wikipedia/en/a/a5/Grand_Theft_Auto_V.png" alt="GTA 5">
        <div class="card-content">
          <h3>Grand Theft Auto V</h3>
          <p>Devasa bir şehirde özgürce dolaşabileceğin aksiyon dolu bir açık dünya macerası.</p>
        
        </a>
        </div>
      
      </div>
  
      <div class="card">
        <a href="kategori/rdr2.html">
        <img src="https://upload.wikimedia.org/wikipedia/en/4/44/Red_Dead_Redemption_II.jpg" alt="Red Dead Redemption 2">
        <div class="card-content">
          <h3>Red Dead Redemption 2</h3>
          <p>Vahşi Batı'nın son dönemlerinde geçen etkileyici bir hikaye ve açık dünya deneyimi.</p>
        </a>
        </div>
      </div>
  
      <div class="card">
        <a href="kategori/valorant.html">
        <img src="images/valorant.jpg" alt="Valorant">
        <div class="card-content">
          <h3>Valorant</h3>
          <p>Yetenek temelli rekabetçi bir nişancı oyunu; hızlı tempolu 5v5 maçlar sunuyor.</p>
        </a>
        </div>

      </div>
  
      <div class="card">
        <a href="kategori/minecraft.html">
        <img src="images/minecraft.jpeg" alt="Minecraft">
        <div class="card-content">
          <h3>Minecraft</h3>
          <p>Sınırsız bir yaratıcılık dünyası; keşfet, inşa et ve hayatta kal!</p>
        </a>
        </div>
      </div>
  
      <div class="card">
        <a href="kategori/elder-ring.html">
        <img src="https://upload.wikimedia.org/wikipedia/en/b/b9/Elden_Ring_Box_art.jpg" alt="Elden Ring">
        <div class="card-content">
          <h3>Elden Ring</h3>
          <p>Zorlu dövüş mekanikleri ve keşfedilecek devasa bir fantezi dünyası sunan aksiyon-RPG.</p>
        </a>
        </div>
      </div>
  
      <div class="card">
        <a href="kategori/lol.html">
        <img src="images/lol.jpeg" alt="League of Legends">
        <div class="card-content">
          <h3>League of Legends</h3>
          <p>Strateji ve takım oyununa dayalı, dünyanın en popüler MOBA oyunlarından biri.</p>
        </a>
        </div>
      </div>
  
      <div class="card">
        <a href="kategori/fortnite.html">
        <img src="images/fortnite.jpeg" alt="Fortnite">
        <div class="card-content">
          <h3>Fortnite</h3>
          <p>Battle Royale türünde hızlı tempolu savaşlar ve yaratıcı inşa mekanikleri sunuyor.</p>
        </a>
        </div>
      </div>
  
      <div class="card">
        <a href="kategori/Cyberpunk.html">
        <img src="https://upload.wikimedia.org/wikipedia/en/9/9f/Cyberpunk_2077_box_art.jpg" alt="Cyberpunk 2077">
        <div class="card-content">
          <h3>Cyberpunk 2077</h3>
          <p>Geleceğin distopik şehirlerinde geçen, detaylı bir açık dünya RPG deneyimi.</p>
        </a>
        </div>
      </div>
    </div>
  </main>

</body>
</html>
<?php include("footer.php");?>