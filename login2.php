<?php
if (isset($_POST["enviar"])) {
	require 'Conexion/conexion_mysqli.php';
	$mysqli = conexionMySQL();
	$loginNombre   = $_POST["login"];
	$loginPassword = ($_POST["password"]);

	/** VALIDAMOS DATOS DEL USUARIO **/
	$rp_detalles    = " SELECT * FROM gb_usuarios WHERE gb_usuario='$loginNombre' AND gb_clave='$loginPassword' ";
	$query_detalles = $mysqli->query($rp_detalles);
	$n = $query_detalles->num_rows;
	$row = $query_detalles->fetch_assoc();
	if ($n > 0) {

		session_start();
		$_SESSION["logueado"]    = TRUE;
		$_SESSION["gb_id_user"]  = $row["gb_id"];
		$_SESSION["gb_nombre"]   = $row["gb_usuario"];
		$_SESSION["gb_perfil"]   = $row["gb_id_perfil"];

		header("Location: pages/index.php");
		
		
	} else {

		echo "Usuario o clave incorrectos";
	}
	$mysqli->close();
}	
