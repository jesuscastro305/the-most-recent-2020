<?php
include_once('includes/load.php');
 if (!$session->isUserLoggedIn(true)) { 
    $session->msg('d', 'Primero debes iniciar sesion');
    redirect('index.php');} 
$op = '5.4';
$page_title = "Administrar Productos";

if (isset($_GET['agregarprod'])) {

	$verificar = $db->query("SELECT * FROM productos where producto = '".$_GET['mat']."'");
	$existe = mysqli_num_rows($verificar);
	if ($existe == 0) {

		$consulta = $db->query("INSERT into productos (producto) VALUES ('".$_GET['producto']."')");

		if (!$consulta) {
			$session->msg('d',"ERROR: No fue posible agregar el nuevo producto.");
			redirect("productos.php",false);
		} else {
			$session->msg('s',"Se agrego correctamente: ".$_GET['mat'].".");
			redirect("productos.php",false);
		}

	} else {
		$session->msg('d',"ERROR: Datos duplicados. El producto que intentas agregar ya se encuentra en la base de datos.");
		redirect("productos.php",false);
	}
	
} else if (isset($_GET['eliminarprod'])) {

	$verificar = $db->query("SELECT * FROM productos where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		
		$consulta = $db->query("DELETE FROM productos WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"No se pudo eliminar el producto.");
			redirect("productos.php",false);
		} else {
			$session->msg('s',"Se elimino correctamente.");
			redirect("productos.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La informacion que intenta eliminar no existe en la base de datos.");
		redirect("productos.php",false);
	}

} else if (isset($_GET['agregar'])) {

	$verificar = $db->query("SELECT * FROM `mprima` where material = '".$_GET['mp']."'");
	$existe = mysqli_num_rows($verificar);

	if ($existe == 0) {
		$session->msg('d',"ERROR: La materia prima no exite o no selecciono ninguna.");
		redirect("productos.php",false);
	}

	$verificar = $db->query("SELECT * FROM `mat_prod` where mp = '".$_GET['mp']."' and producto = '".$_GET['producto']."'");
	$existe = mysqli_num_rows($verificar);
	if ($existe == 0) {

		$consulta = $db->query("INSERT into `mat_prod` (`producto`, `mp`, `cantidad`) VALUES ('".$_GET['producto']."','".$_GET['mp']."','".$_GET['cant']."')");

		if (!$consulta) {
			$session->msg('d',"ERROR: No fue posible agregar la materia prima.");
			redirect("productos.php",false);
		} else {
			$session->msg('s',"Se agrego correctamente: ".$_GET['mp'].".");
			redirect("productos.php",false);
		}

	} else {
		$session->msg('d',"ERROR: Datos duplicados. Verifica que los datos ingresados no se encuentren en la tabla.");
		redirect("productos.php",false);
	}

} else if (isset($_GET['editar'])) {

	$verificar = $db->query("SELECT * FROM mat_prod where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		
		$consulta = $db->query("UPDATE mat_prod SET cantidad = '".$_GET['cant']."' WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"ERROR: No se pudo editar el material.");
			redirect("productos.php",false);
		} else {
			$session->msg('s',"Se edito correctamente.");
			redirect("productos.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La fila no existe en la base de datos.");
		redirect("productos.php",false);
	}
	
} else if (isset($_GET['eliminar'])) {

	$verificar = $db->query("SELECT * FROM mat_prod where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		
		$consulta = $db->query("DELETE FROM mat_prod WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"No se pudo eliminar el material.");
			redirect("productos.php",false);
		} else {
			$session->msg('s',"Se elimino correctamente.");
			redirect("productos.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La informacion que intenta eliminar no existe en la base de datos.");
		redirect("productos.php",false);
	}
	
}

include_once('layouts/header.php');

//SELECT (ELT(WEEKDAY(fecha) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA, DATE_FORMAT(fecha, "%d/%M/%Y") as CUANDO FROM pedidos

?>
	<div class="container buscar">
		<div class="text-center col-12 mt-2">
	    <div class="col-8 offset-2 mb-3">
	        <?php echo display_msg($msg); ?>
	    </div>
	    <div class="col-8 offset-2 mb-3">
	    	<div class="alert alert-warning">Agregar la abreviacion de la unidad de medida a la colunma <strong>Material necesario</strong> para calcular la cantidad necesaria. <br> Esto porque si el material necesario fue registrado en Kg, se descontara <strong>X</strong> cantidad de <strong>Kg</strong> por producto cuando deberian ser gramos. <br><br> <strong>Esto no afecta el funcionamiento del sistema en lo absoluto. Solo es un punto para afinar:) <br> Prosiga sin cuidado..</strong> </div>
	    </div>


			  	<?php
			  		$todo = $db->query("select `id`,`producto` as `p` from productos");
			  		$id_s = 1;
			  		foreach ($todo as $kp ) {
			  	?>
			  	<div class="pubind">
	    <div class="bg-dark" style="font-size: 40px; color: #fff"><?php echo $kp['p']; ?>
	    	

		                <button class="btn btn-xs btn-danger glyphicon glyphicon-trash float-right mr-2 mt-2" data-toggle="modal" 
								data-target="#modaldell<?php echo $kp['id']; ?>" data-toggle="tooltip"></button>

						    <div class="modal fade " style="color:#000" id="modaldell<?php echo $kp['id']; ?>" tabindex="-1" role="dialog"  aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
							  	<div class="modal-dialog modal-centered modal-m " role="document">
								    <div class="modal-content">
								      	<div class="modal-header" style="text-align: center;">
										  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Eliminar producto</strong></h4>
								      	</div>
								      	<div class="modal-body text-center" style="font-size: 20px">
											Seguro que deseas eliminar<strong> <?php echo $kp['p']; ?>?</strong>
									    </div>
									    <div class="modal-footer">
											<form action="" method="get">
									        <button class="btn btn-danger" name="eliminarprod" data-toggle="tooltip">Si</button>
									        <input type="hidden" name="id" value="<?php echo $kp['id']; ?>">
									        </form>
									        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
									    </div>
									</div>
								</div>
							</div>
	    </div>
			<table class="table table-striped">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Material necesario</th>
			      <th scope="col">Cantidad</th>
			      <th scope="col"><button class="btn btn-xs btn-success glyphicon glyphicon-plus" data-toggle="modal" data-target="#modaladd<?php echo $kp['id']; ?>" data-toggle="tooltip"></button></th>
			    </tr>
			  </thead>
			  <tbody>

			  	<?php
			  		$todo = $db->query("select * from mat_prod where producto = '".$kp['p']."'");
			  		$id_s = 1;
			  		foreach ($todo as $k ) {
			  	?>

			    <tr>
			      <th scope="row"><?php echo $id_s; ?></th>
			      <td><?php echo $k['mp']; ?></td>
			      <td><?php echo $k['cantidad']; ?></td>
			      <td>
		                <button class="btn btn-xs btn-warning glyphicon glyphicon-pencil" data-toggle="modal" 
								data-target="#modaledit<?php echo $k['id']; ?>" data-toggle="tooltip"></button>

						    <div class="modal fade " id="modaledit<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
							  	<div class="modal-dialog modal-centered modal-m " role="document">
								    <div class="modal-content">
								      	<div class="modal-header" style="text-align: center;">
										  	<h4 class="modal-title" id="mySmallModalLabel" ><strong><?php echo $k['mp']; ?></strong> para <strong><?php echo $kp['p']; ?></strong></h4>
								      	</div>
								      	<div class="modal-body text-center">
											<strong>Informacion sobre la materia prima del producto:</strong>
											<div class="alert alert-info">En esta seccion puedes modificar la cantidad necesaria de <strong><?php echo $k['mp']; ?></strong> para fabricar <strong><?php echo $kp['p']; ?></strong></div>
											<form action="" method="get">
											<div class="col-12 mt-1">
												<label class="control-label">Cantidad:</label>
											<input type="number" class="form-control" value="<?php echo $k['cantidad']; ?>" name="cant" placeholder="cantidad necesaria" max="10" min="0">
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
										  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Eliminar material</strong></h4>
								      	</div>
								      	<div class="modal-body text-center">
											Seguro que deseas eliminar<strong> <?php echo $k['mp']; ?>?</strong>
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

	    <div class="modal fade " id="modaladd<?php echo $kp['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
		  	<div class="modal-dialog modal-centered modal-m " role="document">
			    <div class="modal-content">
			      	<div class="modal-header" style="text-align: center;">
					  	<h4 class="modal-title" id="mySmallModalLabel" >Agregar materia prima para <strong><?php echo $kp['p']; ?></strong></h4>
			      	</div>
			      	<div class="modal-body text-center">
						<strong>Informacion sobre el producto/servicio</strong>
						<div class="alert alert-info"><strong>Material.-</strong> Se refiere a la materia prima necesaria para fabricar <strong><?php echo $kp['p']; ?></strong><br>
							<strong>Cantidad.-</strong> Se refiere a la cantidad necesaria de dicha materia prima para fabricar <strong><?php echo $kp['p']; ?></strong></div>
						<form action="" method="get">
						<div class="col-12 mt-1">
							<label class="control-label">Material:</label>
							<select name="mp" class="form-control">
								<option value="0">SELECCIONA UN MATERIAL</option>
			                <?php
			                    $todou = $db->query("select material from mprima ");
			                    foreach ($todou as $ks ) {
			                ?>
							<option value="<?php echo $ks['material']; ?>" ><?php echo $ks['material']; ?></option>
			                <?php } ?>
							</select>
						</div>
						<div class="col-12 mt-1">
							<label class="control-label">Cantidad:</label>
						<input type="number" class="form-control" name="cant" placeholder="Cantidad necesaria" max="10" required>
						<input type="hidden" name="producto" value="<?php echo $kp['p']; ?>">
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
			    <?php  } ?>
		</div>
	</div>


<button class="botonF1 bg-success" role="button" data-toggle="modal" data-target="#modalplusp" data-toggle="tooltip" >
	<!-- <button class="" data-toggle="modal" data-target="#modaladd" data-toggle="tooltip"></button> --><strong>+</strong>
</button>

	    <div class="modal fade " id="modalplusp" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
		  	<div class="modal-dialog modal-centered modal-m " role="document">
			    <div class="modal-content">
			      	<div class="modal-header" style="text-align: center;">
					  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Agregar producto nuevo</strong></h4>
			      	</div>
			      	<div class="modal-body">
						<strong>Informacion sobre el producto/servicio</strong>
						<div class="alert alert-info "><div class="alert alert-warning text-center">El producto es el resultado de un conjunto de materias primas. Por ejemplo: </div><br> <strong>Paleta</strong> es el resultado de: <br>
							<ul>
								<li>Azucar</li>
								<li>Palillo</li>
								<li>Bolcita</li>
								<li>...</li>
							</ul>
						</div>
						<form action="" method="get">
						<div class="text-center">
							<div class="col-12 mt-1">
								<label class="control-label">Producto:</label>
							<input type="text" class="form-control" name="producto" placeholder="Paleta">
							</div>
						</div>
				    </div>
				    <div class="modal-footer">
				        <button class="btn btn-success" name="agregarprod" data-toggle="tooltip">Agregar</button>
				        </form>
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				    </div>
				</div>
			</div>
		</div>
	</div>
<?php include_once('layouts/footer.php'); ?>