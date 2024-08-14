<?php
require '../Conexion/conexion_mysqli.php';
include('../control_session.php');
include('../Model/Model_global.php');
include('../Model/Model_usuario.php');
if (isset($_GET["txt_option"]) || isset($_POST["txt_option"])) {

    if (isset($_GET["txt_option"])) {
        $opt = $_GET["txt_option"];
    } else {
        $opt = $_POST["txt_option"];
    }

    switch ($opt) {

        case "1":
            load_categoria();
            break;


        case "2":
            register_user();
            break;


        case "3":
            table_user();
            break;


        case "4":
            edit_user();
            break;

        case "5":
            edit_user();
            break;

        case "6":
            delete_user();
            break;

        default:
            echo "{failure:true}";
            break;
    }
}


/*=============================================
LOAD CATEGORIAS
=============================================*/
function load_categoria()
{
    $consult       = new ModelUsuario();
    $id_usuario    = 1;
    $movements     = $consult->load_categoria($id_usuario);

    $resp       = ' <option value="0">-- Seleccionar --</option>';
    foreach ($movements as $option) {

        $resp .= " <option value=" . $option["gb_id"]. "> " .$option["gb_nombre"]. " </option>";
    }
    return printf($resp);
}


/*=============================================
REGISTER USER
=============================================*/
function register_user()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelUsuario();
    $Global  = new ModelGlobal();

    $data["txt_nombre"]       = $_POST['txt_nombre'];
    $data["txt_usuario"]      = $_POST['txt_usuario'];
    $data["txt_email"]        = $_POST['txt_email'];
    $data["txt_clave"]        = $_POST['txt_clave'];
    $data["txt_categoria"]    = $_POST['txt_categoria'];
    $data["txt_tfno"]    = $_POST['txt_tfno'];
    $data["txt_codvendedor"]    = $_POST['txt_codvendedor'];
    $data["txt_user"]         = $_SESSION["gb_id_user"];
    $i                        = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 10) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->register_user($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}



/*=============================================
TABLE USER
=============================================*/
function table_user()
{ 
	$Consult          = new ModelUsuario();
    $movements        = $Consult->table_user();
    $file             = array();
    $total_inversion =0;

    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['id']            = $i;
        $dato['Nombre']        =  $data['gb_nombre'];
		$dato['usuario']       =  $data['gb_usuario'];
		$dato['telefono']       =  $data['telefono'];
		$dato['cod_vendedor']       =  $data['cod_vendedor'];
		$dato['email']         =  $data['gb_email'];
        $dato['categoria']     =  $data['dp_perfil'];
        $dato['button']        =  '
                                  <button type="button" dp_id="'.$data['gb_id'].'" 
                                  dp_nombre="'.$data['gb_nombre'].'" dp_usuario="'.$data['gb_usuario'].'"
                                  telefono="'.$data['telefono'].'" cod_vendedor="'.$data['cod_vendedor'].'"
                                   dp_email="'.$data['gb_email'].'" dp_perfil="'.$data['dp_id_perfil'].'" dp_clave="'.$data['gb_clave'].'"  class="btn btn-xs btn-warning btn_load_edit_user"><acronym title="Editar usuario!" lang="es"><i class="far fa-edit"></i></acronym></button>
                                  <button type="button" dp_id ="'.$data['gb_id'].'" dp_usuario="'.$data['gb_usuario'].'"   class="btn btn-xs btn-danger btn_delete_user"><acronym title="Eliminar usuario!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>';
        $file[]               = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}



/*=============================================
EDIT USER
=============================================*/
function edit_user()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelUsuario();
    $Global  = new ModelGlobal();

    $data["txt_id_user"]      = $_POST['txt_id_user'];
    $data["txt_nombre"]       = $_POST['txt_nombre'];
    $data["txt_usuario"]      = $_POST['txt_usuario'];
    $data["txt_email"]        = $_POST['txt_email'];
    $data["txt_clave"]        = $_POST['txt_clave'];
    $data["txt_categoria"]    = $_POST['txt_categoria'];
    $data["txt_tfno"]    = $_POST['txt_tfno'];
    $data["txt_codvendedor"]    = $_POST['txt_codvendedor'];
    $data["txt_user"]         = $_SESSION["gb_id_user"];
    $i                        = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 10) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->edit_user($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}



/*=============================================
DELETE USER
=============================================*/
function delete_user()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelUsuario();
    $Global  = new ModelGlobal();

    $data["txt_id"]         = $_POST['txt_id'];
    $data["txt_usuario"]    = $_POST['txt_nombre'];
    $data["txt_user"]       = $_SESSION["gb_id_user"];
    $i                      = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 3) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->delete_user($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}

?>