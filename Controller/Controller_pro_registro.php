<?php
require '../Conexion/conexion_mysqli.php';
include('../control_session.php');
include('../Model/Model_gb_global.php');
include('../Model/Model_pro_registro.php');
include('../Model/Model_pg.php');
if (isset($_GET["txt_option"]) || isset($_POST["txt_option"])) {

    if (isset($_GET["txt_option"])) {
        $opt = $_GET["txt_option"];
    } else {
        $opt = $_POST["txt_option"];
    }

    switch ($opt) {

        case "1":
            secuencia_codigo();
            break;

        case "2":
            cargar_cadenas();
            break;


        case "3":
            cargar_tiendas();
            break;

        case "4":
            serarch_productos();
            break;

        case "4":
            serarch_productos();
            break;

        case "5":
            agregar_item();
            break;

        case "6":
            table_venta();
            break;

        case "7":
            table_imeis();
            break;

        case "8":
            agregar_imei();
            break;


        case "9":
            eliminar_imei();
            break;

        case "10":
            eliminar_item();
            break;

        case "11":
            registrar_venta();
            break;
			
        default:
            echo "{failure:true}";
            break;
    }
}



/*=============================================
FUNCION OBTENER SECUENCIA DE CODIGO
=============================================*/
function secuencia_codigo()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelPromotor();
    $Global  = new ModelGlobal();

    $movements  = $Consult->secuencia_codigo($_SESSION["gb_id_user"]);
    foreach ($movements as $movement) {

        $dato["result"]       = $movement["result"];
        $dato["error"]        = $movement["error"];
        $dato["secuencia"]    = $movement["secuencia"];
        $dato["total"]        = $movement["total"];
    }
    echo json_encode($dato);
}

/*=============================================
CARGAR CADENAS
=============================================*/
function cargar_cadenas()
{
    $consult       = new ModelPromotor();
    $id_usuario    = 1;
    $movements     = $consult->cargar_cadenas();

    $resp       = ' <option value="">--Seleccionar--</option>';
    foreach ($movements as $option) {

        $resp .= " <option value=" . $option["id"]. "> "  .$option["nombre"]. " </option>";
    }
    return printf($resp);
}

/*=============================================
CARGAR TIENDA
=============================================*/
function cargar_tiendas()
{
    $consult       = new ModelPromotor();
    $id_usuario    = 1;
    $movements     = $consult->cargar_tiendas($_POST['txt_id']);

    $resp       = ' <option value="0">--Seleccionar--</option>';
    foreach ($movements as $option) {

        $resp .= " <option value=" . $option["id"]. "> "  .$option["nombre"]. " </option>";
    }
    return printf($resp);
}



/*=============================================
BUSCADOS PREDICTIVO DE PRODUCTOS
=============================================*/
function serarch_productos()
{
    
    $Consult    = new ModelPg();
    $movements  = $Consult->serarch_productos($_GET['term']);
    foreach ($movements as $movement) {
        $dato["text"]                     = $movement["text"];
        $dato["id"]                       = $movement["id"];
        $data[]=$dato;
    }
   
    $datax = array('data' => $data);
	echo json_encode($datax);

    
}




/*=============================================
AGREGRAR ITEM
=============================================*/
function agregar_item()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelPromotor();
    $Global  = new ModelGlobal();

    $data["txt_id"]        = $_POST['txt_id'];
    $data["txt_text"]      = $_POST['txt_text'];
    $data["txt_precio"]    = $_POST['txt_precio'];
    $data["txt_cantidad"]  = $_POST['txt_cantidad'];
    $data["txt_user"]      = $_SESSION["gb_id_user"];
    $i                     = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 6) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->agregar_item($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
        $dato["total"]    = $movement["total"];
    }
    echo json_encode($dato);
}


