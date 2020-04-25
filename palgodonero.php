<?php
include_once('includes/load.php');
 if (!$session->isUserLoggedIn(true)) { 
    $session->msg('d', 'Primero debes iniciar sesion');
    redirect('index.php');} 
$op = '3.3';
$page_title = "Todas las ordenes";
include_once('layouts/header.php');

//SELECT (ELT(WEEKDAY(fecha) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA, DATE_FORMAT(fecha, "%d/%M/%Y") as CUANDO FROM pedidos


    ?>
<div class="container">
	<div class="col-12">
		<div class="col-12 bg-dark">Tono</div>
		<table class="table table-striped">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Color</th>
		      <th scope="col">#</th>
		      <th scope="col">#</th>
		    </tr>
		  </thead>
		  <tbody>
		  </tbody>
		</table>
	</div>
</div>

<?php include_once('layouts/footer.php'); ?>