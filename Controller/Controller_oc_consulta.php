<?php
require '../Conexion/conexion_mysqli.php';
include('../control_session.php');
include('../Model/Model_gb_global.php');
include('../Model/Model_oc_consulta.php');
include('../Model/Model_oc_registro.php');

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

        case "14":
            editar_estado_cobranza_bodega();
            break; 


        case "15":
            table_orden_bitacora();
            break;

            case "16":
                estado_orden();
                break;
    
    case "17":
            descargar_ride();
            break;

    }
}


function descargar_ride()
    {
        $txt_factura = $_POST['txt_factura'];
    
        // Ruta del archivo en el servidor local
        $archivoLocal = "/mnt/samba_share/FE_STARTCOM/DUOCELL/Autorizados/FACTURA_{$txt_factura}.PDF";
    
        // Verificar si el archivo existe
        if (!file_exists($archivoLocal)) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['result' => 0, 'error' => 'Archivo no encontrado: '."FACTURA_{$txt_factura}.PDF"]);
            exit;
        }
    
        // Nombre del archivo que se enviará al usuario
        $nombreArchivo = 'FACTURA' . $txt_factura . '.pdf';
    
        // Establecer los encabezados para forzar la descarga
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
        header('Content-Length: ' . filesize($archivoLocal));
    
        // Limpiar el búfer de salida y desactivar la compresión de salida
        ob_clean();
        flush();
    
        // Leer y enviar el archivo al navegador
        readfile($archivoLocal);
        echo json_encode(['result' => 1, 'error' => '']);
        exit;
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
    $data['txt_pagoC']	 	  = $_POST["txt_pagoC"];
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
        $dato['oc_detalle']	        =  $data['oc_detalle'];
        $dato['oc_observaciones']	        =  $data['oc_observaciones'];
        $dato['oc_estatus2']	        =  $data['oc_estatus2'];

        $dato['vendedor']	        =  $data['vendedor'];
        if ($data['estatus_oc']==1){
            $dato['oc_estatus']	        =  'INGRESADO';
        } if ($data['estatus_oc']==2){
            $dato['oc_estatus'] = 'APROBADO';//'Aprobación Crédito';
        } if ($data['estatus_oc']==3){
            $dato['oc_estatus']	        =  'Rechazado';//'Aprobación Gerencia';
        } if ($data['estatus_oc']==4){
            $dato['oc_estatus']	        =  'DESPACHADO';
        }
        
     /*  $dato['precio']		    =  number_format($data['precio'], 2, '.', ',');
        $dato['cantidad']		=  $data['cantidad'];
        $dato['item']	        =  $data['item'];
*/
        if($data['dias_credito'] == '' OR $data['dias_credito'] == NULL)
        {
                $dias_credito =0;
        }
        else
        {
            $dias_credito =$data['dias_credito'];
        }
        $dato['forma_pago']		=  $data['forma_pago'].'<br> Dias Credito : '.$dias_credito;
        $dato['total']	        =  number_format($data['total'], 2, '.', ',');
        $dato['factura']	    =  $data['factura'];
        $dato['button'] = '';

        $orden = 'ORDEN : '.$data['numoc'].' CLIENTE : '.$data['cliente'];

        //VENDEDOR 
        if ($_SESSION["gb_perfil"]==4){
    

            if ($data['estatus_oc'] == 3) {

                $dato['button'] = '';
            }
            else
            {

            

            if ($data['estatus_oc'] == 1 or $data['estatus_oc'] == 6) {

                    
                $accion ='';
                    $titulo_facturacion = 'Por Facturar';
                    if($data['factura'] =='')
                    {
                       
                        $button = '  
                        <button type="button" dato="'.$data['estatus_oc'].'" mt_id ="' . $data['oc_detalle'] . '"  mt_nombre ="' . $data['numoc'] . '"  class="btn btn-xs btn-danger btn_delete_sistema"><acronym title="Eliminar orden de compra!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button> '.$accion;
                    }
                    else
                    {
                        $titulo_facturacion = 'Facturado';
                        $dato['button'] = '';
                    }

                    
                    if ($data['oc_forma_pago'] == 'CONTADO') {

                        if ($data['bodega_facturado'] == 0) {
                           
                        }
                        if ($data['bodega_facturado'] == 1) {
                            $accion= '<button type="button"  dato="'.$data['estatus_oc'].'"  log_id ="'.$data['oc_detalle'].'" tipo=2 class="btn btn-xs btn-warning btn_edit_estado_bodega"><acronym title="Facturacion" lang="es"><i class="fa fa-shopping-cart"></i></acronym></button>';
                        }
                        if ($data['bodega_facturado'] == 2) {
                             $accion = '<button type="button"  dato="'.$data['estatus_oc'].'"  disabled log_id ="' . $data['oc_detalle'] . '" tipo=0  class="btn btn-xs btn-success btn_edit_estado_bodega"><acronym title="'.$titulo_facturacion.'" lang="es"><i class="fa fa-shopping-cart"></i></acronym></button>';
                        }
                        
                    }
                    else
                    {
                        $accion ='';
                    }

                    $dato['button'] =  $button.$accion;
               
            } else {


                if($data['factura'] =='')
                    {
                        $dato['button'] = '  
                <button type="button"  dato="'.$data['estatus_oc'].'"  disabled mt_id ="' . $data['oc_detalle'] . '" class="btn btn-xs btn-danger btn_delete_sistema"><acronym title="Eliminar orden de compra!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>';
                    }
                    else{

                        $dato['button'] = '';
                    }

                
            }

        }
                 
        }else {

        }

        
        


        /// COBRANZA
        if ($_SESSION["gb_perfil"]==5){


            if ($data['estatus_oc'] == 3) {

                $dato['button'] = '';
            }
            else
            {

            //APROBACION
            $accion ='';
            if ($data['estatus_oc'] == 1 or $data['estatus_oc'] == 6) {

                $titulo_facturacion = 'Por Facturar';
                    if($data['factura'] =='')
                    {
                       
                        $eliminar = '<button type="button"  dato="'.$data['estatus_oc'].'" mt_id ="' . $data['oc_detalle'] . '"   mt_nombre ="' . $data['numoc'] . '"   class="btn btn-xs btn-danger btn_delete_sistema"><acronym title="Eliminar orden de compra!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>';
                    }
                    else
                    {
                        $titulo_facturacion = 'Facturado';
                        $eliminar ='';
                    }
                
                    if ($data['bodega_facturado'] == 0) {

                        $accion ='';
                    }
                    if ($data['bodega_facturado'] == 1) {
    
                        $accion= '<button type="button"  dato="'.$data['estatus_oc'].'"  log_id ="'.$data['oc_detalle'].'" tipo=2  class="btn btn-xs btn-warning btn_edit_estado_bodega"><acronym title="Facturacion" lang="es"><i class="fa fa-shopping-cart"></i></acronym></button> ';

                    }
                    if ($data['bodega_facturado'] == '2') {
                        $accion = '<button type="button"  dato="'.$data['estatus_oc'].'"  disabled log_id ="' . $data['oc_detalle'] . '" tipo=0  class="btn btn-xs btn-success btn_edit_estado_bodega"><acronym title="'.$titulo_facturacion.'" lang="es"><i class="fa fa-shopping-cart"></i></acronym></button>';

                    }
                

                $dato['button'] = $eliminar.'  
                <button type="button"  dato="'.$data['estatus_oc'].'" mt_id ="' . $data['cliente'] . '" class="btn btn-xs btn-info btn_analisis_cliente"><acronym title="Análisis Cliente" lang="es"><i class="fa fa-list" aria-hidden="true"></i></acronym></button>
                <button type="button"  orden="'.$data['oc_id'].'" cliente="'.$data['id_cliente'].'"  oc_id ="' . $data['oc_id'] . '" tipo="2" class="btn btn-xs btn-warning btn_edit_estado"><acronym title="Aprobado" lang="es"><i class="fa fa-check" aria-hidden="true"></i></acronym></button>
                 '.$accion;
            } else {

                $titulo_facturacion = 'Por Facturar';
                if($data['factura'] =='')
                {                   
                }
                else
                {
                    $titulo_facturacion = 'Facturado';
                }

                if ($data['estatus_oc'] == 5) {
                    $accion ='';
                }
                else
                {
                    if ($data['bodega_facturado'] == 0) {

                        $accion ='';
                    }
                    if ($data['bodega_facturado'] == 1) {
    
                        $accion= '<button type="button"  dato="'.$data['estatus_oc'].'"  log_id ="'.$data['oc_detalle'].'" tipo=2 class="btn btn-xs btn-warning btn_edit_estado_bodega"><acronym title="Facturacion" lang="es"><i class="fa fa-shopping-cart"></i></acronym></button>';

                    }
                    if ($data['bodega_facturado'] == 2) {
                        $accion = '<button type="button"  dato="'.$data['estatus_oc'].'"  disabled log_id ="' . $data['oc_detalle'] . '" tipo=0   class="btn btn-xs btn-success btn_edit_estado_bodega"><acronym title="'.$titulo_facturacion.'" lang="es"><i class="fa fa-shopping-cart"></i></acronym></button>';

                    }

                    
                }
                
               
                    $dato['button'] = '<button disabled type="button"  dato="'.$data['estatus_oc'].'"  log_id ="' . $data['oc_detalle'] . '"  class="btn btn-xs btn-success btn_edit_estado"><acronym title="Aprobado" lang="es"><i class="fa fa-check" aria-hidden="true"></i></acronym></button>
                                        '.$accion;
                    
                
               
                
            }
        }
                 
        }else {

        }
    
    
    /// PERFIL RESERVAS
