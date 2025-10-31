<?php
require_once 'vt.php';
session_start();

if (isset($_SESSION['id'])) {
	header("Location: /index.php");
	exit;
}

$eposta = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$parola = $_POST['password'];

if (!isset($eposta)) {
	header("Location: /giris.php?formdurumu=nulleposta");
	exit;
}

if (!isset($parola)) {
	header("Location: /giris.php?formdurumu=nullparola");
	exit;
}

if (filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
	$sql = "SELECT id, password FROM User WHERE email = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$eposta]);

	$kullanici_bilgileri = $stmt->fetch(PDO::FETCH_ASSOC);

	if (password_verify($parola, $kullanici_bilgileri['password'])) {
		$_SESSION['id'] = $kullanici_bilgileri['id'];

		header("Location: /index.php");
		exit;
	}
	else {
		header("Location: /giris.php?formdurumu=hatalicredentials");
		exit;
	}
}
else {
	header("Location: /giris.php?formdurumu=epostadaalfanumerikharicikarakter");
	exit;
}
?>
