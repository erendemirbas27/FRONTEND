<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Çıkış Yap</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #2f2f47, #1e1e2f);
      color: #fff;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
    }

    .logout-container {
      background-color: #2c2c3c;
      padding: 2rem 2.5rem;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.3);
      text-align: center;
      max-width: 400px;
      animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .logout-container h2 {
      margin-bottom: 1rem;
      color: #4CAF50;
      font-size: 1.8rem;
    }

    .logout-container p {
      margin-bottom: 1.5rem;
      color: #ccc;
      line-height: 1.6;
    }

    .logout-container a {
      display: inline-block;
      padding: 0.75rem 1.5rem;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-size: 1rem;
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .logout-container a:hover {
      background-color: transparent;
      border-color: #4CAF50;
      color: #4CAF50;
    }

    .checkmark {
      color: #4CAF50;
      font-size: 3rem;
      margin-bottom: 1rem;
      display: inline-block;
    }
  </style>
</head>
<body>

  <div class="logout-container">
    <div class="checkmark">✓</div>
    <h2>Çıkış Başarılı</h2>
   
    <a href="index.php">Ana Sayfaya Dön</a>
  </div>

</body>
</html>