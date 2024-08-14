<?php
// simple conexion a la base de datos
function connect(){
	return new mysqli("localhost","flotapps","BDFlotapps.21","prom_merc_bd");
}
$con = connect();
if (!$con->set_charset("utf8")) {//asignamos la codificación comprobando que no falle
       die("Error cargando el conjunto de caracteres utf8");
}
?>