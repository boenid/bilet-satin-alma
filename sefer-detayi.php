<?php
require_once 'vt.php';
session_start();

if (!isset($_GET['seferid'])) {
	header("Location: /index.php");
	exit;
}

$seferno = filter_var($_GET['seferid'], FILTER_VALIDATE_INT);

if ($seferno === false) {
	header("Location: /index.php");
	exit;
}

$iller = ['Adana' => 1, 'Adıyaman' => 2, 'Afyonkarahisar' => 3, 'Ağrı' => 4, 'Aksaray' => 51, 'Amasya' => 5, 'Ankara' => 6, 'Antalya' => 7, 'Ardahan' => 75, 'Artvin' => 8, 'Aydın' => 9, 'Balıkesir' => 10, 'Bartın' => 74, 'Batman' => 72, 'Bayburt' => 69, 'Bilecik' => 11, 'Bingöl' => 12, 'Bitlis' => 13, 'Bolu' => 14, 'Burdur' => 15, 'Bursa' => 16, 'Çanakkale' => 17, 'Çankırı' => 18, 'Çorum' => 19, 'Denizli' => 20, 'Diyarbakır' => 21, 'Düzce' => 81, 'Edirne' => 22, 'Elazığ' => 23, 'Erzincan' => 24, 'Erzurum' => 25, 'Eskişehir' => 26, 'Gaziantep' => 27, 'Giresun' => 28, 'Gümüşhane' => 29, 'Hakkâri' => 30, 'Hatay' => 31, 'Iğdır' => 76, 'Isparta' => 32, 'İstanbul' => 34, 'İzmir' => 35, 'Kahramanmaraş' => 46, 'Karabük' => 78, 'Karaman' => 70, 'Kastamonu' => 37, 'Kayseri' => 38, 'Kırklareli' => 39, 'Kırşehir' => 40, 'Kocaeli' => 41, 'Konya' => 42, 'Kütahya' => 43, 'Malatya' => 44, 'Manisa' => 45, 'Mardin' => 47, 'Mersin' => 33, 'Muğla' => 48, 'Muş' => 49, 'Nevşehir' => 50, 'Niğde' => 52, 'Ordu' => 53, 'Osmaniye' => 80, 'Rize' => 54, 'Sakarya' => 54, 'Samsun' => 55, 'Şanlıurfa' => 63, 'Siirt' => 56, 'Sinop' => 57, 'Sivas' => 58, 'Şırnak' => 73, 'Tekirdağ' => 59, 'Tokat' => 60, 'Trabzon' => 61, 'Tunceli' => 62, 'Uşak' => 64, 'Van' => 65, 'Yalova' => 77, 'Yozgat' => 66, 'Zonguldak' => 67];

$kullanici = [];

if (isset($_SESSION['id'])) {
	$sql = "SELECT role, company_id FROM User WHERE id = " . $_SESSION['id'];
	$stmt = $pdo->query($sql);
	$kullanici = $stmt->fetch(PDO::FETCH_ASSOC);
}

$sql = "SELECT * FROM Trips WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$seferno]);

$seferhk = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(*) AS yolcu_sayisi FROM Tickets WHERE trip_id = ? AND status = 'ACTIVE'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$seferno]);

$sefer_yolcusu = $stmt->fetch(PDO::FETCH_ASSOC)['yolcu_sayisi'];

$sql = "SELECT bs.seat_number FROM Trips AS tp INNER JOIN Tickets AS tk ON tp.id = tk.trip_id INNER JOIN Booked_Seats AS bs ON tk.id = bs.ticket_id";
$stmt = $pdo->query($sql);

