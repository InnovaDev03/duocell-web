<?php
require '../Conexion/conexion_mysqli.php';
include('../control_session.php');
include('../Model/Model_gb_global.php');
include('../Model/Model_rv_consulta.php');
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

        case "6":
            eliminar_oc();
            break;

        case "7":
            table_venta();
            break;

        case "8":
            agregar_item();
            break;

        case "10":
            eliminar_item();
            break;
        case "12":
            serarch_stockproductos();
            break;

        case "13":
            editar_cantidad();
            break;

        case "15":
            table_reserva_bitacora();
            break;

        case "16":
            bodegas_consignacion();
            break; 
			
			
			case "17":
                    validar_reserva();
                    break;

    }
}
/*=============================================
BUSCADOS PREDICTIVO PROMOTOR
=============================================*/
function serarch_promotor()
{
    
    $Consult    = new ModelOcCounsulta();
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
	$Consult   = new ModelOcCounsulta();
	$txt_promotor = '';
	
	if(isset($_POST['txt_cadena']))
	{
		$txt_cadena	= $_POST['txt_cadena'];
	}
	$data['txt_fechain']      = $_POST["txt_fechain"];
    $data['txt_fechafin']	  = $_POST["txt_fechafin"];
    $data['txt_cadena']	      = $_POST["txt_cadena"];
    $data['txt_promotor']	  = $_POST["txt_promotor"];
    $data['txt_estado']	 	  = $_POST["txt_estado"];
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
        $dato['oc_fecha']	        =  $data['oc_fecha'];
        $dato['numoc']	        =  $data['oc_id'];
		$dato['cliente']	    =  $data['cliente'];
		$dato['ocs']	    =  $data['ocs'];
        $dato['oc_observaciones']	        =  $data['oc_observaciones'];
        $dato['item']  =	 $data['item'];
        $dato['vendedor']	        =  $data['vendedor'];
        $dato['cantidad_rv']	        =  $data['cantidad_rv'];

        $id_cliente            = explode('-',$data['cliente']);
        $dato['canal']	        =  $data['canal'];
        $dato['subcanal']	        =  $data['subcanal'];
        $dato['id_cliente']	        =  $id_cliente[0];
        
       
        
       /* if ($data['estatus_oc']==1){
            $dato['oc_estatus']	        =  'Ingresado';
        } 
        /*if ($data['estatus_oc']==2){
            $dato['oc_estatus'] = 'Aprobado';//'Aprobación Crédito';
        } if ($data['estatus_oc']==3){
            $dato['oc_estatus']	        =  'Aprobado';//'Aprobación Gerencia';
        } if ($data['estatus_oc']==4){
            $dato['oc_estatus']	        =  'Despachado';
        }
        
     /*  $dato['precio']		    =  number_format($data['precio'], 2, '.', ',');
        $dato['cantidad']		=  $data['cantidad'];
        $dato['item']	        =  $data['item'];
*/
      $dato['forma_pago']		=  $data['forma_pago'];
        //$dato['total']	        =  number_format($data['total'], 2, '.', ',');
        $dato['button'] = '';

/*
        if ($_SESSION["gb_perfil"]==4){
            //APROBACION
            if ($data['estatus_oc'] == 1) {
                $dato['button'] = '  
                <button type="button" dato="'.$data['estatus_oc'].'" mt_id ="' . $data['oc_detalle'] . '"  mt_nombre ="' . $data['numoc'] . '"  class="btn btn-xs btn-danger btn_delete_sistema"><acronym title="Eliminar orden de compra!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>
            ';
            } else {
                $dato['button'] = '  
                <button type="button"  dato="'.$data['estatus_oc'].'"  disabled mt_id ="' . $data['oc_detalle'] . '" class="btn btn-xs btn-danger btn_delete_sistema"><acronym title="Eliminar orden de compra!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>
            ';
            }
                 
        }else {
        }
*/

        $dato['button'] = '    <button type="button"  
        canal ="' . $data['canal'] . '" 
		dias ="' . $data['dias'] . '" 
        subcanal ="' . $data['subcanal'] . '" 
        id_cliente ="' . $id_cliente[0] . '" 
        numoc ="' . $data['numoc'] . '"   oc_observaciones ="' . $data['oc_observaciones'] . '"
        cliente ="' . $dato['cliente'] . '"  oc_fecha ="' . $data['oc_fecha'] . '"  formapago ="' . $data['forma_pago'] . '" 
          class="btn btn-xs btn-secondary btn_ver_items"><acronym title="Crear OC" lang="es"><i class="fa fa-search" aria-hidden="true"></i></acronym></button>';
      
       // $pr_total = $data['total'] + $pr_total;
        $totalRecords = $data['totalRecords'];
		$file[]               = $dato;
    }
    $dato['button']        =  '';
    $dato['id'] = $i+1;
    $dato['oc_fecha']	        =  '';
    $dato['numoc']		= '';
    $dato['cliente']	        =  '';
    $dato['oc_observaciones']	        = '';
    $dato['vendedor']	        ='';
    $dato['ocs']	        ='';
    $dato['estatus_oc']='';
    $dato['item']  ='';
    $dato['cantidad_rv']  ='';
    
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
	$Consult          = new ModelOcCounsulta();
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
    $consult       = new ModelOcCounsulta();
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
    $Consult = new ModelOcCounsulta();
    $Global  = new ModelGlobal();

    $data["txt_id_edit"]              = $_POST['txt_id_edit'];
    $data["tipo"]              = $_POST['tipo'];
    $data["txt_obs_gerencia"]              = $_POST['txt_obs_gerencia'];
    $data["valorimgf"]              = $_POST['valorimgf'];
    
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
ELIMINAR GUÍA
=============================================*/
function eliminar_oc()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelOcCounsulta();
    $Global  = new ModelGlobal();

    $data["txt_id"]         = $_POST['txt_id'];
    $data["txt_nombre"]     = $_POST['txt_nombre'];
    $data["txt_user"]       = $_SESSION["gb_id_user"];
    $i                      = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 3) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->eliminar_oc($data);
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
TABLE VENTA
=============================================*/
function table_venta()
{ 
	$Consult          = new ModelOcCounsulta();
    $movements        = $Consult->table_venta($_REQUEST["ordencompra"]);
    $file             = array();
    $total_inversion =0;

    $i            = 0;
    foreach ($movements as $data) {

        $i++;
        $dato['id']            = $i;


        $dato['item']          =  $data['item'];//.'<br>'.$imei;

         $dato['descripcion']        =  $data['descripcion'];    

         $item = $data['item'];;
        if($_SESSION["gb_perfil"] == 4)
        {
            $dato['precio'] = '<input style="width:70px" type="text" readonly value ="' . htmlspecialchars($data['precio']) . '" id="precionuevo'.$i.'" name="precionuevo[]" oninput="this.value = this.value.replace(/[^0-9.]/g, \'\'); this.value = this.value.replace(/(\..*)\./g, \'$1\');">';
            $dato['cantidad'] = '<input class="cantidadnueva'.$i.'" style="width:60px" type="text" value ="0" id="cantidadnueva" name="cantidadnueva[]" oninput="this.value = this.value.replace(/[^0-9]/g, \'\');buscarprecio1('.$i.');valdiar_cantidad(this.value,'.$data['cantidad'].','.$i.');">
            <input style="width:60px" type="hidden" value ="'.$data['id'].'"  name="iditem[]">
            <input style="width:60px" type="hidden" value ="'.$item.'"  name="id_item'.$i.'" id="id_item'.$i.'" >';
        }
        else
        {
            $dato['precio'] = '<input style="width:70px" type="text" value ="' . htmlspecialchars($data['precio']) . '" id="precionuevo'.$i.'" name="precionuevo[]" oninput="this.value = this.value.replace(/[^0-9.]/g, \'\');  this.value = this.value.replace(/(\..*)\./g, \'$1\');">';
            $dato['cantidad'] = '<input class="cantidadnueva'.$i.'" style="width:60px" type="text" value ="0" id="cantidadnueva" name="cantidadnueva[]" oninput="this.value = this.value.replace(/[^0-9]/g, \'\');buscarprecio1('.$i.');valdiar_cantidad(this.value,'.$data['cantidad'].','.$i.');" >
            <input style="width:60px" type="hidden" value ="'.$data['id'].'"  name="iditem[]"   >
            <input style="width:60px" type="hidden" value ="'.$item.'"  name="id_item'.$i.'" id="id_item'.$i.'" >';
        }
       
       
       
        //$dato['precio']        =  '<input style="width:70px" type="text" value ="'.$data['precio'].'" id="precionuevo"  name="precionuevo[]" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">';    
        $dato['cantidad2']        =  $data['cantidad'];


       


       
        
        $dato['id_ordencompra']        =  $data['id_ordencompra'];
      
       /*        
        if ( $_SESSION["gb_perfil"]==6){
if ($data['oc_estatus']<5){
    $dato['button']        = '<button type="button" dato="'.$data['oc_estatus'].'"  id_ordencompra ="'.$data['id_ordencompra'].'"  total_oc ="'.$data['oc_total'].'"   total_item ="'.$data['total'].'"  pr_item ="'.$data['item'].'" pr_id ="'.$data['id'].'"    class="btn btn-xs btn-danger btn_delete_item"><acronym title="Borrar item!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>
    <button type="button"   descuento="'.$data['descuento'].'"   dato="'.$data['oc_estatus'].'"  id_ordencompra ="'.$data['id_ordencompra'].'"  precio ="'.$data['precio'].'"  total_oc ="'.$data['oc_total'].'"   total_item ="'.$data['total'].'"  pr_item ="'.$data['item'].'" pr_id ="'.$data['id'].'"   class="btn btn-xs btn-warning btn_edit_cantidad"><acronym title="Actualizar" lang="es"><i class="fa fa-check" aria-hidden="true"></i></acronym></button>
    ';

} else {
    $dato['button']        = '<button disabled type="button"  descuento="'.$data['descuento'].'"   dato="'.$data['oc_estatus'].'"  id_ordencompra ="'.$data['id_ordencompra'].'"  total_oc ="'.$data['oc_total'].'"   total_item ="'.$data['total'].'"  pr_item ="'.$data['item'].'" pr_id ="'.$data['id'].'"    class="btn btn-xs btn-danger btn_delete_item"><acronym title="Borrar item!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>';

    }
    } else {
            $dato['button'] = '';
    }
    */
    $dato['button'] = '    <button type="button" producto ="' . $data['descripcion'] . '" id_reserva ="' . $data['id'] . '" class="btn btn-xs btn-secondary btn_ver_bitacora"><acronym title="Bitacora Reserva" lang="es"><i class="fa fa-search" aria-hidden="true"></i></acronym></button>';
 
        $file[]               = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}




/*=============================================
AGREGRAR ITEM
=============================================*/
function agregar_item()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelOcCounsulta();
    $Global  = new ModelGlobal();

    $data["txt_id"]        = $_POST['txt_id'];
    $data["txt_text"]      = $_POST['txt_text'];
    $data["txt_precio"]    = $_POST['txt_precio'];
    $data["txt_cantidad"]  = $_POST['txt_cantidad'];
    $data["txt_descuento"]  = $_POST['txt_descuento'];
    $data["txt_direntrega"]  = $_POST['txt_direntrega'];
    $data["id_guia"]  = $_POST['id_guia'];
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
ELIMINAR IMEI
=============================================*/
function eliminar_item()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelOcCounsulta();
    $Global  = new ModelGlobal();

    $data["txt_id"]          = $_POST['txt_id'];
    $data["txt_id_item"]     = $_POST['txt_id_item'];
    $data["id_ordencompra"]     = $_POST['id_ordencompra'];

    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                       = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 5) {
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
EDIT CANTIDAD
=============================================*/
function editar_cantidad()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelOcCounsulta();
    $Global  = new ModelGlobal();

    $data["txt_codigo"]             = $_POST['txt_codigo'];
    $data["txt_fecha"]              = $_POST['txt_fecha'];
    $data["cliente_edit"]           = $_POST['cliente_edit'];
    $data["cliente_edit_fact"]      = $_POST['cliente_edit_fact'];
    $data["txt_observaciones"]      = $_POST['txt_observaciones'];
    $data["iditem"]                 = $_POST['iditem'];
    $data["cantidadnueva"]          = $_POST['cantidadnueva'];
    $data["precionuevo"]            = $_POST['precionuevo'];
    $data["txt_formapago"]          = $_POST['txt_formapago'];
	$data["txt_dias"]          = $_GET['txt_dias'];
    if(isset($_REQUEST['bodega']))
    {
        $data["txt_bodega"]          = $_REQUEST['bodega'];
    }
    else
    {
        $data["txt_bodega"]          = '';
    }
    $data["txt_user"]               = $_SESSION["gb_id_user"];
    $data["cancelar"]               = $_REQUEST["cancelar"];
    $i                              = 1;

    foreach ($data as $key => $value) {
      /*  $data[$key] = $mysqli->real_escape_string($data[$key]);
        /*if ($i > 7) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;*/
    }
    
    $movements  = $Consult->editar_cantidad($data);
  
}


