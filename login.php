<?php
if (isset($_POST["enviar"])) {
	require 'Conexion/conexion_mysqli.php';
	$mysqli = conexionMySQL();
	$loginNombre   = $_POST["login"];
	$loginPassword = ($_POST["password"]);

	/** VALIDAMOS DATOS DEL USUARIO **/
	$rp_detalles    = " SELECT * FROM gb_usuarios WHERE gb_usuario='$loginNombre' AND gb_clave='$loginPassword'";
	$query_detalles = $mysqli->query($rp_detalles);
	$n = $query_detalles->num_rows;
	$row = $query_detalles->fetch_assoc();
	if ($n > 0) {

		$rp_detalles1    = " SELECT * FROM gb_perfiles WHERE  gb_id='".$row["gb_id_perfil"]."' AND gb_bloqueo='1'";
		$query_detalles1 = $mysqli->query($rp_detalles1);
		$n = $query_detalles1->num_rows;
        if ($n > 0) {

			
			echo "<script>
		alert('Acceso bloqueado temporalmente!');
		window.location.href = 'http://179.49.8.237/index.php';
		</script>";
		}
		else
		{
			session_start();
			$_SESSION["logueado"]    = TRUE;
			$_SESSION["gb_id_user"]  = $row["gb_id"];
			$_SESSION["gb_nombre"]   = $row["gb_usuario"];
			$_SESSION["gb_perfil"]   = $row["gb_id_perfil"];
        	$_SESSION["gb_cod_vendedor"]   = $row["cod_vendedor"];
			header("Location: pages/index.php");
		}
	
	} else {


		echo "<script>
		alert('Usuario o clave incorrectos!');
		window.location.href = 'http://179.49.8.237/index.php';
		</script>";
	
	}
	$mysqli->close();
}	
