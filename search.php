<?php include 'template/header.php' ?>



<?php
    // $añoActual
    // limita la consulta de recibos al año en curso
  $añoActual = date("Y");
  include_once 'model/conexion.php';
  
  $sentencia = $bd -> query('select * from recibo inner join cliente on recibo.id_cliente = cliente.id_cliente inner join tipo_pago on recibo.id_tipodepago = tipo_pago.id_tipodepago order by fecha');
  $recibo = $sentencia->fetchAll(PDO::FETCH_OBJ);
  //print_r($persona);
  
?>


<div class="container-fluid" style='background-color:#d1e7dd;'>
  <div class="row">
    <div class="col-4">
    </div>
    <div class="col-4">
      <header class="py-3">
        <h5 class="text-center">BUSCAR</h5>
      </header>
    </div>
    <div class="col-4">
      <nav class="navbar navbar-expand-sm justify-content-end" style='background-color:#d1e7dd;'>
        <ul class="navbar-nav text-right py-2" style="margin-right:30px;">
          <li class="nav-item active px-2">
            <button class="btn btn-sm btn-outline-dark" type="button">RECIBOS</button>
          </li>
          <li class="nav-item active px-2">
            <button class="btn btn-sm btn-outline-dark" type="button">CLIENTES</button>
          </li>
          <li class="nav-item active px-2">
            <button class="btn btn-sm btn-outline-dark" type="button">BUSCAR</button>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>


<div class="container">
  
</div>



  <div class="container-fluid mt-3">
    <div class="row">
      <div class="col-1">
        <button class="btn btn-sm btn-outline-secondary mb-2" type="button" onclick = mostrarRango();>FECHA</button>
      </div>
      <div class="col-1" id="searchBox1">
        <input class="form-control form-control-sm mb-2 " type="number" name="dmes" placeholder="Mes">
      </div>
      <div class="col-1" id="searchBox2">
        <input class="form-control form-control-sm mb-2 " type="number" name="dano" placeholder="Año">
      </div>
      <div class="col-1" id="searchBox3">
        <input class="form-control form-control-sm mb-2 " type="number" name="hmes" placeholder="Mes">
      </div>
      <div class="col-1" >
        <input id="searchBox4" class="form-control form-control-sm mb-2 " type="number" name="hano" placeholder="Año">
      </div>
      <div class="col-1" id="searchBox5">
        <i class="bi bi-box-arrow-right mt-2"></i>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-9">
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
                  <?php   
                    $mydate = strtotime($dato->fecha);
                    $newformat = date('d-m-Y',$mydate);
                      echo '  <td data-sort="'. $mydate .'">'.$newformat .'</td>';
                  ?>                            
                  <td class="text-left"><?php echo $dato->nombre ?></td>
                  <td class="text-left"><?php echo $dato->observacion ?></td>
                  <td class="text-left">$<?php echo $dato->importe ?></td>
                  <td class="text-left"><?php echo $dato->tipo ?></td>
                  <td class="text-right"><a class="text-success" href="editarRecibo.php?id_cliente=<?php echo $dato->id_cliente ?>&id_recibo=<?php echo $dato->id_recibo ?>&pagina_origen=0"><i class="bi bi-pencil-square text-success"></i></a></td>
                  <td class="text-right"><a onclick="return confirm('Esta seguro de eliminar el periodo <?php echo $dato->observacion ?>') ;" class="text-danger" href="eliminarRecibo.php?id_cliente=<?php echo $dato->id_cliente ?>&id_recibo=<?php echo $dato->id_recibo ?>&pagina_origen=2"><i class="bi bi-trash text-danger"></i></a></td>
                  <td><a class="text-dark" href="buscar.php?id_cliente=<?php echo $dato->id_cliente ?>"><i class="bi bi-search text-darck"></i></a></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
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
