<?php
    if(!isset($_GET['id_recibo'])){
        header('Location: clientes.php?mensaje=error');
        exit();
    }

    include 'model/conexion.php';
    $id_recibo = $_GET['id_recibo'];
    $sentencia = $bd->prepare("DELETE FROM recibo where recibo.id_recibo = ?;");
    $resultado = $sentencia->execute([$id_recibo]);

    if ($resultado === TRUE) {
        if($_GET['pagina_origen'] == 1){
            header('Location: buscar.php?id_cliente='.$_GET['id_cliente'].'&mensaje=eliminado');
        }
        else{
            header('Location: recibos.php?mensaje=eliminado');
        }
    } else {
        header('Location: recibos.php?mensaje=error');
    }
        

?>