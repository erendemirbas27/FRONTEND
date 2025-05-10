<?php
session_start();
require_once 'db.php';

// Hata yönetimi
set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

try {
    // Favori işlemleri
    if (isset($_POST['favori_islem'])) {
        if (!isset($_SESSION['kullanici_id'])) {
            throw new Exception('Lütfen giriş yapın');
        }
        
        $oyun_id = intval($_POST['oyun_id']);
        $kullanici_id = $_SESSION['kullanici_id'];
        
        // Favori kontrolü
        $kontrol = $conn->prepare("SELECT id FROM favoriler WHERE kullanici_id=? AND oyun_id=?");
        $kontrol->bind_param("ii", $kullanici_id, $oyun_id);
        $kontrol->execute();
        $kontrol->store_result();
        
        if ($kontrol->num_rows > 0) {
            $stmt = $conn->prepare("DELETE FROM favoriler WHERE kullanici_id=? AND oyun_id=?");
        } else {
            $stmt = $conn->prepare("INSERT INTO favoriler (kullanici_id, oyun_id) VALUES (?, ?)");
        }
        $stmt->bind_param("ii", $kullanici_id, $oyun_id);
        $stmt->execute();
    }

    // Yorum ekleme
    if (isset($_POST['yorum_ekle'])) {
        if (!isset($_SESSION['kullanici_id'])) {
            throw new Exception('Lütfen giriş yapın');
        }
        
        $oyun_id = intval($_POST['oyun_id']);
        $kullanici_id = $_SESSION['kullanici_id'];
        $yorum = htmlspecialchars(trim($_POST['yorum']));
        $puan = isset($_POST['puan']) ? min(max(1, intval($_POST['puan'])), 5) : null;
        
        if (empty($yorum)) {
            throw new Exception('Yorum boş olamaz');
        }
        
        $stmt = $conn->prepare("INSERT INTO yorumlar (kullanici_id, oyun_id, yorum, puan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iisi", $kullanici_id, $oyun_id, $yorum, $puan);
        $stmt->execute();
        
        // Oyun puanını güncelle
        $conn->query("UPDATE oyunlar SET puan = (
            SELECT AVG(puan) FROM yorumlar WHERE oyun_id = $oyun_id AND puan IS NOT NULL
        ) WHERE id = $oyun_id");
    }

    // Oyunları çek
    $oyunlar = $conn->query("
        SELECT o.*, 
        (SELECT COUNT(*) FROM favori_oyunlar f WHERE f.oyun_id = o.id) AS favori_sayisi,
        (SELECT COUNT(*) FROM yorumlar y WHERE y.oyun_id = o.id) AS yorum_sayisi
        FROM oyunlar o
        ORDER BY eklenme_tarihi DESC
    ");

} catch (Exception $e) {
    $error_message = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oyunlar Hakkında - GameWiki</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #3B82F6;
            --secondary: #10B981;
            --dark: #1F2937;
            --darker: #111827;
        }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: var(--darker);
        }
        .game-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center;
        }
        .game-card:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .star-rating {
            direction: rtl;
            unicode-bidi: bidi-override;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            color: #CBD5E0;
            font-size: 1.25rem;
            padding: 0 2px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            color: #F59E0B;
        }
        .comment-box {
            scrollbar-width: thin;
            scrollbar-color: #4B5563 #1F2937;
        }
        .comment-box::-webkit-scrollbar {
            width: 6px;
        }
        .comment-box::-webkit-scrollbar-track {
            background: #1F2937;
        }
        .comment-box::-webkit-scrollbar-thumb {
            background-color: #4B5563;
            border-radius: 3px;
        }
        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="text-gray-100 min-h-screen">
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <?php if (isset($error_message)): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded fade-in" role="alert">
            <p class="font-bold">Hata!</p>
            <p><?= htmlspecialchars($error_message) ?></p>
        </div>
        <?php endif; ?>

        <h1 class="text-3xl font-bold text-center mb-8">Oyun Kütüphanesi</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php 
            if ($oyunlar && $oyunlar->num_rows > 0):
                while($oyun = $oyunlar->fetch_assoc()): 
                    $favori_durum = isset($_SESSION['kullanici_id']) ? 
                        $conn->query("SELECT id FROM favori_oyunlar WHERE kullanici_id={$_SESSION['kullanici_id']} AND oyun_id={$oyun['id']}")->num_rows > 0 : 
                        false;
            ?>
            <div class="game-card bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-lg">
                <!-- Oyun Kapak -->
                <div class="relative h-48 overflow-hidden">
                    <img src="<?= htmlspecialchars($oyun['kapak_resmi']) ?>" 
                         alt="<?= htmlspecialchars($oyun['ad']) ?>" 
                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                         onerror="this.src='https://via.placeholder.com/400x225?text=Kapak+Resmi+Yok'">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-70"></div>
                    <div class="absolute bottom-0 left-0 p-4">
                        <h2 class="text-xl font-bold text-white"><?= htmlspecialchars($oyun['ad']) ?></h2>
                        <?php if ($oyun['puan'] > 0): ?>
                        <div class="flex items-center mt-1">
                            <span class="text-yellow-400 mr-1"><?= number_format($oyun['puan'], 1) ?></span>
                            <div class="flex">
                                <?= str_repeat('★', floor($oyun['puan'])) ?><?= str_repeat('☆', 5 - floor($oyun['puan'])) ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="p-4">
                    <!-- Oyun Bilgileri -->
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex space-x-2">
                            <?php if ($oyun['tur']): ?>
                            <span class="bg-blue-600 text-xs px-2 py-1 rounded"><?= htmlspecialchars($oyun['tur']) ?></span>
                            <?php endif; ?>
                            <?php if ($oyun['cikis_tarihi']): ?>
                            <span class="bg-gray-700 text-xs px-2 py-1 rounded"><?= date('Y', strtotime($oyun['cikis_tarihi'])) ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex space-x-3 text-xs">
                            <span class="text-gray-400"><i class="far fa-heart mr-1"></i> <?= $oyun['favori_sayisi'] ?></span>
                            <span class="text-gray-400"><i class="far fa-comment mr-1"></i> <?= $oyun['yorum_sayisi'] ?></span>
                        </div>
                    </div>
                    
                    <!-- Kısa Açıklama -->
                    <p class="text-gray-300 text-sm mb-4 line-clamp-3">
                        <?= htmlspecialchars($oyun['aciklama']) ?>
                    </p>
                    
                    <!-- Favori Butonu -->
                    <?php if (isset($_SESSION['kullanici_id'])): ?>
                    <form method="post" class="mb-4">
                        <input type="hidden" name="oyun_id" value="<?= $oyun['id'] ?>">
                        <button type="submit" name="favori_islem" 
                                class="w-full py-2 px-4 rounded-lg <?= $favori_oyunlar_durum ? 'bg-red-600 hover:bg-red-700' : 'bg-blue-600 hover:bg-blue-700' ?> transition-colors">
                            <i class="far <?= $favori_oyunlar_durum ? 'fa-heart' : 'fa-heart' ?> mr-1"></i>
                            <?= $favori_oyunlar_durum ? 'Favorilerden Çıkar' : 'Favorilere Ekle' ?>
                        </button>
                    </form>
                    <?php endif; ?>
                    
                    <!-- Yorumlar -->
                    <div class="border-t border-gray-700 pt-4">
                        <h3 class="font-semibold mb-3 flex items-center">
                            <i class="far fa-comment-dots text-green-500 mr-2"></i>
                            <span>Son Yorumlar</span>
                        </h3>
                        
                        <div class="comment-box max-h-40 overflow-y-auto mb-4 space-y-3 pr-2">
                            <?php
                            $yorumlar = $conn->query("
                            SELECT y.*, k.kullanici_adi 
                            FROM yorumlar y
                            JOIN kullanicilar k ON y.kullanici_id = k.id
                            WHERE y.oyun_id = {$oyun['id']}
                            ORDER BY y.yorum_tarihi DESC LIMIT 2
                        ");
                            
                            if ($yorumlar->num_rows > 0):
                                while($yorum = $yorumlar->fetch_assoc()): 
                            ?>
                            <div class="bg-gray-700 p-3 rounded-lg fade-in">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium text-sm"><?= htmlspecialchars($yorum['kullanici_adi']) ?></span>
                                    <?php if($yorum['puan']): ?>
                                    <div class="text-yellow-400 text-xs">
                                        <?= str_repeat('★', $yorum['puan']) ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <p class="text-gray-300 text-sm"><?= htmlspecialchars($yorum['yorum']) ?></p>
                                <div class="text-right mt-1">
                                    <span class="text-xs text-gray-500"><?= date('d.m.Y', strtotime($yorum['tarih'])) ?></span>
                                </div>
                            </div>
                            <?php 
                                endwhile;
                            else: 
                            ?>
                            <p class="text-gray-500 text-sm italic text-center py-2">Henüz yorum yok</p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Yorum Formu -->
                        <?php if(isset($_SESSION['kullanici_id'])): ?>
                        <form method="post" class="mt-3 fade-in">
                            <input type="hidden" name="oyun_id" value="<?= $oyun['id'] ?>">
                            
                            <div class="star-rating mb-3 flex items-center justify-center">
                                <?php for($i=5; $i>=1; $i--): ?>
                                <input type="radio" id="star<?= $i ?>-<?= $oyun['id'] ?>" name="puan" value="<?= $i ?>">
                                <label for="star<?= $i ?>-<?= $oyun['id'] ?>" title="<?= $i ?> yıldız"><i class="fas fa-star"></i></label>
                                <?php endfor; ?>
                            </div>
                            
                            <textarea name="yorum" placeholder="Yorumunuzu yazın..." 
                                      class="w-full bg-gray-700 text-white p-3 rounded-lg text-sm mb-2 focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                      rows="3" required></textarea>
                            <button type="submit" name="yorum_ekle" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm transition-colors flex items-center justify-center">
                                <i class="far fa-paper-plane mr-2"></i> Yorumu Gönder
                            </button>
                        </form>
                        <?php else: ?>
                        <div class="text-center mt-3">
                            <a href="login.php" class="text-sm text-green-400 hover:underline inline-flex items-center">
                                <i class="far fa-sign-in-alt mr-1"></i> Yorum yapmak için giriş yapın
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                endwhile;
            else:
            ?>
            <div class="col-span-3 text-center py-12">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-gamepad text-5xl"></i>
                </div>
                <h3 class="text-xl font-medium text-white mb-2">Henüz oyun eklenmemiş</h3>
                <p class="text-gray-400">Yönetici oyun eklediğinde burada görünecek</p>
            </div>
            <?php endif; ?>
        </div>
    </main>



    <script>
        // Dinamik yorum ekleme animasyonu
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form[name="yorum_ekle"]');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('button[type="submit"]');
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Gönderiliyor...';
                });
            });
        });
    </script>
</body>
</html>
<?php include("footer.php");?>