<?php
require '../Conexion/conexion_mysqli.php';
include('../control_session.php');
include('../Model/Model_gb_global.php');
include('../Model/Model_presupuesto.php');
if (isset($_GET["txt_option"]) || isset($_POST["txt_option"])) {

    if (isset($_GET["txt_option"])) {
        $opt = $_GET["txt_option"];
    } else {
        $opt = $_POST["txt_option"];
    }

    switch ($opt) {

        case "1":
            load_rubro();
            break;
		
		case "2":
            registro_labor();
            break;
			
		case "3":
            table_labor();
            break;
			
		case "4":
            eliminar_labor();
            break;
			
		case "5":
            activar_labor();
            break;
			
		case "6":
            editar_labor();
            break;


        case "7":
            table_historial_precio();
            break;
			

            case "8":
                cargar_n1();
                break;


                case "9":
                    cargar_n2();
                    break;
                    
            case "10":
                cargar_n3();
                break;                
                case "11":
                    table_ventas();
                    break;

        default:
            echo "{failure:true}";
            break;
    }
}



/*=============================================
TABLE HISTORIAL DE PRECIOS
=============================================*/
function table_historial_precio()
{ 
	$Consult          = new ModelLabor();
    $movements        = $Consult->table_historial_precio($_POST['id_labor']);
    $file             = array();

    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['id']                 =  $i;
        $dato['precio_anterior']    =  $data['precio_anterior'];
		$dato['precio_nuevo']  		=  $data['precio_nuevo'];
		$dato['fecha_cambio']       =  'Fecha : '.$data['fecha_nueva'].'<br> Hora : '.$data['hora_actualizacion'];
		$dato['usuario']            =  $data['usuario'];
							
        $file[]                 = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}

/*=============================================
CARGAR GRUPO
=============================================*/
function load_rubro()
{
    $consult       = new ModelLabor();
    $id_usuario    = 1;
    $movements     = $consult->load_rubro();

    $resp       = " <option value= '0'> -- Seleccione una opción -- </option>";
    foreach ($movements as $option) {

        $resp .= " <option value= '". $option["id"]. "'> " .$option["nombre"]. " </option>";
    }
    return printf($resp);
}




/*=============================================
TABLE LABOR
=============================================*/
function table_labor()
{ 
	$Consult          = new ModelLabor();
    $movements        = $Consult->table_labor();
    $file             = array();
 
    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['id']             = $i;
        $dato['labor']          =  $data['labor'];
		$dato['unidad']  		=  $data['unidad'];
		$dato['valorunitario']  =  $data['valorunitario'];
		$dato['rendimiento_semanal'] = $data['rendimiento_semanal'];
		$dato['grupo']          =  $data['grupo'];
		$dato['tipo_labor']     =  $data['tipo_labor'];
		
		if ($data['estado'] == 'A' ){
			
			$dato['button'] =  '  <button type="button" id_labor="'.$data['id_labor'].'" labor="'.$data['labor'].'"
														unidad="'.$data['unidad'].'" valorunitario="'.$data['valorunitario'].'"
														rendimiento_semanal="'.$data['rendimiento_semanal'].'" grupo="'.$data['grupo'].'"
														tipo_labor="'.$data['tipo_labor'].'" 
														class="btn btn-xs btn-warning btn_load_edit_labor" ><acronym title="Editar caja!" lang="es"><i class="far fa-edit"></i></acronym></button>
                                  <button type="button" id_labor ="'.$data['id_labor'].'" labor="'.$data['labor'].'" class="btn btn-xs btn-danger btn_delete_labor"><acronym title="Eliminar caja!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>
                                  
                                  <button type="button" id_labor ="'.$data['id_labor'].'" 
                                  labor="'.$data['labor'].'"   class="btn btn-xs btn-primary 
								btn_historial_precio"><acronym title="historial cambio de precio!" lang="es">
								<i class="fa fa-search-plus" aria-hidden="true"> Hist.</i></acronym></button>';
								  
									}
		else{
			$dato['button'] =  ' <button type="button" id_labor="'.$data['id_labor'].'" labor="'.$data['labor'].'" class="btn btn-xs btn-success btn_activar"><acronym title="Activar labor!" lang="es">Activar</acronym></button>';
			
		}
									
        $file[]                 = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}



