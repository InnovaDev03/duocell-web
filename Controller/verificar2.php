<?php
echo date('Y-m-d g:i:s-a');

function procesarTexto($texto) {
    // Eliminar saltos de línea y retornos de carro
    $texto = str_replace(array("\r", "\n"), ' ', $texto);

    // Reducir múltiples espacios a un solo espacio
    $texto = preg_replace('/\s+/', ' ', $texto);

    // Recortar el texto a 200 caracteres
    $texto = substr($texto, 0, 200);

    return $texto;
}
require '../Conexion/conexion_mysqli.php';
include '../Model/bdsql.php';
$mysqli       = conexionMySQL();
$conn        = conexionSQLSI();
$total_ordenes =0;
$total_insertada=0;
$total_no_insertada=0;
$rp_detalles = "SELECT * FROM ordencompra WHERE oc_estatus!=5 AND bodega_facturado=2 AND num_factura!=''" ;
$query_detalles=$mysqli->query($rp_detalles);
$n= $query_detalles->num_rows;
if($n>0)
{
    while ($registro_detalles=$query_detalles->fetch_assoc())
    {
        $total_ordenes++;
        $existe      = 0;
        $cod_vendedor   =0;
        $sql         = "SELECT * FROM STEMPRESA_DUOCELL.dbo.FAPedido WHERE numero='".$registro_detalles['oc_id']."'  ";
        $resultado   = sqlsrv_query($conn, $sql);
        while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) 
        {
            $existe = 1;
        }
        
        if($existe == 1)
        {
            $total_insertada++;
            echo $total_ordenes.' - ORDEN : '.$registro_detalles['oc_id'].' INSERTADA '.'<br>';
        }
        else
        {
            $total_no_insertada++;
            echo $total_ordenes.' - ORDEN : '.$registro_detalles['oc_id'].'<stron><span style="color: red;"> NO INSERTADA </span></stron>'.'<br>';

                        
        }
        
    }

    echo 'Total Ordenes      : '.$total_ordenes.'<br>';
    echo 'Total Insertada    : '.$total_insertada.'<br>';
    echo 'Total No Insertada : <stron><span style="color: red;">'.$total_no_insertada.'</span></stron><br>';

    
    
}
