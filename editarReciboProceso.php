<?php



include 'model/conexion.php';


$fecha = trim($_POST['fdia']).'-'.trim($_POST['fmes']).'-'.trim($_POST['fano']);
$fechareg = date("Y-m-d", strtotime($fecha));
$sentencia = $bd->prepare("UPDATE recibo SET `fecha`= ?,`concepto`= ?,`importe`= ?,`id_tipodepago`= ?,`observacion`= ? WHERE `id_recibo`= ?");
$resultado = $sentencia->execute([$fechareg, $_POST['concepto'], $_POST['importe'], $_POST['id_tipodepago'], $_POST['observacion'], $_POST['id_recibo']]);

if ($resultado === TRUE) {
    if($_POST['pagina_origen']){
        header('Location: buscar.php?mensaje=editado&id_cliente='.$_POST['id_cliente']);
    }
    else{
        header('Location: recibos.php?mensaje=editado');
    }
    
} else {
    header('Location: recibos.php?mensaje=error&id_cliente='.$_POST['id_cliente']);
}


?>