/*=============================================
REGISTRAR LABOR
=============================================*/
function registro_labor()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelLabor();
    $Global  = new ModelGlobal();
    
    $data["txt_ano"]     		= $_POST['txt_ano'];
    $data["labor"]     		= $_POST['txt_labor'];
	$data["txt_nivel1"]     	= $_POST['txt_nivel1'];
	$data["txt_nivel2"]  = $_POST['txt_nivel2'];
	$data["txt_nivel3"]  = $_POST['txt_nivel3'];
	$data["mes1"] = $_POST['mes1'];
	$data["mes2"]    			 = $_POST['mes2'];
	$data["mes3"]    		 = $_POST['mes3'];
    $data["mes4"]    		 = $_POST['mes4'];
    $data["mes5"]    		 = $_POST['mes5'];
    $data["mes6"]    		 = $_POST['mes6'];
    $data["mes7"]    		 = $_POST['mes7'];
    $data["mes8"]    		 = $_POST['mes8'];
    $data["mes9"]    		 = $_POST['mes9'];
    $data["mes10"]    		 = $_POST['mes10'];
    $data["mes11"]    		 = $_POST['mes11'];
    $data["mes12"]    		 = $_POST['mes12'];
    $data["txt_user"]            = $_SESSION["gb_id_user"];
    $i                           = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 30) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->registro_labor($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}


/*=============================================
ELIMINAR LABOR
=============================================*/
function eliminar_labor()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelLabor();
    $Global  = new ModelGlobal();

    $data["txt_id"]       = $_POST['txt_id'];
    $data["txt_user"]     = $_SESSION["gb_id_user"];
    $i                    = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 3) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->eliminar_labor($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}



/*=============================================
ACTIVAR LABOR
=============================================*/
function activar_labor()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelLabor();
    $Global  = new ModelGlobal();

    $data["txt_id"]       = $_POST['txt_id'];
    $data["labor"]        = $_POST['labor'];
    $data["txt_user"]     = $_SESSION["gb_id_user"];
    $i                    = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 3) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->activar_labor($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}




/*=============================================
EDITAR LABOR
=============================================*/
function editar_labor()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelLabor();
    $Global  = new ModelGlobal();
	
    $data["txt_id"]              = $_POST['txt_id'];
    $data["mes1"] = $_POST['mes1'];
	$data["mes2"]    			 = $_POST['mes2'];
	$data["mes3"]    		 = $_POST['mes3'];
    $data["mes4"]    		 = $_POST['mes4'];
    $data["mes5"]    		 = $_POST['mes5'];
    $data["mes6"]    		 = $_POST['mes6'];
    $data["mes7"]    		 = $_POST['mes7'];
    $data["mes8"]    		 = $_POST['mes8'];
    $data["mes9"]    		 = $_POST['mes9'];
    $data["mes10"]    		 = $_POST['mes10'];
    $data["mes11"]    		 = $_POST['mes11'];
    $data["mes12"]    		 = $_POST['mes12'];
    $data["txt_user"]            = $_SESSION["gb_id_user"];
    $i                           = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 15) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->editar_labor($data);
    foreach ($movements as $movement) {

        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
    }
    echo json_encode($dato);
}





/*=============================================
CARGAR GRUPO
=============================================*/
function cargar_n1()
{
    $consult       = new ModelLabor();
    $id_usuario    = 1;
    $data            = $_POST['idn0'];
    $data2            = $_POST['dato1'];

    $movements     = $consult->cargar_n1($data,$data2);

    $resp       = " <option value= '0'> -- Seleccione una opción -- </option>";
    foreach ($movements as $option) {

        $resp .= " <option value= '". $option["id"]. "'> " .$option["nombre"]. " </option>";
    }
    return printf($resp);
}


/*=============================================
CARGAR GRUPO
=============================================*/
function cargar_n2()
{
    $consult       = new ModelLabor();
    $id_usuario    = 1;
    $data            = $_POST['idn0'];

    $movements     = $consult->cargar_n2($data);

    $resp       = " <option value= '0'> -- Seleccione una opción -- </option>";
    foreach ($movements as $option) {

        $resp .= " <option value= '". $option["mt_id"]. "'> " .$option["mt_nombre"]. " </option>";
    }
    return printf($resp);
}


