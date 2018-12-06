<?php
	$servername="localhost";
		$username="root";
		$password="";
		$dbname="fitness";
		$conn = new mysqli($servername, $username, $password, $dbname);
		session_start();

	$sql = "SELECT * FROM clase WHERE id=" . $_GET["id"];
	$result = $conn->query($sql);
	$row = mysqli_fetch_assoc($result);
	echo "". $row['cuota_base'];
?>