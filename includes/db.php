<?php

	$dsn = "mysql:host=localhost;dbname=testautomation";

	try {
		$pdo = new PDO($dsn, 'root', '');
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}

?>
