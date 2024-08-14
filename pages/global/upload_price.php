<?php


//$cantidad=$_REQUEST['cantidad'];

date_default_timezone_set('America/Guayaquil');

@session_start();

/*include('../dbconnect.php');
include 'db3.php';
*/
require '../../Conexion/conexion_mysqli.php';

$total=0;
$final=0;

date_default_timezone_set('America/Guayaquil');
$id_final=$_REQUEST['id_form'];
$nombreproducto=$_REQUEST['nombreproducto'];

$total = count($_REQUEST['subcanal'.$id_final]);

$iduser = $_SESSION["gb_id_user"];

$fechafin = date('Y-m-d H:i:s');
//INSERTAR CABECERA
$mysqli       = conexionMySQL();
$mysqli->autocommit(true);
for ($i=0; $i <$total ; $i++) { 
    $subcanal= $_REQUEST['subcanal'.$id_final][$i];
    $cantidad= $_REQUEST['cantidad'.$id_final][$i];
    $precio= $_REQUEST['precio'.$id_final][$i];
    $tipocredito= $_REQUEST['tipocredito'.$id_final][$i];

if ($tipocredito!=''){
    $concatsql=", tipo_credito ";
    $concatval= ", '$tipocredito'  ";
} else {
    $concatsql='';
$concatval='';
}



$sql_insert = "INSERT INTO `precios`(`id_precio`, `producto`, `subcanal`, `minimo`, `precio`,
 `id_usuario`, `fecha_registro`, `estatus`  $concatsql ) 
                VALUES
                (null,
                    '" . $nombreproducto . "',
                    '" . $subcanal . "',
                    '" . $cantidad . "',
                    '" . $precio . "',
                    '" . $iduser . "',
                    '" . $fechafin.  "',
                    1
                    $concatval
                    ) ";

             // echo $sql_insert.'<br>';
$resultado  = $mysqli->query($sql_insert);
//$id_registro =  $mysqli->insert_id;
if ($resultado) {
    $final = $final+1;
    //$mysqli->commit();
} else {
}

}

if ($final==$total){
echo 1;
} else {
    echo 0;
}

?>
