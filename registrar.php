<?php 
    //print_r($_POST);
    if(empty($_POST["oculto"]) || empty($_POST["txtNombre"]) || empty($_POST["txtEmail"])){
        header('Location: clientes.php?mensaje=falta');
        exit();
    }

    include_once 'model/conexion.php';
    $nombre = strval($_POST['txtNombre']);
    $email = $_POST['txtEmail'];

    $query = "select * from cliente where (nombre = '$nombre' ) or (email = '$email')";
    $sentencia = $bd -> query($query);
    $persona = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        
    if(!empty($persona)){
        header('Location: clientes.php?mensaje=duplicado');
        exit();
    }
    
    $sentencia = $bd->prepare("INSERT INTO cliente(nombre, email) VALUES (?,?);");
    $resultado = $sentencia->execute([$nombre, $email]);

    if ($resultado === TRUE) {
        header('Location: clientes.php?mensaje=registrado');
    } else {
        header('Location: clientes.php?mensaje=error');
        exit();
    }
    

?>