/*=============================================
TABLE VENTA
=============================================*/
function table_venta()
{ 
	$Consult          = new ModelPromotor();
    $movements        = $Consult->table_venta($_SESSION["gb_id_user"]);
    $file             = array();
    $total_inversion =0;

    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['id']            = $i;

        if($data['pr_cantidad'] == $data['imei'])
        {
            $imei        = '<acronym title="Imei" lang="es"><button type="button" pr_item ="' . $data['pr_item'] . '" pr_descripcion="'.$data['pr_descripcion'].'"  pr_cantidad="'.$data['pr_cantidad'].'" class="btn btn-sm btn-success btn_imei">Imei : '.$data['pr_cantidad'].'</button></acronym>';
        }
        else
        {
            $faltantes = $data['pr_cantidad'] - $data['imei'];
            $imei        = '<acronym title="Imei" lang="es"><button type="button" pr_item ="' . $data['pr_item'] . '" pr_descripcion="'.$data['pr_descripcion'].'" pr_cantidad="'.$data['pr_cantidad'].'" class="btn btn-sm btn-danger btn_imei">Imei Faltantes : '.$faltantes.'</button></acronym>';
        }
        $imei ='';


        $dato['item']          =  $data['pr_descripcion'];//.'<br>'.$imei;
        $dato['cantidad']      =  $data['pr_cantidad'];
        $dato['precio']        =  $data['pr_precio'];
        $dato['total']         =  $data['pr_total'];
        $dato['button']        = '<button type="button" pr_item ="'.$data['pr_item'].'" pr_id ="'.$data['pr_id'].'"    class="btn btn-xs btn-danger btn_delete_item"><acronym title="Deshabilitar cadena!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>';
        
        $file[]               = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}

/*=============================================
TABLE IMEIS
=============================================*/
function table_imeis()
{ 
	$Consult          = new ModelPromotor();
    $movements        = $Consult->table_imeis($_POST["txt_id"],$_SESSION["gb_id_user"]);
    $file             = array();
    $total_inversion =0;

    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['id']            = $i;
        $dato['imei']          = $data['pr_imei'];
        $dato['button']        = '<button type="button" pr_id ="'.$data['pr_id'].'"   class="btn btn-xs btn-danger btn_delete_imei"><acronym title="Eliminar Imei!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>';
        
        $file[]               = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}



/*=============================================
AGREGAR IMEI
=============================================*/
function agregar_imei()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelPromotor();
    $Global  = new ModelGlobal();

    $data["txt_id_item"]          = $_POST['txt_pr_item_imei'];
    $data["txt_imei"]             = $_POST['txt_txt_imei'];
    $data["txt_cantidad"]         = $_POST['txt_pr_item_cantidad'];
    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 4) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->agregar_imei($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}


/*=============================================
ELIMINAR IMEI
=============================================*/
function eliminar_imei()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelPromotor();
    $Global  = new ModelGlobal();

    $data["txt_id"]          = $_POST['txt_id'];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 4) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->eliminar_imei($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}


/*=============================================
ELIMINAR IMEI
=============================================*/
function eliminar_item()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelPromotor();
    $Global  = new ModelGlobal();

    $data["txt_id"]          = $_POST['txt_id'];
    $data["txt_id_item"]     = $_POST['txt_id_item'];
    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                       = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 4) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->eliminar_item($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
        $dato["total"]    = $movement["total"];
        
    }
    echo json_encode($dato);
}


/*=============================================
REGISTRAR VENTA
=============================================*/
function registrar_venta()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelPromotor();
    $Global  = new ModelGlobal();

    $data["txt_codigo"]           = $_POST['txt_codigo'];
    $data["txt_fecha"]            = $_POST['txt_fecha'];
    $data["txt_cadena"]           = $_POST['txt_cadena'];
    $data["txt_tienda"]           = $_POST['txt_tienda'];
    $data["txt_pago"]             = $_POST['txt_pago'];
    $data["txt_total"]            = $_POST['txt_total'];
    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 10) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->registrar_venta($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}