<?php include 'template/header.php' ?>

<?php 
    if(!isset($_GET['id_cliente'])){
        header('Location: clientes.php?mensaje=error');
        exit();
    }

    include_once 'model/conexion.php';
    $id_cliente = $_GET['id_cliente'];

    $sentencia = $bd->prepare("select * from cliente where id_cliente=?;");
    $sentencia->execute([$id_cliente]);
    $persona = $sentencia->fetch(PDO::FETCH_OBJ);
    //print_r($persona);
?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Editar datos
                    </div>
                    <form class="p-4" method="POST" action="editarProceso.php">
                        <div class="mb-3">
                            <label class="form-label">Nombre:</label> 
                            <input type="text" class="form-control" name="txtNombre" required
                            value = "<?php echo $persona->nombre; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email:</label> 
                            <input type="email" class="form-control" name="txtEmail" required
                            value = "<?php echo $persona->email; ?>">
                        </div>
                        <div class="d-grid">
                            <?php 
                                if($_GET['edit']==1){ ?>
                                <input type="hidden" name="edit" value="1">
                            <?php } ?>                            
                            <input type="hidden" name="id_cliente" value="<?php echo $persona->id_cliente; ?>">
                            <input type="submit" class="btn btn-primary" value="Editar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include 'template/footer.php' ?>