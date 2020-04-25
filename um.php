<?php
include_once('includes/load.php');
 if (!$session->isUserLoggedIn(true)) { 
    $session->msg('d', 'Primero debes iniciar sesion');
    redirect('index.php');} 
$op = '5.7';
$page_title = "Unidades de medida";

if (isset($_GET['agregar'])) {

	if ($_GET['med'] == $_GET['abr']) {
		$session->msg('d',"ERROR: Recuerda que la unidad de medida no puede ser identica a la abreviacion.");
		redirect("um.php",false);
	}

	$verificar = $db->query("SELECT * FROM u_medida where medida = '".$_GET['med']."' OR abreviacion = '".$_GET['abr']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe == 0) {

		$consulta = $db->query("INSERT INTO u_medida (medida,abreviacion) VALUES ('".$_GET['med']."','".$_GET['abr']."')");

		if (!$consulta) {
			$session->msg('d',"ERROR: No fue posible agregar la nueva unidad de medida.");
			redirect("um.php",false);
		} else {
			$session->msg('s',"Se agrego correctamente: ".$_GET['med'].".");
			redirect("um.php",false);
		}

	} else {
		$session->msg('d',"ERROR: Datos duplicados. Verifica que los datos ingresados no se encuentren en la tabla.");
		redirect("um.php",false);
	}
	
} else if (isset($_GET['editar'])) {

/*	$verificar = $db->query("SELECT * FROM u_medida where id != '".$_GET['id']."' AND medida = '".$_GET['med']."' OR abreviacion = '".$_GET['abr']."' ");
	$existe = mysqli_num_rows($verificar);

	if ($existe > 0) {
		$session->msg('d',"ERROR: Verifica que los datos que intentas agregar no hayan sido agregados anteriormente.");
		redirect("um.php",false);
	}*/

	$verificar = $db->query("SELECT * FROM u_medida where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		
		$consulta = $db->query("UPDATE u_medida SET medida = '".$_GET['med']."', abreviacion = '".$_GET['abr']."' WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"ERROR: No se pudo editar la unidad de medida.");
			redirect("um.php",false);
		} else {
			$session->msg('s',"Se edito correctamente.");
			redirect("um.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La fila no existe en la base de datos.");
		redirect("um.php",false);
	}
	
} else if (isset($_GET['eliminar'])) {

	$verificar = $db->query("SELECT * FROM u_medida where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		
		$consulta = $db->query("DELETE FROM u_medida WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"No se pudo eliminar la unidad de medida.");
			redirect("um.php",false);
		} else {
			$session->msg('s',"Se elimino correctamente.");
			redirect("um.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La informacion que intenta eliminar no existe en la base de datos.");
		redirect("um.php",false);
	}
	
}


include_once('layouts/header.php');

//SELECT (ELT(WEEKDAY(fecha) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA, DATE_FORMAT(fecha, "%d/%M/%Y") as CUANDO FROM pedidos

?>
	<div class="container ">
		<div class="text-center col-12 mt-2">
	    <div class="col-8 offset-2">
	        <?php echo display_msg($msg); ?>
	    </div>
	    <div class="alert alert-info">Las unidades de medida seran utilizadas por el sistema para poder contabilizar de la cantidad de materia prima registrada en el sistema. De esta manera, podra realizar calculos muy aproximados para descontar materia prima cada vez que se fabrique un producto.</div>
			<table class="table table-striped">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Unidad de medida</th>
			      <th scope="col">Abreviacion</th>
			      <th scope="col"><button class="btn btn-xs btn-success glyphicon glyphicon-plus" data-toggle="modal" 
								data-target="#modaladd" data-toggle="tooltip"></button></th>
			    </tr>
			  </thead>
			  <tbody>

			  	<?php
			  		$todo = $db->query("select * from u_medida");
			  		$id_s = 1;
			  		foreach ($todo as $k ) {
			  	?>

			    <tr>
			      <th scope="row"><?php echo $id_s; ?></th>
			      <td><?php echo $k['medida']; ?></td>
			      <td><?php echo $k['abreviacion']; ?></td>
			      <td>
		                <button class="btn btn-xs btn-warning glyphicon glyphicon-pencil" data-toggle="modal" 
								data-target="#modaledit<?php echo $k['id']; ?>" data-toggle="tooltip"></button>

						    <div class="modal fade " id="modaledit<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
							  	<div class="modal-dialog modal-centered modal-m " role="document">
								    <div class="modal-content">
								      	<div class="modal-header" style="text-align: center;">
										  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Editar unidad de medida: <?php echo $id_s; ?></strong></h4>
								      	</div>
								      	<div class="modal-body text-center">
								      		<div class="alert alert-warning"><span class="glyphicon glyphicon-alert"></span>Verifica que los datos que intentas agregar no hayan sido agregados anteriormente.</div>
											<strong>Informacion sobre la inidad de medida:</strong>
											<form action="" method="get">
											<div class="col-12 mt-1">
												<label class="control-label">Medida:</label>
											<input type="text" class="form-control" value="<?php echo $k['medida']; ?>" name="med" maxlength="100" placeholder="" required>
											</div>
											<div class="col-12 mt-1">
												<label class="control-label">Abreviacion:</label>
											<input type="text" class="form-control" value="<?php echo $k['abreviacion']; ?>" name="abr" maxlength="20"  required>
											</div>
									    </div>
									    <div class="modal-footer">
									        <button class="btn btn-warning" name="editar" data-toggle="tooltip">Editar</button>
									        <input type="hidden" name="id" value="<?php echo $k['id']; ?>">
									        </form>
									        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									    </div>
									</div>
								</div>
							</div>

		                <button class="btn btn-xs btn-danger glyphicon glyphicon-trash" data-toggle="modal" 
								data-target="#modaldell<?php echo $k['id']; ?>" data-toggle="tooltip"></button>

						    <div class="modal fade " id="modaldell<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
							  	<div class="modal-dialog modal-centered modal-m " role="document">
								    <div class="modal-content">
								      	<div class="modal-header" style="text-align: center;">
										  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Eliminar unidad de medida: <?php echo $id_s; ?></strong></h4>
								      	</div>
								      	<div class="modal-body text-center">
											<strong>Seguro que deseas eliminar esta unidad de medida?</strong>
											<div class="col-12 mt-1">
												<strong>Medida: </strong><?php echo $k['medida']; ?>
											</div>
											<div class="col-12 mt-1">
												<strong>Abreviacion: </strong><?php echo $k['abreviacion']; ?>
											</div>
									    </div>
									    <div class="modal-footer">
											<form action="" method="get">
									        <button class="btn btn-danger" name="eliminar" data-toggle="tooltip">Si</button>
									        <input type="hidden" name="id" value="<?php echo $k['id']; ?>">
									        </form>
									        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
									    </div>
									</div>
								</div>
							</div>

            		</td>


			    </tr>

			    <?php $id_s++; } ?>

			  </tbody>
			</table>
		</div>

	    <div class="modal fade " id="modaladd" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
		  	<div class="modal-dialog modal-centered modal-m " role="document">
			    <div class="modal-content">
			      	<div class="modal-header" style="text-align: center;">
					  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Agregar Unidad de medida</strong></h4>
			      	</div>
			      	<div class="modal-body text-center">
						<strong>Informacion sobre la unidad de medida</strong>
						<form action="" method="get">
						<div class="col-12 mt-1">
							<label class="control-label">Medida:</label>
						<input type="text" class="form-control"  name="med" maxlength="100" ma placeholder="Kilogramo/Gramo/Pieza/.." required>
						</div>
						<div class="col-12 mt-1">
							<label class="control-label">Abreviacion:</label>
						<input type="text" class="form-control"  name="abr" maxlength="20" placeholder="Kg/g/Pz/.." required>
						</div>
				    </div>
				    <div class="modal-footer">
				        <button class="btn btn-success" name="agregar" data-toggle="tooltip">Agregar</button>
				        </form>
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				    </div>
				</div>
			</div>
		</div>
	</div>

<?php include_once('layouts/footer.php'); ?>