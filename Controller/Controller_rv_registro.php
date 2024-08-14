<?php
require '../Conexion/conexion_mysqli.php';
include('../control_session.php');
include('../Model/Model_gb_global.php');
include('../Model/Model_rv_registro.php');
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

        case "12":
            serarch_stockproductos();
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

            case "13":
                buscar_precio();
                break;

                case "14":
                    validar_reserva();
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

        $resp .= " <option value=" . $option["log_id"]. "> "  .$option["log_nombre"]. " </option>";
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

    $resp       = '0';
    foreach ($movements as $option) {

        $resp = " <option value=" . $option["id"]. "> "  .$option["nombre"]. " </option>";
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
    $data["txt_cantidad"]  = $_POST['txt_cantidad'];
    $data["txt_precio"]    = $_POST['txt_precio'];
    $data["txt_user"]      = $_SESSION["gb_id_user"];
    $i                     = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 9) {
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
/*
        if($data['cantidad'] == $data['imei'])
        {
            $imei        = '<acronym title="Imei" lang="es"><button type="button" pr_item ="' . $data['item'] . '" pr_descripcion="'.$data['descripcion'].'"  pr_cantidad="'.$data['cantidad'].'" class="btn btn-sm btn-success btn_imei">Imei : '.$data['cantidad'].'</button></acronym>';
        }
        else
        {
            $faltantes = $data['cantidad'] - $data['imei'];
            $imei        = '<acronym title="Imei" lang="es"><button type="button" pr_item ="' . $data['item'] . '" pr_descripcion="'.$data['descripcion'].'" pr_cantidad="'.$data['cantidad'].'" class="btn btn-sm btn-danger btn_imei">Imei Faltantes : '.$faltantes.'</button></acronym>';
        }
        */
        $imei ='';


        $dato['item']          =  $data['descripcion'];//.'<br>'.$imei;
        $dato['cantidad']      =  $data['cantidad'];
        $dato['button']        = '<button type="button" pr_item ="'.$data['item'].'" pr_id ="'.$data['id'].'"    class="btn btn-xs btn-danger btn_delete_item"><acronym title="Borrar item!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>';
        
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

    $data["txt_codigo"]           = 0;
    $data["txt_fecha"]            = $_POST['txt_fecha'];
    $data["txt_cadena"]           = $_POST['txt_cadena'];
    $data["txt_cliente"]           = $_POST['txt_cliente'];
    $data["txt_observaciones"]           = $_POST['txt_observaciones'];
    $data["txt_pago"]             = $_POST['txt_pago'];
    //$data["txt_total"]            = $_POST['txt_total'];
    $data["txt_cupodisponible"]            = $_POST['txt_cupodisponible'];
    $data["txt_saldovencido"]            = $_POST['txt_saldovencido'];
    $data["txt_codigovendedor"]            = $_POST['txt_codigovendedor'];
    $data["valorimg"]            = $_POST['valorimg'];
    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 15) {
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


/*=============================================
BUSCADOS PREDICTIVO DE PRODUCTOS
=============================================*/
function serarch_stockproductos()
{
    
    $Consult    = new ModelPg();
    $movements  = $Consult->serarch_stockproductos($_GET['term']);
    foreach ($movements as $movement) {
        $dato["text"]                     = $movement["text"];
        $dato["id"]                       = $movement["id"];
        $data[]=$dato;
        $datofinal=$movement["text"];
    }
   
   // $datax = array('data' => $data);
	echo $datofinal;

    
}




/*=============================================
CARGAR PRECIO
=============================================*/
function buscar_precio()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelPromotor();
    $Global  = new ModelGlobal();

    $data['valor']=$_REQUEST["valor"];
    $data['txt_producto']=$_REQUEST["txt_producto"];
    $data['txt_cliente']=$_REQUEST["txt_cliente"];
    $data['txt_cliente2']=$_REQUEST["txt_cliente2"];

    $data['canal']=$_REQUEST["canal"];
    $data['subcanal']=$_REQUEST["subcanal"];
    $data['txt_pago']=$_REQUEST["txt_pago"];
    $movements  = $Consult->buscar_precio($data);
    foreach ($movements as $movement) {
        $dato["precio"]                     = $movement["precio"];
        $dato["minimo"]                       = $movement["minimo"];
      //  $data[]=$dato;
     //   $datofinal=$movement["text"];
    }
   /*
   $datax = array('data' => $data);
	echo $datofinal;
    */
    echo json_encode($dato);
    
}


/*=============================================
VALIDAR RESERVA
=============================================*/
function validar_reserva()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelPromotor();
    $Global  = new ModelGlobal();

    $data['txt_cliente']=$_REQUEST["txt_cliente"];
    $movements  = $Consult->validar_reserva($data);
    foreach ($movements as $movement) {
        $dato["result"]                     = $movement["result"];
        $dato["oc_id"]                 = $movement["oc_id"];

    }
    echo json_encode($dato);
    
}