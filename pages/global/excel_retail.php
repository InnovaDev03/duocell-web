<?php
//header('Content-Type: application/vnd.ms-excel;charset=utf-8');
header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment; filename= precios_retail_".date('Y-m-d g:i:s-a').".xls");
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
include '../../Model/bdsql.php';
$conn      = conexionSQLSI();
 //SELECT CON NUEVOS CAMPOS QUE SE DESEA
//$sql_1 = "SET sql_mode='NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'";
//$result_1 = mysqli_query($db_link, $sql_1);

 $sql = "SELECT * from precios_retail where estatus=1 AND producto!='-'";

 $productconcat = '';
 $itemconcat='';
  $Codigo2 ='';

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

$sqlE         = "SELECT Codigo,Descripcion from CCSubCanal where CodCanal='001' and estado='A' AND Codigo='".$subcanal."'";
$resultadoE   = sqlsrv_query($conn, $sqlE);
while ($rowE = sqlsrv_fetch_array($resultadoE, SQLSRV_FETCH_ASSOC)) 
{
	$Codigo2 = $rowE['Codigo'];
	$Descripcion = $rowE['Descripcion'];
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
/*
echo '<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>';
	echo '<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>';
*/


$sql         = "select count(*) total from CCSubCanal where CodCanal='001' and estado='A' ";
 $resultado   = sqlsrv_query($conn, $sql);
 $cantarecorrer=0;
  while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
  $cantarecorrer =  $row['total']-1;
  
    }


  $sql         = " SELECT Codigo,Descripcion from CCSubCanal where CodCanal='001'  and estado='A'  order by Descripcion desc  ";

  $resultado   = sqlsrv_query($conn, $sql);
      

  $contador=0;
  $concat='';
  for ($i=0; $i <$cantarecorrer ; $i++) { 

    while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
      $concat=$concat.$row['Codigo'].'|';
	  $concat2=$concat2.$row['Descripcion'].'|';
    }

  }


  $concat = explode('|',$concat);
      $concat2 = explode('|',$concat2);
 $concatfin='';

 if ($productconcat!=''){

  $concatfin = "   and codigo not in ($itemconcat)" ;
}



$sql         = " select producto, codigo from productos_habilitados
WHERE  estatus=1  AND producto!='-' AND codigo!='' $concatfin 
order by nombre asc ";
$contador=0;
$productconcat = '';
$itemconcat='';

        $result = mysqli_query($db_link, $sql);
        if (mysqli_num_rows($result) > 0) { 
           while($row = mysqli_fetch_assoc($result)) {


$contador=$contador+1;
  $nombreproducto=$row['codigo']. ' - '.$row['producto'];
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


    