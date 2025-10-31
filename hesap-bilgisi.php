<?php
require_once 'vt.php';
session_start();

if (!isset($_SESSION['id'])) {
	header("Location: /giris.php");
	exit;
}

$sql = "SELECT * FROM User WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['id']]);

$kullanici_bilgileri = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE HTML>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Hesap Bilgileri</title>

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
	
	    /* 2. Header (Başlık Alanı) - Sayfa Başlığı (h2) Eklendi */
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
	    
	    header h2 {
	        margin: 0;
	        font-size: 1.2em;
	        font-weight: 300; /* Daha ince font */
	        opacity: 0.9;
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
	
	
	    /* 4. Ana İçerik Alanı (main) - Ayar sayfası için orta genişlik */
	    main {
	        max-width: 760px; /* Ne çok dar ne çok geniş */
	        margin: 30px auto;
	        padding: 15px 30px;
	        background-color: #ffffff;
	        border-radius: 8px;
	        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
	    }
	
	    /* 5. Ana İçerik Bölümleri (main > div) */
	    /* Her bir ayar bloğunu (İsim, E-posta, Bakiye, Parola) ayıralım */
	    main > div {
	        padding: 25px 0;
	        border-bottom: 1px solid #eee;
	    }
	    
	    main > div:last-child {
	        border-bottom: none; /* Son elemanın alt çizgisini kaldır */
	    }
	
	    /* 6. Form Elemanları (Global Konsept) */
	    form input[type="email"],
	    form input[type="password"] {
	        width: 100%;
	        padding: 12px;
	        border: 1px solid #ccc;
	        border-radius: 4px;
	        font-size: 16px;
	        background-color: #fff;
	    }
	
	    form button {
	        background-color: #28a745; /* Yeşil buton */
	        color: white;
	        padding: 12px 20px;
	        border: none;
	        border-radius: 4px;
	        cursor: pointer;
	        font-size: 16px;
	        font-weight: bold;
	        transition: background-color 0.3s ease;
	        white-space: nowrap; /* "Değiştir" yazısı kırılmasın */
	    }
	
	    form button:hover {
	        background-color: #218838;
	    }
	    
	    /* 7. Alanlara Özel Stiller */
	
	    /* a) İsim ve Bakiye gibi statik bilgi alanları */
	    main > div:nth-child(1),
	    main > div:nth-child(2),
	    main > div:nth-child(3),
	    main > div:nth-child(5) {
	        display: flex;
	        justify-content: space-between;
	        align-items: center;
	    }
	
	    main > div label {
	        font-weight: bold;
	        color: #555;
	        font-size: 1.05em;
	    }
	    
	    main > div p {
	        font-size: 1.1em;
	        color: #000;
	        font-weight: 500;
	    }
	
	    /* b) E-posta (Inline Form) alanı */
	    main > div:nth-child(4) form {
	        display: flex;
	        align-items: center;
	        gap: 15px; /* Elemanlar arası boşluk */
	    }
	    
	    main > div:nth-child(4) form label {
	        flex-shrink: 0; /* Etiket küçülmesin */
	    }
	    
	    main > div:nth-child(4) form input {
	        flex-grow: 1; /* Input alanı boşluğu doldursun */
	        width: auto; /* %100'ü ezelim */
	    }
	
	    /* c) Parola Değiştirme alanı */
	    main > div:nth-child(6) h4 {
	        font-size: 1.4em;
	        color: #005a9c;
	        margin-bottom: 20px;
	        border-bottom: 2px solid #eee;
	        padding-bottom: 10px;
	    }
	    
	    main > div:nth-child(6) form div {
	        margin-bottom: 15px;
	    }
	    
	    main > div:nth-child(6) form label {
	        display: block; /* Etiketi input'un üstüne al */
	        margin-bottom: 6px;
	    }
	    
	    main > div:nth-child(6) form button {
	        width: 100%; /* Buton tam genişlikte olsun */
	        margin-top: 10px;
	    }
	
	</style>
</head>

<body>
<header>
	<h1>Beş Dakika Yolculuk</h1>
	<h2>Hesap Bilgileri</h2>
</header>

<nav>
	<div>
		<a href="/index.php">Ana sayfa</a>
	</div>

	<?php if(isset($kullanici_bilgileri['role']) && $kullanici_bilgileri['role'] == "company"): ?>
	<div>
		<a href="/sefer-yonetimi.php">Firma Seferleri</a>
	</div>
	<div>
		<a href="/firma-yonetimi.php">Firma Yönetimi</a>
	</div>
	<?php endif; ?>>

	<div>
		<a href="/api/cikis-yap.php">Çıkış yap</a>
	</div>
</nav>

<main>
	<div>
		<label for="isim">İsim:</label>
		<p id="isim"><?= $kullanici_bilgileri['full_name'] ?></p>
	</div>

	<div>
		<label for="yetki">Yetkiniz:</label>
		<p id="yetki"><?= $kullanici_bilgileri['role'] ?></p>
	</div>

	<?php if ($kullanici_bilgileri['role'] == 'company'):
			$sql = "SELECT name FROM Bus_Company WHERE id = " . $kullanici_bilgileri['company_id'];
			$stmt = $pdo->query($sql);
			$sirket_adi = $stmt->fetch(PDO::FETCH_ASSOC)['name']; ?>
	
	<div>
		<label for="sirket">Şirket bilgisi:</label>
		<p id="sirket"><?= $sirket_adi ?></p>
	</div>
	<?php endif; ?>
	
	<div>
	<form action="/api/kullanici-bilgileri-guncelle.php" method="POST">
		<label for="eposta">E-posta:</label>
		<input type="email" id="eposta" value="<?= $kullanici_bilgileri['email'] ?>">
		<button type="submit">Değiştir</button>
	</form>
	</div>
	
	<div>
		<label for="bakiye">Bakiyeniz:</label>
		<p>₺ <?= $kullanici_bilgileri['balance'] ?>,00</p>
	</div>
	
	<div>
		<h4>Parolanızı Değiştirebilirsiniz</h4>
		
		<form action="/api/kullanici-bilgileri-guncelle.php" method="POST">
		<div>
			<label for="m-parola">Mevcut parolanız</label>
			<input type="password" id="m-parola" name="cpassword">
		</div>
		<div>
			<label for="y1-parola">Yeni parolanız</label>
			<input type="password" id="y1-parola" name="new1password">
		</div>
		<div>
			<label for="y2-parola">Yeni parolanız tekrar</label>
			<input type="password" id="y2-parola" name="new2password">
		</div>
		<div>
			<button type="submit">Değiştir</button>
		</div>
		</form>
	</div>

	<div>
		<h4>Biletlerim</h4>

		<div>
		</div>
	</div>
</main>
</body>
</html>
