<?php
function conexionSQLSI()
{

/*
$serverName="10.0.20.6";
$databaseName= "STEMPRESA_DUOCELL_PRUEBAS";
$username="jdominguez";
$password= "Senglar64";

*/
$serverName="10.0.20.4";
$databaseName= "STEMPRESA_DUOCELL";
$username="jdominguez";
$password= "Senglar64";

// Conexión a la base de datos
$conn = sqlsrv_connect($serverName, array("Database" => $databaseName, "UID" => $username, "PWD" => $password,  "CharacterSet"=>"UTF-8"));

if ($conn === false) {
   echo "No se pudo conectar a la base de datos: " . sqlsrv_errors();
    die();
} else {
   // echo "Conectado correctamente a la base de datos.";
}
   return $conn;
 }
