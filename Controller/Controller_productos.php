<?php
require '../Conexion/conexion_mysqli.php';
include('../control_session.php');
include('../Model/Model_gb_global.php');
include('../Model/Model_productos.php');
if (isset($_GET["txt_option"]) || isset($_POST["txt_option"])) {

    if (isset($_GET["txt_option"])) {
        $opt = $_GET["txt_option"];
    } else {
        $opt = $_POST["txt_option"];
    }

    switch ($opt) {

        case "1":
            register_cadena();
            break;

        case "2":
            table_cadenas();
            break;

        case "3":
            edit_cadena();
            break;

        case "4":
            disabled_cadena();
            break;

        case "5":
            enabled_cadena();
            break;

        case "6":
            table_tiendas();
            break;

        case "7":
            register_tienda();
            break;

        case "8":
            edit_tienda();
            break;

        case "9":
            disabled_tienda();
            break;

        case "10":
            enabled_tienda();
            break;
            case "11":
                cargar_vendedores();
                break;


        default:
            echo "{failure:true}";
            break;
    }
}



/*=============================================
REGISTER CADENA
=============================================*/
function register_cadena()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelParametrizacion();
    $Global  = new ModelGlobal();

    $data["txt_nombre_cadena"]    = $_POST['txt_nombre_cadena'];
    $data["txt_codigoproducto"]    = $_POST['txt_codigoproducto'];
    $data["txt_nombreproducto"]    = $_POST['txt_nombreproducto'];
    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 6) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->registrar_cadena($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}


/*=============================================
TABLE CADENAS
=============================================*/
function table_cadenas()
{ 
	$Consult          = new ModelParametrizacion();
    $movements        = $Consult->table_cadenas();
    $file             = array();
    $total_inversion =0;

    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['idx']            = $i;
        $dato['id']        =  $data['nombre'];
        $dato['nombre']        =  $data['nombre'];

        $dato['button']        =  '
        <button type="button" pr_id ="'.$data['id'].'" pr_nombre="'.$data['nombre'].'"   class="btn btn-xs btn-danger btn_delete_cadena"><acronym title="Deshabilitar Producto!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>';

        /*
        if($data['estatus'] == 1)
        {
             }
        else
        {
            $dato['button'] = '<acronym title="Activar cadena" lang="es"><button type="button" pr_id ="' . $data['id'] . '" pr_nombre="'.$data['nombre'].'" class="btn btn-sm btn-danger btn_activar_cadena">Inactivo</button></acronym>';
        }
*/
        
        $file[]               = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}


/*=============================================
EDIT CADENA
=============================================*/
function edit_cadena()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelParametrizacion();
    $Global  = new ModelGlobal();

    $data["txt_id_cadena"]        = $_POST['txt_id_cadena'];
    $data["txt_nombre_cadena"]    = $_POST['txt_nombre_cadena'];
    $data["txt_ciudad_cadena"]    = $_POST['txt_ciudad_cadena'];
    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 5) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->editar_cadena($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}


/*=============================================
DESACTIVAR CADENA
=============================================*/
function disabled_cadena()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelParametrizacion();
    $Global  = new ModelGlobal();

    $data["txt_id"]        = $_POST['txt_id'];
    $data["txt_nombre"]    = $_POST['txt_nombre'];
    $data["txt_user"]      = $_SESSION["gb_id_user"];
    $i                     = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 4) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->disabled_cadena($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}


/*=============================================
ACTIVAR CADENA
=============================================*/
function enabled_cadena()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelParametrizacion();
    $Global  = new ModelGlobal();

    $data["txt_id"]        = $_POST['txt_id'];
    $data["txt_nombre"]    = $_POST['txt_nombre'];
    $data["txt_user"]      = $_SESSION["gb_id_user"];
    $i                     = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 4) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->enabled_cadena($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}


