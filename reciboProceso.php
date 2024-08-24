<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



require '../phpMyAdmin5.2.0/vendor/autoload.php';
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';



include 'model/conexion.php';

if (isset($_POST['id_cliente'])) {
    if (strlen($_POST['concepto']) >= 1 && strlen($_POST['importe']) >= 1) {
	    $id_cliente = trim($_POST['id_cliente']);
		$concepto = trim($_POST['concepto']);
		$importe = trim($_POST['importe']);
		$observacion = trim($_POST['observacion']);
		$fechaparamail = trim($_POST['fdia']).'-'.trim($_POST['fmes']).'-'.trim($_POST['fano']);
		$fechareg = date("Y-m-d", strtotime($fechaparamail));
		$id_tipodepago = trim($_POST['id_tipodepago']);

	    //$consulta = "INSERT INTO recibo(id_cliente, concepto, importe, observacion, fecha, id_tipodepago) VALUES ('$id_cliente','$concepto','$importe','$observacion','$fechareg', '$id_tipodepago')";
		//$resultado = mysqli_query($conex,$consulta);

        $sentencia = $bd->prepare("INSERT INTO recibo (id_cliente, concepto, importe, observacion, fecha, id_tipodepago) VALUES (?,?,?,?,?,?);");
        $resultado = $sentencia->execute([$id_cliente, $concepto, $importe, $observacion, $fechareg,  $id_tipodepago]);

		if ($resultado) {

            $sql = "SELECT * FROM CLIENTE WHERE id_cliente = ".$_POST['id_cliente'];
		    $stmt = $bd->prepare($sql);
		    $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql_tipo_pago = "SELECT tipo FROM TIPO_PAGO WHERE id_tipodepago = ".$id_tipodepago;
		    $stmt_tipo_pago = $bd->prepare($sql_tipo_pago);
		    $stmt_tipo_pago->execute();
            $row_tipo_pago = $stmt_tipo_pago->fetch(PDO::FETCH_ASSOC);

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Mailer = 'smtp';
            $mail->SMTPDebug  = 0;  
            $mail->SMTPAuth   = TRUE;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $mail->SMTPOptions = array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                );
            $mail->Host       = 'smtp.gmail.com';
            //$mail->Username   = 'angiellaurado@gmail.com';
            //$mail->Password   = 'wyrcpdvtopjfjjtl';
            $mail->Username   = 'leo.debole@gmail.com';
            $mail->Password   = 'hhiigtbvsqwcrtxj';
            $mail->IsHTML(true);
            $mail->AddAddress($row['email'], $row['nombre']);
            //$mail->SetFrom('angiellaurado@gmail.com', 'Angeles Llaurado');
            //$mail->AddReplyTo('angiellaurado@gmail.com', 'Angeles Llaurado');
            //$mail->AddBCC('angiellaurado@gmail.com');
            $mail->SetFrom('leo.debole@gmail.com', 'Leonardo');
            $mail->AddReplyTo('leo.debole@gmail.com', 'Leonardo');
            $mail->AddBCC('leo.debole@gmail.com');
            $mail->Subject = 'Recibo de pago - Angeles Llaurado';
            if ($concepto=='Honorarios mensuales'){
		        $content = '<!DOCTYPE html>
			        <head>
                        <style>
                            #recibos {
                                font-family: Arial, Helvetica, sans-serif;
                                border-collapse: collapse;
                                width: 100%;
                            }
                            #recibos td, #recibos th {
                                text-align: center;
                                border: 1px solid #ddd;
                                padding: 8px;
                            }
                            #recibos tr:nth-child(even){background-color: #f2f2f2;}
                            #recibos tr:hover {background-color: #ddd;}
                            #recibos th {
                                padding-top: 12px;
                                padding-bottom: 12px;
                                background-color: #04AA6D;
                                color: white;
                            }
                        </style>
			        </head>
			        <body>
			            <b>Hola, te adjunto el detalle del pago. <br/>
			            '.$_POST['txtmail'].'<br/>
			            Gracias! <br/>
			            Saludos, Angeles <br>
				        <table id="recibos" border="1" cellpadding="0" cellspacing="0" class="browseTable">
					        <tr>
					            <th>Nombre</th>
					            <th>Fecha de Transferencia</th>
					            <th>Concepto</th>
					            <th>Detalle</th>
					            <th>Medio de Pago</th>
					            <th>Importe</th>
					        </tr>   
					        <tr>
					            <td>'.$row['nombre'].'</td>
					            <td>'.$fechaparamail.'</td>
					            <td>'.$concepto.'</td>
					            <td>'.$observacion.'</td>
					            <td>'.$row_tipo_pago['tipo'].'</td>
					            <td>$'.$importe.'</td>
					        </tr>
				        </table>
				        </b>
				    </body>
				</html>';
            }

            else{
	            $content = '<!DOCTYPE html>
			        <head>
			            <style>
			                #recibos {
				            font-family: Arial, Helvetica, sans-serif;
				            border-collapse: collapse;
				            width: 100%;
			                }
                            #recibos td, #recibos th {
                                text-align: center;
                                border: 1px solid #ddd;
                                padding: 8px;
                            }
                            #recibos tr:nth-child(even){background-color: #f2f2f2;}
                            #recibos tr:hover {background-color: #ddd;}
                            #recibos th {
                                padding-top: 12px;
                                padding-bottom: 12px;
                                background-color: #04AA6D;
                                color: white;
                            }
                        </style>
                    </head>
                    <body>
                        <b>Hola, te adjunto el detalle del pago. <br/>
                            '.$_POST['txtmail'].'<br/>
                            Gracias! <br/>
                            Saludos, Angeles <br>
                            <table id="recibos" border="1" cellpadding="0" cellspacing="0" class="browseTable">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Fecha de Transferencia</th>
                                    <th>Concepto</th>
                                    <th>Detalle</th>
                                    <th>Medio de Pago</th>
                                    <th>Importe</th>
                                </tr>
                                <tr>
                                    <td>'.$row['nombre'].'</td>
                                    <td>'.$fechaparamail.'</td>
                                    <td>'.$concepto.'</td>
                                    <td>'.$observacion.'</td>
                                    <td>'.$row_tipo_pago['tipo'].'</td>
                                    <td>$'.$importe.'</td>
                                </tr>
                            </table>
                        </b>
                    </body>
                </html>';
            }
            $mail->MsgHTML($content); 
            if(!TRUE){
            /*if(!$mail->Send()) {
                header('Location: clientes.php?mensaje=errorMail');
                var_dump($mail);*/
            } else {
                if($_POST['pagina_origen'] == 1){
                    header('Location: buscar.php?id_cliente='.$_POST['id_cliente'].'&mensaje=agregado');
                }
                else{
                    header('Location: recibos.php?mensaje=agregado');
                }
            }

	    } else {
	    	 
	    	//    <!--<h3 class="bad">¡Ups ha ocurrido un error!</h3>-->
                header('Location: clientes.php?mensaje=errorInsercion');
            
	        }
    }   else {
	    	 
	        //	<h3 class="bad">¡Por favor complete los campos!</h3>
            header('Location: clientes.php?mensaje=faltanCampos');
           
        }
    }

?>

