<?php
//header('Content-Type: application/vnd.ms-excel;charset=utf-8');


header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename= datos.xls");
//EXCEL DE AFILIADOS X SEMANA, HACIENDA, SECTOR, EMPLEADO
include 'db3.php';
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table width="1083" border="1">
  <tr>
    <td><strong>Datos</strong></td>
    <td><strong>Promotor</strong></td>
    <td><strong>Cadena</strong></td>
    <td><strong>Item</strong></td>
    <td><strong>Forma Pago</strong></td>
    <td><strong>Cantidad</strong></td>
    <td><strong>Valor</strong></td>
  </tr>
<?php
 //SELECT CON NUEVOS CAMPOS QUE SE DESEA
//$sql_1 = "SET sql_mode='NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'";
//$result_1 = mysqli_query($db_link, $sql_1);

	
ini_set('memory_limit', '64M');
ini_set('max_execution_time', 9000000);

$fechainicio0    =explode('-',$_REQUEST['fechain']);
$fechafin0    =explode('-',$_REQUEST['fechafin']);
$txt_promotor   = $_REQUEST['txt_promotor'];
$txt_cadena		= $_REQUEST['txt_cadena'];
$txt_tienda		= $_REQUEST['txt_tienda'];
@session_start();

$fechainicio = $fechainicio0[2].'-'.$fechainicio0[1].'-'.$fechainicio0[0];
$fechafin=$fechafin0[2].'-'.$fechafin0[1].'-'.$fechafin0[0];
$txt_user		= $_SESSION["gb_id_user"];
$txt_gb_perfil  =  $_SESSION["gb_perfil"];




$sql_query      = "SELECT d.pr_id, v.pr_codigo,v.pr_fecha,v.pr_fecha_registro,v.pr_forma_pago,v.pr_id_cadena,v.pr_id_tienda,d.pr_descripcion,d.pr_total,v.pr_id_usuario, d.pr_cantidad as cantidad, pa_cadenas.nombre as cadena, pa_tiendas.nombre as tienda, gb_usuarios.gb_nombre as usuario
FROM pr_venta_detalle d
INNER JOIN pr_venta v
ON d.pr_id_venta=v.pr_id
inner join pa_cadenas ON
pa_cadenas.id = pr_id_cadena
inner join pa_tiendas ON
pa_tiendas.id = pr_id_tienda
inner join gb_usuarios ON
gb_usuarios.gb_id = pr_id_usuario
WHERE d.estatus <>0 and  v.pr_fecha BETWEEN '".($fechainicio)."' AND '".($fechafin)."' ";
//echo $sql_query;

if($txt_gb_perfil != 1)
{
$sql_query         .= " AND v.pr_id_usuario ='". $txt_user."'  ";
}
else
{
if($txt_promotor != 0)
{
$sql_query         .= " AND v.pr_id_usuario ='". $txt_promotor."'  ";
}
}

if($txt_cadena != 0)
{
$sql_query         .= " AND v.pr_id_cadena ='". $txt_cadena."'  ";
}

if($txt_tienda != 0)
{
$sql_query         .= " AND v.pr_id_tienda ='". $txt_tienda."'  ";

}

         $result = mysqli_query($db_link, $sql_query);
         if (mysqli_num_rows($result) > 0) { //existe ese id
            while($fila = mysqli_fetch_assoc($result)) {
                
                $datoid = $fila['pr_id'];
                $fila['datos']    = '<strong>Codigo : </strong>'.$fila['pr_codigo'].'<br>'.'<strong>Fecha : </strong>'.$fila['pr_fecha'].
                                    '<br>'.'<strong>Fecha Registro: </strong>'.$fila['pr_fecha_registro'];
                $fila['promotor']    = '<strong>Promotor : </strong>'.($fila['usuario']);
                $fila['cadena2']      = '<strong>Cadena : </strong>'.($fila['cadena']).'<br>'.'<strong>Tienda : </strong>'.($fila['tienda']);
                $fila['item']        =	 $fila['pr_descripcion'];
                //$fila['imei']        =	 $fila['pr_imei'];
                $fila['forma_pago']  =	 $fila['pr_forma_pago'];
                $fila['valor']       =	 $fila['pr_total'];

//<td>'.number_format($precio,2,".", "").'</td>  
        echo '<tr>
        <td>'.$fila['datos'].'</td>
        <td>'.$fila['promotor'].'</td>
        <td>'.$fila['cadena2'].'</td>
        <td>'.$fila['item'].'</td>
        <td>'.$fila['forma_pago'].'</td>
        <td>'.$fila['cantidad'].'</td>
        <td>'.$fila['valor'].'</td>
        </tr>';

            }
         }

echo '</table>';



 ?>


    