<?php

require_once 'vt.php';

session_start();

$iller = ['Adana' => 1, 'Adıyaman' => 2, 'Afyonkarahisar' => 3, 'Ağrı' => 4, 'Aksaray' => 51, 'Amasya' => 5, 'Ankara' => 6, 'Antalya' => 7, 'Ardahan' => 75, 'Artvin' => 8, 'Aydın' => 9, 'Balıkesir' => 10, 'Bartın' => 74, 'Batman' => 72, 'Bayburt' => 69, 'Bilecik' => 11, 'Bingöl' => 12, 'Bitlis' => 13, 'Bolu' => 14, 'Burdur' => 15, 'Bursa' => 16, 'Çanakkale' => 17, 'Çankırı' => 18, 'Çorum' => 19, 'Denizli' => 20, 'Diyarbakır' => 21, 'Düzce' => 81, 'Edirne' => 22, 'Elazığ' => 23, 'Erzincan' => 24, 'Erzurum' => 25, 'Eskişehir' => 26, 'Gaziantep' => 27, 'Giresun' => 28, 'Gümüşhane' => 29, 'Hakkâri' => 30, 'Hatay' => 31, 'Iğdır' => 76, 'Isparta' => 32, 'İstanbul' => 34, 'İzmir' => 35, 'Kahramanmaraş' => 46, 'Karabük' => 78, 'Karaman' => 70, 'Kastamonu' => 37, 'Kayseri' => 38, 'Kırklareli' => 39, 'Kırşehir' => 40, 'Kocaeli' => 41, 'Konya' => 42, 'Kütahya' => 43, 'Malatya' => 44, 'Manisa' => 45, 'Mardin' => 47, 'Mersin' => 33, 'Muğla' => 48, 'Muş' => 49, 'Nevşehir' => 50, 'Niğde' => 52, 'Ordu' => 53, 'Osmaniye' => 80, 'Rize' => 54, 'Sakarya' => 54, 'Samsun' => 55, 'Şanlıurfa' => 63, 'Siirt' => 56, 'Sinop' => 57, 'Sivas' => 58, 'Şırnak' => 73, 'Tekirdağ' => 59, 'Tokat' => 60, 'Trabzon' => 61, 'Tunceli' => 62, 'Uşak' => 64, 'Van' => 65, 'Yalova' => 77, 'Yozgat' => 66, 'Zonguldak' => 67];

$uid = 0;
$urole = "";
$ubalance = 0;
$uname = "";
$ucompid = 0;


if(isset($_SESSION['id']) && isset($_SESSION['role']) && isset($_SESSION['balance']) && isset($_SESSION['full_name']) && isset($_SESSION['company_id'])) {
	$uid = $_SESSION['id'];
	$urole = $_SESSION['role'];
	$ubalance = $_SESSION['balance'];
	$uname = $_SESSION['full_name'];
	$ucompid = $_SESSION['company_id'];
}

?>

<!DOCTYPE HTML>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Beş Dakika Yolculuk</title>

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
	
	    /* 2. Header (Başlık Alanı) */
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
	
	    /* 3. Navigasyon Menüsü */
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
	
	    /* 4. Ana İçerik Alanı (main) */
	    main {
	        max-width: 960px;
	        margin: 30px auto;
	        padding: 25px;
	        background-color: #ffffff;
	        border-radius: 8px;
	        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
	    }
	
	    /* 5. Bölümler (section) ve Başlıklar (h2) */
	    section {
	        margin-bottom: 30px;
	    }
	
	    section h2 {
	        color: #005a9c;
	        border-bottom: 2px solid #eee;
	        padding-bottom: 10px;
	        margin-bottom: 20px;
	        font-size: 1.8em;
	    }
	
	    /* 6. Arama Formu */
	    form div {
	        margin-bottom: 15px;
	    }
	
	    form label {
	        display: block;
	        font-weight: bold;
	        margin-bottom: 5px;
	        color: #555;
	    }
	
	    form select {
	        width: 100%;
	        padding: 12px;
	        border: 1px solid #ccc;
	        border-radius: 4px;
	        font-size: 16px;
	        background-color: #fff;
	    }
	
	    form button {
	        background-color: #28a745; /* Canlı bir yeşil */
	        color: white;
	        padding: 12px 25px;
	        border: none;
	        border-radius: 4px;
	        cursor: pointer;
	        font-size: 16px;
	        font-weight: bold;
	        transition: background-color 0.3s ease;
	    }
	
	    form button:hover {
	        background-color: #218838;
	    }
	
	    /* 7. Sefer Arama Sonuçları (PHP ile basılan alan) */
	    
	    /* PHP'nin ürettiği section'ı hedef alalım (arama formundan sonraki) */
	    main section + section { 
	        border-top: 1px solid #ddd;
	        padding-top: 20px;
	    }
	
	    /* Her bir sefer sonucu için kart görünümü */
	    main section + section > div {
	        border: 1px solid #e0e0e0;
	        border-radius: 8px;
	        padding: 20px;
	        margin-bottom: 20px;
	        background-color: #fafafa;
	        box-shadow: 0 2px 4px rgba(0,0,0,0.03);
	    }
	    
	    /* Sonuçların içindeki satırlar (label + p) */
	    main section + section > div > label {
	        font-weight: bold;
	        color: #444;
	        display: inline-block;
	        width: 160px; /* Etiketlerin hizalı durması için sabit genişlik */
	    }
	    
	    main section + section > div > p {
	        display: inline;
	        font-size: 1.1em;
	        color: #000;
	    }
	
	    /* PHP'den gelen <hr> etiketini gizle, kartlar arası boşluk daha iyi */
	    main section + section > hr {
	        display: none;
	    }
	</style>
