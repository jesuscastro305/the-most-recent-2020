<?php
include_once('includes/load.php');
 if (!$session->isUserLoggedIn(true)) { 
    $session->msg('d', 'Primero debes iniciar sesion');
    redirect('index.php');} 
$op = '5.1';
$page_title = "Usuarios";

include_once('layouts/header.php');

//SELECT (ELT(WEEKDAY(fecha) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA, DATE_FORMAT(fecha, "%d/%M/%Y") as CUANDO FROM pedidos
$all_users = find_all_user();
?>
<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>
<div class="container">
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Usuarios</span>
       </strong>
            <div >
              <a href="add_user.php" class="btn btn-warning  float-right btn-sm"> Agregar usuario</a>
            </div>
      </div>
     <div class="panel-body">
      <table class="table  table-striped">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th>Nombre </th>
            <th>Usuario</th>
            <th class="text-center" style="width: 15%;">Rol de usuario</th>
            <th class="text-center" style="width: 10%;">Estado</th>
            <th style="width: 20%;">Último login</th>
            <th class="text-center" style="width: 100px;">Acciones</th>
          </tr>
        </thead>
        <tbody class="buscar">
        <?php foreach($all_users as $a_user): 
			$c =$a_user['id'];
				?>
          <tr>
           <td class="text-center"><?php echo count_id();?></td>
           <td><?php echo remove_junk(ucwords($a_user['name']))?></td>
           <td><?php echo remove_junk(ucwords($a_user['username']))?></td>
           <td class="text-center"><?php echo remove_junk(ucwords($a_user['group_name']))?></td>
           <td class="text-center">
           <?php if($a_user['status'] === '1'): ?>
            <span class="label label-success btn" onclick="window.location='act-desact.php?estado=<?php echo $a_user['status'];echo "&id=".$a_user['id'] ?>'"><?php echo "Activo"; ?></span>
          <?php else: ?>
            <span class="label label-danger btn" onclick="window.location='act-desact.php?estado=<?php echo $a_user['status'];echo "&id=".$a_user['id'] ?>'"><?php echo "Inactivo"; ?></span>
          <?php endif;?>
           </td>
           <td><?php echo read_date($a_user['last_login'])?></td>
           <td class="text-center">
             <div class="btn-group">
                <a href="edit_user.php?id=<?php echo (int)$a_user['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                  <i class="glyphicon glyphicon-pencil"></i>
               </a>
                <a type="button" role="button"  data-toggle="modal" 
								data-target="#modal<?php echo $c ?>"  class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                  <i class="glyphicon glyphicon-trash"></i>
                </a>
                </div>
           </td>
          </tr>
			
			<div class="modal fade " id="modal<?php echo $c ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-centered modal-sm " role="document">
    <div class="modal-content">
      <div class="modal-header">
		  <h4 class="modal-title" id="mySmallModalLabel"><strong>CONFIRMACION</strong></h4>
       
      </div>
      <div class="modal-body text-center">
		  <strong>¿Deseas borrar el usuario "<?php echo $a_user['name'] ?>"?</strong>
      </div>
      <div class="modal-footer">
		  
      	
                            
                        
                        <a href="delete_user.php?id=<?php echo $c ?>" class="btn btn-danger" data-toggle="tooltip">Si
                        </a>
                      
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
			
			
        <?php endforeach;?>
       </tbody>
     </table>
     </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
 
            (function ($) {
 
                $('#filtrar').keyup(function () {
 
                    var rex = new RegExp($(this).val(), 'i');
                    $('.buscar tr').hide();
                    $('.buscar tr').filter(function () {
                        return rex.test($(this).text());
                    }).show();
 
                })
 
            }(jQuery));
 
        });
</script>
    <?php include_once('layouts/footer.php'); ?>