if ($_SESSION["gb_perfil"]==7){
    



            if ($data['estatus_oc'] == 3) {

               $eliminar = '';
            }
             else
            {
				if ($data['estatus_oc'] == 5) {

               $eliminar = '';
            }
             else
             {
             
             if($data['factura'] =='')
						{
							$eliminar = '<button type="button"  dato="'.$data['estatus_oc'].'"  mt_id ="' . $data['oc_detalle'] . '"    mt_nombre ="' . $data['numoc'] . '"   class="btn btn-xs btn-danger btn_delete_sistema"><acronym title="Eliminar orden de compra!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button> ';
						}
						else
						{
							$eliminar = '';

						}
             }
					
						
					
			
			}
		 $dato['button']        = $eliminar;
	}


         /// BODEGA
         if ($_SESSION["gb_perfil"] == 6) {

            if ($data['estatus_oc'] == 3) {

                $dato['button'] = '';
            }
            else
            {
            //DESPACHADO
            if ($data['estatus_oc']!=1 and $data['estatus_oc']!=4 and $data['estatus_oc']!=5 ){

                $titulo_facturacion = 'Por Facturar';

                if($data['factura'] =='')
                    {
                        $eliminar = '<button type="button"  dato="'.$data['estatus_oc'].'"  mt_id ="' . $data['oc_detalle'] . '"    mt_nombre ="' . $data['numoc'] . '"   class="btn btn-xs btn-danger btn_delete_sistema"><acronym title="Eliminar orden de compra!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button> ';
                    }
                    else
                    {
                        $eliminar = '';
                        $titulo_facturacion = 'Facturado';
                    }


                if ($data['bodega_facturado'] == 0) {

                    $accion ='';
                }
                if ($data['bodega_facturado'] == 1) {

                    $accion= '<button type="button"  dato="'.$data['estatus_oc'].'"  log_id ="'.$data['oc_detalle'].'" tipo=2 class="btn btn-xs btn-warning btn_edit_estado_bodega"><acronym title="Facturacion" lang="es"><i class="fa fa-shopping-cart"></i></acronym></button>';

                }
                if ($data['bodega_facturado'] == 2) {
                  
					 $accion = '<button type="button"  dato="'.$data['estatus_oc'].'"  disabled log_id ="' . $data['oc_detalle'] . '" tipo=0  class="btn btn-xs btn-success btn_edit_estado_bodega"><acronym title="'.$titulo_facturacion.'" lang="es"><i class="fa fa-shopping-cart"></i></acronym></button>';
                }

                

                
            
                $dato['button']        = $eliminar.'
                <button type="button"  dato="'.$data['estatus_oc'].'"  log_id ="'.$data['oc_detalle'].'"  class="btn btn-xs btn-warning btn_edit_estado"><acronym title="Despachado" lang="es"><i class="fa fa-shopping-cart"></i></acronym></button> '.$accion;
                } else {
                    $dato['button']        = ' ';
                }
            if ($data['estatus_oc'] == 4) {

                $dato['button'] = '
                    <button type="button"  dato="'.$data['estatus_oc'].'"  disabled log_id ="' . $data['oc_detalle'] . '"  class="btn btn-xs btn-success btn_edit_estado"><acronym title="Despachado" lang="es"><i class="fa fa-shopping-cart"></i></acronym></button>';
            }

        }
        } else { }




            /// JEFE DE VENTAS
            if ($_SESSION["gb_perfil"]==8){


                if ($data['estatus_oc'] == 3) {

                    $dato['button'] = '';
                }
                else
                {

                $accion ='';
                $eliminar = '';
                if ($data['estatus_oc'] == 1 or $data['estatus_oc'] == 6) {

                    $titulo_facturacion = 'Por Facturar';
                    if($data['factura'] =='')
                    {
                        $eliminar = '<button type="button"  dato="'.$data['estatus_oc'].'"  mt_id ="' . $data['oc_detalle'] . '"    mt_nombre ="' . $data['numoc'] . '"   class="btn btn-xs btn-danger btn_delete_sistema"><acronym title="Eliminar orden de compra!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button> ';
                    }
                    else
                    {
                        $eliminar = '';
                        $titulo_facturacion = 'Facturado';
                    }
                
                    if ($data['oc_forma_pago'] == 'CONTADO') {
                        if ($data['bodega_facturado'] == 0) {
                            $accion ='';
                        }
                        if ($data['bodega_facturado'] == 1) {
                            $accion= '<button type="button"  dato="'.$data['estatus_oc'].'"  log_id ="'.$data['oc_detalle'].'" tipo=2 class="btn btn-xs btn-warning btn_edit_estado_bodega"><acronym title="Facturacion" lang="es"><i class="fa fa-shopping-cart"></i></acronym></button> ';
                        }
                        if ($data['bodega_facturado'] == 2) {
                             $accion = '<button type="button"  dato="'.$data['estatus_oc'].'"  disabled log_id ="' . $data['oc_detalle'] . '" tipo=0  class="btn btn-xs btn-success btn_edit_estado_bodega"><acronym title="'.$titulo_facturacion.'" lang="es"><i class="fa fa-shopping-cart"></i></acronym></button> ';
                        }
                        
                    }

                   
                }  
                
                $dato['button'] = $accion .$eliminar;
            }
            }



            /// COBRANZA
        if ($_SESSION["gb_perfil"]==11){


           $dato['button'] = '';      
        }
    
    
    if($data['dato_adjunto'] =='no' OR $data['dato_adjunto'] =='' OR $data['dato_adjunto'] ==NULL )
            {
                $pdf = ''; 
                    
            }
            else
            {
                
                    $pdf = ' <a href="'.$data['dato_adjunto'].'" target="_blank"><button type="button" class="btn btn-xs btn-secondary">
                    <acronym title="Adjunto Orden" lang="es">
                        <i class="fa fa-file-pdf" aria-hidden="true"></i>
                    </acronym>
                </button>
                </a>';
            }

