<?php
//header('Content-Type: application/vnd.ms-excel;charset=utf-8');
header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment; filename= precios_operadoras_".date('Y-m-d g:i:s-a').".xls");
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
include '../../Model/bdsql.php';
$conn      = conexionSQLSI();
 $sql ="SELECT * from precios_operadoras where estatus=1 AND producto!='-'";

 $productconcat = '';
 $itemconcat='';
 $Codigo2 = '';
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

$sqlE         = "SELECT Codigo,Descripcion from CCSubCanal where CodCanal='004' and estado='A' AND Descripcion='".$subcanal."'";
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
//LLAMAMOS DATOS DE POSTGRES

//CONEXION A LA BD DUOCELL POSTGRES PARA OBTENER DATA




$sql         = "select count(*) total from CCSubCanal where CodCanal='004' and estado='A' ";
  $resultado   = sqlsrv_query($conn, $sql);// $mysqli->query($sql);
  $cantarecorrer=0;
  
  while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
  $cantarecorrer =  $row['total']-1;
  
    }

     //fin cantidad a recorrer

  $sql         = " SELECT Codigo,Descripcion from CCSubCanal where CodCanal='004'  and estado='A'  order by Descripcion desc  ";
  //$resultado   = $mysqli->query($sql);
  $resultado   = sqlsrv_query($conn, $sql);// $mysqli->query($sql);
      
 /* $row_count = sqlsrv_num_rows($resultado);
echo 'la cantidad es'.$row_count;
  */
  $contador=0;
  $concat='';
  for ($i=0; $i <$cantarecorrer ; $i++) { 
    //RECORREMOS POR CADA SUBTIPO Y QUE APAREZCA POR DEFECTO
    while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
      $concat=$concat.$row['Codigo'].'|';
	  	  $concat2=$concat2.$row['Descripcion'].'|';
    }

  }

  //dividimos y borramos
  $concat = explode('|',$concat);
  $concat2 = explode('|',$concat2);
 $concatfin='';

 if ($productconcat!=''){
  //se comenta para que a todos les aparezca
 //and nombre not in ($productconcat)
  $concatfin = "   and codigo not in ($itemconcat)" ;
}



$sql         = " select producto, codigo from productos_habilitados
WHERE  estatus=1  AND producto!='-' AND codigo!='' $concatfin
order by nombre asc ";
$contador=0;
$productconcat = '';
$itemconcat='';
// echo $sql;
        $result = mysqli_query($db_link, $sql);
        if (mysqli_num_rows($result) > 0) { //existe ese id
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


    