/*=============================================
CARGAR GRUPO
=============================================*/
function cargar_n3()
{
    $consult       = new ModelLabor();
    $id_usuario    = 1;
    $data            = $_POST['idn0'];

    $movements     = $consult->cargar_n3($data);

    $resp       = " <option value= '0'> -- Seleccione una opción -- </option>";
    foreach ($movements as $option) {

        $resp .= " <option value= '". $option["mt_id"]. "'> " .$option["mt_nombre"]. " </option>";
    }
    return printf($resp);
}



/*=============================================
TABLE LABOR
=============================================*/
function table_ventas()
{ 
	$Consult          = new ModelLabor();
    $data            = $_POST['idn0'];
    $data2            = $_POST['dato1'];

    $movements        = $Consult->table_ventas($data,$data2);
    $file             = array();
 
    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['id']             = $i;


        $dato['id_presupuesto']  =$data['id_presupuesto'];
        $dato['enero']  =$data['enero'];
        $dato['febrero']  =$data['febrero'];
        $dato['marzo'] =$data['marzo'];
        $dato['abril']  =$data['abril'];
        $dato['mayo']  =$data['mayo'];
        $dato['junio']  =$data['junio'];
        $dato['julio']  =$data['julio'];
        $dato['agosto']  =$data['agosto'];
        $dato['septiembre']  =$data['septiembre'];
        $dato['octubre']  =$data['octubre'];
        $dato['noviembre']  =$data['noviembre'];
        $dato['diciembre']  =$data['diciembre'];
        $dato['nombre']  =$data['nombre'];
        
		
		if ($data['estado'] == 1){
			
			$dato['button'] = '  <button type="button" id_labor="'.$data['id_presupuesto'].'"  enero="'.$data['enero'].'" 
            febrero="'.$data['febrero'].'"  marzo="'.$data['marzo'].'"  abril="'.$data['abril'].'" 
            mayo="'.$data['mayo'].'"  junio="'.$data['junio'].'"  julio="'.$data['julio'].'" id_tienda="'.$data['id_tienda'].'" 
            agosto="'.$data['agosto'].'"  septiembre="'.$data['septiembre'].'"  octubre="'.$data['octubre'].'" 
            noviembre="'.$data['noviembre'].'"  diciembre="'.$data['diciembre'].'"  nombre="'.$data['nombre'].'"  
            class="btn btn-xs btn-warning btn_load_edit_labor" ><acronym title="Editar!" lang="es"><i class="far fa-edit"></i></acronym></button>
<button type="button"  id_labor="'.$data['id_presupuesto'].'"  nombre="'.$data['nombre'].'"   class="btn btn-xs btn-danger btn_delete_labor"><acronym title="Eliminar !" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>

';
            
            /* '  <button type="button" id_labor="'.$data['id_labor'].'" labor="'.$data['labor'].'"
														unidad="'.$data['unidad'].'" valorunitario="'.$data['valorunitario'].'"
														rendimiento_semanal="'.$data['rendimiento_semanal'].'" grupo="'.$data['grupo'].'"
														tipo_labor="'.$data['tipo_labor'].'" 
														class="btn btn-xs btn-warning btn_load_edit_labor" ><acronym title="Editar caja!" lang="es"><i class="far fa-edit"></i></acronym></button>
                                  <button type="button" id_labor ="'.$data['id_labor'].'" labor="'.$data['labor'].'" class="btn btn-xs btn-danger btn_delete_labor"><acronym title="Eliminar caja!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>
                                  
                                  <button type="button" id_labor ="'.$data['id_labor'].'" 
                                  labor="'.$data['labor'].'"   class="btn btn-xs btn-primary 
								btn_historial_precio"><acronym title="historial cambio de precio!" lang="es">
								<i class="fa fa-search-plus" aria-hidden="true"> Hist.</i></acronym></button>';
								  */
									}
		else{
			$dato['button'] ='';//  ' <button type="button" id_labor="'.$data['id_labor'].'" labor="'.$data['labor'].'" class="btn btn-xs btn-success btn_activar"><acronym title="Activar labor!" lang="es">Activar</acronym></button>';
			
		}
									
        $file[]                 = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}