if($data['num_factura'] !='')
            {
                $pdf_ride = '<button type="button" factura="'.$data['num_factura'].'"   
                class="btn btn-xs btn-secondary btn_descargar_ride"><acronym title="Descargar Ride" lang="es"><i class="fa fa-file-pdf" aria-hidden="true"></i></acronym></button>';

            }
            else
            {
                $pdf_ride = '';
            }
       
        $dato['button'] = $pdf_ride.'    
         <button type="button" orden ="' . $orden . '" id_order ="' . $data['numoc'] . '" class="btn btn-xs btn-secondary btn_ver_bitacora"><acronym title="Bitacora Orden" lang="es"><i class="fa fa-cogs" aria-hidden="true"></i></acronym></button>
        <button type="button"  dato="'.$data['estatus_oc'].'"  log_id ="' . $data['oc_detalle'] . '"  numoc ="' . $data['numoc'] . '"
        cliente ="' . $dato['cliente'] . '" oc_observaciones ="' . $data['oc_observaciones'] . '"  oc_fecha ="' . $data['oc_fecha'] . '"
        forma_pago ="' . $data['forma_pago'] . '" total ="' . $data['total'] . '"  
          class="btn btn-xs btn-secondary btn_ver_items"><acronym title="Ver Items" lang="es"><i class="fa fa-search" aria-hidden="true"></i></acronym></button>
        ' .  $dato['button'].$pdf;


        $dato['factura'] = $data['factura'].'<br>Bodega : '.$data['bodega'];
      
        $pr_total = $data['total'] + $pr_total;
        $totalRecords = $data['totalRecords'];
		$file[]               = $dato;
    }
    $dato['button']        =  '';
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
    $dato['factura'] = '';
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

        if($data['cantidad'] == $data['imei'])
        {
            $imei        = '<acronym title="Imei" lang="es"><button type="button"  dato="'.$data['oc_estatus'].'"  pr_item ="' . $data['item'] . '" pr_descripcion="'.$data['descripcion'].'"  pr_cantidad="'.$data['cantidad'].'" class="btn btn-sm btn-success btn_imei">Imei : '.$data['cantidad'].'</button></acronym>';
        }
        else
        {
            $faltantes = $data['cantidad'] - $data['imei'];
            $imei        = '<acronym title="Imei" lang="es"><button type="button"  dato="'.$data['oc_estatus'].'"  pr_item ="' . $data['item'] . '" pr_descripcion="'.$data['descripcion'].'" pr_cantidad="'.$data['cantidad'].'" class="btn btn-sm btn-danger btn_imei">Imei Faltantes : '.$faltantes.'</button></acronym>';
        }
        $imei ='';


        $dato['item']          =  $data['descripcion'];//.'<br>'.$imei;
        $dato['cantidad'] = '<input style="width:60px" type="text" value ="'.$data['cantidad'].'" id="cantidadnueva'.$data['id'].'"   ">';//;
        $dato['precio']        =  $data['precio'];
        
        $dato['pvp']        =  $data['PVP'];
        $dato['id_ordencompra']        =  $data['id_ordencompra'];
        $dato['dcto']        =  $data['descuento'];
        $dato['dctoiva']        =  $data['Dcto_iva'];
        $dato['iva']        =  $data['iva'];
        
        $dato['total']         =  $data['total'];
        $dato['direccion_entrega']        =  $data['direccion_entrega'];

        $dato['oc_total']        =  $data['oc_total'];
               
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

    $data["txt_id_edit"]              = $_POST['txt_id_edit'];
    $data["precio"]              = $_POST['precio'];
    $data["cantidad"]              = $_POST['cantidad'];
    $data["descuento"]              = $_POST['descuento'];
    $data["id_ordencompra"]              = $_POST['id_ordencompra'];
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
    
    $movements  = $Consult->editar_cantidad($data);
  
}



