<?php
require '../Conexion/conexion_mysqli.php';
include('../control_session.php');
include('../Model/Model_gb_global.php');
include('../Model/Model_clientes.php');
if (isset($_GET["txt_option"]) || isset($_POST["txt_option"])) {

    if (isset($_GET["txt_option"])) {
        $opt = $_GET["txt_option"];
    } else {
        $opt = $_POST["txt_option"];
    }

    switch ($opt) {

        case "1":
            registro_cliente();
            break;


        case "2":
            table_clientes();
            break;

        case "3":
            validar_identificacion();
            break;


        case "4":
            editar_cliente();
            break;


        case "5":
            eliminar_cliente();
            break;

        case "6":
            load_unidades();
            break;

        case "7":
            predictivo_servicios();
            break;


        case "8":
            table_servicios_clientes();
            break;

        case "9":
            load_servicios();
            break;

        case "10":
            registro_servicio_cliente();
            break;

        case "11":
            editar_servicio_cliente();
            break;


        case "12":
            eliminar_servicio_cliente();
            break;
    
       case "13":
            load_zona();
            break;
       
        default:
            echo "{failure:true}";
            break;
    }
}



/*=============================================
CARGAR ZONAS
=============================================*/
function load_zona()
{
    $consult       = new ModelCliente();
    $id_usuario    = 1;
    $movements     = $consult->load_zona();

    $resp       = ' <option value=""> -- Seleccionar -- </option> ';
    foreach ($movements as $option) {

        $resp .= " <option value=" . $option["id_zona"]. "> " .$option["nombre_zona"]. " </option>";
    }
    return printf($resp);
}


/*=============================================
REGISTRAR CLIENTE
=============================================*/
function registro_cliente()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelCliente();
    $Global  = new ModelGlobal();

    $data["txt_nombre"]           = $_POST['txt_nombre'];
    $data["txt_identificacion"]   = $_POST['txt_identificacion'];
    $data["txt_direccion"]        = $_POST['txt_direccion'];
    $data["txt_telefono"]         = $_POST['txt_telefono'];
    $data["txt_email"]            = $_POST['txt_email'];
	$data["url_imagen"]           = $_POST['url_imagen'];
    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 7) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->registro_cliente($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}


/*=============================================
TABLE CLIENTES
=============================================*/
function table_clientes()
{ 
	$Consult          = new ModelCliente();
    $movements        = $Consult->table_clientes();
    $file             = array();
    $total_inversion =0;

    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['id']               = $i;
        $dato['Nombre']           =  $data['log_identificacion'].' - '.$data['log_nombre'];
        $dato['Direccion']        =  $data['log_direccion'];
        $concat='';
        if($data['logo']!='nologo'){
            $data['logo']=$data['logo'];
            $concat='<br> <strong><a target="_blank" href="'.$data['logo'].'">Ver Logo</a></strong>';
        } else {
            $concat='';
        }
        $dato['Telefono']         =  '<strong>Email : </strong>'.$data['log_email'].' <br> <strong>Telefono : </strong>'.$data['log_telefono'].$concat;
        $dato['button']        =  '

        <button type="button" log_id ="'.$data['log_id'].'" log_nombre="'.$data['log_nombre'].'" log_identificacion="'.$data['log_identificacion'].'"  class="btn btn-xs btn-success btn_select_servicio_cliente"><acronym title="Cargar Servicios cliente!" lang="es"><i class="fa fa-eye"></i></acronym></button>
                                  <button type="button" log_id="'.$data['log_id'].'" 
                                                       log_nombre="'.$data['log_nombre'].'"
                                                       log_identificacion="'.$data['log_identificacion'].'"
                                                       log_direccion="'.$data['log_direccion'].'"    
                                                       log_telefono="'.$data['log_telefono'].'" 
                                                       log_email="'.$data['log_email'].'"													   
                                                       class="btn btn-xs btn-warning btn_load_edit_cliente"><acronym title="Editar Cliente!" lang="es"><i class="far fa-edit"></i></acronym></button>
                                  <button type="button" log_id ="'.$data['log_id'].'" log_nombre="'.$data['log_nombre'].'" log_identificacion="'.$data['log_identificacion'].'"    class="btn btn-xs btn-danger btn_delete_cliente"><acronym title="Eliminar cliente!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>';
        $file[]               = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}



/*=============================================
VALIDAR IDENTIFICACION
=============================================*/
function validar_identificacion()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelCliente();
    $Global  = new ModelGlobal();

    $data["txt_identificacion"]   = $_POST['txt_identificacion'];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 1) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->validar_identificacion($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}




/*=============================================
EDITAR CLIENTE
=============================================*/
function editar_cliente()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelCliente();
    $Global  = new ModelGlobal();

    $data["txt_id"]               = $_POST['txt_id'];
    $data["txt_nombre"]           = $_POST['txt_nombre'];
    $data["txt_identificacion"]   = $_POST['txt_identificacion'];
    $data["txt_direccion"]        = $_POST['txt_direccion'];
    $data["txt_telefono"]         = $_POST['txt_telefono'];
    $data["txt_email"]            = $_POST['txt_email'];
    $data["url_imagen"]            = $_POST['url_imagen'];
    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 8) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->editar_cliente($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}




/*=============================================
ELIMINAR CLIENTE
=============================================*/
function eliminar_cliente()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelCliente();
    $Global  = new ModelGlobal();

    $data["txt_id"]               = $_POST['txt_id'];
    $data["txt_nombre"]           = $_POST['txt_nombre'];
    $data["txt_identificacion"]   = $_POST['txt_identificacion'];
    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 4) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->eliminar_cliente($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}



