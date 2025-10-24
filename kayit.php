<?php
session_start();

if (isset($_SESSION['id'])) {
	header("Location: index.php");
	exit;
}
?>

<!DOCTYPE HTML>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Kayıt Ol</title>

	<style>
	    /* 1. Genel Stiller (Reset ve Body) */
	    * {
	        margin: 0;
	        padding: 0;
	        box-sizing: border-box;
	    }
	
	    body {
	        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
	        background-color: #f4f7f6;
	        color: #333;
	        line-height: 1.6;
	    }
	
	    /* 2. Header (Başlık Alanı) - Konseptle Aynı */
	    header {
	        background-color: #005a9c; /* Kurumsal bir mavi */
	        color: #ffffff;
	        padding: 20px 0;
	        text-align: center;
	        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	    }
	
	    header h1 {
	        margin: 0;
	        font-size: 2em;
	    }
	    
	    /* 3. Navigasyon Menüsü (HTML'de olmasa da konsept bütünlüğü için) */
	    nav {
	        display: flex;
	        justify-content: center;
	        background-color: #333;
	        padding: 10px 0;
	    }
	
	    nav div {
	        margin: 0 10px;
	    }
	
	    nav a {
	        color: #ffffff;
	        text-decoration: none;
	        padding: 8px 15px;
	        border-radius: 4px;
	        font-weight: bold;
	        transition: background-color 0.3s ease;
	    }
	
	    nav a:hover {
	        background-color: #005a9c;
	    }
	
	
	    /* 4. Ana İçerik Alanı (main) - Form için daraltıldı */
	    main {
	        max-width: 500px; /* Kayıt formu için daha dar bir alan */
	        margin: 30px auto;
	        padding: 25px;
	        background-color: #ffffff;
	        border-radius: 8px;
	        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
	    }
	
	    /* 5. Bölümler (section) ve Başlıklar (h2) */
	    section {
	        margin-bottom: 20px; /* Alt boşluk ayarlandı */
	    }
	
	    /* Form başlığı için (HTML'e <h2>Kayıt Ol</h2> eklerseniz kullanılır) */
	    section h2 {
	        color: #005a9c;
	        text-align: center;
	        padding-bottom: 10px;
	        margin-bottom: 25px;
	        font-size: 1.8em;
	    }
	
	    /* 6. Kayıt Formu */
	    form div {
	        margin-bottom: 18px;
	    }
	
	    form label {
	        display: block;
	        font-weight: bold;
	        margin-bottom: 6px;
	        color: #555;
	    }
	
	    /* Yeni eklenen input stili (Select ile aynı görünümde) */
	    form input[type="text"] {
	        width: 100%;
	        padding: 12px;
	        border: 1px solid #ccc;
	        border-radius: 4px;
	        font-size: 16px;
	        background-color: #fff;
	    }
	
	    /* Konseptteki 'Ara' butonuyla aynı stil, tam genişlikte */
	    form button {
	        background-color: #28a745; /* Konseptteki yeşil renk */
	        color: white;
	        padding: 12px 25px;
	        border: none;
	        border-radius: 4px;
	        cursor: pointer;
	        font-size: 16px;
	        font-weight: bold;
	        transition: background-color 0.3s ease;
	        width: 100%; /* Form butonları genelde tam genişlikte olur */
	    }
	
	    form button:hover {
	        background-color: #218838;
	    }
	</style>
</head>

<body>
<header>
	<h1>Beş Dakika Yolculuk</h1>
</header>

<main>
	<section>
		<form action="/api/kayit.php" method="POST">
		<div>
			<label for="isim">İsminiz:</label>
			<input type="text" id="isim" name="fullname">
		</div>
		<div>
			<label for="email">E-Posta:</label>
			<input type="text" id="email" name="email">
		</div>
		<div>
			<label for="passwd">Parola:</label>
			<input type="text" id="passwd" name="password">
		</div>
		<div>
			<button type="submit">Kayıt Ol</button>
		</div>
		</form>
	</section>
</main>
</body>
</html>
