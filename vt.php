<?php

$vt_db = "api/besdakika.db";

try {
	$pdo = new PDO("sqlite:".$vt_db);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo "Bağlantı hatası: " . $e->getMessage();
	exit();
}
