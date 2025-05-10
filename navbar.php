<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameWiki</title>
    <style>
        :root {
            --primary: #3B82F6;
            --secondary: #10B981;
            --dark: #1F2937;
            --darker: #111827;
            --light: #F3F4F6;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, sans-serif;
            margin-bottom: 0; 
        }
        
        header {
            background-color: var(--darker);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--secondary);
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .logo::before {
            content: "🎮";
            margin-right: 0.5rem;
            font-size: 1.5rem;
        }
        
        nav {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        
        nav a {
            color: var(--light);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
            position: relative;
        }
        
        nav a:hover {
            color: var(--secondary);
        }
        
        nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--secondary);
            bottom: 0;
            left: 0;
            transition: width 0.3s ease;
        }
        
        nav a:hover::after {
            width: 100%;
        }
        
        .search-bar {
            position: relative;
            width: 250px;
        }
        
        .search-bar input {
            width: 100%;
            padding: 0.6rem 1rem;
            border-radius: 2rem;
            border: none;
            background-color: var(--dark);
            color: white;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            padding-left: 2.5rem;
        }
        
        .search-bar input:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--secondary);
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .search-bar::before {
            content: "🔍";
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            color: var(--light);
        }
        
        /* Responsive Tasarım */
        @media (max-width: 1024px) {
            header {
                flex-direction: column;
                padding: 1rem;
                gap: 1rem;
            }
            
            nav {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .search-bar {
                width: 100%;
                max-width: 400px;
            }
        }
        
        @media (max-width: 640px) {
            .logo {
                font-size: 1.5rem;
            }
            
            nav {
                gap: 1rem;
            }
            
            nav a {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php" class="logo">GameWiki</a>

        <nav>
            <a href="index.php">Ana Sayfa</a>
            <a href="oyunlar.php">Oyunlar</a>
            <a href="hakkinda.php">Hakkında</a>
            <a href="iletişim.php">İletişim</a>
               
            <?php if(isset($_SESSION['kullanici_id'])): ?>
                <p style="color:cyan">Hoş Geldin! <?php echo htmlspecialchars($_SESSION['kullanici_adi']); ?></p>
                <a href="profil.php">Profil</a>
                <a href="logout.php">Çıkış Yap</a>
             
            <?php else: ?>
                <a href="login.php">Giriş Yap</a>
                <a href="register.php">Kayıt Ol</a>
            <?php endif; ?>
        </nav>

        <div class="search-bar">
            <form action="arama.php" method="get">
                <input type="text" name="q" placeholder="Oyun ara..." autocomplete="off">
            </form>
        </div>
    </header>
</body>
</html>