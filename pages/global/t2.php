<?php

include '../../Model/bdsql.php';


$con      = conexionSQLSI();

$dato1='3';
$dato2='3';
$dato3='3';
    $sql = "INSERT INTO [dbo].[ATFormaPago] 
                       (Tip_Codigo, estado, Tip_Descripcion)
                VALUES (?, ?, ?)";

    $params = array( $dato1,$dato2,$dato3);

$stmt = sqlsrv_prepare($con, $sql, $params);
if (sqlsrv_execute( $stmt ) === false) {
    echo "Row insertion failed";  
    die(print_r(sqlsrv_errors(), true)); 
} else echo "Row successfully inserted"; 

?>