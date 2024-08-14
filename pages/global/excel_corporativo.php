<?php
//header('Content-Type: application/vnd.ms-excel;charset=utf-8');
header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment; filename= precios_corportivo_".date('Y-m-d g:i:s-a').".xls");
//EXCEL DE AFILIADOS X SEMANA, HACIENDA, SECTOR, EMPLEADO
include 'db3.php';
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    .text { mso-number-format:"\@"; }
</style>
</head>

<table width="1083" border="1">
  <tr>
    <td><strong>Producto</strong></td>
    <td><strong>Subcanal</strong></td>
	<td><strong>Subcanal Nombre</strong></td>
    <td><strong>Mínimo</strong></td>
    <td><strong>Precio</strong></td>
    <td><strong>Tipo de Crédito</strong></td>
  </tr>
<?php
 //SELECT CON NUEVOS CAMPOS QUE SE DESEA
//$sql_1 = "SET sql_mode='NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'";
//$result_1 = mysqli_query($db_link, $sql_1);

 $sql = 'SELECT * from precios_corporativo where estatus=1';

 $productconcat = '';
 $itemconcat='';
   $Codigo2 ='';
 // echo $sql;
         $result = mysqli_query($db_link, $sql);
         if (mysqli_num_rows($result) > 0) { //existe ese id
            while($row = mysqli_fetch_assoc($result)) {
$total1 =0;$total2 =0;$total3 =0;$total4 =0;
$completa=0; $media=0;$extra=0;$acopio=0;$multa=0;
                $producto = $row['producto'];
                $prodarray=explode(' - ',$producto);
                $subcanal = $row['subcanal'];
                $productconcat = $productconcat. "'".$prodarray[1]."'," ;
                $itemconcat = $itemconcat. "'".$prodarray[0]."'," ;
$minimo         = $row["minimo"];
$precio          = $row["precio"];
//<td>'.number_format($precio,2,".", "").'</td>  

$result = pg_query($dbconn," SELECT sc_id,sc_descripcion from public.subcanal where ca_id=3 and sc_id='".$subcanal."' ");
while ($row = pg_fetch_row($result)) 
{
    $Codigo2=$row['sc_id'];
	$Descripcion=$row['sc_descripcion'];
}

        echo '<tr>
        <td>'.$producto.'</td>
        <td class="text">' . htmlspecialchars($Codigo2) . '</td>
		<td class="text">' . htmlspecialchars($Descripcion) . '</td>
        <td>'.$minimo.'</td>
        <td>'.number_format($precio,2).'</td>
        <td></td>
        </tr>';

            }
            //quitamos ultimo , caso contrario no se hace nada
            $productconcat =    substr($productconcat,0,-1);
            $itemconcat =    substr($itemconcat,0,-1);
         }

    
echo '</tr>';
//LLAMAMOS DATOS DE POSTGRES

//CONEXION A LA BD DUOCELL POSTGRES PARA OBTENER DATA
include '../../Model/bdpostgres.php';

$dbconn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass")
or die('Could not connect: ' . pg_last_error());

if (!$dbconn)
  {
  $result["result"] = 0;
  $result["error"] = 'Ocurrio un error en la conexion!!';
  echo json_encode($result);
  exit;
  }
  pg_set_client_encoding($dbconn, "UNICODE");    



   //CONSULTA DE LOS SUBCANALES WHERE CANALID=2
   $result = pg_query($dbconn," SELECT sc_id,sc_descripcion from public.subcanal where ca_id=3 and sc_descripcion is not null order by sc_descripcion desc");
   $rows = pg_num_rows($result);
   $concat='';
 if($rows > 0){
   for ($i=1; $i <=$rows ; $i++) { 
     //RECORREMOS POR CADA SUBTIPO Y QUE APAREZCA POR DEFECTO
     while ($row = pg_fetch_row($result)) {
       $concat=$concat.$row[0].'|';
	   $concat2=$concat2.$row[1].'|';
     }
 
   }
   //dividimos y borramos
   $concat = explode('|',$concat);
   $concat2 = explode('|',$concat2);
 }
 $concatfin='';

 if ($productconcat!=''){
  //se comenta para que a todos les aparezca
 $concatfin = "  and descripcion not in ($productconcat) and inv_inventario.codigo_item not in ($itemconcat)" ;
}

$result = pg_query($dbconn," SELECT descripcion, inv_inventario.codigo_item  FROM public.inv_inventario 
inner join public.inv_item on
public.inv_item.codigo_item = public.inv_inventario.codigo_item
where bodega_id=6  and inv_item.estado=1 $concatfin 
group by descripcion, inv_inventario.codigo_item
order by sum(existencia) desc ");
//and public.inv_inventario.codigo_item=1420
// and ( public.inv_inventario.codigo_item=1420  or public.inv_inventario.codigo_item=20)
$contador=0;
$rows = pg_num_rows($result);
if($rows <= 0){

}
else
{
  while ($row = pg_fetch_row($result)) {
    $nombreproducto=$row[1]. ' - '.$row[0];
$cantidad = count($concat) -1;

for ($i=0; $i <$cantidad ; $i++) { 

    echo '<tr>
    <td>'.$nombreproducto.'</td>
    <td class="text">' . htmlspecialchars($concat[$i]) . '</td>
	<td class="text">' . htmlspecialchars($concat2[$i]) . '</td>
    <td></td>
    <td></td>
    <td></td>
    </tr>';

  }

  }
} 


echo '</table>';



 ?>


    