</head>

<body>
<header>
	<h1>Beş Dakika Yolculuk</h1>
</header>

<nav>
<?php if($uid > 0): ?>
	<div>
		<a href="hesap-bilgisi.php?<?= $_SESSION['id'] ?>">Hesabım</a>
	</div>
	<?php if(isset($_SESSION['role']) && $urole == "company"): ?>
	<div>
		<a href="sefer-yonetimi.php?<?= htmlspecialchars($ucompid) ?>">Firma Seferleri</a>
	</div>
	<?php endif; ?>

	<?php if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"): ?>
	<div>
		<a href="firma-yonetimi.php ?>">Firmalar</a>
	</div>
	<?php endif; ?>
	<div>
		<label for="cuzdan-bakiyesi">Cüzdan: </label>
		<p id="cuzdan-bakiyesi"><?= htmlspecialchars($ubalance) ?></p>
	</div>
<?php else: ?>
	<div>
		<a href="giris.php">Giriş Yap</a>
	</div>
	<div>
		<a href="kayit.php">Kayıt Ol</a>
	</div>
<?php endif; ?>
</nav>

<main>
<section>
	<h2>Sefer Ara</h2>

	<form action="" method="GET">
	<div>
	<label for="kalkis-il">Kalkış Şehri</label>

	<select id="kalkis-il" name="k-il">
		<option value="" selected disabled>--Kalkış Noktası Seçin--</option>

		<?php foreach($iller as $sehir => $plaka): ?>
			<option value=<?= $plaka ?>><?= $sehir ?></option>
		<?php endforeach; ?>
	</select>
	</div>
	
	<div>
	<label for="varis-il">Varış Şehri</label>

	<select id="varis-il" name="v-il">
		<option value="" selected disabled>--Varış Noktası Seçin--</option>

		<?php foreach($iller as $sehir => $plaka): ?>
			<option value=<?= $plaka ?>><?=$sehir?></option>
		<?php endforeach; ?>
	</select>
	</div>

	<div>
	<button type="submit">Ara</button>
	</div>
	</form>
</section>
	
<?php
if (isset($_GET['k-il']) && isset($_GET['v-il'])) {
	$kalkis_yapilacak_il = filter_var($_GET['k-il'], FILTER_VALIDATE_INT);
	$varis_yapilacak_il	 = filter_var($_GET['v-il'], FILTER_VALIDATE_INT);
	
	if (!($kalkis_yapilacak_il === false || $kalkis_yapilacak_il <= 0 || $varis_yapilacak_il === false || $varis_yapilacak_il <= 0)) {
		$sql = "SELECT b.name, b.logo_path, t.destination_city, t.arrival_time, t.departure_time, t.departure_city, t.price, t.capacity FROM Trips AS t INNER JOIN Bus_Company AS b ON t.company_id = b.id WHERE departure_city = ? AND destination_city = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$kalkis_yapilacak_il, $varis_yapilacak_il]);
		$sefer_arama_sonuclari = $stmt->fetchAll(PDO::FETCH_ASSOC);

		echo '<section>
			<div>
			<h2>Seferler</h2>
			</div>';

		foreach ($sefer_arama_sonuclari as $sefer) {
			echo '<div>';
			echo '<label for="otobus-firmasi">Firma: </label><p id="otobus-firmasi">' . htmlspecialchars($sefer['name']) . '</p><br>';
			echo '<label for="sefer-tarihi">Sefer Tarihi: </label><p id="sefer-tarihi">' . htmlspecialchars($sefer['departure_time']) . '</p><br>';
			echo '<label for="kalkis-sehri">Kalkış: </label><p id="kalkis-sehri">' . htmlspecialchars(array_search($sefer['departure_city'], $iller)) . '</p><br>';
			echo '<label for="varis-sehri">İstikamet: </label><p id="varis-sehri">' . htmlspecialchars(array_search($sefer['destination_city'], $iller)) . '</p><br>';
			echo '<label for="varis-zamani">Varış Zamanı: </label><p id="varis-zamani">' . htmlspecialchars($sefer['arrival_time']) . '</p><br>';
			echo '<label for="bilet-ucreti">Bilet Ücreti: </label><p id="bilet-ucreti">' . htmlspecialchars($sefer['price']) . '</p><br>';
			echo '<label for="otobus-kapasitesi">Otobüs Kapasitesi: </label><p id="otobus-kapasitesi">' . htmlspecialchars($sefer['capacity']) . '</p><br>';
			echo '</div><hr>';
		}

		echo '</section>';
	}
}
?>
</main>
</body>
</html>
