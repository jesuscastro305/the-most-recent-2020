<?php
include_once('includes/load.php');
 if (!$session->isUserLoggedIn(true)) { 
    $session->msg('d', 'Primero debes iniciar sesion');
    redirect('index.php');} 
$op = '2.1';
$page_title = "Agendar pedido";
include_once('layouts/header.php');
    ?>

    

<div class="container mt-1 mb-3">
    <div class="col-8 offset-2">
        <?php echo display_msg($msg); ?>
    </div>
<div class="">
   <div class="row">
       <div class="col-12 col-md-6 offset-md-3"><h1>Agendar Pedido</h1></div>
   </div>
    <form action="php/registrarpedido.php" class="form-horizontal" id="formulario" method="post" >
        <div class="row">
            <div class="form-group col-6"><label for="fecha" class="control-label">Fecha:*</label><input type="date" id="fecha" class="form-control" name="fecha" required></div>
            <div class="form-group col-6"><label for="hora" class="control-label">Hora:*</label><input type="time" id="hora" class="form-control" name="hr" required></div>
        </div>
        <div class="row">
        <div class="form-group col-6">
            <label for="tipo_ent" class="control-label">Tipo de entrega:</label>
            <select name="t_ent" id="tipo_ent" class="form-control">
                <?php
                    $todo = $db->query("select * from servicios");
                    foreach ($todo as $k ) {
                ?>
                <option value="<?php echo $k['servicio']; ?>"><?php echo $k['servicio']; ?></option>
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
            <div class="form-group col-6"><label for="flor" class="control-label">Flor:</label>
            <select name="flor_c" id="flor" class="form-control">
                <option value="NO" selected>Sin flor</option>
                <option value="blanco">blanco</option>
                <option value="naranja">naranja</option>
                <option value="rosa">rosa</option>
                <option value="morado">morado</option>
                <option value="azul">azul</option>
                <option value="verde">verde</option>
                <option value="amarillo">amarillo</option>
                <option value="negro">negro</option>
                <option value="rojo">rojo</option>
                <option value="cafe">cafe</option>
                <option value="acua">acua</option>
            </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6">
                <label for="total_al" class="control-label">Algodones totales :*</label>
                <input type="number" id="total_al" class="form-control" name="alg_tot" maxlength="4" placeholder="" value="0" required>
            </div>
            <div class="form-group col-6"><label for="tono" class="control-label">Tono:</label>
                <select name="tono_c" id="tono" class="form-control">
                    <option value="Fuerte">Fuerte</option>
                    <option value="Normal" selected>Normal</option>
                    <option value="Pastel">Pastel</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="color" class="control-label">Color(es):*</label>
            <ul>
                <li>
                    <input type="checkbox" class="form-check-input" id="blanco" value="blanco"><label for="blanco" class="control-label">Blanco</label>
                    <ul>
                        <li><label for="input_bl" class="control-label">Cantidad:</label><input type="number" class="form-control cant_form" id="input_bl" name="cant_bl" value="0" min="0" readonly></li>
                    </ul>
                </li>
                <li>
                    <input type="checkbox" class="form-check-input" id="naranja"  value="naranja"><label for="naranja" class="control-label">Naranja</label>
                    <ul>
                        <li><label for="input_na" class="control-label">Cantidad:</label><input type="number" class="form-control cant_form" id="input_na" name="cant_na" value="0" min="0" readonly></li>
                    </ul>
                </li>
                <li>
                    <input type="checkbox" class="form-check-input" id="rosa"  value="rosa"><label for="rosa" class="control-label">Rosa</label>
                    <ul>
                        <li><label for="input_ros" class="control-label">Cantidad:</label><input type="number" class="form-control cant_form" id="input_ros" name="cant_ros" value="0" min="0" readonly></li>
                    </ul>
                </li>
                <li>
                    <input type="checkbox" class="form-check-input" id="morado" value="morado"><label for="morado" class="control-label">Morado</label>
                    <ul>
                        <li><label for="input_m" class="control-label">Cantidad:</label><input type="number" class="form-control cant_form" id="input_m" name="cant_m" value="0" min="0" readonly></li>
                    </ul>
                </li>
                <li>
                    <input type="checkbox" class="form-check-input" id="azul"  value="azul"><label for="azul" class="control-label">Azul</label>
                    <ul>
                        <li><label for="input_az" class="control-label">Cantidad:</label><input type="number" class="form-control cant_form" id="input_az" name="cant_az" value="0" min="0" readonly></li>
                    </ul>
                </li>
                <li>
                    <input type="checkbox" class="form-check-input" id="verde" value="verde"><label for="verde" class="control-label">Verde</label>
                    <ul>
                        <li><label for="input_v" class="control-label">Cantidad:</label><input type="number" class="form-control cant_form" id="input_v" name="cant_v" value="0" min="0" readonly></li>
                    </ul>
                </li>
                <li>
                    <input type="checkbox" class="form-check-input" id="amarillo"  value="amarillo"><label for="amarillo" class="control-label">Amarillo</label>
                    <ul>
                        <li><label for="input_am" class="control-label">Cantidad:</label><input type="number" class="form-control cant_form" id="input_am" name="cant_am" value="0" min="0" readonly></li>
                    </ul>
                </li>
                <li>
                    <input type="checkbox" class="form-check-input" id="negro"  value="negro"><label for="negro" class="control-label">Negro</label>
                    <ul>
                        <li><label for="input_ne" class="control-label">Cantidad:</label><input type="number" class="form-control cant_form" id="input_ne" name="cant_ne" value="0" min="0" readonly></li>
                    </ul>
                </li>
                <li>
                    <input type="checkbox" class="form-check-input" id="rojo"  value="rojo"><label for="rojo" class="control-label">Rojo</label>
                    <ul>
                        <li><label for="input_roj" class="control-label">Cantidad:</label><input type="number" class="form-control cant_form" id="input_roj" name="cant_roj" value="0" min="0" readonly></li>
                    </ul>
                </li>
                <li>
                    <input type="checkbox" class="form-check-input" id="cafe"  value="cafe"><label for="cafe" class="control-label">Cafe</label>
                    <ul>
                        <li><label for="input_c" class="control-label">Cantidad:</label><input type="number" class="form-control cant_form" id="input_c" name="cant_c" value="0" min="0" readonly></li>
                    </ul>
                </li>
                <li>
                    <input type="checkbox" class="form-check-input" id="acua"  value="acua"><label for="acua" class="control-label">Acua</label>
                    <ul>
                        <li><label for="input_ac" class="control-label">Cantidad:</label><input type="number" class="form-control cant_form" id="input_ac" name="cant_ac" value="0" min="0" readonly></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="form-group">
            <div class="btn btn-success" id="btn_pi">Partes iguales</div>
            <div class="" id="texto_faltantes"></div>
            <input type="hidden" id="hid">
        </div>
        
        <div class="form-group"><label for="direccion" class="control-label">Direcci&oacute;n:*</label><input type="text" id="direccion" class="form-control" name="dir" required maxlength="100"></div>
        <div class="form-group"><label for="cliente" class="control-label">Cliente:*</label><input type="text" id="cliente" class="form-control" name="clie" required maxlength="100"></div>
        <div class="form-group">
            <div class="alert alert-warning">Despues podras buscar todos los pedidos registrados a este numero de telefono. Ya que el numero de telefono es unico y el nombre puede repetirse.</div>
            <label for="numero" class="control-label">N&uacute;mero:*</label><input type="text" id="numero" class="form-control" name="num" maxlength="10" list="numerostt" required placeholder="Puedes gregar solo un numero a 10 digitos"></div>
            <datalist id="numerostt">
                <?php

                $todos = $db->query("SELECT DISTINCT(`numero`) from pedidos");

                foreach ($todos as $key1) {
                ?>
                <option value="<?php echo $key1['numero']; ?>"></option>
                <?php } ?>
            </datalist>
        <div class="row">
            <div class="form-group col-7"><label for="" class="control-label">Nombre en facebook:</label><input type="text" id="fb" class="form-control" maxlength="30" name="nom_fb"></div>
            <div class="form-group col-5">
                <label for="" class="control-label">Precio total:*</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">$</span>
                  </div>
                    <input type="number" id="precio_tot" class="form-control" placeholder="1000" name="precio" required>
                </div>
            </div>
        </div>
        <div class="form-group"><label for="observaciones" class="control-label">observaciones:</label><textarea name="obs" id="observaciones" cols="30" rows="10" class="form-control" maxlength="300"></textarea></div>
    </form>
        <div class="row">
            <div class="col-6 offset-3 col-md-4 offset-md-4">
                <button class="btn btn-lg btn-dark btn-block glyphicon glyphicon-copy" role="button" id="checar"  data-toggle="modal"></button>
            </div>
        </div>


            <div class="modal fade " id="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-centered modal-m " role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="text-align: left;">
                            <h4 class="modal-title" id="mySmallModalLabel" ><strong>¿Los datos son correctos?</strong></h4>
                        </div>
                        <div class="modal-body text-left">
                            <div class="col-12 mb-1">
                                <strong>Fecha (aaaa-mm-dd): </strong>
                                <div id="f"></div>
                            </div>
                            <div class="col-12 mb-1">
                                <strong>Hora: </strong>
                                <div id="h"></div>
                            </div>
                            <div class="col-12 mb-1">
                                <strong>Tipo: </strong>
                                <div id="t"></div>
                            </div>
                            <div class="col-12 mb-1">
                                <strong>Flor: </strong>
                                <div id="fl"></div>
                            </div>
                            <div class="col-12 mb-1">
                                <strong>Colores: </strong>
                                <div id="c"></div>
                                
                            </div>
                            <div class="col-12 mb-1">
                                <strong>Tono: </strong>
                                <div id="to"></div>
                            </div>
                            <div class="col-12 mb-1">
                                <strong>Dirección: </strong>
                                <div id="d"></div>
                            </div>
                            <div class="col-12 mb-1">
                                <strong>Numero: </strong>
                                <div id="n"></div>
                            </div>
                            <div class="col-12 mb-1">
                                <strong>Cliente: </strong>
                                <div id="cli"></div>
                            </div>
                            <div class="col-12 mb-1">
                                <strong>Alias: </strong>
                                <div id="a"></div>
                            </div>
                            <div class="col-12 mb-1">
                                <strong>Precio: </strong>
                                <div id="pr"></div>
                            </div>
                            <div class="col-12 mb-1">
                                <strong>Observaciones: </strong>
                                <div id="o"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success glyphicon glyphicon-ok" data-toggle="tooltip" id="checado"></button>
                            <button type="button" class="btn btn-danger glyphicon glyphicon-remove" data-dismiss="modal"></button>
                        </div>
                    </div>
                </div>
            </div>
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
                else if(validacion == 0){
                    alert("Los algodones totales deben ser mayores a 0");
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
            $("#formulario").submit(function() {
                var falta = $("#hid").val();
                if (falta == 0) {       
                    return true;
                } else {
                    alert("Hay algodones sin repartir");
                    return false;
                }
                                
            });
            $("#checar").click(function() {
            
                $("#f").html($("#fecha").val());
                $("#h").html($("#hora").val());
                $("#t").html($("#tipo_ent").val());
                $("#fl").html($("#flor").val());
                // $("#c").html($("#").val());
                $("#alg").html($("#total_al").val());
                $("#to").html($("#tono").val());
                $("#d").html($("#direccion").val());
                $("#n").html($("#numero").val());
                $("#cli").html($("#cliente").val());
                $("#a").html($("#fb").val());
                $("#pr").html($("#precio_tot").val());
                $("#o").html($("#observaciones").val());


                if ($("#fecha").val().length<1 || $("#hora").val().length<1 || $("#total_al").val().length<1 || $("#direccion").val().length<1 || $("#cliente").val().length<1 || $("#numero").val().length<1 || $("#precio_tot").val().length<1 ) {
                    alert("Completa la informacion para poder confirmar pedido");
                }else{
                    $("#modal").modal("show");
                }
            });
            $("#checado").click(function() {
                $("form#formulario").submit();
            });

        });
    </script>

    <?php include_once('layouts/footer.php'); ?>