<!DOCTYPE html>
<html lang="es">
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="includes/jquery-3.3.1.js" ></script>
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta+Vaani"> -->
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

.botonF1{
  text-align: center;
  width:60px;
  height:60px;
  border-radius:100%;
  right:0;
  bottom:0;
  position:fixed;
  margin-right:16px;
  margin-bottom:16px;
  border:none;
  outline:none;
  color:#FFF;
  font-size:40px;
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
  cursor: pointer;
  transition: .09s;
}
.botonF1:hover{
  width:62px;
  height:62px;
  font-size: 42px;

}
div.pinf{
   border-bottom-right-radius: 10px;
   border-bottom-left-radius:  10px;
}
div.psup{
   border-top-right-radius: 10px;
   border-top-left-radius:  10px;
}
        #carga{
          width: 150px;
          height: 150px;
          margin: auto;

          -webkit-animation: girar 1s linear infinite;
          -o-animation: girar 2s linear infinite;
          animation: girar 2s linear infinite;
        }
        @keyframes girar {
          from {transform: rotate(0deg);}
          to {transform: rotate(360deg);}
        }
    </style>
    
  </head>
  <body class=" bg-light" >

    
  <div class="modal fade " id="contenedor_carg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered" role="document" >
        <div class="modal-content  modal-dialog-centered" style="background: none; box-shadow: none; border:none">
            <div class="row">
                <!-- <div id="carga" ><img src="data/logoT.png" style="width: 100%"></div> -->
                <div id="carga"><h3 style="color: #fff">Cargando...</h3></div>
            </div>
        </div>
    </div>
  </div>

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
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Ordenes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown1 ">
          <a class="dropdown-item <?php if($op=='2.1'){echo 'active';} ?>" href="agendar.php">Agendar pedido</a>
          <a class="dropdown-item <?php if($op=='2.2'){echo 'active';} ?>" href="confirmar.php">Por confirmar</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item <?php if($op=='2.3'){echo 'active';} ?>" href="todo.php">Todas las ordenes</a>
        </div>
      </li>
      <li class="nav-item <?php if($op=='3' || $op=='3.1' || $op=='3.2' || $op=='3.3'){echo 'active';} ?> dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          A trabajar
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown2 ">
          <a class="dropdown-item <?php if($op=='3.1'){echo 'active';} ?>" href="ordsem.php">Ordenes de la semana</a>
          <a class="dropdown-item <?php if($op=='3.2'){echo 'active';} ?>" href="#">Material necesario</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item <?php if($op=='3.3'){echo 'active';} ?>" href="palgodonero.php">Para el algodonero</a>
        </div>
      </li>
      <li class="nav-item <?php if($op=='4'){echo 'active';} ?>">
        <a class="nav-link " href="#">Pendiente</a>
      </li>
      <li class="nav-item <?php if($op>'5'){echo 'active';} ?> dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Seccion Admin
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item <?php if($op=='5.1'){echo 'active';} ?>" href="usuarios.php">Usuarios</a>
          <a class="dropdown-item <?php if($op=='5.2'){echo 'active';} ?>" href="#">Clientes</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item <?php if($op=='5.3'){echo 'active';} ?>" href="servicios.php">Estructuras/Servicios</a>
          <a class="dropdown-item <?php if($op=='5.4'){echo 'active';} ?>" href="productos.php">Productos</a>
          <a class="dropdown-item <?php if($op=='5.5'){echo 'active';} ?>" href="inventario.php">Inventario</a>
          <a class="dropdown-item <?php if($op=='5.6'){echo 'active';} ?>" href="mpri.php">Materia prima</a>
          <a class="dropdown-item <?php if($op=='5.7'){echo 'active';} ?>" href="um.php">Unidades de medida</a>
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
      <input class="form-control mr-sm-2" id="filtrar" type="search" placeholder="Buscar" aria-label="Buscar">
    </form>
  </div>
</nav>