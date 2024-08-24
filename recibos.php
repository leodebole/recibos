<!-- 
  CRUD CON BOOTSTRAP Y PHP
  https://www.youtube.com/watch?v=FRvHYOrVDZo

  REFORZAR LAS VALIDACIONES DE DATOS!!!
-->

  <?php include 'template/header.php' ?>
  <?php
    include_once 'model/conexion.php';

    if($_POST){
      $dMes = $_POST['dmes']; $dAno = $_POST['dano']; $hMes = $_POST['hmes']; $hAno = $_POST['hano'];    
      ?>
      <script>
        window.onload= function(){
          document.getElementById("searchBox1").value = <?php echo $dMes?>;
          document.getElementById("searchBox2").value = <?php echo $dAno?>;
          document.getElementById("searchBox3").value = <?php echo $hMes?>;
          document.getElementById("searchBox4").value = <?php echo $hAno?>;
        }
      </script>
      <?php 
        $desde = date('Y-m-01', strtotime($dAno.'-'.$dMes.'-01'));
        $hasta = date('Y-m-t', strtotime($hAno.'-'.$hMes.'-01'));
        $sentencia = $bd -> query('select * from recibo inner join cliente on recibo.id_cliente = cliente.id_cliente inner join tipo_pago on recibo.id_tipodepago = tipo_pago.id_tipodepago where recibo.fecha BETWEEN "'.$desde.'" AND "'.$hasta.'"');
        
    }
    else{
      // $añoActual
      // limita la consulta de recibos al año en curso
      $añoActual = date("Y");
      $sentencia = $bd -> query('select * from recibo inner join cliente on recibo.id_cliente = cliente.id_cliente inner join tipo_pago on recibo.id_tipodepago = tipo_pago.id_tipodepago where YEAR(fecha) = '.$añoActual.' order by fecha');
    }
    $recibo = $sentencia->fetchAll(PDO::FETCH_OBJ);
  ?>
      <!-- Llena los placeholders -->
      
 

  <div class="container-fluid">
    <div class="row">
      <div class="col-2 tituloRec">
        <header class="py-3 px-3">
          <h5 class="text-white">LISTADO DE RECIBOS</h5>          
        </header>
      </div>
      <div class="col-6 tituloRec">
        <div class="row">
          <form action="recibos.php" method="post" style="display: inherit;">
            <div class="col-7">
              <div class="row justify-content-center">
                <div class="col-4 "><input class="form-control form-control-sm mb-1 mt-2" id="searchBox1" type="number" name="dmes" placeholder="Desde mes.." required></div>
                <div class="col-4"><input class="form-control form-control-sm mb-1 mt-2" id="searchBox2" type="number" name="dano" placeholder="Desde año.." required></div>
                <div class="w-100"></div>
                <div class="col-4"><input class="form-control form-control-sm " id="searchBox3" type="number" name="hmes" placeholder="Hasta mes.." required></div>
                <div class="col-4"><input class="form-control form-control-sm " id="searchBox4" type="number" name="hano" placeholder="Hasta año.." required></div>
              </div>
            </div>
            <div class="col-5 py-3">
              <button class="btn btn-sm btn btn-light btn-block mt-2 mb-2 ml-5" type="submit">APLICAR FILTRO</button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-4 tituloRec" style="border-right: 10px solid white;">        
        <nav class="navbar navbar-expand-sm justify-content-center">
        <ul class="navbar-nav text-right py-2">
          <li class="nav-item active px-2">
            <button class="btn btn-sm btn-outline-light" type="button" onclick="window.location.href='../V3/recibos.php';">RECIBOS</button>
          </li>
          <li class="nav-item active px-2">
            <button class="btn btn-sm btn-outline-light" type="button" onclick="window.location.href='../V3/clientes.php';">CLIENTES</button>
          </li>
        </ul>
        </nav>
      </div>
    </div>
  </div>





  <div class="container-fluid mt-5">
    <div class="row justify-content-center">
      <div class="col-md-9">
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
            if(isset($_GET['mensaje']) and $_GET['mensaje'] == 'agregado'){
          ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Recibo Agregado</strong>
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

                <table class="table table-stripped table-sm mt-6" id="myTable">
                    <thead class="table-success">
                        <tr>
                            <th class="text-left">Fecha</th>
                            <th class="text-left">Cliente</th>
                            <th class="text-left">Periodo</th>
                            <th class="text-left">Importe</th>
                            <th class="text-left">Tipo de Pago</th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recibo as $dato){ ?>
                        <tr>
                            <?php   $mydate = strtotime($dato->fecha);
                                    $newformat = date('d-m-Y',$mydate);
                                    echo '  <td data-sort="'. $mydate .'">'.$newformat .'</td>';
                            ?>                            
                            
                            <td class="text-left"><?php echo $dato->nombre ?></th>
                            <td class="text-left"><?php echo $dato->observacion ?></th>
                            <td class="text-left">$<?php echo $dato->importe ?></th>
                            <td class="text-left"><?php echo $dato->tipo ?></th>
                            <td class="text-right"><a class="text-success" href="editarRecibo.php?id_cliente=<?php echo $dato->id_cliente ?>&id_recibo=<?php echo $dato->id_recibo ?>&pagina_origen=0"><i class="bi bi-pencil-square text-success"></i></a></td>
                            <td class="text-right"><a onclick="return confirm('Esta seguro de eliminar el periodo <?php echo $dato->observacion ?>') ;" class="text-danger" href="eliminarRecibo.php?id_cliente=<?php echo $dato->id_cliente ?>&id_recibo=<?php echo $dato->id_recibo ?>&pagina_origen=2"><i class="bi bi-trash text-danger"></i></a></td>
                            <td><a class="text-dark" href="buscar.php?id_cliente=<?php echo $dato->id_cliente ?>"><i class="bi bi-search text-darck"></i></a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
        </div>
      </div>
      <div class="col-md-3">
        <select class="form-select form-select mb-2" aria-label="Default select example" onchange="formu()" id="select_id">
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
              <input type="submit" class="btn btn-primary" value="Registrar">
            </div>
          </form>
        </div>          
        <div class="card"  id="addRecibo">
          <!--<div class="card-header text-center">
            Nuevo Recibo
          </div>-->
          <form class="p-2" action="reciboProceso.php" method="POST">
            <select class="form-control mb-2" name="id_cliente">
              <option selected disabled>Seleccionar Cliente...</option>
              <?php 
                $sentencia1 = $bd -> query('select * from cliente order by nombre');
                $persona = $sentencia1->fetchAll(PDO::FETCH_OBJ);
                foreach($persona as $dato){ ?>
			           <option value="<?php echo $dato->id_cliente ?>"><?php echo $dato->nombre ?></option>
		          <?php	}?>
            </select>
            <select class="form-control mb-2" name="concepto" id="concepto">
              <option value="Honorarios mensuales">Honorarios mensuales</option>
              <option value="Honorarios por">Honorarios por</option>
            </select>
            <input class="form-control mb-2" type="text" name="observacion" placeholder="Detalle - Periodo">
            <div class="row">
              <div class="col">
                <input class="form-control mb-2" type="number" name="importe" placeholder="Importe">
              </div>
              <div class="col">
                <select class="form-control mb-2" name="id_tipodepago">
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
                <input class="form-control mb-2" type="number" name="fdia" placeholder="Dia">
              </div>
              <div class="col">
                <input class="form-control mb-2" type="number" name="fmes" placeholder="Mes">
              </div>
              <div class="col">
               <input class="form-control mb-2" type="number" name="fano" placeholder="Año">
              </div>
            </div>
            <textarea class="form-control mb-2" name="txtmail" placeholder="Texto para email..." rows="4" cols="50" style="text-align:left;"></textarea>
            <input class="btn btn-outline-primary  btn-block form-control mb-2" type="submit">
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
        "pageLength": 12,
        order: [[0, 'desc']],
        
    });
    </script>

  
<?php include 'template/footer.php' ?>
