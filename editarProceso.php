<?php

print_r($_POST);
if(!isset($_POST['id_cliente'])){
    header('Location: clientes.php?mensaje=error');    
}

include 'model/conexion.php';
$id_cliente = $_POST['id_cliente'];
$nombre = $_POST['txtNombre'];
$email = $_POST['txtEmail'];

$query = "select * from cliente where (nombre = '$nombre' ) or (email = '$email')";
$sentencia = $bd -> query($query);
$persona = $sentencia->fetchAll(PDO::FETCH_ASSOC);

if(!empty($persona) && (!$_POST['edit'] == 1)){
    header('Location: clientes.php?mensaje=duplicado');
    exit();
}

$sentencia = $bd->prepare("UPDATE cliente SET nombre = ?, email = ? where id_cliente = ?;");
$resultado = $sentencia->execute([$nombre, $email, $id_cliente]);

if ($resultado === TRUE) {
    header('Location: clientes.php?mensaje=editado');
} else {
    header('Location: clientes.php?mensaje=error');
}


?>