/*=============================================
CARGAR UNIDADES
=============================================*/
function load_unidades()
{
    $consult       = new ModelCliente();
    $id_usuario    = 1;
    $movements     = $consult->load_unidades($id_usuario);

    $resp       = ' <option value="0">-- Seleccionar --</option>';
    foreach ($movements as $option) {

        $resp .= " <option value=" . $option["log_id"]. "> " .$option["log_nombre"]. " </option>";
    }
    return printf($resp);
}



/*=============================================
BUSCADOR PREDICTIVO SERVICIOS
=============================================*/
function predictivo_servicios()
{
    
    $Consult    = new ModelCliente();
    $movements  = $Consult->predictivo_servicios($_GET['term']);
    foreach ($movements as $movement) {
        $dato["text"]                     = $movement["text"];
        $dato["id"]                       = $movement["id"];
        $data[]=$dato;
    }
   
    $datax = array('data' => $data);
	echo json_encode($datax);
}



/*=============================================
TABLE SERICIOS CLIENTES
=============================================*/
function table_servicios_clientes()
{ 
	$Consult          = new ModelCliente();
    $movements        = $Consult->table_servicios_clientes($_POST['txt_id']);
    $file             = array();
    $total_inversion =0;

    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['id']            = $i;
        /*$dato['Servicio']      =  $data['log_servicio'];
		$dato['Detalle']       =  $data['ciudad_ini'].' - '.$data['zona'].' - '.$data['ciudad_fin'] ;
        $dato['Unidad']        =  $data['log_unidad'];
        */
        $dato['Precio']        =  '$ '.number_format($data['log_precio'], 3, ',', '.');
        $dato['Descripcion']   =  $data['log_descripcion'];

        $dato['button']        =  '
                                  <button type="button" log_id ="'.$data['log_id'].'" 
                                  log_precio="'.$data['log_precio'].'"
                                  log_descripcion="'.$data['log_descripcion'].'" 
                                  class="btn btn-xs btn-warning btn_load_edit_servicio"><acronym title="Editar tarifa!" lang="es"><i class="far fa-edit"></i></acronym></button>
                                  <button type="button" log_id ="'.$data['log_id'].'" log_precio="'.$data['log_precio'].'"
                                  log_descripcion="'.$data['log_descripcion'].'"  class="btn btn-xs btn-danger btn_delete_servicio"><acronym title="Eliminar tarifa!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>';
        $file[]               = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}





/*=============================================
CARGAR SERVICIOS
=============================================*/
function load_servicios()
{
    $consult       = new ModelCliente();
    $id_usuario    = 1;
    $movements     = $consult->load_servicios();

    $resp       = '';
    foreach ($movements as $option) {

        $resp .= " <option value=" . $option["log_id"]. "> " .$option["log_nombre"]. " </option>";
    }
    return printf($resp);
}



/*=============================================
REGISTRAR SERVICO CLIENTE
=============================================*/
function registro_servicio_cliente()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelCliente();
    $Global  = new ModelGlobal();

    $data["txt_id_cliente"]         = $_POST['txt_id_cliente'];
    /*$data["txt_servicio"]           = $_POST['txt_servicio'];
    $data["txt_ciudad_ini"]         = $_POST['txt_ciudad_ini'];
    $data["txt_ciudad_fin"]         = $_POST['txt_ciudad_fin'];
    $data["txt_zona"]               = $_POST['txt_zona'];
    $data["txt_unidad"]             = $_POST['txt_unidad'];
    */
    $data["txt_precio"]             = $_POST['txt_precio'];
    $data["txt_descripcion"]        = $_POST['txt_descripcion'];
    $data["txt_user"]               = $_SESSION["gb_id_user"];
    $i                              = 1;
    
    $movements  = $Consult->registro_servicio_cliente($data);
    foreach ($movements as $movement) {

        $data["result"]   = $movement["result"];
        $data["error"]    = $movement["error"];
    }
    echo json_encode($data);
}


/*=============================================
EDITAR SERVICO CLIENTE
=============================================*/
function editar_servicio_cliente()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelCliente();
    $Global  = new ModelGlobal();

    $data["txt_id_servicio"]        = $_POST['txt_id_servicio'];
    /*$data["txt_servicio"]           = $_POST['txt_servicio'];
	$data["txt_ciudad_ini"]         = $_POST['txt_ciudad_ini'];
    $data["txt_ciudad_fin"]         = $_POST['txt_ciudad_fin'];
    $data["txt_zona"]               = $_POST['txt_zona'];
    $data["txt_unidad"]             = $_POST['txt_unidad'];*/
    $data["txt_precio"]             = $_POST['txt_precio'];
    $data["txt_descripcion"]        = $_POST['txt_descripcion'];
    $data["txt_user"]               = $_SESSION["gb_id_user"];
    $i                              = 1;

   
    
    $movements  = $Consult->editar_servicio_cliente($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}




/*=============================================
ELIMINAR SERVICIO CLIENTE
=============================================*/
function eliminar_servicio_cliente()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelCliente();
    $Global  = new ModelGlobal();

    $data["txt_id"]               = $_POST['txt_id'];
    //$data["txt_servicio"]         = $_POST['log_servicio'];
    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 4) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->eliminar_servicio_cliente($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}

?>