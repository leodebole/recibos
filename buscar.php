<?php include 'template/header.php' ?>

<?php 
    if(!isset($_GET['id_cliente'])){
        header('Location: clientes.php?mensaje=error');
        exit();
    }

    include_once 'model/conexion.php';
    $id_cliente = $_GET['id_cliente'];

    $sentencia = $bd->prepare("select * from recibo inner join cliente on recibo.id_cliente = cliente.id_cliente inner join tipo_pago on recibo.id_tipodepago = tipo_pago.id_tipodepago where recibo.id_cliente=? order by fecha DESC;");
    $sentencia->execute([$id_cliente]);
    
    $sql_cliente = "SELECT * FROM CLIENTE WHERE id_cliente = ".$id_cliente;
    $stmt_cliente = $bd->prepare($sql_cliente);
    $stmt_cliente->execute();
    $row_cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);
    //$persona=$sentencia->fetch(PDO::FETCH_OBJ);
    //print_r($persona);exit();
?>


<div class="container-fluid" style='background-color:#d1e7dd;'>
  <div class="row">
    <div class="col-1 tituloRec" style='background-color:#fff;'>
    </div>
    <div class="col-6 tituloRec">
      <header class="py-3">
        <h5 class="text-white"><?php echo strtoupper($row_cliente['nombre']) ?></h5>
      </header>
    </div>
    <div class="col-5 tituloRec">
      <nav class="navbar navbar-expand-sm justify-content-center" >
        <ul class="navbar-nav text-right py-2" style="margin-right:50px;">
          <li class="nav-item active px-2">
            <button class="btn btn-sm btn-outline-light" type="button" onclick="window.location.href='../V3/recibos.php';">RECIBOS</button>
          </li>
          <li class="nav-item active px-2">
            <button class="btn btn-sm btn-outline-light" type="button" onclick="window.location.href='../V3/clientes.php';">CLIENTES</button>
          </li>
          <!--<li class="nav-item active px-2">
            <button class="btn btn-sm btn-outline-dark" type="button">BUSCAR</button>
          </li>-->
        </ul>
      </nav>
    </div>
  </div>
</div>





    <!-- Inicio Alerta -->

    <?php 
          if(isset($_GET['mensaje']) and $_GET['mensaje'] == 'agregado'){
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Recibo Agregado</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>
    <?php 
          if(isset($_GET['mensaje']) and $_GET['mensaje'] == 'eliminado'){
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Recibo Eliminado</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>
    <?php 
            if(isset($_GET['mensaje']) and $_GET['mensaje'] == 'editado'){
          ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Datos actualizados!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php } ?>

    <!-- Fin Alerta -->


    <div class="container mt-4">
        <div class="row">
            
            <div class="col-md-8">
                
                <table class="table mt-6" id="myTable">
                    <thead class="table-success table-stripped">
                        <tr class="text-left">
                            <th>Fecha</th>    
                            <th>Periodo</th>
                            <th>Importe</th>
                            <th>Tipo de pago</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {

                        ?>
                        <tr class="text-left">
                            <?php   $mydate = strtotime($row['fecha']);
                                    $newformat = date('d-m-Y',$mydate);
                                    echo '  <td data-sort="'. $mydate .'">'.$newformat .'</td>';
                            ?>                            
                            
                            <td><?php echo $row['observacion'] ?></td>
                            <td class="text-center">$<?php echo $row['importe'] ?></td>
                            <td><?php echo $row['tipo'] ?></td>
                            <td><a class="text-success" href="editarRecibo.php?id_cliente=<?php echo $row_cliente['id_cliente'] ?>&id_recibo=<?php echo $row['id_recibo'] ?>&pagina_origen=1"><i class="bi bi-pencil-square text-success"></i></a></td>
                            <td><a onclick="return confirm('Esta seguro de eliminar el periodo <?php echo $row['observacion'] ?>') ;" class="text-danger" href="eliminarRecibo.php?id_cliente=<?php echo $row_cliente['id_cliente'] ?>&id_recibo=<?php echo $row['id_recibo'] ?>&pagina_origen=1"><i class="bi bi-trash text-danger"></i></a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">                
                <div class="card"  id="addRecibo">
                    <div class="card-header text-center text-muted mb-3">
                        Nuevo Recibo
                    </div>
                    <form class="p-2" action="reciboProceso.php" method="POST">
                        <select class="form-control mb-3" name="id_cliente">
                            <option selected disabled>Seleccionar Cliente...</option>
                            <?php 
                            $sentencia1 = $bd -> query('select * from cliente order by nombre');
                            $persona = $sentencia1->fetchAll(PDO::FETCH_OBJ);
                            foreach($persona as $dato){ ?>
                                <option value="<?php echo $dato->id_cliente ?>"><?php echo $dato->nombre ?></option>
                            <?php	}?>
                        </select>
                        <select class="form-control mb-3" name="concepto" id="concepto">
                            <option value="Honorarios mensuales">Honorarios mensuales</option>
                            <option value="Honorarios por">Honorarios por</option>
                        </select>
                        <input class="form-control mb-3" type="text" name="observacion" placeholder="Detalle - Periodo">
                        <div class="row">
                            <div class="col">
                                <input class="form-control mb-3" type="number" name="importe" placeholder="Importe">
                            </div>
                            <div class="col">
                                <select class="form-control mb-3" name="id_tipodepago">
                                <?php
                                    $query = $bd->prepare("select * from tipo_pago;");
                                    $query->execute();
                                    $datos = $query->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <?php	foreach ($datos as $opciones): ?>
                                    <option value="<?php echo $opciones['id_tipodepago']?>"><?php echo $opciones['tipo']?></option>
                                <?php	endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input class="form-control mb-3" type="number" name="fdia" placeholder="Dia">
                            </div>
                            <div class="col">
                                <input class="form-control mb-3" type="number" name="fmes" placeholder="Mes">
                            </div>
                            <div class="col">
                                <input class="form-control mb-3" type="number" name="fano" placeholder="Año">
                            </div>
                        </div>
                        <textarea class="form-control mb-3" name="txtmail" placeholder="Texto para email..." rows="4" cols="50" style="text-align:left;"></textarea>
                        <input type="hidden" name="pagina_origen" value=1>
                        <input class="btn btn-outline-primary  btn-block form-control mb-3" type="submit">
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.3/datatables.min.js"></script>
    <script>
        var table = new DataTable('#myTable',{
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.3/i18n/es-ES.json',
        },
        "lengthChange": false,
        "searching": false,
        "pageLength": 10,
        order: [[0, 'desc']],
        
    });
    </script>
    

    <?php include 'template/footer.php' ?>