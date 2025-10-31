<?php
require_once 'vt.php';
session_start();

$sirket_id = 0;

if (isset($_SESSION['id'])) {
	$sql = "SELECT role, company_id FROM User WHERE id = " . $_SESSION['id'];
	$stmt = $pdo->query($sql);
	
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($user['role'] <> 'company') {
		header("Location: /index.php");
		exit;
	}

	$sirket_id = $user['company_id'];
}
else {
	header("Location: index.php");
	exit;
}

//Artık company kullanıcısı olduğumuzdan eminiz.

$iller = ['Adana' => 1, 'Adıyaman' => 2, 'Afyonkarahisar' => 3, 'Ağrı' => 4, 'Aksaray' => 51, 'Amasya' => 5, 'Ankara' => 6, 'Antalya' => 7, 'Ardahan' => 75, 'Artvin' => 8, 'Aydın' => 9, 'Balıkesir' => 10, 'Bartın' => 74, 'Batman' => 72, 'Bayburt' => 69, 'Bilecik' => 11, 'Bingöl' => 12, 'Bitlis' => 13, 'Bolu' => 14, 'Burdur' => 15, 'Bursa' => 16, 'Çanakkale' => 17, 'Çankırı' => 18, 'Çorum' => 19, 'Denizli' => 20, 'Diyarbakır' => 21, 'Düzce' => 81, 'Edirne' => 22, 'Elazığ' => 23, 'Erzincan' => 24, 'Erzurum' => 25, 'Eskişehir' => 26, 'Gaziantep' => 27, 'Giresun' => 28, 'Gümüşhane' => 29, 'Hakkâri' => 30, 'Hatay' => 31, 'Iğdır' => 76, 'Isparta' => 32, 'İstanbul' => 34, 'İzmir' => 35, 'Kahramanmaraş' => 46, 'Karabük' => 78, 'Karaman' => 70, 'Kastamonu' => 37, 'Kayseri' => 38, 'Kırklareli' => 39, 'Kırşehir' => 40, 'Kocaeli' => 41, 'Konya' => 42, 'Kütahya' => 43, 'Malatya' => 44, 'Manisa' => 45, 'Mardin' => 47, 'Mersin' => 33, 'Muğla' => 48, 'Muş' => 49, 'Nevşehir' => 50, 'Niğde' => 52, 'Ordu' => 53, 'Osmaniye' => 80, 'Rize' => 54, 'Sakarya' => 54, 'Samsun' => 55, 'Şanlıurfa' => 63, 'Siirt' => 56, 'Sinop' => 57, 'Sivas' => 58, 'Şırnak' => 73, 'Tekirdağ' => 59, 'Tokat' => 60, 'Trabzon' => 61, 'Tunceli' => 62, 'Uşak' => 64, 'Van' => 65, 'Yalova' => 77, 'Yozgat' => 66, 'Zonguldak' => 67];

$sql = "SELECT * FROM Trips WHERE company_id = " . $sirket_id;
$stmt = $pdo->query($sql);

