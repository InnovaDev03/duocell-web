<?php
require '../Conexion/conexion_mysqli.php';
include('../control_session.php');
include('../Model/Model_gb_global.php');
include('../Model/Model_oc_inventario.php');
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
                cargar_estados();
                break;

                case "5":
                    editar_estado();
                    break;                
                
        case "7":
            table_venta();
            break;

    }
}
/*=============================================
BUSCADOS PREDICTIVO PROMOTOR
=============================================*/
function serarch_promotor()
{
    
    $Consult    = new ModelOcInventario();
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
	$Consult   = new ModelOcInventario();
	$txt_promotor = '';
	
    /*	if(isset($_POST['txt_cadena']))
	{
		$txt_cadena	= $_POST['txt_cadena'];
	}*/
	/*$data['txt_promotor']  = $txt_promotor;
	$data['txt_fechain']      = $_POST["txt_fechain"];
    $data['txt_fechafin']	  = $_POST["txt_fechafin"];
    $data['txt_cadena']	      = $_POST["txt_cadena"];
    $data['txt_estado']	 	  = $_POST["txt_estado"];
    */
    $data['txt_bodega']	 	  = $_POST["txt_bodega"];
    $data["txt_user"]         = $_SESSION["gb_id_user"];
    $data["txt_gb_perfil"]    = $_SESSION["gb_perfil"];
    

    /*$data['search']['value']  = $_POST['search']['value'];
    $data['start']	          = $_POST["start"];
    $data['length']	          = $_POST["length"];
    $data['draw']	          = $_POST["draw"];
	*/
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
        $dato['item']	        =  $data['item'];
        $dato['descripcion']	        =  $data['descripcion'];

        //LO SIGUINTE NO PUEDE VER PERFIL 4
        if($_SESSION["gb_perfil"]!=4){
        $dato['totalreserva']	        =  $data['totalreserva'];
		if($data['stockfragata'] > 0)
		{
			$dato['stockfragata']	        =  $data['stockfragata'];
		}
        else
        {
        $dato['stockfragata']	        = 0;
        }
        $dato['ocsproceso']	        =  $data['ocsproceso'];
        $dato['accion']	        = '<button type="button" pr_item ="' . $data['item'] . '" class="btn btn-sm btn-success btn_verreservas">Ver Reservas</button>';
    } else {
        $dato['totalreserva']	        =  0;
        $dato['stockfragata']	        =  0;
        $dato['ocsproceso']	        = 0;
        $dato['accion']	        = '';
    }
		$dato['stock']	    =  $data['stock'];
        //$totalRecords = $data['totalRecords'];
		$file[]               = $dato;


    }
   
   /* $dato['button']        =  '';
    $dato['id'] = $i+1;
    $dato['oc_fecha']	        =  '';
    $dato['numoc']		= '';
    $dato['cliente']	        =  '';
    $dato['vendedor']	='';
    $dato['oc_estatus']	 ='';
    $dato['oc_estatus2']   ='';
    $dato['item']		    =  '';
	$dato['precio']	    =  '';
    $dato['cantidad']		    =  '';
    $dato['forma_pago']		=  '';
    $dato['button']='';
    $dato['total']	        =  '<strong>'.number_format($pr_total, 2, '.', ' ').'</strong>';
    $file[]               = $dato;
    */

    echo json_encode(array(	
        'draw'            => 1,   
        'recordsTotal'    => 1,  
        'recordsFiltered' => 1,
        'data' => $file)
        );
}


/*=============================================
TABLE IMEIS
=============================================*/
function table_imeis()
{ 
	$Consult          = new ModelOcInventario();
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
CARGAR CADENAS
=============================================*/
function cargar_estados()
{
    $consult       = new ModelOcInventario();
    $id_usuario    = 1;
    $movements     = $consult->cargar_estados();

    $resp       = ' <option value="">--Seleccionar--</option>';
    foreach ($movements as $option) {

        $resp .= " <option value=" . $option["id_estado"]. "> "  .$option["detalle"]. " </option>";
    }
    return printf($resp);
}




/*=============================================
EDIT ESTADO DESPACHADO
=============================================*/
function editar_estado()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelOcInventario();
    $Global  = new ModelGlobal();

    $data["txt_id_edit"]              = $_POST['txt_id_edit'];
    $data["txt_user"]         = $_SESSION["gb_id_user"];
    $i                        = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        /*if ($i > 7) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        */
        $i++;
    }
    
    $movements  = $Consult->editar_estado($data);
  
}




/*=============================================
TABLE VENTA
=============================================*/
function table_venta()
{ 
	$Consult          = new ModelOcInventario();
    $movements        = $Consult->table_venta($_REQUEST["ordencompra"]);
    $file             = array();
    $total_inversion =0;

    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['id']            = $i;
        $dato['fecha']          =  $data['oc_fecha'];//.'<br>'.$imei;
        $dato['cliente']          =  $data['id_cliente'];//.'<br>'.$imei;
        $dato['reservada']        =  $data['cantidad'];        
      
        $file[]               = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}



