<?php

date_default_timezone_set('America/Guayaquil');

@session_start();

require '../../Conexion/conexion_mysqli.php';

$total=0;
$final=0;

date_default_timezone_set('America/Guayaquil');
$id_final=$_REQUEST['id_form'];
$nombreproducto=$_REQUEST['nombreproducto'];

$total = $_REQUEST['cantidadregistros'.$id_final];
$iduser = $_SESSION["gb_id_user"];

$fechafin = date('Y-m-d H:i:s');
//INSERTAR CABECERA
$mysqli       = conexionMySQL();
$mysqli->autocommit(true);

for ($i=0; $i <$total ; $i++) { 
    $subcanal= $_REQUEST['subcanallisto'.$id_final][$i];
    if ($_REQUEST['cantidadlisto'.$id_final][$i]!='' or $_REQUEST['cantidadlisto'.$id_final][$i]<>null){
    $cantidad2= $_REQUEST['cantidadlisto'.$id_final][$i];
    $cantidad= " `minimo`= $cantidad2 ";

} else {
    $cantidad= " `minimo`= null ";
}
    $precio= $_REQUEST['preciolisto'.$id_final][$i];
    $id_precio= $_REQUEST['id_precio'.$id_final][$i];
    $tipocrelisto= $_REQUEST['tipocrelisto'.$id_final][$i];
    
//INSERTAMOS 1 VEZ TODOS LOS PRECIOS ANTES DE MODIFICAR.

$sql_insert = "INSERT `precios_historial` 
select null, `id_precio`, `producto`, `subcanal`, `minimo`, `precio`, `id_usuario`, 
`fecha_registro`, `estatus`, tipo_credito, '" . $iduser . "',  '" . $fechafin.  "'  from precios
where `id_precio`='" . $id_precio . "' ";

//echo $sql_insert;
$resultado  = $mysqli->query($sql_insert);
if ($resultado) {
} else {
}

if ($tipocrelisto!=''){
    $concatedit=", tipo_credito= '".$tipocrelisto."' ";
} else {
    $concatedit='';
}
    $sql_insert = "update `precios` set  `subcanal`='" . $subcanal . "',
 $cantidad  , `precio`= '" . $precio . "',
  $concatedit `id_usuario`=  '" . $iduser . "', id_user_edit=  '" . $iduser . "',
 fecha_hora_edit = '" . $fechafin.  "', fecha_registro= '" . $fechafin.  "' where `id_precio`='" . $id_precio . "' ";

             // echo $sql_insert.'<br>';
$resultado  = $mysqli->query($sql_insert);
//$id_registro =  $mysqli->insert_id;
if ($resultado) {
    $final = $final+1;
    //$mysqli->commit();
} else {
}

}

/*
if ($final==$total){
echo 1;
} else {
    echo 0;
}
*/
echo 1;

?>