/*=============================================
TABLE TIENDAS
=============================================*/
function table_tiendas()
{ 
	$Consult          = new ModelParametrizacion();
    $movements        = $Consult->table_tiendas($_POST['txt_id']);
    $file             = array();
    $total_inversion =0;

    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['id']            = $i;
        $dato['cadena']        =  $data['cadena'];
        $dato['nombre']        =  $data['nombre'];
        $dato['ciudad']        =  $data['ciudad'];
        $dato['direccion']     =  $data['direccion'];
        $dato['gb_nombre']     =  $data['gb_nombre'];
        $dato['pr_vendedor']     =  $data['pr_vendedor'];
        $dato['fecha']         =  $data['fecha_registro'];
        

        if($data['estatus'] == 1)
        {
            $dato['button']        =  '
                                  <button type="button" pr_id="'.$data['id'].'" pr_cadena="'.$data['cadena'].'"  pr_vendedor="'.$data['pr_vendedor'].'" pr_nombre="'.$data['nombre'].'" pr_ciudad ="'.$data['ciudad'].'" pr_direccion ="'.$data['direccion'].'"   class="btn btn-xs btn-warning btn_load_edit_tienda"><acronym title="Editar tienda!" lang="es"><i class="far fa-edit"></i></acronym></button>
                                  <button type="button" pr_id ="'.$data['id'].'" pr_cadena="'.$data['cadena'].'" pr_nombre="'.$data['nombre'].'"   class="btn btn-xs btn-danger btn_delete_tienda"><acronym title="Deshabilitar cadena!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>';
        }
        else
        {
            $dato['button'] = '<acronym title="Activar cadena" lang="es"><button type="button" pr_id ="' . $data['id'] . '" pr_cadena="'.$data['cadena'].'" pr_nombre="'.$data['nombre'].'" class="btn btn-sm btn-danger btn_activar_tienda">Inactivo</button></acronym>';
        }

        
        $file[]               = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}

/*=============================================
REGISTER TIENDA
=============================================*/
function register_tienda()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelParametrizacion();
    $Global  = new ModelGlobal();

    $data["txt_pr_id_cadena"]     = $_POST['txt_pr_id_cadena'];
    $data["txt_nombre_tienda"]    = $_POST['txt_nombre_tienda'];
    $data["txt_ciudad_tienda"]    = $_POST['txt_ciudad_tienda'];
    $data["txt_direccion_tienda"] = $_POST['txt_direccion_tienda'];
    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 5) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->register_tienda($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}

/*=============================================
EDIT TIENDA
=============================================*/
function edit_tienda()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelParametrizacion();
    $Global  = new ModelGlobal();

    $data["txt_id_tienda"]        = $_POST['txt_id_tienda'];
    $data["txt_nombre_tienda"]    = $_POST['txt_nombre_tienda'];
    $data["txt_ciudad_tienda"]    = $_POST['txt_ciudad_tienda'];
    $data["txt_direccion_tienda"] = $_POST['txt_direccion_tienda'];
    $data["txt_vendedor_cadena"] = $_POST['txt_vendedor_cadena'];
    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                            = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 8) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->edit_tienda($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}



/*=============================================
DESACTIVAR TIENDA
=============================================*/
function disabled_tienda()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelParametrizacion();
    $Global  = new ModelGlobal();

    $data["txt_id"]        = $_POST['txt_id'];
    $data["txt_nombre"]    = $_POST['txt_nombre'];
    $data["txt_user"]      = $_SESSION["gb_id_user"];
    $i                     = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 4) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->disabled_tienda($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}


/*=============================================
ACTIVAR TIENDA
=============================================*/
function enabled_tienda()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelParametrizacion();
    $Global  = new ModelGlobal();

    $data["txt_id"]        = $_POST['txt_id'];
    $data["txt_nombre"]    = $_POST['txt_nombre'];
    $data["txt_user"]      = $_SESSION["gb_id_user"];
    $i                     = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 4) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->enabled_tienda($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}


/*=============================================
CARGAR CADENAS
=============================================*/
function cargar_vendedores()
{
    $consult       = new ModelParametrizacion();
    $id_usuario    = 1;
    $movements     = $consult->cargar_vendedores();

    $resp       = ' <option value="">--Seleccionar--</option>';
    foreach ($movements as $option) {

        $resp .= " <option value=" . $option["gb_id"]. "> "  .$option["gb_nombre"]. " </option>";
    }
    return printf($resp);
}
