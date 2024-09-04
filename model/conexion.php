<?php 
$contrasena = "root";
$usuario = "root";
$nombre_bd = "sistema";
$db_server = 'db_server';

try {
	$bd = new PDO (
		'mysql:host='.$db_server.';
		dbname='.$nombre_bd,
		$usuario,
		$contrasena,
		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
	);
} catch (Exception $e) {
	echo "Problema con la conexion: ".$e->getMessage();
}
?>
