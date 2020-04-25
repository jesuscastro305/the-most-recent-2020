<?php
include_once('includes/load.php');
 if (!$session->isUserLoggedIn(true)) { 
    $session->msg('d', 'Primero debes iniciar sesion');
    redirect('index.php');} 
$op = '5.3';
$page_title = "Administrar servicios";

if (isset($_GET['agregarserv'])) {

	$verificar = $db->query("SELECT * FROM servicios where servicio = '".$_GET['servicio']."'");
	$existe = mysqli_num_rows($verificar);
	if ($existe == 0) {
		$sc = (isset($_GET['sc'])) ? 1 : 0 ;
		$consulta = $db->query("INSERT into servicios (servicio, cantidad, sc) VALUES ('".$_GET['servicio']."','".$_GET['cantidad']."', '".$sc."')");

		if (!$consulta) {
			$session->msg('d',"ERROR: No fue posible agregar el nuevo servicio.");
			redirect("servicios.php",false);
		} else {
			$session->msg('s',"Se agrego correctamente: ".$_GET['servicio'].".");
			redirect("servicios.php",false);
		}

	} else {
		$session->msg('d',"ERROR: Datos duplicados. El servicio que intentas agregar ya se encuentra en la base de datos.");
		redirect("servicios.php",false);
	}
	
} else if (isset($_GET['eliminarserv'])) {

	$verificar = $db->query("SELECT * FROM servicios where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		
		$consulta = $db->query("DELETE FROM servicios WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"No se pudo eliminar el servicio.");
			redirect("servicios.php",false);
		} else {
			$session->msg('s',"Se elimino correctamente.");
			redirect("servicios.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La informacion que intenta eliminar no existe en la base de datos.");
		redirect("servicios.php",false);
	}

} else if (isset($_GET['agregar'])) {

	$verificar = $db->query("SELECT * FROM `productos` where producto = '".$_GET['producto']."'");
	$existe = mysqli_num_rows($verificar);

	if ($existe == 0) {
		$session->msg('d',"ERROR: el producto no exite o no selecciono ninguna.");
		redirect("servicios.php",false);
	}

	$verificar = $db->query("SELECT * FROM `prod_serv` where producto = '".$_GET['producto']."' and servicio = '".$_GET['servicio']."'");
	$existe = mysqli_num_rows($verificar);
	if ($existe == 0) {


		if ($_GET['prioridad']==1) {
			$verif = $db->query("SELECT prioridad FROM `prod_serv` where servicio = '".$_GET['servicio']."' and prioridad = 1");
			$sihay = mysqli_num_rows($verif);

			if ($sihay > 0) {
				$db->query("UPDATE `prod_serv` SET prioridad = 0 where prioridad = 1 and servicio = '".$_GET['servicio']."'");
			}
		}


		$consulta = $db->query("INSERT `prod_serv` (`servicio`, `producto`, `cantidad`, `prioridad`) VALUES ('".$_GET['servicio']."','".$_GET['producto']."','".$_GET['cantidad']."','".$_GET['prioridad']."')");

		if (!$consulta) {
			$session->msg('d',"ERROR: No fue posible agregar el producto.");
			redirect("servicios.php",false);
		} else {
			$session->msg('s',"Se agrego correctamente: ".$_GET['producto'].".");
			redirect("servicios.php",false);
		}

	} else {
		$session->msg('d',"ERROR: Datos duplicados. Verifica que los datos ingresados no se encuentren en la tabla.");
		redirect("servicios.php",false);
	}

} else if (isset($_GET['editar'])) {

	$verificar = $db->query("SELECT * FROM prod_serv where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		
		if ($_GET['prioridad']==1) {
			$verif = $db->query("SELECT prioridad FROM `prod_serv` where servicio = '".$_GET['servicio']."' and prioridad = 1");
			$sihay = mysqli_num_rows($verif);

			if ($sihay > 0) {
				$db->query("UPDATE `prod_serv` SET prioridad = 0 where prioridad = 1 and servicio = '".$_GET['servicio']."'");
			}
		}

		$consulta = $db->query("UPDATE prod_serv SET cantidad = '".$_GET['cant']."', prioridad = '".$_GET['prioridad']."' WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"ERROR: No se pudo editar el Producto.");
			redirect("servicios.php",false);
		} else {
			$session->msg('s',"Se edito correctamente.");
			redirect("servicios.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La fila no existe en la base de datos.");
		redirect("servicios.php",false);
	}
	
} else if (isset($_GET['eliminar'])) {

	$verificar = $db->query("SELECT * FROM prod_serv where id = '".$_GET['id']."' ");
	$existe = mysqli_num_rows($verificar);
	if ($existe > 0) {
		
		$consulta = $db->query("DELETE FROM prod_serv WHERE id = '".$_GET['id']."'");

		if (!$consulta) {
			$session->msg('d',"No se pudo eliminar el Producto.");
			redirect("servicios.php",false);
		} else {
			$session->msg('s',"Se elimino correctamente.");
			redirect("servicios.php",false);
		}

	} else {
		$session->msg('d',"ERROR: La informacion que intenta eliminar no existe en la base de datos.");
		redirect("servicios.php",false);
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

			  	<?php
			  		$todo = $db->query("select `id`,`servicio` as `p`, `cantidad` as `c` from servicios");
			  		$id_s = 1;
			  		foreach ($todo as $kp ) {
			  	?>
			  	<div class="pubind">
	    <div class="bg-dark" style="font-size: 40px; color: #fff"><?php echo $kp['p']; ?> (<?php echo $kp['c']; ?>)
	    	

		                <button class="btn btn-xs btn-danger glyphicon glyphicon-trash float-right mr-2 mt-2" data-toggle="modal" 
								data-target="#modaldell<?php echo $kp['id']; ?>" data-toggle="tooltip"></button>

						    <div class="modal fade " style="color:#000" id="modaldell<?php echo $kp['id']; ?>" tabindex="-1" role="dialog"  aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
							  	<div class="modal-dialog modal-centered modal-m " role="document">
								    <div class="modal-content">
								      	<div class="modal-header" style="text-align: center;">
										  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Eliminar servicio</strong></h4>
								      	</div>
								      	<div class="modal-body text-center" style="font-size: 20px">
											Seguro que deseas eliminar<strong> <?php echo $kp['p']; ?>?</strong>
									    </div>
									    <div class="modal-footer">
											<form action="" method="get">
									        <button class="btn btn-danger" name="eliminarserv" data-toggle="tooltip">Si</button>
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
			      <th scope="col">Producto necesario</th>
			      <th scope="col">Cantidad</th>
			      <th scope="col">Tipo</th>
			      <th scope="col"><button class="btn btn-xs btn-success glyphicon glyphicon-plus" data-toggle="modal" data-target="#modaladd<?php echo $kp['id']; ?>" data-toggle="tooltip"></button></th>
			    </tr>
			  </thead>
			  <tbody>

			  	<?php
			  		$todo = $db->query("select * from prod_serv where servicio = '".$kp['p']."' order by `prioridad` desc");
			  		$id_s = 1;
			  		foreach ($todo as $k ) {
			  	?>

			    <tr>
			      <th scope="row"><?php echo $id_s; ?></th>
			      <td><?php echo $k['producto']; ?></td>
			      <td><?php echo $k['cantidad']; ?></td>
			      <td><?php if($k['prioridad'] == 1){ echo "Primario"; }else{echo "Secundario"; }  ?></td>
			      <td>
		                <button class="btn btn-xs btn-warning glyphicon glyphicon-pencil" data-toggle="modal" 
								data-target="#modaledit<?php echo $k['id']; ?>" data-toggle="tooltip"></button>

						    <div class="modal fade " id="modaledit<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
							  	<div class="modal-dialog modal-centered modal-m " role="document">
								    <div class="modal-content">
								      	<div class="modal-header" style="text-align: center;">
										  	<h4 class="modal-title" id="mySmallModalLabel" ><strong><?php echo $k['producto']; ?></strong> para <strong><?php echo $kp['p']; ?></strong></h4>
								      	</div>
								      	<div class="modal-body text-center">
											<strong>Informacion sobre el producto del servicio:</strong>
											<div class="alert alert-info">En esta seccion puedes modificar la cantidad necesaria de <strong><?php echo $k['producto']; ?></strong> para <strong><?php echo $kp['p']; ?></strong></div>
											<form action="" method="get">
											<div class="col-12 mt-1">
												<label class="control-label">Prioridad:</label>
												<select name="prioridad" class="form-control">
													<option value="1"<?php if ($k['prioridad']==1) {echo " selected";} ?>>Primario</option>
													<option value="0"<?php if ($k['prioridad']==0) {echo " selected";} ?>>Secundario</option>
												</select>
											</div>
											<div class="col-12 mt-1">
												<label class="control-label">Cantidad:</label>
											<input type="number" class="form-control" value="<?php echo $k['cantidad']; ?>" name="cant" placeholder="cantidad necesaria" min="0">
											</div>
										    </div>
									    <div class="modal-footer">
									        <button class="btn btn-warning" name="editar" data-toggle="tooltip">Editar</button>
									        <input type="hidden" name="id" value="<?php echo $k['id']; ?>">
											<input type="hidden" name="servicio" value="<?php echo $kp['p']; ?>">
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
										  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Eliminar producto</strong></h4>
								      	</div>
								      	<div class="modal-body text-center">
											Seguro que deseas eliminar <strong><?php echo $k['producto']; ?>?</strong>
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
					  	<h4 class="modal-title" id="mySmallModalLabel" >Ligar producto para <strong><?php echo $kp['p']; ?></strong></h4>
			      	</div>
			      	<div class="modal-body text-center">
						<strong>Informacion sobre el servicio</strong>
						<div class="alert alert-info"><strong>Producto.-</strong> Se refiere a el producto necesaria para fabricar <strong><?php echo $kp['p']; ?></strong><br>
							<strong>Cantidad.-</strong> Se refiere a la cantidad necesaria de dicha materia prima para fabricar <strong><?php echo $kp['p']; ?></strong></div>
						<form action="" method="get">
						<div class="col-12 mt-1">
							<label class="control-label">Producto:</label>
							<select name="producto" class="form-control">
								<option value="0">SELECCIONA UN PRODUCTO</option>
			                <?php
			                    $todou = $db->query("select producto from productos ");
			                    foreach ($todou as $ks ) {
			                ?>
							<option value="<?php echo $ks['producto']; ?>" ><?php echo $ks['producto']; ?></option>
			                <?php } ?>
							</select>
						</div>
						<div class="col-12 mt-1">
							<label class="control-label">Prioridad:</label>
							<select name="prioridad" class="form-control">
								<option value="1">Primario</option>
								<option value="0">Secundario</option>
							</select>
						</div>
						<div class="col-12 mt-1">
							<label class="control-label">Cantidad necesaria:</label>
						<input type="number" class="form-control" name="cantidad" placeholder="Cantidad necesaria" min="0" required>
						<input type="hidden" name="servicio" value="<?php echo $kp['p']; ?>">
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
					  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Agregar servicio nuevo</strong></h4>
			      	</div>
			      	<div class="modal-body">
						<strong>Informacion sobre el servicio</strong>
						<div class="alert alert-info "><div class="alert alert-warning text-center">El servicio es el resultado de un conjunto de productos. Por ejemplo: </div><br> <strong>Arco grande con flor</strong> es el resultado de: <br>
							<ul>
								<li>Algodon Grande</li>
								<li>Algodon Chico</li>
								<li>...</li>
							</ul>
						<br>
						<strong>Cantidad disponible</strong> se refiere a la cantidad de estructuras o servicios que tienes fisicamente disponibles.
						</div>
						<form action="" method="get" class="was-validated">
						<div class="text-center">
							<div class="col-12 mt-1">
								<label class="control-label">Servicio:</label>
							<input type="text" class="form-control" name="servicio" placeholder="Arco grande">
							</div>
							<div class="col-12 mt-1">
								<label class="control-label">Cantidad disponible:</label>
							<input type="number" class="form-control" name="cantidad" min="0" placeholder="10" required="">
							</div>
							<div class="col-12 mt-1 custom-control custom-checkbox mt-5 mb-5" >
								<input  type="checkbox" class="custom-control-input" name="sc" id="scs" value="1">
								<label class="custom-control-label" for="scs">Usaras mas de un producto?</label>

								 <!--    <input type="checkbox" class="custom-control-input" id="alg" name="cb" value="Algodones acomodados" required>
								    <label class="custom-control-label" for="alg">Los algodones estan acomodados</label> -->
							</div>
						</div>
				    </div>
				    <div class="modal-footer">
				        <button class="btn btn-success" name="agregarserv" data-toggle="tooltip">Agregar</button>
				        </form>
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				    </div>
				</div>
			</div>
		</div>
	</div>
<?php include_once('layouts/footer.php'); ?>