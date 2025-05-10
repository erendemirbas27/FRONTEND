<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <style>
        /* FOOTER STYLES */
        .footer {
            background-color: #1F2937;
            color: #9CA3AF;
            padding: 2.5rem 1rem;
            font-family: 'Segoe UI', system-ui, sans-serif;
            margin-top: auto; /* Sayfa sonuna yapışması için */
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }
        
        .footer-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #10B981;
            margin-bottom: 1rem;
            display: inline-flex;
            align-items: center;
        }
        
        .footer-logo::before {
            content: "🎮";
            margin-right: 0.5rem;
        }
        
        .footer-heading {
            color: #F3F4F6;
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .footer-heading::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 2px;
            background-color: #10B981;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 0.75rem;
        }
        
        .footer-links a {
            color: #9CA3AF;
            text-decoration: none;
            transition: color 0.3s ease;
            display: inline-block;
        }
        
        .footer-links a:hover {
            color: #10B981;
            transform: translateX(5px);
        }
        
        .footer-social {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .footer-social a {
            color: #F3F4F6;
            background-color: #374151;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .footer-social a:hover {
            background-color: #10B981;
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid #374151;
            font-size: 0.875rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .footer-container {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .footer-section {
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <a href="index.php" class="footer-logo">GameWiki</a>
                <p class="text-sm">Oyun dünyasının en kapsamlı rehberi. Tüm oyunlar hakkında detaylı bilgiler.</p>
            </div>
            
            <div class="footer-section">
                <h3 class="footer-heading">Hızlı Linkler</h3>
                <ul class="footer-links">
                    <li><a href="index.php">Ana Sayfa</a></li>
                    <li><a href="oyunlarhakkinda.php">Oyunlar</a></li>
                    <li><a href="hakkinda.php">Hakkımızda</a></li>
                    <li><a href="iletisim.php">İletişim</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3 class="footer-heading">Yardım</h3>
                <ul class="footer-links">
                    <li><a href="sss.php">SSS</a></li>
                    <li><a href="kullanim.php">Kullanım Koşulları</a></li>
                    <li><a href="gizlilik.php">Gizlilik Politikası</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3 class="footer-heading">Bize Ulaşın</h3>
                <p class="text-sm mb-2"><i class="fas fa-envelope mr-2"></i> info@gamewiki.com</p>
                <p class="text-sm mb-4"><i class="fas fa-phone mr-2"></i> +90 555 123 45 67</p>
                
                <div class="footer-social">
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Discord"><i class="fab fa-discord"></i></a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>© <?= date('Y') ?> GameWiki. Tüm hakları saklıdır.</p>
        </div>
    </footer>
    
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>