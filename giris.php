<?php
session_start();

if (isset($_SESSION['id'])) {
	header("Location: /index.php");
	exit;
}
?>

<!DOCTYPE HTML>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Oturum Girişi</title>

	<style>
	    /* 1. Genel Stiller (Reset ve Body) - Konseptle Aynı */
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
	        background-color: #005a9c;
	        color: #ffffff;
	        padding: 20px 0;
	        text-align: center;
	        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	    }
	
	    header h1 {
	        margin: 0;
	        font-size: 2em;
	    }
	    
	    /* 3. Navigasyon (Konsept Bütünlüğü İçin) */
	    nav {
	        display: flex;
	        justify-content: center;
	        background-color: #333;
	        padding: 10px 0;
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
	
	    /* 4. Ana İçerik Alanı (main) - Giriş/Kayıt için daraltılmış */
	    main {
	        max-width: 500px; /* Giriş formu için dar alan */
	        margin: 30px auto;
	        padding: 25px;
	        background-color: #ffffff;
	        border-radius: 8px;
	        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
	    }
	
	    /* 5. Form Başlığı (main içindeki h2) */
	    main h2 {
	        color: #005a9c;
	        text-align: center;
	        padding-bottom: 10px;
	        margin-bottom: 25px;
	        font-size: 1.8em;
	    }
	
	    /* 6. PHP Hata Mesajları (main'in içindeki ilk divler) */
	    /* Bu seçici, <main> etiketinin doğrudan altındaki <div>'leri 
	      hedefler (section içindekileri değil). 
	    */
	    main > div {
	        background-color: #f8d7da; /* Açık kırmızı */
	        color: #721c24; /* Koyu kırmızı (metin) */
	        border: 1px solid #f5c6cb; /* Kırmızı border */
	        padding: 12px 15px;
	        border-radius: 4px;
	        margin-bottom: 20px;
	    }
	    
	    main > div p {
	        margin: 0;
	        font-weight: 500;
	    }
	
	
	    /* 7. Giriş Formu (section içindeki) */
	    section form div {
	        margin-bottom: 18px;
	    }
	
	    section form label {
	        display: block;
	        font-weight: bold;
	        margin-bottom: 6px;
	        color: #555;
	    }
	
	    section form input[type="email"],
	    section form input[type="password"] {
	        width: 100%;
	        padding: 12px;
	        border: 1px solid #ccc;
	        border-radius: 4px;
	        font-size: 16px;
	        background-color: #fff;
	    }
	
	    section form button {
	        background-color: #28a745; /* Yeşil buton */
	        color: white;
	        padding: 12px 25px;
	        border: none;
	        border-radius: 4px;
	        cursor: pointer;
	        font-size: 16px;
	        font-weight: bold;
	        transition: background-color 0.3s ease;
	        width: 100%;
	    }
	
	    section form button:hover {
	        background-color: #218838;
	    }
	</style>
</head>

<body>
<header>
	<h1>Beş Dakika Yolculuk</h1>
</header>

<nav>
<div>
	<a href="/index.php">Ana sayfa</a>
</div>
</nav>

<main>
	<h2>Giriş Yap</h2>
	
	<?php $formdurumuhk = $_GET['formdurumu'];
		if (isset($formdurumuhk) && ctype_alnum($formdurumuhk)): ?>
	<?php switch ($formdurumuhk): case 'epostadaalfanumerikharicikarakter': ?>
		<div>
			<p>Lütfen geçerli bir e-posta adresi girin.</p>
		</div>
	<?php break; case 'hatalicredentials': ?>
		<div>
			<p>Böyle bir kullanıcı bulunamadı.</p>
		</div>
	<?php break; case 'nulleposta': ?>
		<div>
			<p>Lütfen geçerli bir e-posta adresi girin.</p>
		</div>
	<?php break; case 'nullparola': ?>
		<div>
			<p>Parola alanı boş olamaz.</p>
		</div>
	<?php endswitch; endif; ?>
	
	<section>
		<form action="/api/giris-yap.php" method="POST">
		<div>
			<label for="eposta">E-posta</label>
			<input type="email" id="eposta" name="email">
		</div>
		<div>
			<label for="parola">Parola</label>
			<input type="password" id="parola" name="password">
		</div>
		<div>
			<button type="submit">Giriş Yap</button>
		</div>
		</form>
	</section>
</main>
</body>
</html>
