<?php
require_once 'vt.php';
session_start();

if (isset($_SESSION['id'])) {
	header("Location: /index.php");
	exit;
}

if (isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['t_password'])) {
	$kadi = "";
	$parola = "";

	$vakumlu_isim = str_replace(' ', '', $_POST['fullname']);
	
	if (ctype_alnum($vakumlu_isim))
		$kadi = $_POST['fullname'];
	else {
		header("Location: /kayit.php?formdurumu=isimdealfanumerikharicikarakter");
		exit;
	}

	$eposta = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

	if(!filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
		header("Location: /kayit.php?formdurumu=epostadaalfanumerikharicikarakter");
		exit;
	}

	//Eposta yinelenmesi kontrolü
	$sql = "SELECT COUNT(*) AS kayit_sayisi FROM User WHERE email = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$eposta]);

	if ($stmt->fetch(PDO::FETCH_ASSOC)['kayit_sayisi'] > 0) {
		header("Location: /kayit.php?formdurumu=kayitlikullanici");
		exit;
	}

	if ($_POST['password'] == $_POST['t_password']) {
		$parola = $_POST['password'];
		$parola_h = password_hash($parola, PASSWORD_DEFAULT);
	}
	else {
		header("Location: /kayit.php?formdurumu=eslesmeyenparola");
		exit;
	}

	$sql = "INSERT INTO User (full_name, email, role, password) VALUES (?, ?, 'user', ?)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$kadi, $eposta, $parola_h]);

	$sql = "SELECT id FROM User WHERE email = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$eposta]);

	$_SESSION['id'] = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

	header("Location: /index.php");
	exit;
}
else {
	header("Location: /index.php");
	exit;
}
?>

<!DOCTYPE HTML>
<html lang="tr">
<head>
<title>ekleniyor..</title>
</head>

<body>
</body>
</html>
