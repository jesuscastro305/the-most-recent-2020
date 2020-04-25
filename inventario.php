<?php
include_once('includes/load.php');
 if (!$session->isUserLoggedIn(true)) { 
    $session->msg('d', 'Primero debes iniciar sesion');
    redirect('index.php');} 
$op = '5.5';
$page_title = "Inventario";

if (isset($_GET['agregar'])) {

	$verificar = $db->query("SELECT * FROM `mprima` where material = '".$_GET['mp']."'");
	$existe = mysqli_num_rows($verificar);

	if ($existe == 0) {
		$session->msg('d',"ERROR: El material no exite o no selecciono ninguno.");
		redirect("inventario.php",false);
	}

	$verificar = $db->query("SELECT * FROM inventario where material = '".$_GET['mp']."'");
	$existe = mysqli_num_rows($verificar);
	if ($existe == 0) {

		$consulta = $db->query("INSERT inventario (material,max,rp,min) VALUES ('".$_GET['mp']."','".$_GET['max']."','".$_GET['rp']."','".$_GET['min']."')");

		if (!$consulta) {
			$session->msg('d',"ERROR: No fue posible agregar el nuevo material al inventario.");
			redirect("inventario.php",false);
		} else {
			$session->msg('s',"Se agrego correctamente: ".$_GET['mp'].".");
			redirect("inventario.php",false);
		}

	} else {
		$session->msg('d',"ERROR: El material ".$_GET['mp']." ya se encuentra agregado al inventario.");
		redirect("inventario.php",false);
	}
	
} else if (isset($_GET['suma'])) {

	$verificar = $db->query("SELECT * FROM inventario where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		
		$consulta = $db->query("UPDATE inventario SET cantidad = cantidad + '".$_GET['cant']."' WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"ERROR: No se pudo aumentar la cantidad en stock.");
			redirect("inventario.php",false);
		} else {
			$session->msg('s',"Se aumento correctamente.");
			redirect("inventario.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La fila no existe en la base de datos.");
		redirect("inventario.php",false);
	}
	
}else if (isset($_GET['resta'])) {

	$verificar = $db->query("SELECT * FROM inventario where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		
		$consulta = $db->query("UPDATE inventario SET cantidad = cantidad - '".$_GET['cant']."' WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"ERROR: No se pudo disminuir la cantidad en stock.");
			redirect("inventario.php",false);
		} else {
			$session->msg('s',"Se dismuyo correctamente.");
			redirect("inventario.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La fila no existe en la base de datos.");
		redirect("inventario.php",false);
	}
	
} else if (isset($_GET['editar'])) {

	$verificar = $db->query("SELECT * FROM inventario where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		
		$consulta = $db->query("UPDATE inventario SET min = '".$_GET['min']."', rp = '".$_GET['rp']."', max = '".$_GET['max']."' WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"ERROR: No fue posible editar los valores.");
			redirect("inventario.php",false);
		} else {
			$session->msg('s',"Se editaron correctamente.");
			redirect("inventario.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La fila no existe en la base de datos.");
		redirect("inventario.php",false);
	}
	
} else if (isset($_GET['eliminar'])) {

	$verificar = $db->query("SELECT * FROM inventario where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		
		$consulta = $db->query("DELETE FROM inventario WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"No se pudo eliminar el material del inventario.");
			redirect("inventario.php",false);
		} else {
			$session->msg('s',"Se elimino correctamente.");
			redirect("inventario.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La informacion que intenta eliminar no existe en la base de datos.");
		redirect("inventario.php",false);
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
	    <div class="alert alert-info">La seccion de inventario te ayudara a tener un control del material que tienes en stock. Esto te permitira tener ver dicha informacion desde cualquier parte y te sera util cuando surtas material, claro, deberas tener la informacion actualizada. <br>
	    </div>
			<table class="table table-striped">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Material</th>
			      <th scope="col">Cantidad actual</th>
			      <th scope="col">Minimo</th>
			      <th scope="col">Punto de reorden</th>
			      <th scope="col">Maximo</th>
			      <th scope="col"><button class="btn btn-xs btn-success glyphicon glyphicon-plus" data-toggle="modal" 
								data-target="#modaladd" data-toggle="tooltip"></button></th>
			    </tr>
			  </thead>
			  <tbody>

			  	<?php
			  		$todo = $db->query("select inventario.id, inventario.material ,inventario.cantidad,inventario.max,inventario.rp, inventario.min, mprima.unidad_m as `u_material` from inventario inner join `mprima` on mprima.material = inventario.material");
			  		$id_s = 1;
			  		foreach ($todo as $k ) {
			  	?>

			    <tr>
			      <th scope="row"><?php echo $id_s; ?></th>
			      <td><div class="
			      	<?php 
			      		if($k['cantidad']>$k['max']){
			      			echo "bg-primary";
			      		}
			      		else if($k['cantidad'] <= $k['min']){
			      			echo "bg-danger";
			      		}
			      		else if($k['cantidad'] <= $k['rp']){
			      			echo "bg-warning";
			      		}
			      		else if($k['cantidad'] <= $k['max']){
			      			echo "bg-success";
			      		}
			      	?> float-left" style="width: 20px; height: 20px; border-radius: 100%;"></div><?php echo $k['material']; ?></td>
			      <td><?php echo $k['cantidad']." ".$k['u_material']; ?>
		                <button class="btn btn-xs btn-success glyphicon glyphicon-plus" data-toggle="modal" 
								data-target="#modalinvmas<?php echo $k['id']; ?>" data-toggle="tooltip"></button>

		                <button class="btn btn-xs btn-danger glyphicon glyphicon-minus" data-toggle="modal" 
								data-target="#modalinvmen<?php echo $k['id']; ?>" data-toggle="tooltip"></button>

						    <div class="modal fade " id="modalinvmas<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
							  	<div class="modal-dialog modal-centered modal-m " role="document">
								    <div class="modal-content">
								      	<div class="modal-header" style="text-align: center;">
										  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Aumentar cantidad de stock</strong></h4>
								      	</div>
								      	<div class="modal-body text-center">
											<strong>Cuanto desea agregar?</strong>

											<div style="font-size: 30px;">
												<STRONG>Cantidad actual:</STRONG>
												<?php echo $k['cantidad']." ".$k['u_material']; ?>
											</div>

											<div class="alert alert-info">Esta seccion te permite agregar en <strong><?php echo $k['u_material']; ?></strong> la cantidad de <strong><?php echo $k['material']; ?></strong> que compraste</div>
											<form action="" method="get">
											<div class="input-group mb-3">
											  <div class="input-group-prepend">
											    <span class="input-group-text glyphicon glyphicon-plus bg-success" id="basic-addon2"></span>
											  </div>
											  <input type="number" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="cant" min="0" maxlength="10" placeholder="50">
											  <div class="input-group-append">
											    <span class="input-group-text" id="basic-addon2"><?php echo $k['u_material']; ?></span>
											  </div>
											</div>
									    </div>
									    <div class="modal-footer">
									        <button class="btn btn-success" name="suma" data-toggle="tooltip">Sumar</button>
									        <input type="hidden" name="id" value="<?php echo $k['id']; ?>">
									        </form>
									        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									    </div>
									</div>
								</div>
							</div>

						    <div class="modal fade " id="modalinvmen<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
							  	<div class="modal-dialog modal-centered modal-m " role="document">
								    <div class="modal-content">
								      	<div class="modal-header" style="text-align: center;">
										  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Disminuir cantidad de stock</strong></h4>
								      	</div>
								      	<div class="modal-body text-center">
											<strong>Cuanto desea restar?</strong>

											<div style="font-size: 30px;">
												<STRONG>Cantidad actual:</STRONG>
												<?php echo $k['cantidad']." ".$k['u_material']; ?>
											</div>

											<div class="alert alert-info">Esta seccion te permite restar en <strong><?php echo $k['u_material']; ?></strong> la cantidad de <strong><?php echo $k['material']; ?></strong> que decidas</div>
											<form action="" method="get">
											<div class="input-group mb-3">
											  <div class="input-group-prepend">
											    <span class="input-group-text glyphicon glyphicon-minus bg-danger" id="basic-addon2"></span>
											  </div>
											  <input type="number" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" name="cant" min="0" maxlength="10" placeholder="50">
											  <div class="input-group-append">
											    <span class="input-group-text" id="basic-addon2"><?php echo $k['u_material']; ?></span>
											  </div>
											</div>
									    </div>
									    <div class="modal-footer">
									        <button class="btn btn-danger" name="resta" data-toggle="tooltip">Restar</button>
									        <input type="hidden" name="id" value="<?php echo $k['id']; ?>">
									        </form>
									        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									    </div>
									</div>
								</div>
							</div>
						</td>
			      <td><?php echo $k['min']." ".$k['u_material']; ?></td>
			      <td><?php echo $k['rp']." ".$k['u_material']; ?></td>
			      <td><?php echo $k['max']." ".$k['u_material']; ?></td>
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
											<strong>Informacion sobre el material:</strong>
											<form action="" method="get">
											<div class="col-12 mt-1">
												<label class="control-label">Cantidad minima:</label>
											<input type="number" class="form-control" id="mi<?php echo $id_s; ?>" onchange="$('#r<?php echo $id_s; ?>').attr('min',(parseInt($(this).val())+parseInt(1)));" min="0" value="<?php echo $k['min']; ?>" name="min" placeholder="Cantidad minima" required>
											</div>
											<div class="col-12 mt-1">
												<label class="control-label">Punto de reorden:</label>
											<input type="number" class="form-control" id="r<?php echo $id_s; ?>" onchange="$('#ma<?php echo $id_s; ?>').attr('min',(parseInt($(this).val())+parseInt(1)));" min="" value="<?php echo $k['rp']; ?>" name="rp" placeholder="Punto de reorden" required>
											</div>
											<div class="col-12 mt-1">
												<label class="control-label">Cantidad maxima:</label>
											<input type="number" class="form-control" id="ma<?php echo $id_s; ?>"  min="" value="<?php echo $k['max']; ?>" name="max" placeholder="Cantidad maxima" required>
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
											<strong>Seguro que deseas eliminar este material del inventario?</strong>
											<form action="" method="get">
											<div class="col-12 mt-1">
												<strong>Material: </strong><?php echo $k['material']; ?>
											</div>
											<div class="col-12 mt-1">
												<strong>Maximo: </strong><?php echo $k['max']; ?>
											</div>
											<div class="col-12 mt-1">
												<strong>Punto de reorden: </strong><?php echo $k['rp']; ?>
											</div>
											<div class="col-12 mt-1">
												<strong>Minimo: </strong><?php echo $k['min']; ?>
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
						<div class="alert-info"><strong>Cantidad Maxima.- </strong>Se refiere a la maxima cantidad que deseas tener de dicho material en el stock. <br>
						<strong>Punto de Reorden.- </strong>Definir el punto de reorden permitira al programa saber cuando debe avisarte que necesitas comprar mas material. <br>
						<strong>Cantidad Maxima.- </strong>Se refiere a la minima cantidad que deseas tener de dicho material en el stock. <br>
						<div class="alert alert-warning">La cantidad maxima debe ser mayor al punto de reorden y el punto de reorden debe ser mayor a la cantidad minima</div><br>
						<div class="alert alert-danger"><strong>NOTA.-</strong> Hacer un scritp que valide cual valor tiene que ser mayor que otro y que no permita que se ingrese otro valor sin antes haber completado el anterior. <br><br> Cambiar <strong>Cantidad minima</strong> a la parte de arriba y <strong>Cantidad maxima </strong>a la parte de abajo.</div></div>
						<form action="" method="get">
							<div class="col-12 mt-1">
								<label class="control-label">Material:</label>
							<select name="mp" class="form-control">
								<option>SELECCIONA UN MATERIAL</option>
			                <?php
			                    $todou = $db->query("select * from mprima");
			                    foreach ($todou as $ks ) {
			                ?>
							<option value="<?php echo $ks['material']; ?>" ><?php echo $ks['material']; ?></option>
			                <?php } ?>
							</select>
							</div>
							<div class="col-12 mt-1">
								<label class="control-label">Cantidad minima:</label>
							<input type="number" id="mi" class="form-control"  name="min" min="0"  placeholder="10" required>
							</div>
							<div class="col-12 mt-1">
								<label class="control-label">Punto de reorden:</label>
							<input type="number" id="r" class="form-control"  name="rp" min="" placeholder="25" required>
							</div>
							<div class="col-12 mt-1">
								<label class="control-label">Cantidad maxima:</label>
							<input type="number" id="ma" class="form-control"  name="max" min="" placeholder="50" required>
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
<script type="text/javascript">
	$(document).ready(function () {
		$("#mi").change(function(){
			$("#r").attr("min",(parseInt($("#mi").val())+parseInt(1)));
			$("#r").val(parseInt($("#mi").val())+parseInt(1));
		});
		$("#r").change(function(){
			$("#ma").attr("min",(parseInt($("#r").val())+parseInt(1)));
			$("#ma").val(parseInt($("#r").val())+parseInt(1));
		});
	});
</script>
<?php include_once('layouts/footer.php'); ?>