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
	$arr = array('cuota' => $row['cuota_base'],
				 'lunes' => $row['lunes'],
				 'martes' => $row['martes'],
				 'miercoles' => $row['miercoles'],
				 'jueves' => $row['jueves'],
				 'viernes' => $row['viernes'],
				 'sabado' => $row['sabado']
				);
	echo json_encode($arr);
?>