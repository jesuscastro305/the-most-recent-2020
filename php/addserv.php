<?php
include_once('../includes/load.php');
if (isset($_GET['agregar'])) {
	$num = $_GET['num'];
	$cant = $_GET['cant'];

	$verif = $db->query("select * from servicios where `servicio` = '$num'");
	$cantt = mysqli_num_rows($verif);
	if ($cantt > 0) {
		$session->msg('d','Ya existe ese servicio o producto');
		redirect('../servicios.php');
	}else{
		$agregar = $db->query("INSERT INTO `servicios` (`servicio`,`cant`) VALUES ('$num','$cant')");

		if(!$agregar){
			$session->msg('d','No se pudo agregar el servico/producto');
			redirect('../servicios.php');
		}else{
			$session->msg('s','Se agrego correctamente');
		}
	}
}
else if (isset($_GET['editar'])) {
	$num = $_GET['num'];
	$cant = $_GET['cant'];
	$id = $_GET['id'];

	$verif = $db->query("select * from servicios where `id` = '$id'");
	$cantt = mysqli_num_rows($verif);
	if ($cantt == 0) {
		$session->msg('d','Ese servicio no esta registrado');
		redirect('../servicios.php');
	}else{
		$editar = $db->query("UPDATE `servicios` set `servicio`='$num', `cant`='$cant' where `id`='$id'");

		if(!$editar){
			$session->msg('d','No se pudo editar el servico/producto');
			redirect('../servicios.php');
		}else{
			$session->msg('s','Se edito correctamente');
		}
	}
	
}
else if (isset($_GET['eliminar'])) {
	
	$id = $_GET['id'];

	$verif = $db->query("select * from servicios where `id` = '$id'");
	$cantt = mysqli_num_rows($verif);
	if ($cantt == 0) {
		$session->msg('d','No hay nada para eliminar');
		redirect('../servicios.php');
	}else{
		$eliminar = $db->query("DELETE FROM `servicios` where `id`='$id'");

		if(!$eliminar){
			$session->msg('d','No se pudo eliminar el servico/producto');
			redirect('../servicios.php');
		}else{
			$session->msg('s','Se elimino correctamente');
		}
	}
	
}
	
redirect('../servicios.php');
?>