<?php
    if(!isset($_GET['id_cliente'])){
        header('Location: clientes.php?mensaje=error');
        exit();
    }

    include 'model/conexion.php';
    $id_cliente = $_GET['id_cliente'];

    $sentencia = $bd->prepare("DELETE FROM cliente where cliente.id_cliente = ?;");
    $resultado = $sentencia->execute([$id_cliente]);

    if ($resultado === TRUE) {
        if($_GET['pagina_origen'] == 1){
        //borre $_POST por $_GET en if y else
            header('Location: clientes.php?id_cliente='.$_GET['id_cliente'].'&mensaje=agregado');
        }

        else{
            header('Location: buscar.php?id_cliente='.$_GET['id_cliente'].'&mensaje=agregado');
        }
    } else {
        header('Location: clientes.php?mensaje=error');
    }
        

?>