<?php
require '../Conexion/conexion_mysqli.php';
include('../control_session.php');
include('../Model/Model_gb_global.php');
include('../Model/Model_mer_consulta.php');
include('../Model/Model_pg.php');
if (isset($_GET["txt_option"]) || isset($_POST["txt_option"])) {

    if (isset($_GET["txt_option"])) {
        $opt = $_GET["txt_option"];
    } else {
        $opt = $_POST["txt_option"];
    }

    switch ($opt) {

        case "1":
            serarch_promotor();
            break;

        case "2":
            table_ventas();
            break;

        case "3":
            table_imeis();
            break;

        case "4":
            serarch_cliente();
            break;
    }
}
/*=============================================
BUSCADOS PREDICTIVO PROMOTOR
=============================================*/
function serarch_promotor()
{
    
    $Consult    = new ModelProCounsulta();
    $movements  = $Consult->serarch_promotor($_GET['term']);
    foreach ($movements as $movement) {
        $dato["text"]                     = $movement["text"];
        $dato["id"]                       = $movement["id"];
        $data[]=$dato;
    }
   
    $datax = array('data' => $data);
	echo json_encode($datax);
}


    /*=============================================
TABLE TAREAS
=============================================*/
function table_ventas()
{ 	

	$mysqli    = conexionMySQL();
    $Global    = new ModelGlobal();
	$Consult   = new ModelProCounsulta();
	$txt_promotor = '';
	
	if(isset($_POST['txt_promotor']))
	{
		$txt_promotor	= $_POST['txt_promotor'];
	}
	$data['txt_promotor']  = $txt_promotor;
	
	
	$data['txt_fechain']      = $_POST["txt_fechain"];
    $data['txt_fechafin']	  = $_POST["txt_fechafin"];
    $data['txt_cliente']	      = $_POST["txt_cliente"];
      $data['txt_promotor']	      = $_POST["txt_promotor"];
    $data["txt_user"]         = $_SESSION["gb_id_user"];
    $data["txt_gb_perfil"]    = $_SESSION["gb_perfil"];
    

    $data['search']['value']  = $_POST['search']['value'];
    $data['start']	          = $_POST["start"];
    $data['length']	          = $_POST["length"];
    $data['draw']	          = $_POST["draw"];
	
	$movements        = $Consult->table_ventas($data);
	$file             = array();
    $total_inversion  =	0;
    $totalRecords =0;
    $total_cantidad	=0;
    $pr_total	=0;
    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['id']	            =  $i;
        $dato['datos']	        =  $data['datos'];
		$dato['promotor']	    =  $data['promotor'];
        $dato['cliente']	        =  $data['cliente'];
        $dato['item']		    =  $data['item'];
        $dato['imei']		    =  $data['imei'];
        $dato['forma_pago']		=  $data['forma_pago'];
        $dato['valor']	        =  number_format($data['valor'], 2, '.', ',');
		
        $pr_total = $data['valor'] + $pr_total;
        $totalRecords = $data['totalRecords'];
		$file[]               = $dato;
    }

    $dato['id'] = $i+1;
    $dato['datos']	        =  '';
	$dato['promotor']	    =  '';
    $dato['cliente']	        =  '';
    $dato['item']		    =  '';
    $dato['imei']		    =  '';
    $dato['forma_pago']		=  '';
    $dato['valor']	        =  '<strong>'.number_format($pr_total, 2, '.', ' ').'</strong>';
    $file[]               = $dato;
    echo json_encode(array(	
        'draw'            => intval( $_POST['draw'] ),   
        'recordsTotal'    => intval( $totalRecords ),  
        'recordsFiltered' => intval($totalRecords),
        'data' => $file)
        );
}


/*=============================================
TABLE IMEIS
=============================================*/
function table_imeis()
{ 
	$Consult          = new ModelProCounsulta();
    $movements        = $Consult->table_imeis($_POST["txt_id"]);
    $file             = array();
    $total_inversion =0;

    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['id']            = $i;
        $dato['producto']      = $data['pr_descripcion'];
        $dato['imei']          = $data['pr_imei'];
        
        $file[]               = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}

/*=============================================
BUSCADOS PREDICTIVO CLIENTE
=============================================*/
function serarch_cliente()
{
    
    $Consult    = new ModelProCounsulta();
    $movements  = $Consult->serarch_cliente($_GET['term']);
    foreach ($movements as $movement) {
        $dato["text"]                     = $movement["text"];
        $dato["id"]                       = $movement["id"];
        $data[]=$dato;
    }
   
    $datax = array('data' => $data);
	echo json_encode($datax);
}
