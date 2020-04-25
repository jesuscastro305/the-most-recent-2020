<?php
include_once('includes/load.php');
 if (!$session->isUserLoggedIn(true)) { 
    $session->msg('d', 'Primero debes iniciar sesion');
    redirect('index.php');} 
$op = '5.6';
$page_title = "Inicio";


include_once('layouts/header.php');

//SELECT (ELT(WEEKDAY(fecha) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA, DATE_FORMAT(fecha, "%d/%M/%Y") as CUANDO FROM pedidos

?>
    <div class="container-fluid">
       <div class="row p-2">
                <div class="col-lg-3 col-md-6" style="margin-bottom: 20px"  >
                    <div class="panel panel-primary" >
                        <div class="panel-heading bg-primary p-2 psup" style="color: #fff">
                            <div class="row">
                                <div class="col-3" style="color: #fff">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <div class="huge">26</div>
                                    <div>Nuevos comentarios!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#" >
                            <div class="panel-footer p-2 pinf" style="border: 1px solid">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" style="margin-bottom: 20px" >
                    <div class="panel panel-green">
                        <div class="panel-heading p-2 psup">
                            <div class="row">
                                <div class="col-3 ">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <div class="huge">12</div>
                                    <div>Nuevos objetivos!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#" >
                            <div class="panel-footer p-2 pinf" style="border: 1px solid">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" style="margin-bottom: 20px">
                    <div class="panel panel-yellow" >
                        <div class="panel-heading p-2 psup">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <div class="huge">124</div>
                                    <div>Nuevas ordenes!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#" >
                            <div class="panel-footer p-2 pinf" style="border: 1px solid">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6"  style="margin-bottom: 20px">
                    <div class="panel panel-red ">
                        <div class="panel-heading p-2 psup">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Personas que necesitan soporte!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#" >
                            <div class="panel-footer p-2 pinf" style="border: 1px solid;">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>   
    </div>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="GJAPRAMDK5C8A">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal, la forma más segura y rápida de pagar en línea.">
<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
</form>

      
            <?php include_once('layouts/footer.php'); ?>