<?php 
date_default_timezone_set('America/Lima');
define ("SERVER","localhost");
 define("USER", "flotapps");
 define("PASS", "BDFlotapps.21");
 define("DB", "prom_merc_bd");
 function conexionMySQL()
 {
   $conexion=new mysqli(SERVER, USER,PASS,DB);
   if($conexion->connect_error)
   {
    $error = "<div class='error'>Error de conexiOn NO <br> %d </br> Mensaje del error : <mark> %s </mark> </div>";
    printf($error, $conexion->connect_errno, $conexion->connect_error);
   }
   $conexion->query("SET CHARACTER SET UTF8");
   return $conexion;
 }
 ?>