$alinmis_koltuklar = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE HTML>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Seçili Seferin Detayları</title>

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
	        flex-wrap: wrap; /* Mobil için sığmazsa alt satıra atar */
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
	
	
	    /* 4. Ana İçerik Alanı (main) - Orta genişlik */
	    main {
	        max-width: 760px;
	        margin: 30px auto;
	        padding: 25px;
	        background-color: #ffffff;
	        border-radius: 8px;
	        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
	    }
	
	    /* 5. Sayfa Başlığı (h3) - Her iki rol için de ortak */
	    main section h3 {
	        color: #005a9c;
	        font-size: 1.8em;
	        margin-bottom: 25px;
	        border-bottom: 2px solid #eee;
	        padding-bottom: 10px;
	    }
	    
	    /* 6. Sefer Düzenleme Formu (Firma Rolü) */
	    main section form > div {
	        margin-bottom: 18px; /* Form satırları arası boşluk */
	    }
	
	    main section form label {
	        display: block;
	        font-weight: bold;
	        margin-bottom: 6px;
	        color: #555;
	    }
	
	    /* Tüm form elemanlarını standart hale getir */
	    main section form input[type="datetime-local"],
	    main section form input[type="text"],
	    main section form input[type="number"],
	    main section form select {
	        width: 100%;
	        padding: 12px;
	        border: 1px solid #ccc;
	        border-radius: 4px;
	        font-size: 16px;
	        background-color: #fff;
	    }
	
	    /* Form Kaydet/Güncelle Butonu */
	    main section form button {
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
	
	    main section form button:hover {
	        background-color: #218838;
	    }
	
	    /* 7. Statik Sefer Bilgisi (Kullanıcı Rolü) ve Doluluk Bilgisi */
	    /* Not: Bu seçici (main section > div) hem statik bilgi 
	      satırlarını (Kullanıcı görünümü) hem de 'Doluluk' satırını 
	      (her iki görünüm) hedefler.
	      Ayrıca Firma görünümündeki formu çevreleyen <div>'i de hedefler.
	      En iyi görünüm için Firma görünümündeki <h3>'yi 
	      o <div>'in dışına taşımanız önerilir.
	    */
	    main section > div {
	        display: flex;
	        justify-content: space-between;
	        align-items: center;
	        padding: 15px 0;
	        border-bottom: 1px solid #eee;
	    }
	    
	    /* Firma görünümündeki formun olduğu <div> için flex'i iptal et */
	    /* Bu, o <div> içinde <form> olduğunu varsayar */
	    main section div:has(form) {
	        display: block;
	        padding: 0;
	        border-bottom: none;
	    }
	    
	    main section > div:last-child {
	        border-bottom: none; /* Son elemanın alt çizgisi olmasın */
	    }
	
	    /* Statik bilgi satırlarındaki etiketler */
	    main section > div > label {
	        font-weight: bold;
	        color: #555;
	        font-size: 1.05em;
	    }
	    
	    /* Statik bilgi satırlarındaki veriler */
	    main section > div > p {
	        font-size: 1.1em;
	        color: #000;
	        font-weight: 500;
	        text-align: right;
	    }
	</style>
</head>

<body>
<header>
	<h1>Beş Dakika Yolculuk</h1>
	<h2>Sefer Detayları</h2>
</header>

<nav>
<?php if (isset($kullanici['role'])): ?>
	<div>
		<a href="/hesap-bilgisi.php">Hesabım</a>
	</div>

	<?php if($kull_role <> "user"): ?>
	<div>
		<a href="/sefer-yonetimi.php">Firma Seferleri</a>
	</div>
	<div>
		<a href="/firma-yonetimi.php">Firma Yönetimi</a>
	</div>
	<?php endif; ?>

	<div>
		<a href="/api/cikis-yap.php">Çıkış yap</a>
	</div>
	
<?php else: ?>
	<div>
		<a href="/giris.php">Giriş Yap</a>
	</div>
	<div>
		<a href="/kayit.php">Kayıt Ol</a>
	</div>
<?php endif; ?>
</nav>

<main>
	<section>
	<?php if ($kullanici['role'] == 'company' && $seferhk['company_id'] == $kullanici['company_id']): ?>
		<div>
		<h3>Sefer Ekle/Düzenle</h3>
		
		<form action="/api/sefer-guncelle.php?sefer=<?= $seferno ?>" method="POST">
		<div>
			<label for="seferintarihi">Sefer Tarihi</label>
			<input type="datetime-local" id="seferintarihi" name="sefertarihi" value="<?= $seferhk['departure_time'] ?>">
		</div>
		<div>
			<label for="kalkisili">Kalkış Şehri</label>
			<select id="kalkisili" name="k-il">
				<option value="<?= $seferhk['departure_city'] ?>" selected><?= array_search($seferhk['departure_city'], $iller) ?></option>

				<?php foreach($iller as $sehir => $plaka): ?>
				<option value="<?= $plaka ?>"><?= $sehir ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div>
			<label for="istikamet">Varış Şehri</label>
			<select id="istikamet" name="istikamet-sehri">
				<option value="<?= $seferhk['destination_city'] ?>" selected><?= array_search($seferhk['destination_city'], $iller) ?></option>
			
				<?php foreach($iller as $sehir => $plaka): ?>
				<option value="<?= $plaka ?>"><?= $sehir ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div>
			<label for="tahminivariszamani">Tahmini Varış</label>
			<input type="datetime-local" id="tahminivariszamani" name="tahminivariszamani" value="<?= $seferhk['arrival_time'] ?>">
		</div>
		<div>
			<label for="biletucreti">Ücreti</label>
			<input type="text" id="biletucreti" name="bilet-tutari" value="<?= $seferhk['price'] ?>">
		</div>
		<div>
			<label for="kapasite">Kapasite</label>
			<input type="number" id="kapasite" name="kapasite" value="<?= $seferhk['capacity'] ?>">
		</div>
		<div>
			<button type="submit">Güncelle</button>
		</div>
		</form>
		
		</div>
		<div>
		<label for="doluluk">Doluluk</label>
		<p id="doluluk"><?= $sefer_yolcusu ?> kişi</p>
		</div>
	<?php else: ?>
		<h3>Sefer Hakkında</h3>

		<div>
		<form action="bilet-cikart.php" method="POST">
		<?php for ($i = 0; $i < $seferhk['capacity']; $i++): ?>
			<div>
			<input type="checkbox" value="<?= $i + 1 ?>" id="<?= 'k' . ($i + 1) ?>" name="<?= 'k' . ($i + 1) ?>" <?php if (in_array($i+1, $alinmis_koltuklar)) echo 'selected disabled';?>>
			<label for="<?= 'k' . ($i + 1) ?>"><?= ($i+1) . '. koltuk' ?></label>
			</div>
		<?php endfor; ?>
		</form>
		</div>

		<div>
			
		</div>
	<?php endif; ?>
	</section>
</main>
</body>
</html>
