<?php
require '../Conexion/conexion_mysqli.php';
include('../control_session.php');
include('../Model/Model_gb_global.php');
include('../Model/Model_inventario_blo.php');
include('../Model/Model_pg.php');
if (isset($_GET["txt_option"]) || isset($_POST["txt_option"])) {

    if (isset($_GET["txt_option"])) {
        $opt = $_GET["txt_option"];
    } else {
        $opt = $_POST["txt_option"];
    }

    switch ($opt) {

        case "1":
            table_ventas_bloeuqeo();
            break;

        case "2":
            bloqueo();
            break;

    }
}

/*=============================================
TABLE ITEM BLOQUEADOS
=============================================*/
function table_ventas_bloeuqeo()
{ 	

	$mysqli    = conexionMySQL();
    $Global    = new ModelGlobal();
	$Consult   = new ModelInventarioBlo();
	$txt_promotor = '';
    $data["txt_user"]         = $_SESSION["gb_id_user"];
    $data["txt_gb_perfil"]    = $_SESSION["gb_perfil"];
    $i=0;
    $totalRecords =0;
	$movements        = $Consult->table_ventas_bloeuqeo($data);
	$file             = array();
    foreach ($movements as $data) {  
        $i++;
        $dato['id']	            =  $i;
        $dato['perfil']	        =  $data['gb_nombre'];
		$dato['estado']	        =  $data['estado'];
		$file[]               = $dato;
    }



    echo json_encode(array(	
        'draw'            => 1,   
        'recordsTotal'    => 1,  
        'recordsFiltered' => 1,
        'data' => $file)
        );
}


function bloqueo()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelInventarioBlo();
    $Global  = new ModelGlobal();
    @session_start();
    $data["id"]                   = $_POST['id'];
    $data["estado"]               = $_POST['estado'];
    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 4) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->bloqueo($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}
