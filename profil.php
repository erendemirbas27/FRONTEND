<?php
session_start();
include("db.php"); // Veritabanı bağlantısı buradan yapılır

if (!isset($_SESSION['kullanici_adi'])) {
    header("Location: login.php");
    exit();
}

$kullanici_adi = $_SESSION['kullanici_adi'];

$sql = "SELECT * FROM kullanicilar WHERE kullanici_adi = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $kullanici_adi);
$stmt->execute();
$result = $stmt->get_result();
$kullanici = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Profil Sayfası</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #00ffe1;
      --dark: #121212;
      --dark-secondary: #1e1e1e;
      --light: #f5f5f5;
      --gray: #888;
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background: var(--dark);
      color: var(--light);
      line-height: 1.6;
    }
    
    .profile-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
    }
    
    .profile-header {
      display: flex;
      align-items: center;
      margin-bottom: 3rem;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .avatar {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background: linear-gradient(45deg, var(--primary), #0099ff);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3rem;
      font-weight: 600;
      color: white;
      margin-right: 2rem;
    }
    
    .user-info h1 {
      font-size: 2rem;
      margin-bottom: 0.5rem;
      color: var(--primary);
    }
    
    .user-meta {
      display: flex;
      gap: 1.5rem;
    }
    
    .meta-item {
      display: flex;
      align-items: center;
      color: var(--gray);
    }
    
    .meta-item i {
      margin-right: 0.5rem;
      color: var(--primary);
    }
    
    .profile-content {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 2rem;
    }
    
    .card {
      background: var(--dark-secondary);
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      margin-bottom: 2rem;
    }
    
    .card h2 {
      font-size: 1.5rem;
      margin-bottom: 1.5rem;
      color: var(--primary);
      position: relative;
      padding-bottom: 0.5rem;
    }
    
    .card h2::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50px;
      height: 3px;
      background: var(--primary);
    }
    
    .game-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 1rem;
    }
    
    .game-card {
      background: rgba(255,255,255,0.05);
      border-radius: 8px;
      overflow: hidden;
      transition: transform 0.3s ease;
    }
    
    .game-card:hover {
      transform: translateY(-5px);
    }
    
    .game-card img {
      width: 100%;
      height: 100px;
      object-fit: cover;
    }
    
    .game-card h3 {
      padding: 0.75rem;
      font-size: 0.9rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    .comment-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    
    .comment-item {
      background: rgba(255,255,255,0.05);
      padding: 1rem;
      border-radius: 8px;
      border-left: 3px solid var(--primary);
    }
    
    .comment-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
      color: var(--gray);
    }
    
    .comment-game {
      color: var(--primary);
      font-weight: 500;
    }
    
    .comment-form textarea {
      width: 100%;
      padding: 1rem;
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 8px;
      color: white;
      resize: vertical;
      min-height: 100px;
      margin-bottom: 1rem;
    }
    
    .btn {
      background: var(--primary);
      color: var(--dark);
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .btn:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
      .profile-header {
        flex-direction: column;
        text-align: center;
      }
      
      .avatar {
        margin-right: 0;
        margin-bottom: 1.5rem;
      }
      
      .user-meta {
        justify-content: center;
      }
      
      .profile-content {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<div class="profile-container">
  <div class="profile-header">
    <div class="avatar">
      <?= strtoupper(substr($kullanici['kullanici_adi'], 0, 1)) ?>
    </div>
    <div class="user-info">
      <h1><?= htmlspecialchars($kullanici['kullanici_adi']) ?></h1>
      <div class="user-meta">
        <div class="meta-item">
          <i class="fas fa-envelope"></i>
          <span><?= htmlspecialchars($kullanici['email']) ?></span>
        </div>
        <div class="meta-item">
          <i class="fas fa-user"></i>
          <span>GameWiki Üyesi</span>
        </div>
      </div>
    </div>
  </div>

  <div class="profile-content">
    <div class="profile-sidebar">
      <div class="card">
        <h2>Hızlı İşlemler</h2>
        <ul style="list-style: none;">
          <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--light); text-decoration: none;">Profilimi Düzenle</a></li>
          <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--light); text-decoration: none;">Şifre Değiştir</a></li>
          <li><a href="logout.php" style="color: #ff5555; text-decoration: none;">Çıkış Yap</a></li>
        </ul>
      </div>
      
      <div class="card">
        <h2>İstatistikler</h2>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
          <div>
            <div style="color: var(--gray); font-size: 0.9rem;">Toplam Yorum</div>
            <div style="font-size: 1.5rem; color: var(--primary);">12</div>
          </div>
          <div>
            <div style="color: var(--gray); font-size: 0.9rem;">Favori Oyun</div>
            <div style="font-size: 1.5rem; color: var(--primary);">The Witcher 3</div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="profile-main">
      <div class="card">
        <h2>Favori Oyunlarım</h2>
        <div class="game-list">
          <div class="game-card">
            <img src="https://upload.wikimedia.org/wikipedia/en/0/0c/Witcher_3_cover_art.jpg" alt="The Witcher 3">
            <h3>The Witcher 3</h3>
          </div>
          <div class="game-card">
            <img src="https://upload.wikimedia.org/wikipedia/en/a/a5/Grand_Theft_Auto_V.png" alt="GTA 5">
            <h3>Grand Theft Auto V</h3>
          </div>
          <div class="game-card">
            <img src="https://upload.wikimedia.org/wikipedia/en/4/44/Red_Dead_Redemption_II.jpg" alt="Red Dead Redemption 2">
            <h3>Red Dead Redemption 2</h3>
          </div>
          <div class="game-card">
            <img src="https://upload.wikimedia.org/wikipedia/en/b/b9/Elden_Ring_Box_art.jpg" alt="Elden Ring">
            <h3>Elden Ring</h3>
          </div>
        </div>
      </div>
      
      <div class="card">
        <h2>Son Yorumlarım</h2>
        <div class="comment-list">
          <div class="comment-item">
            <div class="comment-header">
              <span class="comment-game">Cyberpunk 2077</span>
              <span>2 gün önce</span>
            </div>
            <p>Oyunun atmosferi gerçekten nefes kesici. Grafikler mükemmel!</p>
          </div>
          <div class="comment-item">
            <div class="comment-header">
              <span class="comment-game">Red Dead Redemption 2</span>
              <span>1 hafta önce</span>
            </div>
            <p>Şimdiye kadar oynadığım en iyi hikaye odaklı oyunlardan biri.</p>
          </div>
        </div>
        
        <div class="comment-form" style="margin-top: 2rem;">
          <h3>Yeni Yorum Ekle</h3>
          <form method="post" action="yorum_ekle.php">
            <textarea name="yorum" placeholder="Oyun hakkındaki düşünceleriniz..."></textarea>
            <button type="submit" class="btn">Yorumu Gönder</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Font Awesome ikonları için -->
<script src="https://kit.fontawesome.com/fb08b6ca2d.js" crossorigin="anonymous"></script>
</body>
</html>
<?php include("footer.php");?>