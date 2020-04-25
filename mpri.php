<?php
include_once('includes/load.php');
 if (!$session->isUserLoggedIn(true)) { 
    $session->msg('d', 'Primero debes iniciar sesion');
    redirect('index.php');} 
$op = '5.6';
$page_title = "Materia prima";

if (isset($_GET['agregar'])) {

	$verificar = $db->query("SELECT * FROM `u_medida` where abreviacion = '".$_GET['um']."'");
	$existe = mysqli_num_rows($verificar);

	if ($existe == 0) {
		$session->msg('d',"ERROR: La unidad de medida no exite o no selecciono ninguna.");
		redirect("mpri.php",false);
	}

	$verificar = $db->query("SELECT * FROM mprima where material = '".$_GET['mat']."'");
	$existe = mysqli_num_rows($verificar);
	if ($existe == 0) {

		$consulta = $db->query("INSERT INTO mprima (material,unidad_m) VALUES ('".$_GET['mat']."','".$_GET['um']."')");

		if (!$consulta) {
			$session->msg('d',"ERROR: No fue posible agregar el nuevo material.");
			redirect("mpri.php",false);
		} else {
			$session->msg('s',"Se agrego correctamente: ".$_GET['mat'].".");
			redirect("mpri.php",false);
		}

	} else {
		$session->msg('d',"ERROR: Datos duplicados. Verifica que los datos ingresados no se encuentren en la tabla.");
		redirect("mpri.php",false);
	}
	
} else if (isset($_GET['editar'])) {

	$verificar = $db->query("SELECT * FROM mprima where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		
		$consulta = $db->query("UPDATE mprima SET material = '".$_GET['mat']."', unidad_m = '".$_GET['um']."' WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"ERROR: No se pudo editar el material.");
			redirect("mpri.php",false);
		} else {
			$session->msg('s',"Se edito correctamente.");
			redirect("mpri.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La fila no existe en la base de datos.");
		redirect("mpri.php",false);
	}
	
} else if (isset($_GET['eliminar'])) {

	$verificar = $db->query("SELECT * FROM mprima where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		$ta = $db->query("select `material` FROM mprima WHERE id = '".$_GET['id']."'");

		$mat = mysqli_fetch_assoc($ta);
		$consulta2 = $db->query("DELETE FROM mat_prod WHERE mp = '".$mat['material']."'");
		$consulta = $db->query("DELETE FROM mprima WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"No se pudo eliminar el material.");
			redirect("mpri.php",false);
		} else {
			$session->msg('s',"Se elimino correctamente.");
			redirect("mpri.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La informacion que intenta eliminar no existe en la base de datos.");
		redirect("mpri.php",false);
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
	    <div class="alert alert-info">La materia prima se refiere al material necesario para fabricar un producto. Agregar esta informacion a la base de datos permitira crear un inventario del material que se tiene de manera fisica. Esto facilitara la administracion del materia que se utiliza por mes aproximadamente. <br> La materia prima necesita tener una unidad de medida para que el sistema sepa de que manera debe identificar los materiales que se utilizan para elaborar un producto.</div>
			<table class="table table-striped">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Material</th>
			      <th scope="col">Unidad de medida</th>
			      <th scope="col"><button class="btn btn-xs btn-success glyphicon glyphicon-plus" data-toggle="modal" data-target="#modaladd" data-toggle="tooltip"></button></th>
			    </tr>
			  </thead>
			  <tbody>

			  	<?php
			  		$todo = $db->query("select * from `mprima`");
			  		$id_s = 1;
			  		foreach ($todo as $k ) {
			  	?>

			    <tr>
			      <th scope="row"><?php echo $id_s; ?></th>
			      <td><?php echo $k['material']; ?></td>
			      <td><?php echo $k['unidad_m']; ?></td>
			      <td>
		                <button class="btn btn-xs btn-warning glyphicon glyphicon-pencil" data-toggle="modal" 
								data-target="#modaledit<?php echo $k['id']; ?>" data-toggle="tooltip"></button>

						    <div class="modal fade " id="modaledit<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
							  	<div class="modal-dialog modal-centered modal-m " role="document">
								    <div class="modal-content">
								      	<div class="modal-header" style="text-align: center;">
										  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Editar material: <?php echo $k['material']; ?></strong></h4>
								      	</div>
								      	<div class="modal-body text-center">
											<strong>Informacion sobre la materia prima:</strong>
											<form action="" method="get">
											<div class="col-12 mt-1">
												<label class="control-label">Material:</label>
											<input type="text" class="form-control" value="<?php echo $k['material']; ?>" name="mat" placeholder="" required>
											</div>
											<div class="col-12 mt-1">
												<label class="control-label">Unidad de medida:</label>
											<select name="um" class="form-control">
							                <?php
							                    $todou = $db->query("select * from u_medida");
							                    foreach ($todou as $ks ) {
							                ?>
											<option value="<?php echo $ks['abreviacion']; ?>" <?php if ($ks['abreviacion']==$k['unidad_m']) {echo " selected";} ?>><?php echo $ks['medida']." (".$ks['abreviacion'].")"; ?></option>
							                <?php } ?>
											</select>
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
										  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Eliminar material: <?php echo $id_s; ?></strong></h4>
								      	</div>
								      	<div class="modal-body text-center">
											<strong>Seguro que deseas eliminar este material?</strong>
											<form action="" method="get">
											<div class="col-12 mt-1">
												<strong>Material: </strong><?php echo $k['material']; ?>
											</div>
											<div class="col-12 mt-1">
												<strong>Unidad de medida: </strong><?php echo $k['unidad_m']; ?>
											</div>
									    </div>
									    <div class="modal-footer">
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
					  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Agregar Material</strong></h4>
			      	</div>
			      	<div class="modal-body text-center">
						<strong>Informacion sobre el material</strong>
						<form action="" method="get">
						<div class="col-12 mt-1">
							<label class="control-label">Material:</label>
						<input type="text" class="form-control"  name="mat" placeholder="Bolsa 25x40" required>
						</div>
						<div class="col-12 mt-1">
							<label class="control-label">Unidad de medida:</label>
							<select name="um" class="form-control">
								<option>SELECCIONAR UNIDAD DE MEDIDA</option>
				                <?php
				                    $todou = $db->query("select * from u_medida");
				                    foreach ($todou as $ks ) {
				                ?>
								<option value="<?php echo $ks['abreviacion']; ?>" ><?php echo $ks['medida']." (".$ks['abreviacion'].")"; ?></option>
				                <?php } ?>
							</select>
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