/*=============================================
CANCELAR ORDEN
=============================================*/
function cancelar_orden()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelOcCounsulta();
    $Global  = new ModelGlobal();

    $data["txt_id_edit"]              = $_POST['txt_id_edit'];
    $data["txt_user"]         = $_SESSION["gb_id_user"];
    $i                        = 1;

    foreach ($data as $key => $value) {
      /*  $data[$key] = $mysqli->real_escape_string($data[$key]);
        /*if ($i > 7) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;*/
    }
    
    $movements  = $Consult->cancelar_orden($data);
  
}


/*=============================================
TABLE RESERVA BITACORA
=============================================*/
function table_reserva_bitacora()
{ 
	$Consult          = new ModelOcCounsulta();
    $movements        = $Consult->table_reserva_bitacora($_REQUEST["txt_id_reserva"]);
    $file             = array();
    $total_inversion =0;

    $i            = 0;
    foreach ($movements as $data) {
        $i++;
        $dato['id']            = $i;
        if($data['tipo'] == 1)
        {
            $dato['tipo']          =  'Liberar Inventario';
        }
        if($data['tipo'] == 2)
        {
            $dato['tipo']          =  'Crear orden de compra';
        }
        if($data['tipo'] == 3)
        {
            $dato['tipo']          =  'Consignacion';
        }
        $dato['cantidad']          =  $data['cantidad']; 
        $dato['fecha']             =  $data['fecha'];
        $dato['usuario']           =  $data['usuario'];
        $dato['bodega']            =  $data['bodega'];
        $file[]                    = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}


/*=============================================
CARGAR BODEGAS A CONSIGNACION
=============================================*/
function bodegas_consignacion()
{
    $Consult    = new ModelPg();
    $id_usuario    = 1;
    $movements     = $Consult->bodegas_consignacion();
    $resp       = ' <option value="12">GUAYAQUIL</option>';
    foreach ($movements as $option) {

        $resp .= " <option value=" . $option["codigo"]. ">".$option["nombre"]."</option>";
    }
    return printf($resp);
}


/*=============================================
VALIDAR RESERVA
=============================================*/
function validar_reserva()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelOcCounsulta();
    $Global  = new ModelGlobal();

    $data['txt_reserva']=$_REQUEST["txt_reserva"];
    $movements  = $Consult->validar_reserva($data);
    foreach ($movements as $movement) {
		
        $dato["result"]                     = $movement["result"];
        $dato["oc_id"]                      = $movement["oc_id"];
		$dato["id_cliente"]                 = $movement["id_cliente"];
		$dato["dias"]                       = $movement["dias"];
		$dato["oc_fecha"]                   = $movement["oc_fecha"];
		$dato["oc_forma_pago"]              = $movement["oc_forma_pago"];
		$dato["oc_observaciones"]           = $movement["oc_observaciones"];

        $dato["canal"]           = $movement["canal"];
        $dato["subcanal"]           = $movement["subcanal"];

    }
    echo json_encode($dato);
    
}