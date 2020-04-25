<?php 
	include_once('../includes/load.php');
	$id = $_GET['id'];
	$state = $_GET['state'];
	$page = $_GET['page'];

	if ($state == 0) {
		$state = 1;
	}else if($state == 1){
		if (isset($_GET['razon'])) {
			$state = 0;
			$razon = $_GET['razon'];
			$accion = $_GET['accion'];
		}else{
			$session->msg("d", "No se pudo cambiar el estado del pedido ".$id." Porque no se explicó el porque");
	    	redirect('../'.$page,false);
		}
	}else
	{
		$session->msg("d", "Datos no reconocidos");
	    	redirect('../'.$page,false);
	}

	$cambiar = $db->query("update pedidos set estado = '$state' where id = '$id'");

	$verif = $db->query("select * from cancelados where id_pedido = '$id'");
	if ($db->num_rows($verif) > 0) {
		$update = $db->query("update cancelados set categoria = '$accion', Comentario = '$razon', fecha = now() where id_pedido = '$id'");
/*		if (!$update) {
			$session->msg("d", "No se pudo actializar la informacion de cancelado del pedido: ".$id);
	    	redirect('../'.$page,false);
		}*/
	}
	else{
		$insert = $db->query("insert into cancelados (`categoria`, `Comentario`, `id_pedido`) values ('$accion','$razon','$id')");

/*		if (!$insert) {
			$session->msg("d", "No se pudo agregar informacion sobre la cancelación del pedido: ".$id);
	    	redirect('../'.$page,false);
		}*/
	}

	if (!$cambiar) {
	    $session->msg("d", "No se pudo cambiar el estado del pedido ".$id);
	    redirect('../'.$page,false);
	}else{
	    $session->msg("s", "Se cambio el estado del pedido ".$id);
	    redirect('../'.$page,false);
	}
?>