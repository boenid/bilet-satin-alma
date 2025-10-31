<?php
require_once 'vt.php';
session_start();

if (!isset($_SESSION['id'])) {
	header("Location: /index.php");
	exit;
}

$seferno = filter_var($_GET['sefer'], FILTER_VALIDATE_INT);

$sql = "SELECT company_id FROM Trips WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$seferno]);

$ilgili_seferin_firmasi = $stmt->fetch(PDO::FETCH_ASSOC)['company_id'];

$sql = "SELECT company_id FROM User WHERE id = " . $_SESSION['id'];
$stmt = $pdo->query($sql);

$kull_sirket = $stmt->fetch(PDO::FETCH_ASSOC)['company_id'];

if ($ilgili_seferin_firmasi != $kull_sirket) {
	header("Location: /sefer-yonetimi.php");
	exit;
}

//Güncellenecek veriler
$sefertarihi = $_POST['sefertarihi'];
$kalkisil	 = $_POST['k-il'];
$varisil	 = $_POST['istikamet-sehri'];
$tahminivaris= $_POST['tahminivariszamani'];
$biletucreti = $_POST['bilet-tutari'];
$otobuskapasite = $_POST['kapasite'];

$sql = "UPDATE Trips SET departure_time = ?, departure_city = ?, destination_city = ?, arrival_time = ?, price = ?, capacity = ? WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$sefertarihi, $kalkisil, $varisil, $tahminivaris, $biletucreti, $otobuskapasite, $seferno]);

header("Location: /sefer-yonetimi.php");
exit;
?>
