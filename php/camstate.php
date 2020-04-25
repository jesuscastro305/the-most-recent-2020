<?php 
	include_once('../includes/load.php');
				echo "<script>console.log('entro principal');</script>";

	$id = $_GET['id'];
	$state = $_GET['state'];
	$page = $_GET['page'];

	

	if ($_GET['btn']=="confirmar") {

		$camb = $db->query("UPDATE `pedidos` set `estado` = '1' WHERE `id` = '$id'");
		$regmov = $db->query("UPDATE `cambiosestado` SET `".$_GET['btn']."`= NOW() WHERE `pedido` = '$id';");

	} else if ($_GET['btn']=="fabricar") {

		$camb = $db->query("UPDATE `pedidos` set `estado` = '2' WHERE `id` = '$id'");
		$regmov = $db->query("UPDATE `cambiosestado` SET `".$_GET['btn']."`= NOW() WHERE `pedido` = '$id';");

	} else if ($_GET['btn']=="encamino") {

		$camb = $db->query("UPDATE `pedidos` set `estado` = '3' WHERE `id` = '$id'");
		$regmov = $db->query("UPDATE `cambiosestado` SET `".$_GET['btn']."`= NOW() WHERE `pedido` = '$id';");

	} else if ($_GET['btn']=="liquidar" || $_GET['btn']=="anticipo") {
				echo "<script>console.log('entro a la condicional');</script>";

		$pagoform = $_GET['pago'];
		$tipo = $_GET['btn'];


				$cons = $db->query("select SUM(`pago`) as `z` from `pagos` where `id_pedido` = '$id';");
				$faltante = mysqli_fetch_assoc($cons);

				$con = $db->query("select `precio` as `z` from `pedidos` where `id` = '$id';");
				$fa = mysqli_fetch_assoc($con);

				if (($faltante['z'] + $pagoform) > $fa['z']) {
				    $session->msg("d", "El anticipo excede lo que falta por pagar. Pedido: ".$id);
				    redirect('../'.$page,false);
					
				}

				$pago = $db->query("INSERT INTO `pagos`(`pago`, `tipo`, `id_pedido`) VALUES ('$pagoform','$tipo','$id')");

			if ($db->affected_rows() == 0) {
				echo "<script>console.log('no hay cambios');</script>";
				$TRES = $db->query("ROLLBACK;");
			    $session->msg("d", "No se pudo afectar ninguna fila del pedido: ".$id.". Intentalo de nuevo, si vuelve a ocurrir, contacta a Jesus, pues esto es grabe y no te dejara continuar. Recuerda apuntar el numero de pedido junto con el tipo de pago y la cantidad.");
			    redirect('../'.$page,false);
			}
			else if ($db->affected_rows() > 0) {
				echo "<script>console.log('entro en el 1');</script>";
				// $regmov = $db->query("UPDATE `cambiosestado` SET `".$_GET['btn']."`= NOW() WHERE `pedido` = '$id';");
				$TRES = $db->query("COMMIT;");
			    $session->msg("s", "Se realizo el pago del pedido: ".$id);
			    redirect('../'.$page.'#indiv'.$id,false);
			}

	} else if ($_POST['btn']=="terminar") {
			//$media_files = find_all('media');
				echo "<script>console.log('paso el process');</script>";
		  /*$photo = new Media();
		  $photo->upload($_FILES['foto']);
		  $photo->process_media();*/
		   /* if(!){
		      	$session->msg('d',join($photo->errors));
	    		redirect('../'.$page.'#indiv'.$id,false);
		    }*/


		$page = $_POST['page'];
  $photo = new Media();
  $photo->upload($_FILES['foto']);
    if($photo->process_media()){
        // $session->msg('s','Imagen subida al servidor.');
				echo "<script>console.log('paso ');</script>";
			    $session->msg("s", "Pedido:".$id." Terminado");
			    redirect('../'.$page.'#indiv'.$_POST['id'],false);
    } else{
      $session->msg('d',join($photo->errors));
		    $session->msg("d", join($photo->errors).". Pedido: ".$_POST['id']);
		    redirect('../'.$page,false);
    }
		// $camb = $db->query("INSERT INTO `terminados`(`primercb`, `fecha`, `hora`, `foto`, `id_ped`) VALUES ()");
		// $camb = $db->query("UPDATE `pedidos` set `estado` = '4' WHERE `id` = '".$_GET['id']."'");
	/*	$idd = $_POST['id'];
		$page = $_POST['page'];
		if ($regmov) {
		    $session->msg("s", "Se cambio el estado del pedido ".$id);
		    redirect('../'.$page.'#indiv'.$idd,false);
		}*/

	} else if ($_GET['btn']=="cancelar") {


			$razon = $_GET['razon'];
			$accion = $_GET['accion'];
			$cliente = $_GET['cliente'];

		$camb = $db->query("UPDATE `pedidos` set `estado` = '5' WHERE `id` = '$id'");
		$regmov = $db->query("UPDATE `cambiosestado` SET `".$_GET['btn']."`= NOW() WHERE `pedido` = '$id';");

		$verif = $db->query("select * from cancelados where id_pedido = '$id'");
		if ($db->num_rows($verif) > 0) {
			$update = $db->query("update cancelados set categoria = '$accion', Comentario = '$razon', fecha = now() where id_pedido = '$id'");
		}
		else{
			$insert = $db->query("insert into cancelados (`categoria`, `Comentario`, `id_pedido`, `cliente`) values ('$accion','$razon','$id', '$cliente')");
		}

	}else if ($_GET['btn']=="recoger") {



		$regmov = $db->query("UPDATE `cambiosestado` SET `".$_GET['btn']."`= NOW() WHERE `pedido` = '$id';");

		$verif = $db->query("select * from terminados where id_ped = '$id'");
		if ($db->num_rows($verif) > 0) {
			$update = $db->query("update terminados set estado = 1, fecha_r = now() where id_ped = '$id'");
	    $session->msg("s", "Se cambio el estado del pedido ".$id);
	    redirect('../'.$page.'#indiv'.$id,false);
		}
		else{
		    $session->msg("w", "El pedido ".$id." aun no se ha finalizado");
	    redirect('../'.$page.'#indiv'.$id,false);
		}

	}

	if (!$camb) {
	    $session->msg("d", "No se pudo cambiar el estado del pedido ".$id);
	    redirect('../'.$page.'#indiv'.$id,false);
	}else{
	    $session->msg("s", "Se cambio el estado del pedido ".$id);
	    redirect('../'.$page.'#indiv'.$id,false);
	} 
	
?>