<!DOCTYPE html>
<html>
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta+Vaani">
    <link rel="stylesheet" type="text/css" href="css/icon.css">
    <title>
    	<?php
    		if(!isset($page_title))
    		{
    			echo "Página común";	
    		}
    		else
    		{
    			echo $page_title;	
    		}
     	?>
    </title>
    <style type="text/css">


    	.espacio
    	{
    		margin-top: 5px;
    	}
    	.pub_ind
    	{
        margin-top: 15px;
    		border: 1px solid rgba(200,200,200,.5);
    		border-radius: 5px;
    	}
        .sombra{       
         box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.2), 0 4px 18px 0 rgba(0, 0, 0, 0.19);
         } 
      @media(min-width: 772px){
        .todo{    
        border: 1px solid rgba(200,200,200,.5);
        border-radius: 5px;   
         box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.2), 0 4px 18px 0 rgba(0, 0, 0, 0.19);
         } 
        }
      
    </style>
  </head>
  <body class=" bg-light" >

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Algodones</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php if($op=='1'){echo 'active';} ?>">
        <a class="nav-link" href="#">General</a>
      </li>
      <li class="nav-item <?php if($op=='2' || $op=='2.1' || $op=='2.2' || $op=='2.3'){echo 'active';} ?> dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Ordenes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown ">
          <a class="dropdown-item <?php if($op=='2.1'){echo 'active';} ?>" href="agendar.php">Agendar pedido</a>
          <a class="dropdown-item <?php if($op=='2.2'){echo 'active';} ?>" href="confirmar.php">Por confirmar</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item <?php if($op=='2.3'){echo 'active';} ?>" href="todo.php">Todas las ordenes</a>
        </div>
      </li>
      <li class="nav-item <?php if($op=='3' || $op=='3.1' || $op=='3.2' || $op=='3.3'){echo 'active';} ?> dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          A trabajar
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown ">
          <a class="dropdown-item <?php if($op=='3.1'){echo 'active';} ?>" href="ordsem.php">Ordenes de la semana</a>
          <a class="dropdown-item <?php if($op=='3.2'){echo 'active';} ?>" href="#">Material necesario</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item <?php if($op=='3.3'){echo 'active';} ?>" href="#">Para el algodonero</a>
        </div>
      </li>
      <li class="nav-item <?php if($op=='4'){echo 'active';} ?>">
        <a class="nav-link " href="#">Pendiente</a>
      </li>
      <li class="nav-item <?php if($op=='5' || $op=='5.1' || $op=='5.2' || $op=='5.3'){echo 'active';} ?> dropdown">
        <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Seccion Admin
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown ">
          <a class="dropdown-item <?php if($op=='5.1'){echo 'active';} ?>" href="#">Usuarios</a>
          <a class="dropdown-item <?php if($op=='5.2'){echo 'active';} ?>" href="#">Clientes</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item <?php if($op=='5.3'){echo 'active';} ?>" href="servicios.php">Administrar servicios</a>
        </div>
      </li>
      <li class="nav-item">
        <?php if($session->isUserLoggedIn(true)){ ?>
        <a class="nav-link <?php if($op=='8'){echo 'active';} ?>" href="php/logout.php" tabindex="-1" aria-disabled="true">Salir</a>
        <?php }else{ ?>
        <a class="nav-link <?php if($op=='8'){echo 'active';} ?>" href="index.php" tabindex="-1" aria-disabled="true">Iniciar sesión</a>
      <?php } ?>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>
  </div>
</nav>