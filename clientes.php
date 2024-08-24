<!-- 
  CRUD CON BOOTSTRAP Y PHP
  https://www.youtube.com/watch?v=FRvHYOrVDZo

  REFORZAR LAS VALIDACIONES DE DATOS!!!
-->

<?php include 'template/header.php' ?>

<?php
  include_once 'model/conexion.php';
  $sentencia = $bd -> query('select * from cliente order by nombre');
  $persona = $sentencia->fetchAll(PDO::FETCH_OBJ);
  //print_r($persona);
  
?>

<!--
  <div class="container-fluid bg-warning">
    <div class="row">
      <div class="col-md">
        <header class="py-2">
          <h5 class="text-center">Listado de Clientes</h5>
        </header>
      </div>
    </div>
  </div>
-->

<div class="container-fluid" style='background-color:#d1e7dd;'>
  <div class="row">
    <div class="col-3">
    </div>
    <div class="col-4">
      <header class="py-3">
        <h5 class="text-center">CLIENTES</h5>
      </header>
    </div>
    <div class="col-4">
      <nav class="navbar navbar-expand-sm justify-content-end" style='background-color:#d1e7dd;'>
        <ul class="navbar-nav text-right py-2" style="margin-right:80px;">
          <li class="nav-item active px-2">
            <button class="btn btn-sm btn-outline-dark" type="button" onclick="window.location.href='../V3/recibos.php';">RECIBOS</button>
          </li>
          <li class="nav-item active px-2">
            <button class="btn btn-sm btn-outline-dark" type="button" onclick="window.location.href='../V3/clientes.php';">CLIENTES</button>
          </li>
          <!--
          <li class="nav-item active px-2">
            <button class="btn btn-sm btn-outline-dark" type="button">BUSCAR</button>
          </li>-->
        </ul>
      </nav>
    </div>
  </div>
</div>


  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-7">
        <!-- inicio alerta -->
          <?php 
            if(isset($_GET['mensaje']) and $_GET['mensaje'] == 'falta'){
          ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Rellenar todos los campos
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php } ?>
          <?php 
            if(isset($_GET['mensaje']) and $_GET['mensaje'] == 'registrado'){
          ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Se agregaron los datos con exito!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php } ?>
          <?php 
            if(isset($_GET['mensaje']) and $_GET['mensaje'] == 'error'){
          ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Vuelve a intentar
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
          <?php 
            if(isset($_GET['mensaje']) and $_GET['mensaje'] == 'eliminado'){
          ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Registro Eliminado!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php } ?>
          <?php 
            if(isset($_GET['mensaje']) and $_GET['mensaje'] == 'duplicado'){
          ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Nombre o Email duplicado!!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php } ?>
          <?php 
            if(isset($_GET['mensaje']) and $_GET['mensaje'] == 'errorMail'){
          ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error al enviar Email</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php } ?>
          <?php 
            if(isset($_GET['mensaje']) and $_GET['mensaje'] == 'errorInsercion'){
          ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error al generar recibo!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php } ?>
        <!-- fin alerta -->

        <div class="card" id="formRecibo">
          <div class="card-header text-center" style="background-color:#d1e7dd">
            <h5>Listado</h5>
          </div>
          <div class="p-4">
            <table class="table align-middle">
              <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col" colspan="3">Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0;
                  foreach($persona as $dato){ 
                ?>
                  <tr>
                    <td scope="row"><?php $i++; echo $i ?></td>
                    <td><?php echo $dato->nombre ?></td>
                    <td><?php echo $dato->email ?></td>
                    <td><a class="text-success" href="editar.php?id_cliente=<?php echo $dato->id_cliente ?>&edit=1"><i class="bi bi-pencil-square text-success"></i></a></td>
                    <td><a onclick="return confirm('Esta seguro de eliminar el registro <?php echo $dato->nombre ?>') ;" class="text-danger" href="eliminar.php?id_cliente=<?php echo $dato->id_cliente ?>&pagina_origen=1"><i class="bi bi-trash text-danger"></i></a></td>
                    <td><a class="text-dark" href="buscar.php?id_cliente=<?php echo $dato->id_cliente ?>"><i class="bi bi-search text-darck"></i></a></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>              
          </div>
        </div>
      </div>

        <div class="col-md-4">    

          <select class="form-select form-select mb-3" aria-label="Default select example" onchange="formu()" id="select_id">
            <option class="text-center text-muted mb-3" value="r">Nuevo Recibo</option>
            <option class="text-center text-muted mb-3" value="c">Nuevo Cliente</option>
          </select>
          <div class="card"  id="addCliente">
            <!--<div class="card-header text-center">
              Nuevo Cliente
            </div>-->
            <form class="p-4" method="POST" action="registrar.php">
              <div class="mb-3">
                <label class="form-label">Nombre:</label> 
                <input type="text" class="form-control" name="txtNombre" autofocus required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email:</label> 
                <input type="email" class="form-control" name="txtEmail" required>
              </div>
              <div class="d-grid">
                <input type="hidden" name="oculto" value="1">
                <input type="submit" class="btn btn-primary btn-lg btn-block form-control mb-3" value="Registrar">
              </div>
            </form>
          </div>          
          <div class="card"  id="addRecibo">
            <!--<div class="card-header text-center">
              Nuevo Recibo
            </div>-->
            <form class="p-4" action="reciboProceso.php" method="POST">
              <select class="form-control mb-3" name="id_cliente">
                  <?php foreach($persona as $dato){ ?>
			              <option value="<?php echo $dato->id_cliente ?>"><?php echo $dato->nombre ?></option>
		            <?php	}?>
              </select>
              <select class="form-control mb-3" name="concepto" id="concepto">
                <option value="Honorarios mensuales">Honorarios mensuales</option>
                <option value="Honorarios por">Honorarios por</option>
              </select>
              <input class="form-control mb-2" type="text" name="observacion" placeholder="Detalle - Periodo">
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
              <input class="btn btn-outline-primary  btn-block form-control mb-3" type="submit">
            </form>
          </div>
        </div>
      </div>
  </div>


<?php include 'template/footer.php' ?>
