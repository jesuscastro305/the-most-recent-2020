<?php
include_once('../includes/load.php');
$info = $db->query("select max(`id`) as `ultimoid` from `pedidos`");
$x = mysqli_fetch_array($info);

echo $x["ultimoid"];