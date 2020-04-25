<?php
include_once('../includes/load.php');
//************************************************Variables************************************************
$mensaje = "";
$fecha = $_POST["fecha"];
$hr = $_POST["hr"];
$t_ent = $_POST["t_ent"];
$alg_tot = $_POST["alg_tot"];
$precio = $_POST["precio"];

//ejecutamos una consulta para verificar si el tipo de entrega tiene mas de un producto
$masdeuno = $db->query("Select * from prod_serv where servicio = '$t_ent' and prioridad = '0' limit 1");
$masdeuno_resnum = mysqli_num_rows($masdeuno); //Devuelve el numero de filas
$masdeuno_resvalores = mysqli_fetch_assoc($masdeuno);//Devuelve las filas en arreglos
//**************************************************************************************

$iTE = $db->query("Select * from prod_serv where servicio = '$t_ent' and prioridad = '1'");

$iTE_res = mysqli_fetch_assoc($iTE);

$tam = $iTE_res['producto'];

//LA CANTIDAD DEL PRODUCTO PRIMARIO QUEDARA PENDIENTE PORQUE AUN NO LOGRO IDEAR UN PLAN DE CALCULO...



$tono_c = $_POST["tono_c"];
$dir = $_POST["dir"];
$clie = $_POST["clie"];
$num = $_POST["num"];
$nom_fb = $_POST["nom_fb"];
$obs = $_POST["obs"];
$flor_c = $_POST["flor_c"];


if (isset($_POST['editar'])) {

    $id = $_POST['id'];

    $editar = $db->query("UPDATE `pedidos` SET `fecha`='$fecha',`hora`='$hr',`tipo_entrega`='$t_ent',`alg_tot`='$alg_tot',`tono`='$tono_c',`direccion`='$dir',`numero`='$num',`alias`='$nom_fb',`observaciones`='$obs',`flor`='$flor_c', `precio`= '$precio' WHERE `id`='$id'");
    if ($flor_c == 'NO') {
        $elim = $db->query("delete from cantidades where id_pedido = '$id' and flor = '1'");
    }else{
        $verifflor = $db->query("select * from cantidades where id_pedido = '$id' and flor = '1'");

        $sino = mysqli_num_rows($verifflor);

        if ($sino > 0) {
            $act = $db->query("UPDATE cantidades set blanco = 0, naranja=0, rosa=0, morado=0, azul=0, verde=0, amarillo=0, negro=0, rojo=0, cafe=0, acua=0 where id_pedido = '$id' and flor = '1'; ");
            $act = $db->query("UPDATE cantidades set `$flor_c` = 9 where id_pedido = '$id' and flor = '1';");
        }else{
            $act = $db->query("INSERT into `cantidades`(`$flor_c`, `tamaño`, `tono`,`flor`, `id_pedido`) VALUES ('9','chico','$tono_c','1', '$id')");
        }
    }
    if (!$editar) {
        $session->msg('d','No se pudo editar');
        redirect('../todo.php');
    }else{
        $session->msg('s','Se edito correctamente');
        redirect('../todo.php');
    }
}

$cant_bl = $_POST["cant_bl"];
$cant_na = $_POST["cant_na"];
$cant_ros = $_POST["cant_ros"];
$cant_m = $_POST["cant_m"];
$cant_az = $_POST["cant_az"];
$cant_v = $_POST["cant_v"];
$cant_am = $_POST["cant_am"];
$cant_ne = $_POST["cant_ne"];
$cant_roj = $_POST["cant_roj"];
$cant_c = $_POST["cant_c"];
$cant_ac = $_POST["cant_ac"];

//**********************************Switch Para Determinar Tamaño De Palillo**********************************


//*****************************************NOTA IMPORTANTE*****************************************
// no se esta ejecutando la consulta.. 
//el error no aparece asi que hay que ulizar los comandos para mostrar errores en query de php
//ya que no se esta ejecutando la consulta, el FETCH_ROW marca un error pues no obtiene valores.

//************************************************Variables De Consultas************************************************
$agregado = $db->query("INSERT INTO `pedidos`(`fecha`, `hora`, `tipo_entrega`, `alg_tot`, `tono`, `direccion`, `cliente`, `numero`, `alias`, `observaciones`, `flor`, `precio`, `faltante`) VALUES ('$fecha','$hr','$t_ent','$alg_tot','$tono_c','$dir','$clie','$num','$nom_fb','$obs', '$flor_c', '$precio', '$precio')");

//*********************************************Query Para Tomar ID De Pedido*********************************************
$info = $db->query("select max(`id`) as `ultimoid` from `pedidos`");
$x = mysqli_fetch_array($info);
$id_ped = $x["ultimoid"];
//************************************************Variables De Consultas************************************************
$cantidades = $db->query("INSERT INTO `cantidades`(`blanco`, `naranja`, `rosa`, `morado`, `azul`, `verde`, `amarillo`, `negro`, `rojo`, `cafe`, `acua`, `tamaño`, `tono`,`id_pedido`) VALUES ('$cant_bl','$cant_na','$cant_ros','$cant_m','$cant_az','$cant_v','$cant_am','$cant_ne','$cant_roj','$cant_c','$cant_ac','$tam','$tono_c','$id_ped')");
if ($flor_c != 'NO') {
    //Aunque la persona que registro el pedido seleccione que si hay flor, devemos verificar que exista un producto con prioridad secundaria para realizar la siguiente consulta..
    if ($masdeuno_resnum > 0) {
        $cantidadesFLOR = $db->query("INSERT INTO `cantidades`(`$flor_c`, `tamaño`, `tono`,`flor`, `id_pedido`) VALUES ('".$masdeuno_resvalores['cantidad']."','".$masdeuno_resvalores['producto']."','$tono_c','1', '$id_ped')");
    }else{
        $mensaje .="--Se selecciono flor pero este servicio no cuenta con un producto secundario";
    }
}

if(!$agregado){
    $estado = 'd';
    $mensaje .= " --OCURRIO UN ERROR AL AGREGAR EL PEDIDO. CONTACATA AL DESAROOLLADOR";
}
else if(!$cantidades){
    $estado = 'd';
    $mensaje .= " --OCURRIO UN ERROR AL AGREGAR LAS CANTIDADES POR COLOR. CONTACATA AL DESAROOLLADOR";
}else{

    $regmov = $db->query("INSERT INTO `cambiosestado`(`pedido`, `agendar`) VALUES ('$id_ped',now());");
    $estado = 's';
    $mensaje .= " --TODO EN ORDEN:)";
}
    $session->msg($estado,$mensaje);
    redirect('../agendar.php');