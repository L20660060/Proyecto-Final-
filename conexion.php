<?php
	
	$host = 'localhost:3308';
	$user = 'root';
	$password = '';
	$db = 'bd_ventas';

	$conection = @mysqli_connect($host,$user,$password,$db);

	if (!$conection) {
		echo "Error en la conexion";
	}

?>
