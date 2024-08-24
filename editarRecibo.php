<?php include 'template/header.php' ?>

<?php 
    if(!isset($_GET['id_cliente'])){
        header('Location: clientes.php?mensaje=error');
        exit();
    }

    include_once 'model/conexion.php';
    $id_cliente = $_GET['id_cliente'];
    $id_recibo = $_GET['id_recibo'];

    $sentencia = $bd->prepare("select * from recibo inner join cliente on recibo.id_cliente = cliente.id_cliente inner join tipo_pago on recibo.id_tipodepago = tipo_pago.id_tipodepago where id_recibo=?;");
    $sentencia->execute([$id_recibo]);
    $recibo = $sentencia->fetch(PDO::FETCH_OBJ);
    //print_r($persona);
?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center text-muted ">
                        Editar Recibo
                    </div>
                    <form class="p-4" action="editarReciboProceso.php" method="POST">
                        <input class="form-control mb-3" type="text" name="nada" readonly placeholder="<?php echo $recibo->nombre?>">
                        <select class="form-control mb-3" name="concepto" id="concepto">
                            <option <?php echo $recibo->concepto === 'Honorarios mensuales' ? "selected='selected'" : "" ?> value="Honorarios mensuales">Honorarios mensuales</option>
                            <option <?php echo $recibo->concepto === 'Honorarios por' ? "selected='selected'" : "" ?> value="Honorarios por">Honorarios por</option>
                        </select>
                        <input class="form-control mb-3" type="text" name="observacion" value="<?php echo $recibo->observacion?>">
                        <div class="row">
                            <div class="col">
                                <input class="form-control mb-3" type="number" name="importe" value="<?php echo $recibo->importe?>">
                            </div>
                            <div class="col">
                                <select class="form-control mb-3" name="id_tipodepago">
                                    <option value="<?php echo $recibo->id_tipodepago?>" selected><?php echo $recibo->tipo?></option>
                                    <?php
                                        $query = $bd->prepare("select * from tipo_pago;");
                                        $query->execute();
                                        $datos = $query->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php	foreach ($datos as $opciones): 
                                        if(!($opciones['id_tipodepago'] === $recibo->id_tipodepago)){?>
                                            <option value="<?php echo $opciones['id_tipodepago']?>"><?php echo $opciones['tipo']?></option>
                                    <?php	}endforeach ?>
                                </select>
                            </div>                            
                        </div>
                        <?php $orderdate = explode('-', $recibo->fecha); $ano = $orderdate[0]; $mes = $orderdate[1]; $dia   = $orderdate[2]; ?>
                        <div class="row">
                            <div class="col">
                                <input class="form-control mb-3" type="number" name="fdia" value=<?php echo $dia ?>>
                            </div>
                            <div class="col">
                                <input class="form-control mb-3" type="number" name="fmes" value=<?php echo $mes ?>>
                            </div>
                            <div class="col">
                                <input class="form-control mb-3" type="number" name="fano" value=<?php echo $ano ?>>
                            </div>
                        </div>
                        <input type="hidden" name="id_recibo" value=<?php echo $recibo->id_recibo?>>
                        <input type="hidden" name="nombre" value=<?php echo $recibo->nombre?>>
                        <input type="hidden" name="id_cliente" value=<?php echo $recibo->id_cliente?>>
                        <?php if($_GET['pagina_origen']){?>
                            <input type="hidden" name="pagina_origen" value=<?php echo $_GET['pagina_origen']?>>
                        <?php } ?>
                        <input class="btn btn-outline-primary  btn-block form-control mb-3" type="submit" value="GUARDAR">
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include 'template/footer.php' ?>