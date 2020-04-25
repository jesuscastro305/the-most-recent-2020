<?php include_once('includes/load.php'); 
if ($session->isUserLoggedIn(true)) { redirect('agendar.php', false);}
?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">

    <title>Inicio de Sesi&oacute;n</title>
  </head>
  <body>
    
    
<div class="container">
<div class="row">
        <div class="col-xs-12 col-md-6 offset-md-3 mt-5" >
           <div class="border p-3" style="border-radius: 10px;">
                <?php echo display_msg($msg); ?>
            <form action="php/auth.php" method="post" class="form-horizontal">
                <div class="form-group">
                    <label for="usuario" class="control-label">Usuario:</label>
                    <input type="text" id="usuario" name="username" class="form-control" placeholder="Administrador">
                </div>
                <div class="form-group">
                    <label for="contrasena" class="control-label">Contrase&ntilde;a:</label>
                    <input type="password" id="contrasena" name="password" class="form-control" placeholder="*************">
                </div>
                <div class="text-center">
                    <button class="btn btn-dark btn-block">Entrar</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>