/*=============================================
EDIT ESTADO DESPACHADO
=============================================*/
function editar_estado_cobranza_bodega()
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
    
    $movements  = $Consult->editar_estado_cobranza_bodega($data);
  
}


/*=============================================
TABLE ORDEN BITACORA
=============================================*/
function table_orden_bitacora()
{ 
	$Consult          = new ModelOcCounsulta();
    $movements        = $Consult->table_orden_bitacora($_REQUEST["txt_id_reserva"]);
    $file             = array();
    $total_inversion =0;

    $i            = 0;
    foreach ($movements as $data) {
        $i++;
        $dato['id']                = $i;
        $dato['accion']            =  $data['accion']; 
        $dato['usuario']           =  $data['usuario'];
        $dato['observacion']       =  $data['observaciones'];

        if($dato['accion'] == 'Facturado')
        {
            $dato['fecha']             =  $data['fecha_hora_num_factura'];
        }
        else
        {
            $dato['fecha']             =  $data['fecha_registro'];
        }
        
        $file[]                    = $dato;
    }

    $result = array('data' => $file);
    echo json_encode($result);
}


/*=============================================
ESTADO ORDEN
=============================================*/
function estado_orden()
{
    $mysqli  = conexionMySQL();
    $Consult = new ModelOcCounsulta();
    $Global  = new ModelGlobal();

    $data["txt_id"]          = $_POST['txt_id'];
    $data["txt_estado_orden"]     = $_POST['txt_estado_orden'];
    $data["txt_observaciones_orden"]     = $_POST['txt_observaciones_orden'];

    $data["txt_user"]             = $_SESSION["gb_id_user"];
    $i                       = 1;

    foreach ($data as $key => $value) {
        $data[$key] = $mysqli->real_escape_string($data[$key]);
        if ($i > 5) {
            $Global->salir_json("2", "error excede la cantidad de parametros!!");
        }
        $i++;
    }
    
    $movements  = $Consult->estado_orden($data);
    foreach ($movements as $movement) {
        $dato["result"]   = $movement["result"];
        $dato["error"]    = $movement["error"];
        
    }
    echo json_encode($dato);
}