$sirkete_ait_seferler = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE HTML>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Sefer Yönetimi</title>

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
	
	    /* 2. Header (Başlık Alanı) - Konseptle Aynı (h2 eklendi) */
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
	        font-weight: 300;
	        opacity: 0.9;
	    }
	    
	    /* 3. Navigasyon (Konsept Bütünlüğü İçin) - Değişiklik Gerekmiyor */
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
	
	
	    /* 4. Ana İçerik Alanı (main) - Yönetim sayfası için orta genişlik */
	    main {
	        max-width: 800px; /* Kartlar için biraz daha geniş */
	        margin: 30px auto;
	        padding: 25px;
	        background-color: #ffffff;
	        border-radius: 8px;
	        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
	    }
	
	    /* 5. Ana Başlık (Seferler h3) */
	    main > div:first-child h3 {
	        color: #005a9c;
	        font-size: 1.8em;
	        margin-bottom: 20px;
	        border-bottom: 2px solid #eee;
	        padding-bottom: 10px;
	    }
	
	    /* 6. Sefer Kartları (Her bir <section>) */
	    main section {
	        border: 1px solid #e0e0e0;
	        border-radius: 8px;
	        padding: 20px;
	        margin-bottom: 20px;
	        background-color: #fafafa;
	        box-shadow: 0 2px 4px rgba(0,0,0,0.03);
	    }
	
	    /* 7. Kart İçeriği (label/p satırları) */
	    main section > div {
	        display: flex;
	        justify-content: space-between;
	        align-items: center;
	        padding: 10px 0;
	        border-bottom: 1px solid #eee;
	    }
	
	    main section > div label {
	        font-weight: bold;
	        color: #555;
	    }
	    
	    main section > div p {
	        font-size: 1.1em;
	        color: #000;
	        font-weight: 500;
	        text-align: right; /* Verileri sağa yasla */
	    }
	
	    /* 8. Kart Link Alanı (Son div) */
	    main section > div:last-child {
	        border-bottom: none; /* Son satırın alt çizgisi olmasın */
	        padding-top: 20px; /* Buton/link için üst boşluk */
	        justify-content: flex-end; /* Linki sağa yasla */
	    }
	
	    /* Linki konseptteki butonlara benzetelim */
	    main section > div a {
	        background-color: #005a9c; /* Ana renk */
	        color: #ffffff;
	        text-decoration: none;
	        padding: 8px 15px;
	        border-radius: 4px;
	        font-weight: bold;
	        transition: background-color 0.3s ease;
	    }
	
	    main section > div a:hover {
	        background-color: #004170; /* Hover için koyu mavi */
	    }
	</style>
</head>

<body>
<header>
	<h1>Beş Dakika Yolculuk</h1>
	<h2>Seferlerin Yönetimi</h2>
</header>

<nav>
	<div>
		<a href="/index.php">Ana sayfa</a>
	</div>
	<div>
		<a href="/hesap-bilgisi.php">Hesabım</a>
	</div>
	<div>
		<a href="/firma-yonetimi.php">Firma Yönetimi</a>
	</div>
	<div>
		<a href="/api/cikis-yap.php">Çıkış yap</a>
	</div>
</nav>

<main>
	<div>
	<h3>Seferler</h3>
	</div>
	
	<?php foreach($sirkete_ait_seferler as $sefer): ?>
	<section>
		<div>
			<label for="tarih">Sefer Tarihi</label>
			<p id="tarih"><?= htmlspecialchars($sefer['departure_time']) ?></p>
		</div>
		<div>
			<label for="istikamet">İstikamet</label>
			<p id="istikamet"><?= htmlspecialchars(array_search($sefer['departure_city'], $iller)) ?> -> <?= htmlspecialchars(array_search($sefer['destination_city'], $iller)) ?></p>
		</div>
		<div>
			<label for="varis_zamani">Varış Hakkında</label>
			<p id="varis_zamani"><?= $sefer['arrival_time'] ?></p>
		</div>
		<div>
			<label for="ucret">Ücreti</label>
			<p id="ucret"><?= $sefer['price'] ?>,00 ₺</p>
		</div>
		<div>
			<label for="koltuk-sayisi">Toplam Koltuk Sayısı</label>
			<p id="koltuk-sayisi"><?= $sefer['capacity'] ?></p>
		</div>

		<div>
			<?php
			$sql = "SELECT COUNT(*) AS dolu_koltuk_sayisi FROM Tickets WHERE trip_id = " . $sefer['id'] . " AND status = 'active'";
			$stmt = $pdo->query($sql);

			$otobus_doluluk_orani = ($stmt->fetch(PDO::FETCH_ASSOC)['dolu_koltuk_sayisi'] / $sefer['capacity']) * 100;
			?>
		<label for="doluluk">Doluluk</label>
		<p id="doluluk"><?= htmlspecialchars('% ' . $otobus_doluluk_orani) ?></p>
		</div>

		<div>
		<a href="/sefer-detayi.php?seferid=<?= $sefer['id'] ?>">Sefer detayları</a>
		</div>
	</section>
	<?php endforeach; ?>
</main>
</body>
</html>
