<?php
include_once('includes/load.php');
 if (!$session->isUserLoggedIn(true)) { 
    $session->msg('d', 'Primero debes iniciar sesion');
    redirect('index.php');} 
$op = '2.3';
$page_title = "Todas las ordenes";
include_once('layouts/header.php');

//SELECT (ELT(WEEKDAY(fecha) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA, DATE_FORMAT(fecha, "%d/%M/%Y") as CUANDO FROM pedidos


    ?>
  
	<div class="col-lg-container-fluid col-container mt-2 p-2">
	    <div class="col-12 col-md-8 offset-md-2">
	        <?php echo display_msg($msg); ?>
	    </div>
	    <div class="row buscar">
	    	<?php 
	    	$consulta = $db->query("SELECT *, (ELT(WEEKDAY(fecha) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA, DATE_FORMAT(fecha, '%d/%M/%Y') as CUANDO FROM pedidos  ORDER BY id DESC");

	    	foreach ($consulta as $k) {
	    		
	    	 ?>
		    <div class="pubind col-12 col-md-6 col-lg-4  mt-2 " id="indiv<?php echo $k['id']; ?>">
		    	<div class="p-2" style="background: #99A3A4; text-align: center; border-top-left-radius: 
		    	10px; border-top-right-radius: 10px; color: #fff;">
		    		<h3><?php echo $k['id'].".- ".$k['cliente']; ?></h3>
		    	</div>
		    	<div class="bg-light p-2" style="border: 1px solid #99A3A4; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
		    		<?php if ($k['estado']==0) {
		    			
		    		?>
		    		<div class="alert alert-warning" style="text-align: center">No confirmado </div>

		    	<?php }else if ($k['estado']==1){ ?>

		    		<div class="alert alert-success" style="text-align: center">Confirmado </div>
		    	<?php } else if ($k['estado']==2){ ?>

		    		<div class="alert alert-primary" style="text-align: center">Fabricando</div>
		    	<?php } else if ($k['estado']==3){ ?>

		    		<div class="alert alert-dark" style="text-align: center">En ruta</div>
		    	<?php }  else if ($k['estado']==4){ ?>

		    		<div class="alert alert-info" style="text-align: center">Entregado</div>
		    	<?php }  else if ($k['estado']==5){ ?>

		    		<div class="alert alert-danger" style="text-align: center">Cancelado</div>
		    	<?php } ?>
		    		<div class="col-12 mb-1" style="text-align: center">
		    			<div>
		    				<strong>HORA</strong>
		    			</div>
		    			<div><h1><?php echo $k['hora']; ?></h1></div>
		    		</div>
		    		<div class="col-12 mb-1">
		    			<strong>Fecha: </strong>
		    			<?php echo $k['DIA'].", ".$k['CUANDO']; ?>
		    		</div>
		    		<div class="col-12 mb-1">
		    			<strong>Tipo: </strong>
		    			<?php echo $k['tipo_entrega'].", ".$k['alg_tot']." piezas."; ?>
		    		</div>
		    		<div class="col-12 mb-1">
		    			<strong>Flor: </strong>
		    			<?php echo $k['flor']; ?>
		    		</div>
		    		<div class="col-12 mb-1">
		    			<strong>Colores: </strong>
		    			<?php 
		    			$idd = $k['id'];
		    			$colores = $db->query("select * from cantidades where id_pedido = '$idd' and flor = '0'");
		    			foreach ($colores as $s ) {
		    				if ($s['blanco'] > 0) {
		    					echo "blanco, ";
		    				}
		    				if ($s['naranja'] > 0) {
		    					echo "naranja, ";
		    				}
		    				if ($s['rosa'] > 0) {
		    					echo "rosa, ";
		    				}
		    				if ($s['morado'] > 0) {
		    					echo "morado, ";
		    				}
		    				if ($s['azul'] > 0) {
		    					echo "azul, ";
		    				}
		    				if ($s['verde'] > 0) {
		    					echo "verde, ";
		    				}
		    				if ($s['amarillo'] > 0) {
		    					echo "amarillo, ";
		    				}
		    				if ($s['negro'] > 0) {
		    					echo "negro, ";
		    				}
		    				if ($s['rojo'] > 0) {
		    					echo "rojo, ";
		    				}
		    				if ($s['cafe'] > 0) {
		    					echo "cafe, ";
		    				}
		    				if ($s['acua'] > 0) {
		    					echo "acua ";
		    				}
		    			} ?>
		    			.
		    		</div>
		    		<div class="col-12 mb-1">
		    			<strong>Tono: </strong>
		    			<?php echo $k['tono']; ?>
		    		</div>
		    		<div class="col-12 mb-1">
		    			<strong>Dirección: </strong>
		    			<?php echo $k['direccion']; ?>
		    		</div>
		    		<div class="col-12 mb-1">
		    			<strong>Alias: </strong>
		    			<?php echo $k['alias']; ?>
		    		</div>
		    		<div class="col-12 mb-1">
		    			<strong>Numero: </strong>
		    			<?php echo $k['numero']; ?> <a href="" class="glyphicon glyphicon-question-sign "></a>
		    		</div>
		    		<div class="col-12 mb-1">
		    			<strong>Observaciones: </strong>
		    			<?php echo $k['observaciones']; ?>
		    		</div>
		    		<div class="col-12 mb-1">
		    			<strong>¿Cuando se agendó?: </strong>
		    			<?php echo $k['fecha_agendado']; ?>
		    		</div>
		    		<div class="col-12 mb-1">
		    			<strong>Precio: </strong>
		    			$<?php echo $k['precio']; ?>
		    		</div>
		    		<div class="alert alert-light text-center">
		    			<p><em>Falta pagar:</em></p>
		    			<h1>
		    				$<?php

		    				$pagoh = $db->query("select SUM(`pago`) as `p` from `pagos` where `id_pedido` = ".$k['id']."");
		    				$m = mysqli_fetch_assoc($pagoh);
		    				echo ($k['faltante'] - $m['p']);
		    				?>
		    			</h1>
		    			<!-- Mostrar las deducciones de la tabla deducciones con foreach -->
		    			<!-- Disminuir font-size 1px cada vuelta del div class ded -->
		    			<!-- Disminuir la intensidad del color -->
		    
		    			<?php 
		    			if ($k['estado']!=5 && $k['estado']!=4){ 
		    			$pixeles = 15;


		    			$pagos = $db->query("select *, DATE_FORMAT(fecha, '%d/%M/%Y') as cuando from `pagos` where `id_pedido`='".$k['id']."' ORDER by `id` DESC");

		    			foreach ($pagos as $key){
		    				$pixeles--;
		    				?>
		    				<p class="ded" style="font-size: <?php echo $pixeles;?>px; "><em>-$<?php echo $key['pago']; ?> -- <?php echo $key['tipo']; ?> <br> <?php echo $key['cuando'] ?></em></p>
		    			<?php 
		    			 } 

		    			}?>

		    		</div>
			    	<div style="text-align: center;" class="mt-3">

					<?php  if ($k['estado']==0 || $k['estado']==1){ ?>

		                <button class="btn btn-lg btn-warning glyphicon glyphicon-pencil" data-toggle="modal" 
								data-target="#modaledit<?php echo $k['id']; ?>" data-toggle="tooltip"></button>
								
		                <!-- <button class="btn btn-lg btn-warning glyphicon glyphicon-cloud-upload" data-toggle="modal" 
								data-target="#modaledit<?php echo $k['id']; ?>" data-toggle="tooltip"></button>
								
		                <button class="btn btn-lg btn-warning glyphicon glyphicon glyphicon glyphicon-cloud-download" data-toggle="modal" 
								data-target="#modaledit<?php echo $k['id']; ?>" data-toggle="tooltip"></button>

								glyphicon glyphicon-cloud-upload -->

						    <div class="modal fade " id="modaledit<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
							  	<div class="modal-dialog modal-centered modal-m " role="document">
								    <div class="modal-content">
								      	<div class="modal-header" style="text-align: center;">
										  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Editar pedido: <?php echo $k['cliente']; ?></strong></h4>
								      	</div>
								      	<div class="modal-body text-left">
											<div class="">
											    <form action="php/registrarpedido.php" class="form-horizontal" id="formulario" method="post">
											        <div class="form-group"><label for="fecha" class="control-label">Fecha:*</label><input type="date" id="fecha" class="form-control" name="fecha" value="<?php echo $k['fecha']; ?>" required></div>
											        <div class="form-group"><label for="hora" class="control-label">Hora:*</label><input type="time" id="hora" class="form-control" name="hr" value="<?php echo $k['hora']; ?>" required></div>
											        <div class="form-group"><label for="tipo_ent" class="control-label">Tipo de entrega:</label>
											            <select name="t_ent" id="tipo_ent" class="form-control">

											                <?php
											                    $todo = $db->query("select * from servicios");

											                    foreach ($todo as $s ) {
											                ?>
											                <option value="<?php echo $s['servicio']; ?>"><?php echo $s['servicio']; ?></option>
											                <?php } ?>
											<!-- 
											                <option value="Arco grande">Arco grande</option>
											                <option value="Arco mini">Arco mini</option>
											                <option value="Torre grande">Torre grande</option>
											                <option value="Torre mini">Torre mini</option>
											                <option value="Pz grande">Pieza grande suelta</option>
											                <option value="Pz chica">Pieza chica suelta</option>
											                <option value="Vaso">Vaso</option>
											                <option value="En vivo">En vivo</option> -->
											            </select>
											        </div>
        											<div class="form-group"><label for="total_al" class="control-label">Algodones totales:*</label><input type="number" id="total_al" class="form-control" name="alg_tot" value="<?php echo $k['alg_tot']; ?>" maxlength="4" placeholder="" required></div>
											        <div class="form-group"><label for="flor" class="control-label">Flor:</label>
											            <select name="flor_c" id="flor" class="form-control">
											                <option value="NO" <?php if ($k['flor']=='NO') {echo "selected";} ?>>Sin flor</option>
											                <option value="blanco" <?php if ($k['flor']=='blanco') {echo "selected";} ?>>blanco</option>
											                <option value="naranja" <?php if ($k['flor']=='naranja') {echo "selected";} ?>>naranja</option>
											                <option value="rosa" <?php if ($k['flor']=='rosa') {echo "selected";} ?>>rosa</option>
											                <option value="morado" <?php if ($k['flor']=='morado') {echo "selected";} ?>>morado</option>
											                <option value="azul" <?php if ($k['flor']=='azul') {echo "selected";} ?>>azul</option>
											                <option value="verde" <?php if ($k['flor']=='verde') {echo "selected";} ?>>verde</option>
											                <option value="amarillo" <?php if ($k['flor']=='amarillo') {echo "selected";} ?>>amarillo</option>
											                <option value="negro" <?php if ($k['flor']=='negro') {echo "selected";} ?>>negro</option>
											                <option value="rojo" <?php if ($k['flor']=='rojo') {echo "selected";} ?>>rojo</option>
											                <option value="cafe" <?php if ($k['flor']=='cafe') {echo "selected";} ?>>cafe</option>
											                <option value="acua" <?php if ($k['flor']=='acua') {echo "selected";} ?>>acua</option>
											            </select>
											        </div>
											        <div class="form-group"><label for="tono" class="control-label">Tono:</label>
											            <select name="tono_c" id="tono" class="form-control">
											                <option value="Fuerte" <?php if ($k['tono']=='Fuerte') { ?> selected <?php } ?>>Fuerte</option>
											                <option value="Normal" <?php if ($k['tono']=='Normal') { ?> selected <?php } ?>>Normal</option>
											                <option value="Pastel" <?php if ($k['tono']=='Pastel') { ?> selected <?php } ?>>Pastel</option>
											            </select>
											        </div>
											        <div class="form-group"><label for="direccion" class="control-label">Direcci&oacute;n:*</label><input type="text" id="direccion" class="form-control" name="dir" value="<?php echo $k['direccion']; ?>" required maxlength="100"></div>
											        <div class="form-group"><label for="cliente" class="control-label">Cliente:*</label><input type="text" id="cliente" class="form-control" name="clie" value="<?php echo $k['cliente']; ?>" required maxlength="100" readonly></div>
											        <div class="form-group"><label for="numero" class="control-label">N&uacute;mero:*</label><input type="text" id="numero" class="form-control" name="num" value="<?php echo $k['numero']; ?>" maxlength="50" required placeholder="Puedes gregar hasta 4 numeros: 656432432,656534234"></div>
											        <div class="form-group"><label for="" class="control-label">Nombre en facebook:</label><input type="text" id="" class="form-control" maxlength="30" value="<?php echo $k['alias']; ?>" name="nom_fb"></div>
        											<div class="form-group"><label for="" class="control-label">Precio total:</label><input type="number" id="" class="form-control" name="precio" value="<?php echo $k['precio']; ?>"></div>
											        <div class="form-group"><label for="observaciones" class="control-label">Observaciones:</label><textarea name="obs" id="observaciones" cols="30" value="" rows="10" class="form-control" maxlength="300"><?php echo $k['observaciones']; ?></textarea></div>
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

			<a  class="btn btn-dark" role="button"  data-toggle="modal" 
								data-target="#modalanticipo<?php echo $k['id']; ?>" data-toggle="tooltip" style="color: #fff; cursor: pointer;">Anticipo</a>


		    <div class="modal fade " id="modalanticipo<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
			  	<div class="modal-dialog modal-centered modal-m " role="document">
				    <div class="modal-content">
				      	<div class="modal-header" style="text-align: center;">
						  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>El cliente dio un anticipo?</strong></h4>
				      	</div>
				      	<div class="modal-body text-center">
							<form action="php/camstate.php" method="get">
								<div class="col-12">
								<input type="hidden" name="id" value="<?php echo $k['id']; ?>">
								<input type="hidden" name="state" value="<?php echo $k['estado']; ?>">
								<input type="hidden" name="page" value="todo.php">
								<input type="hidden" name="btn" value="anticipo">

				      	<div class="modal-body text-center">
							<strong>Pedido: </strong>
							<?php echo $k['id'].".- ".$k['cliente']; ?>
					    </div>
								<div class="formgroup">
									<label class="control-label">Cuanto?</label>
									<input type="number" class="form-control" placeholder="0000" min="0" name="pago" required>
								</div>
								</div>
					    </div>
					    <div class="modal-footer">
						        <button class="btn btn-success" data-toggle="tooltip">correcto</button>
					        </form>
					        <button type="button" class="btn btn-danger" data-dismiss="modal">cancelar</button>
					    </div>
					</div>
				</div>
			</div>
		    		
		    	<?php } ?>

			    		<?php if ($k['estado']==0) {?>

		    				<a  class="btn btn-success" role="button"  data-toggle="modal" 
								data-target="#modalconf<?php echo $k['id']; ?>" data-toggle="tooltip" style="color: #fff; cursor: pointer;">Confirmar</a>


							    <div class="modal fade " id="modalconf<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
								  	<div class="modal-dialog modal-centered modal-m " role="document">
									    <div class="modal-content">
									      	<div class="modal-header" style="text-align: center;">
											  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>¿Confirmar pedido?</strong></h4>
									      	</div>
									      	<div class="modal-body text-center">
												<strong>Pedido: </strong>
												<?php echo $k['id'].".- ".$k['cliente']; ?>
												<form action="php/camstate.php" method="get">
												<div class="col-12">
												<input type="hidden" name="id" value="<?php echo $k['id']; ?>">
												<input type="hidden" name="state" value="<?php echo $k['estado']; ?>">
												<input type="hidden" name="page" value="todo.php">
												<input type="hidden" name="btn" value="confirmar">
												</div>
										    </div>
										    <div class="modal-footer">
										        <button class="btn btn-success" data-toggle="tooltip">Confirmar</button>
										        </form>
										        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
										    </div>
										</div>
									</div>
								</div>

		    				<a  class="btn btn-danger" role="button"  data-toggle="modal" 
								data-target="#modal<?php echo $k['id']; ?>" data-toggle="tooltip" style="color: #fff; cursor: pointer;">Cancelar</a>


							    <div class="modal fade " id="modal<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
								  	<div class="modal-dialog modal-centered modal-m " role="document">
									    <div class="modal-content">
									      	<div class="modal-header" style="text-align: center;">
											  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>¿Porque será cancelado?</strong></h4>
									      	</div>
									      	<div class="modal-body text-center">
												<strong>Pedido: </strong>
												<?php echo $k['id'].".- ".$k['cliente']; ?>
												<form action="php/camstate.php" method="get">
												<div class="col-12 mt-1">
													<select name="accion" class="form-control">
														<option value="c">Canceló con anticipación</option>
														<option value="b">Betar</option>
														<option value="n">No hay ninguna razón</option>
													</select>
												</div>
												<div class="col-12">
												<textarea required class="form-control mt-1" rows="3" style="resize: none;" name="razon" placeholder="Explica porque será cancelado este pedido"></textarea>
												<input type="hidden" name="id" value="<?php echo $k['id']; ?>">
												<input type="hidden" name="state" value="<?php echo $k['estado']; ?>">
												<input type="hidden" name="page" value="todo.php">
												<input type="hidden" name="btn" value="cancelar">
												<input type="hidden" name="cliente" value="<?php echo $k['cliente']; ?>">
												</div>
										    </div>
										    <div class="modal-footer">
										        <button class="btn btn-danger" data-toggle="tooltip">Proceder</button>
										        </form>
										        <button type="button" class="btn btn-secondary" data-dismiss="modal">No cancelar</button>
										    </div>
										</div>
									</div>
								</div>
		    	




		    			<?php }else if($k['estado']==1){ ?>

			<a  class="btn btn-primary" role="button"  data-toggle="modal" 
								data-target="#modalfab<?php echo $k['id']; ?>" data-toggle="tooltip" style="color: #fff; cursor: pointer;">Fabricar</a>


		    <div class="modal fade " id="modalfab<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
			  	<div class="modal-dialog modal-centered modal-m " role="document">
				    <div class="modal-content">
				      	<div class="modal-header" style="text-align: center;">
						  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>¿Comenzar a fabricar?</strong></h4>
				      	</div>
				      	<div class="modal-body text-center">
							<strong>Pedido: </strong>
							<?php echo $k['id'].".- ".$k['cliente']; ?>
					    </div>
					    <div class="modal-footer">
							<form action="php/camstate.php" method="get">
							<div class="col-12">
							<input type="hidden" name="id" value="<?php echo $k['id']; ?>">
							<input type="hidden" name="state" value="<?php echo $k['estado']; ?>">
							<input type="hidden" name="page" value="todo.php">
							<input type="hidden" name="btn" value="fabricar">
							</div>
					        <button class="btn btn-primary" data-toggle="tooltip">Si</button>
					        </form>
					        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
					    </div>
					</div>
				</div>
			</div>
		    		
		    				<a  class="btn btn-danger" role="button"  data-toggle="modal" 
								data-target="#modal<?php echo $k['id']; ?>" data-toggle="tooltip" style="color: #fff; cursor: pointer;">Cancelar</a>


		    <div class="modal fade " id="modal<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
			  	<div class="modal-dialog modal-centered modal-m " role="document">
				    <div class="modal-content">
				      	<div class="modal-header" style="text-align: center;">
						  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>¿Porque será cancelado?</strong></h4>
				      	</div>
				      	<div class="modal-body text-center">
							<strong>Pedido: </strong>
							<?php echo $k['id'].".- ".$k['cliente']; ?>
							<form action="php/camstate.php" method="get">
							<div class="col-12 mt-1">
								<select name="accion" class="form-control">
									<option value="c">Canceló con anticipación</option>
									<option value="b">Betar</option>
									<option value="n">No hay ninguna razón</option>
								</select>
							</div>
							<div class="col-12">
							<textarea required class="form-control mt-1" rows="3" style="resize: none;" name="razon" placeholder="Explica porque será cancelado este pedido"></textarea>
							<input type="hidden" name="id" value="<?php echo $k['id']; ?>">
							<input type="hidden" name="state" value="<?php echo $k['estado']; ?>">
							<input type="hidden" name="page" value="todo.php">
							<input type="hidden" name="btn" value="cancelar">
							<input type="hidden" name="cliente" value="<?php echo $k['cliente']; ?>">
							</div>
					    </div>
					    <div class="modal-footer">
					        <button class="btn btn-danger" data-toggle="tooltip">Proceder</button>
					        </form>
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">No cancelar</button>
					    </div>
					</div>
				</div>
			</div>

		<?php } else if ($k['estado']==2){ ?>

		    			<a  class="btn btn-secondary" role="button"  data-toggle="modal" 
								data-target="#modalcam<?php echo $k['id']; ?>" data-toggle="tooltip" style="color: #fff; cursor: pointer;">En camino</a>


		    <div class="modal fade " id="modalcam<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
			  	<div class="modal-dialog modal-centered modal-m " role="document">
				    <div class="modal-content">
				      	<div class="modal-header" style="text-align: center;">
						  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>¿El pedido esta en camino?</strong></h4>
				      	</div>
				      	<div class="modal-body text-center">
							<strong>Pedido: </strong>
							<?php echo $k['id'].".- ".$k['cliente']; ?>
					    </div>
					    <div class="modal-footer">
							<form action="php/camstate.php" method="get">
							<div class="col-12">
							<input type="hidden" name="id" value="<?php echo $k['id']; ?>">
							<input type="hidden" name="state" value="<?php echo $k['estado']; ?>">
							<input type="hidden" name="page" value="todo.php">
							<input type="hidden" name="btn" value="encamino">
							</div>
					        <button class="btn btn-secondary" data-toggle="tooltip">Si</button>
					        </form>
					        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
					    </div>
					</div>
				</div>
			</div>

		    				<a  class="btn btn-danger" role="button"  data-toggle="modal" 
								data-target="#modal<?php echo $k['id']; ?>" data-toggle="tooltip" style="color: #fff; cursor: pointer;">Cancelar</a>


		    <div class="modal fade " id="modal<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
			  	<div class="modal-dialog modal-centered modal-m " role="document">
				    <div class="modal-content">
				      	<div class="modal-header" style="text-align: center;">
						  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>¿Porque será cancelado?</strong></h4>
				      	</div>
				      	<div class="modal-body text-center">
							<strong>Pedido: </strong>
							<?php echo $k['id'].".- ".$k['cliente']; ?>
							<form action="php/camstate.php" method="get">
							<div class="col-12 mt-1">
								<select name="accion" class="form-control">
									<option value="c">Canceló con anticipación</option>
									<option value="b">Betar</option>
									<option value="n">No hay ninguna razón</option>
								</select>
							</div>
							<div class="col-12">
							<textarea required class="form-control mt-1" rows="3" style="resize: none;" name="razon" placeholder="Explica porque será cancelado este pedido"></textarea>
							<input type="hidden" name="id" value="<?php echo $k['id']; ?>">
							<input type="hidden" name="state" value="<?php echo $k['estado']; ?>">
							<input type="hidden" name="page" value="todo.php">
							<input type="hidden" name="btn" value="cancelar">
							<input type="hidden" name="cliente" value="<?php echo $k['cliente']; ?>">
							</div>
					    </div>
					    <div class="modal-footer">
					        <button class="btn btn-danger" data-toggle="tooltip">Proceder</button>
					        </form>
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">No cancelar</button>
					    </div>
					</div>
				</div>
			</div>
		    	<?php } else if ($k['estado']==3){ ?>

		    			<a  class="btn btn-lg btn-dark glyphicon glyphicon-usd"  role="button"  data-toggle="modal" 
								data-target="#modalliquidar<?php echo $k['id']; ?>" data-toggle="tooltip" style="color: #fff; cursor: pointer;"></a>


		    <div class="modal fade " id="modalliquidar<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
			  	<div class="modal-dialog modal-centered modal-m " role="document">
				    <div class="modal-content">
				      	<div class="modal-header" style="text-align: center;">
						  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Restante</strong></h4>
				      	</div>
				      	<div class="modal-body text-center">
				      		<div class="alert alert-danger">En esta seccion y la de anticipo, deberan especificar que tipo de transaccion se registro</div>
				      		<h1>$<?php

		    				$suma = $db->query("select sum(`pago`) as `tot` from `pagos` where `id_pedido` = '".$k['id']."'");
		    				$res = mysqli_fetch_assoc($suma);
		    				$final = ($k['precio']-$res['tot']);
		    				echo $final;
		    				?></h1>
					    </div>
					    <div class="modal-footer">
							<form action="php/camstate.php" method="get">
							<div class="col-12">
							<input type="hidden" name="id" value="<?php echo $k['id']; ?>">
							<input type="hidden" name="state" value="<?php echo $k['estado']; ?>">
							<input type="hidden" name="page" value="todo.php">
							<input type="hidden" name="btn" value="liquidar">
									<input type="hidden" class="form-control" value="<?php echo $final; ?>"  name="pago"><!-- VALOR DE LO QUE FALTA POR PAGAR -->
							</div>
					        <button class="btn btn-dark" data-toggle="tooltip">Liquidar</button>
					        </form>
					        <button type="button" class="btn btn-danger" data-dismiss="modal">cancelar</button>
					    </div>
					</div>
				</div>
			</div>

			<a  class="btn btn-info" role="button"  data-toggle="modal" data-target="#modalterm<?php echo $k['id']; ?>" data-toggle="tooltip" style="color: #fff; cursor: pointer;">Entregado</a>


		    <div class="modal fade " id="modalterm<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
			  	<div class="modal-dialog modal-centered modal-m " role="document">
				    <div class="modal-content">
				      	<div class="modal-header" style="text-align: center;">
						  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Antes de terminar</strong></h4>
				      	</div>
				      	<div class="modal-body text-left">
							<form action="php/camstate.php" method="POST" class="was-validated" enctype="multipart/form-data">
								<div class="custom-file">
								    <input type="file" class="custom-file-input" multiple="multiple" name="foto" id="validatedCustomFile" required>
								    <label class="custom-file-label" for="validatedCustomFile">Subir foto</label>
								    <div class="invalid-feedback">Recuerda tomar una foto del pedido</div>
								    <div class="valid-feedback">Foto del archivo seleccionado</div>
								</div>
							  	<div class="col-12 custom-control custom-checkbox mb-3 mt-3">
								    <input type="checkbox" class="custom-control-input" id="alg" name="cb" value="Algodones acomodados" required>
								    <label class="custom-control-label" for="alg">Los algodones estan acomodados</label>
							    	<div class="invalid-feedback">Verifica que los algodones estan ordenados</div>
							    	<div class="valid-feedback">Los algodones estan ordenados</div>
							  	</div>
							    <div class="col-12 mb-3 row">
							    	<div class="col-12">
							    		<label for="validationServer03">Cuando se recoge la base?</label>
							    	</div>
							      <div class="col-6">
							      	<input type="date" class="form-control" id="validationServer03" name="fechac"  required>
							      <div class="invalid-feedback">
							        Preguntar por el dia
							      </div>
							      </div>
							      <div class="col-6">
							      	<input type="time" class="form-control" id="validationServer04" name="hrac"  required>
							      <div class="invalid-feedback">
							        Preguntar por la hora
							      </div>
							      </div>
							    </div>
							    <div class="col-12 mb-3 ">
							    	<div class="col-12">
							    		<label for="validationServer03">Observaciones:</label>
							    	</div>
								    <div class="col-12">
								    	<textarea name="obs" id="observaciones" style="width: 100%" rows="5" class="form-control" maxlength="300"></textarea>
								    </div>
							    </div>
					    </div>
					    <div class="modal-footer">
							<div class="col-12">
							<input type="hidden" name="id" value="<?php echo $k['id']; ?>">
							<input type="hidden" name="state" value="<?php echo $k['estado']; ?>">
							<input type="hidden" name="page" value="todo.php">
							<input type="hidden" name="btn" value="terminar">
							</div>
					        <button class="btn btn-info" data-toggle="tooltip" id="confirped">confirmar</button>
					        </form>
					        <button type="button" class="btn btn-danger" data-dismiss="modal">cancelar</button>
					    </div>
					</div>
				</div>
			</div>

		    				<a  class="btn btn-danger" role="button"  data-toggle="modal" 
								data-target="#modal<?php echo $k['id']; ?>" data-toggle="tooltip" style="color: #fff; cursor: pointer;">Cancelar</a>


		    <div class="modal fade " id="modal<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
			  	<div class="modal-dialog modal-centered modal-m " role="document">
				    <div class="modal-content">
				      	<div class="modal-header" style="text-align: center;">
						  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>¿Porque será cancelado?</strong></h4>
				      	</div>
				      	<div class="modal-body text-center">
							<strong>Pedido: </strong>
							<?php echo $k['id'].".- ".$k['cliente']; ?>
							<form action="php/camstate.php" method="get">
							<div class="col-12 mt-1">
								<select name="accion" class="form-control">
									<option value="c">Canceló con anticipación</option>
									<option value="b">Betar</option>
									<option value="n">No hay ninguna razón</option>
								</select>
							</div>
							<div class="col-12">
							<textarea required class="form-control mt-1" rows="3" style="resize: none;" name="razon" placeholder="Explica porque será cancelado este pedido"></textarea>
							<input type="hidden" name="id" value="<?php echo $k['id']; ?>">
							<input type="hidden" name="state" value="<?php echo $k['estado']; ?>">
							<input type="hidden" name="page" value="todo.php">
							<input type="hidden" name="btn" value="cancelar">
							<input type="hidden" name="cliente" value="<?php echo $k['cliente']; ?>">

							</div>
					    </div>
					    <div class="modal-footer">
					        <button class="btn btn-danger" data-toggle="tooltip">Proceder</button>
					        </form>
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">No cancelar</button>
					    </div>
					</div>
				</div>
			</div>
		    	<?php } else if ($k['estado']==4){ ?>

		    		<ul class="nav nav-tabs" id="myTab<?php echo $k['id']; ?>" role="tablist">
					  <li class="nav-item">
					    <a class="nav-link active" style="color: #000;" id="home-tab<?php echo $k['id']; ?>" data-toggle="tab" href="#home<?php echo $k['id']; ?>" role="tab" aria-controls="home" aria-selected="true">Foto</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link" style="color: #000;" id="profile-tab<?php echo $k['id']; ?>" data-toggle="tab" href="#profile<?php echo $k['id']; ?>" role="tab" aria-controls="profile" aria-selected="false">Pagos</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link" style="color: #000;" id="contact-tab<?php echo $k['id']; ?>" data-toggle="tab" href="#contact<?php echo $k['id']; ?>" role="tab" aria-controls="contact" aria-selected="false">Extras</a>
					  </li>
					</ul>
					<div class="tab-content" id="myTabContent<?php echo $k['id']; ?>">
					  <div class="tab-pane fade show active" id="home<?php echo $k['id']; ?>" role="tabpanel" aria-labelledby="home-tab<?php echo $k['id']; ?>">
					  	<div class="m-2">
					  		<img style="max-width: 90%" src="images/pedidos/<?php echo $k['foto']; ?>">
					  	</div>
					  	
					  </div>
					  <div class="tab-pane fade" id="profile<?php echo $k['id']; ?>" role="tabpanel" aria-labelledby="profile-tab<?php echo $k['id']; ?>">
					  	<table class="table">
						  <thead>
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Cantidad</th>
						      <th scope="col">Tipo</th>
						      <th scope="col">Fecha</th>
						    </tr>
						  </thead>
						  <tbody>
					  	<?php 
		    			$pagos = $db->query("select * from `pagos` where `id_pedido`='".$k['id']."' ORDER by `id` DESC");
		    					$contador = 1;
		    			foreach ($pagos as $key){
		    				$pixeles--;
		    				?>
						    <tr>
						      <th scope="row"><?php echo $contador; ?></th>
						      <td>$<?php echo $key['pago']; ?></td>
						      <td><?php echo $key['tipo']; ?></td>
						      <td><?php echo $key['fecha']; ?></td>
						    </tr>
		    			<?php $contador++;
		    			 } ?>
						  </tbody>
						</table>

						<?php

							if (($k['faltante'] - $m['p'])>0) {
						

						?>


		    			<a  class="btn btn-lg btn-dark glyphicon glyphicon-usd"  role="button"  data-toggle="modal" 
								data-target="#modalliquidar<?php echo $k['id']; ?>" data-toggle="tooltip" style="color: #fff; cursor: pointer;"></a>


		    <div class="modal fade " id="modalliquidar<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
			  	<div class="modal-dialog modal-centered modal-m " role="document">
				    <div class="modal-content">
				      	<div class="modal-header" style="text-align: center;">
						  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Restante</strong></h4>
				      	</div>
				      	<div class="modal-body text-center">
				      		<div class="alert alert-danger">En esta seccion y la de anticipo, deberan especificar que tipo de transaccion se registro</div>
				      		<h1>$<?php

		    				$suma = $db->query("select sum(`pago`) as `tot` from `pagos` where `id_pedido` = '".$k['id']."'");
		    				$res = mysqli_fetch_assoc($suma);
		    				$final = ($k['precio']-$res['tot']);
		    				echo $final;
		    				?></h1>
					    </div>
					    <div class="modal-footer">
							<form action="php/camstate.php" method="get">
							<div class="col-12">
							<input type="hidden" name="id" value="<?php echo $k['id']; ?>">
							<input type="hidden" name="state" value="<?php echo $k['estado']; ?>">
							<input type="hidden" name="page" value="todo.php">
							<input type="hidden" name="btn" value="liquidar">
									<input type="hidden" class="form-control" value="<?php echo $final; ?>"  name="pago"><!-- VALOR DE LO QUE FALTA POR PAGAR -->
							</div>
					        <button class="btn btn-dark" data-toggle="tooltip">Liquidar</button>
					        </form>
					        <button type="button" class="btn btn-danger" data-dismiss="modal">cancelar</button>
					    </div>
					</div>
				</div>
			</div>

		<?php } ?>
					  </div>
					  <div class="tab-pane fade" id="contact<?php echo $k['id']; ?>" role="tabpanel" aria-labelledby="contact-tab<?php echo $k['id']; ?>">	
					  	<?php

					  		$extras = $db->query("select DATEDIFF(fecha, now()) as cuando, comentario, hora, fecha, estado from terminados where id_ped = '".$k['id']."' and estado limit 1");
					  		foreach ($extras as $ext) { ?>
					  			
					  			<div class="col-12 mt-3"><strong>Comentarios:</strong><br><?php echo $ext['comentario']; ?></div>
					  		<?php	
					  		}

					  		$cuando = array( 0 => "Hoy",1 => "Mañana",2 => "Pasado mañana",3 => "En 3 dias",4 => "En 4 dias",5 => "En 5 dias",6 => "En 6 dias",7 => "En una semana" );

					  		$extras = $db->query("select DATEDIFF(fecha, now()) as cuando, comentario, hora, fecha, estado from terminados where id_ped = '".$k['id']."' and estado = 0 limit 1");
					  		foreach ($extras as $ext) { ?>
					  			
					  			<div class="col-12 mt-3"><strong>Comentarios:</strong><br><?php echo $ext['comentario']; ?></div>


					  			<div class="col-12 mt-3"><strong>¿Cuando se recoge la base?</strong><br>
					  				<div class="alert alert-<?php if($ext['cuando']>1){echo "success";}else if($ext['cuando']==1){echo "warning";}else if($ext['cuando']<=0){echo "danger";} ?>">
					  					<?php if ($ext['cuando']>7 || $ext['cuando']<0) {?>
					  						<h1>Se paso el dia.. <br>
					  					<?php 	echo $ext['fecha']; ?> 
					  						</h1>
					  					<?php
					  					} else {?>
					  						<h1>
					  					<?php 	echo $cuando[$ext['cuando']]; ?> 
					  						</h1>
					  					<?php
					  						 
					  					}
					  					 ?> <br>A las(24hrs):<br><?php echo $ext['hora']; ?> 
					  				</div>
					  			</div>

					  			<?php
					  			if ($ext['estado'] == 0) {?>

				    			<a  class="btn btn-lg btn-success"  role="button"  data-toggle="modal" 
										data-target="#modalrecoger<?php echo $k['id']; ?>" data-toggle="tooltip" style="color: #fff; cursor: pointer;">Finalizar entrega</a>


							    <div class="modal fade " id="modalrecoger<?php echo $k['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
								  	<div class="modal-dialog modal-centered modal-m " role="document">
									    <div class="modal-content">
									      	<div class="modal-header" style="text-align: center;">
											  	<h4 class="modal-title" id="mySmallModalLabel" ><strong>Recogiendo estructura</strong></h4>
									      	</div>
									      	<div class="modal-body text-center">
									      		<div class="alert alert-info">Asegura que la estructura este completa</div>
										    </div>
										    <div class="modal-footer">
												<form action="php/camstate.php" method="get">
												<div class="col-12">
												<input type="hidden" name="id" value="<?php echo $k['id']; ?>">
												<input type="hidden" name="page" value="todo.php">
												<input type="hidden" name="btn" value="recoger">
												</div>
										        <button class="btn btn-success" data-toggle="tooltip">Finalizar</button>
										        </form>
										        <button type="button" class="btn btn-danger" data-dismiss="modal">cancelar</button>
										    </div>
										</div>
									</div>
								</div>


					  				
					  		<?php	


					  			}
					  		}

					  		if (mysqli_num_rows($extras)==0) {
					  			echo "<div class='alert alert-success'><em>Finalizado</em></div>";
					  		}

					  	?>

					  </div>
					</div>

		    		
		    	<?php } else if ($k['estado']==5){ 
		    		$iC = $db->query("select * from cancelados where id_pedido = '".$k['id']."'");
		    		$catlet = array('c' => "Cancelo con anticipacion", 'b' => "Betar", 'n' => "No hay razon" );

		    		foreach ($iC as $iCRe) {?>

		    			<div class="alert alert-danger">
		    				<strong>Tipo de cancelacion:</strong><br>
		    				<?php echo $catlet[$iCRe['categoria']]; ?><br><br>
		    				<strong>Comentario:</strong><br>
		    				<?php echo $iCRe['comentario']; ?><br><br>
		    				<strong>Fecha:</strong><br>
		    				<?php echo $iCRe['fecha']; ?><br><br>
		    			</div>

		    	<?php } 

		    }?>
		    		

		    			
			    	</div>
		    	</div>
		    </div>
		<?php } ?>
	    </div>
	</div>
	<script>
        $(document).ready(function(evento){
            var agregar = 0;
            var validacion;
            var sumatotal = 0;
            var cant_checks = 0;
            var val_bl, val_na = 0, val_ros = 0, val_m = 0, val_az = 0, val_v = 0, val_am = 0, val_ne = 0, val_roj = 0, val_c, val_ac = 0;
     //----------------------------------------Validacion Individual-naranja--------------------------------       
            $("#blanco").change(function(evento){
                validacion = $("#total_al").val();
                if(validacion == ""){
                    alert("Necesitas poner la cantidad de algodones para el pedido");
                    $("#blanco").prop("checked",false);
                    $("#total_al").focus();
                    
                }
                else{
                var check = $(this).is(":checked");
                if(check==true){
                  $("#input_bl").prop("readonly", false);
                    cant_checks++;
                }
                else if(check==false){
                  $("#input_bl").prop("readonly", true);
                    $("#input_bl").val("0");
                    cant_checks--;
                    $("#input_bl").change();
                }
                }
            });      
            $("#input_na").change(function(evento){
                val_na= parseInt($("#input_na").val());
            
            });
     
      //----------------------------------------------------------------------------------------------------
     //----------------------------------------Validacion Individual-naranja--------------------------------       
            $("#naranja").change(function(evento){
                validacion = $("#total_al").val();
                if(validacion == ""){
                    alert("Necesitas poner la cantidad de algodones para el pedido");
                    $("#naranja").prop("checked",false);
                    $("#total_al").focus();
                    
                }
                else{
                var check = $(this).is(":checked");
                if(check==true){
                  $("#input_na").prop("readonly", false);
                    cant_checks++;
                }
                else if(check==false){
                  $("#input_na").prop("readonly", true);
                    $("#input_na").val("0");
                    cant_checks--;
                    $("#input_na").change();
                }
                }
            });      
            $("#input_na").change(function(evento){
                val_na= parseInt($("#input_na").val());
            
            });
     
      //----------------------------------------------------------------------------------------------------
     //----------------------------------------Validacion Individual-rosa-----------------------------------       
            $("#rosa").change(function(evento){
                validacion = $("#total_al").val();
                if(validacion == ""){
                    alert("Necesitas poner la cantidad de algodones para el pedido");
                    $("#rosa").prop("checked",false);
                    $("#total_al").focus();
                    
                }
                else{
                var check = $(this).is(":checked");
                if(check==true){
                  $("#input_ros").prop("readonly", false);
                    cant_checks++;
                }
                else if(check==false){
                  $("#input_ros").prop("readonly", true);
                    $("#input_ros").val("0");
                    cant_checks--;
                    $("#input_ros").change();
                }
                }
            }); 
     
      //---------------------------------------------------------------------------------------------------- 
     //----------------------------------------Validacion Individual-morado---------------------------------       
            $("#morado").change(function(evento){
                validacion = $("#total_al").val();
                if(validacion == ""){
                    alert("Necesitas poner la cantidad de algodones para el pedido");
                    $("#morado").prop("checked",false);
                    $("#total_al").focus();
                    
                }
                else{
                var check = $(this).is(":checked");
                if(check==true){
                  $("#input_m").prop("readonly", false);
                    cant_checks++;
                }
                else if(check==false){
                  $("#input_m").prop("readonly", true);
                    $("#input_m").val("0");
                    cant_checks--;
                    $("#input_m").change();
                }
                }
            });  
     
      //---------------------------------------------------------------------------------------------------- 
     //----------------------------------------Validacion Individual-azul-----------------------------------       
            $("#azul").change(function(evento){
                validacion = $("#total_al").val();
                if(validacion == ""){
                    alert("Necesitas poner la cantidad de algodones para el pedido");
                    $("#azul").prop("checked",false);
                    $("#total_al").focus();
                    
                }
                else{
                var check = $(this).is(":checked");
                if(check==true){
                  $("#input_az").prop("readonly", false);
                    cant_checks++;
                }
                else if(check==false){
                  $("#input_az").prop("readonly", true);
                    $("#input_az").val("0");
                    cant_checks--;
                    $("#input_az").change();
                }
                }
            }); 
     
      //---------------------------------------------------------------------------------------------------- 
     //----------------------------------------Validacion Individual-verde----------------------------------       
            $("#verde").change(function(evento){
                validacion = $("#total_al").val();
                if(validacion == ""){
                    alert("Necesitas poner la cantidad de algodones para el pedido");
                    $("#verde").prop("checked",false);
                    $("#total_al").focus();
                    
                }
                else{
                var check = $(this).is(":checked");
                if(check==true){
                  $("#input_v").prop("readonly", false);
                    cant_checks++;
                }
                else if(check==false){
                  $("#input_v").prop("readonly", true);
                    $("#input_v").val("0");
                    cant_checks--;
                    $("#input_v").change();
                }
                }
            });  
     
      //---------------------------------------------------------------------------------------------------- 
     //----------------------------------------Validacion Individual-amarillo-------------------------------       
            $("#amarillo").change(function(evento){
                validacion = $("#total_al").val();
                if(validacion == ""){
                    alert("Necesitas poner la cantidad de algodones para el pedido");
                    $("#amarillo").prop("checked",false);
                    $("#total_al").focus();
                    
                }
                else{
                var check = $(this).is(":checked");
                if(check==true){
                  $("#input_am").prop("readonly", false);
                    cant_checks++;
                }
                else if(check==false){
                  $("#input_am").prop("readonly", true);
                    $("#input_am").val("0");
                    cant_checks--;
                    $("#input_am").change();
                }
                }
            }); 
     
      //---------------------------------------------------------------------------------------------------- 
     //----------------------------------------Validacion Individual-negro----------------------------------       
            $("#negro").change(function(evento){
                validacion = $("#total_al").val();
                if(validacion == ""){
                    alert("Necesitas poner la cantidad de algodones para el pedido");
                    $("#negro").prop("checked",false);
                    $("#total_al").focus();
                    
                }
                else{
                var check = $(this).is(":checked");
                if(check==true){
                  $("#input_ne").prop("readonly", false);
                    cant_checks++;
                }
                else if(check==false){
                  $("#input_ne").prop("readonly", true);
                    $("#input_ne").val("0");
                    cant_checks--;
                    $("#input_ne").change();
                }
                }
            });
     
      //---------------------------------------------------------------------------------------------------- 
     //----------------------------------------Validacion Individual-rojo-----------------------------------       
            $("#rojo").change(function(evento){
                validacion = $("#total_al").val();
                if(validacion == ""){
                    alert("Necesitas poner la cantidad de algodones para el pedido");
                    $("#rojo").prop("checked",false);
                    $("#total_al").focus();
                    
                }
                else{
                var check = $(this).is(":checked");
                if(check==true){
                  $("#input_roj").prop("readonly", false);
                    cant_checks++;
                }
                else if(check==false){
                  $("#input_roj").prop("readonly", true);
                    $("#input_roj").val("0");
                    cant_checks--;
                    $("#input_roj").change();
                }
                }
            }); 
     
      //---------------------------------------------------------------------------------------------------- 
     //----------------------------------------Validacion Individual-cafe-----------------------------------       
            $("#cafe").change(function(evento){
                validacion = $("#total_al").val();
                if(validacion == ""){
                    alert("Necesitas poner la cantidad de algodones para el pedido");
                    $("#cafe").prop("checked",false);
                    $("#total_al").focus();
                    
                }
                else{
                var check = $(this).is(":checked");
                if(check==true){
                  $("#input_c").prop("readonly", false);
                    cant_checks++;
                }
                else if(check==false){
                  $("#input_c").prop("readonly", true);
                    $("#input_c").val("0");
                    cant_checks--;
                    $("#input_c").change();
                }
                }
            });  
     
      //---------------------------------------------------------------------------------------------------- 
     //----------------------------------------Validacion Individual-acua-----------------------------------       
            $("#acua").change(function(evento){
                validacion = $("#total_al").val();
                if(validacion == ""){
                    alert("Necesitas poner la cantidad de algodones para el pedido");
                    $("#acua").prop("checked",false);
                    $("#total_al").focus();
                    
                }
                else{
                var check = $(this).is(":checked");
                if(check==true){
                  $("#input_ac").prop("readonly", false);
                    cant_checks++;
                }
                else if(check==false){
                  $("#input_ac").prop("readonly", true);
                    $("#input_ac").val("0");
                    cant_checks--;
                    $("#input_ac").change();
                }
                }
            });
     
      //---------------------------------------------------------------------------------------------------- 
      //-----------------------------------DIV->falta por agregar (html)----------------------------------- 
            $(".cant_form").change(function(evento){
                var inp_t = parseInt($("#total_al").val());
                var sum = 0;
                $(".cant_form").each(function(index, value){
                    sum = sum + eval($(this).val());
                });
                var agregar = inp_t-sum;
                parseInt(agregar);
                $("#texto_faltantes").html("falta por agregar <strong>"+agregar+"</strong> algodon(es)");
                
                    $("#hid").val(agregar);
            });
      //---------------------------------------------------------------------------------------------------- 
      //----------------------------------------Boton partes iguales----------------------------------------  
            $("#btn_pi").click(function(evento){
                validacion = $("#total_al").val();
                if(validacion == ""){
                    alert("Necesitas poner la cantidad de algodones para el pedido");
                    $("#total_al").focus();
                }
                else{
                var v_bl = $("#blanco").is(":checked");
                var v_na = $("#naranja").is(":checked");
                var v_ros = $("#rosa").is(":checked");
                var v_m = $("#morado").is(":checked");
                var v_az = $("#azul").is(":checked");
                var v_v = $("#verde").is(":checked");
                var v_am = $("#amarillo").is(":checked");
                var v_ne = $("#negro").is(":checked");
                var v_roj = $("#rojo").is(":checked");
                var v_c = $("#cafe").is(":checked");
                var v_ac = $("#acua").is(":checked");
                
                var division = parseInt($("#total_al").val())/(cant_checks);
                //division = Math.trunc(division);
                var d_int = parseInt(division);
                
                if(v_bl == true){
                   $("#input_bl").val(d_int);
                   }
                if(v_na == true){
                   $("#input_na").val(d_int);
                   }
                if(v_ros == true){
                   $("#input_ros").val(d_int);
                   }
                if(v_m == true){
                   $("#input_m").val(d_int);
                   }
                if(v_az == true){
                   $("#input_az").val(d_int);
                   }
                if(v_v == true){
                   $("#input_v").val(d_int);
                   }
                if(v_am == true){
                   $("#input_am").val(d_int);
                   }
                if(v_ne == true){
                   $("#input_ne").val(d_int);
                   }
                if(v_roj == true){
                   $("#input_roj").val(d_int);
                   }
                if(v_c == true){
                   $("#input_c").val(d_int);
                   }
                if(v_ac == true){
                   $("#input_ac").val(d_int);
                   }
                
                var inp_t = parseInt($("#total_al").val());
                var sum = 0;
                $(".cant_form").each(function(index, value){
                    sum = sum + eval($(this).val());
                });
                agregar = inp_t-sum;
                parseInt(agregar);
                $("#texto_faltantes").html("falta por agregar <strong>"+agregar+"</strong> algodon(es)");
                    $("#hid").val(agregar);
                }
            });
            //-----------------------Validar antes de enviar contenido de formulario-----------------------
        });
    </script>
    <?php include_once('layouts/footer.php'); ?>