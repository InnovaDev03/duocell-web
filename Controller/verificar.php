<?php
echo date('Y-m-d g:i:s-a');
/*
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
$rp_detalles = "SELECT * FROM ordencompra WHERE oc_estatus!=5 AND bodega_facturado=2" ;
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

                        
                            
                            $id_cliente = explode('-',$registro_detalles['id_cliente']);

                            $resultado_c   = sqlsrv_query($conn,"SELECT Vendedor FROM CCCliente WHERE codigo='".$id_cliente[0]."'");
                            while ($row_c = sqlsrv_fetch_array($resultado_c, SQLSRV_FETCH_ASSOC)) 
                            {
                                   $cod_vendedor   =  $row_c['Vendedor']; 
                            }
                            $fechaHora = $registro_detalles['oc_fecha_registro'] . '.000';
                            $observacion = procesarTexto($registro_detalles['oc_observaciones']);
                            $sqlx    = "INSERT INTO STEMPRESA_DUOCELL.dbo.FAPedido(numero, estado, cliente,  vendedor, fechafac, comentario, total,usuario, fechadig)VALUES(?,?,?,?,?,?,?,?,?)";
                            $paramsx = array($registro_detalles['oc_id'],'1',$id_cliente[0],$cod_vendedor,$registro_detalles['oc_fecha'],$observacion,$registro_detalles['oc_total'],$cod_vendedor,$fechaHora);
                            $stmtx   = sqlsrv_prepare($conn, $sqlx, $paramsx);
                            if (sqlsrv_execute($stmtx) === false) {
                                
                                if( ($errors = sqlsrv_errors() ) != null) {
                                    $error_details  ='';
                                    foreach( $errors as $error ) {
                                        $error_details =  "SQLSTATE: ".$error[ 'SQLSTATE']." - ";
                                        $error_details .= "code: ".$error[ 'code']." - ";
                                        $error_details .= "message: ".$error[ 'message']."";
                                    }
                                    
                                }

                                $arch = fopen("SQL_INSERT_FAPedido2.txt", "a+"); 
                                fwrite($arch,'Fecha : '.date('Y-m-d H:i:s').' : '.$error_details."\r\n");
                                fclose($arch);
                            
                                
                            }
                            
                            


        }
        
    }

    echo 'Total Ordenes      : '.$total_ordenes.'<br>';
    echo 'Total Insertada    : '.$total_insertada.'<br>';
    echo 'Total No Insertada : <stron><span style="color: red;">'.$total_no_insertada.'</span></stron><br>';

    
    
}
*/