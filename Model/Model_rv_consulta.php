<?php
class ModelOcCounsulta
{


		/*=============================================
		BUSCADOS PREDICTIVO PROMOTOR
		=============================================*/
		public function serarch_promotor($term)
		{
			$mysqli      = conexionMySQL();


			$sql = "SELECT gb_id,gb_nombre FROM gb_usuarios WHERE gb_nombre  LIKE '%$term%'  and gb_id_perfil=4 limit 20";
			$resultado = $mysqli->query($sql);
			$n = $resultado->num_rows;
			$data = array();
			$datax = array();
			if ($n > 0) {
				while ($fila = $resultado->fetch_assoc()) {

					$datax["text"] =  $fila["gb_nombre"];
					$datax["id"]   =  $fila["gb_id"];
					$data[] = $datax;
				}
			} else {
				$fila["text"]		= "...!0 RESULTADOS!...";
				$fila["id"]			= "0";
				$data[] = $fila;
			}

			return $data;
		}

    /*=============================================
	TABLE SERVICIOS
	=============================================*/
	public function table_ventas($dato)
	{
		$mysqli      = conexionMySQL();
		$Global         = new ModelGlobal();
        include 'bdsql.php';
        $dbconn      = conexionSQLSI();
		
		ini_set('memory_limit', '64M');
		ini_set('max_execution_time', 9000000);
		
		$fechainicio    = $Global->formatearFecha($dato['txt_fechain']);
		$fechafin   	= $Global->formatearFecha($dato['txt_fechafin']);
		$txt_promotor   = $dato['txt_promotor'];
		$txt_cadena		= $dato['txt_cadena'];
		$txt_estado		= $dato['txt_estado'];
        $txt_user		= $dato['txt_user'];
        $txt_gb_perfil  = $dato['txt_gb_perfil'];

		
		$data        = array();


			$where_condition = $sqlTot = $sqlRec = "";
		/*	if (!empty($dato['search']['value'])) {
				$where_condition .=	" and ";
				$where_condition .= " ( pr_codigo LIKE '%" . $dato['search']['value'] . "%' ";

			}
		

			/*
			INNER JOIN pr_venta_imei i
			ON i.pr_id_venta=v.pr_id

			, '20' as pr_imei
*/

		$sql_query      = "SELECT reserva.* , GROUP_CONCAT(rv_detalle.descripcion separator '<br>' ) as item,
        GROUP_CONCAT(  rv_detalle.cantidad   separator '<br>' ) as cantidad_rv
        
,(select GROUP_CONCAT( concat(ordencompra.oc_id)  separator ' | ' ) from ordencompra where ordencompra.codigo_rv = reserva.oc_id ) as ocs
        FROM `reserva` inner join rv_detalle ON
        rv_detalle.id_ordencompra = reserva.oc_id
							WHERE  reserva.oc_fecha BETWEEN '".($fechainicio)."' AND '".($fechafin)."' and reserva.oc_estatus !=5 ";
		
	/*	if($txt_gb_perfil != 1)
		{
			$sql_query         .= " AND v.pr_id_usuario ='". $txt_user."'  ";
		}
        else
        {	 }
		*/

        /*
		if ($_SESSION["gb_perfil"]==4) 
{
	$sql_query         .= " AND oc_id_usuario ='". $_SESSION["gb_id_user"] ."'  ";
} else {

}
*/
/*
            if($txt_promotor != '')
            {
                $sql_query         .= " AND oc_id_usuario ='". $txt_promotor."'  ";
            }
       */
	
        
		if($txt_cadena != 0)
		{
			$sql_query         .= " AND reserva.id_cliente ='". $txt_cadena."'  ";
		}



        if ($_SESSION["gb_perfil"]==4){
            
            $sql_query         .= " AND reserva.cod_vendedor ='".$_SESSION["gb_cod_vendedor"]."' ";
    }

        /*
		 if($txt_estado != '')
		{
			$sql_query         .= " AND oc_estatus ='". $txt_estado."'  ";
         
		} else {

            if ($_SESSION["gb_perfil"]==6){
                $sql_query         .= " AND oc_estatus  in (2,4)";
        } 
            //QUITAMOS FILTRO DE ANULADAS, PARA MOSTRARLAS
			//$sql_query         .= " AND oc_estatus !='5'  ";

		}
		*/

		$sqlTot .= $sql_query;
			
			$sqlRec .= $sql_query;
			$sqlTot .= $where_condition;
			$sqlRec .= $where_condition;
			$sqlRec .=  " 
            group by reserva.oc_id LIMIT ".$dato['start']." ,".$dato['length']." ";

			$resultado = $mysqli->query($sqlTot);
			$totalRecords = $resultado->num_rows;
            if($totalRecords == 0)
            {
                $totalRecords =0;
            }
			$queryRecords = $mysqli->query($sqlRec);
			
			$a		   = 1;	
 
			while ($fila = $queryRecords->fetch_assoc()) {


		/*	$fila['datos']    = '<strong>Codigo : </strong>'.$fila['pr_codigo'].'<br>'.'<strong>Fecha : </strong>'.$fila['pr_fecha'].
			                    '<br>'.'<strong>Fecha Registro: </strong>'.$fila['pr_fecha_registro'];
		*/
			$fila['numoc']      = $fila['oc_id'];
			$fila['cliente']    = $fila['id_cliente'];
			//$fila['oc_estatus2']    = $this->estado($fila['oc_estatus']);

			//$fila['imei']        =	 $fila['pr_imei'];
		//	$fila['oc_detalle']      = $fila['oc_id'];
        $fila['oc_observaciones']  =	 $fila['oc_observaciones'];
        $fila['ocs']  =	 $fila['ocs'];
        $fila['item']  =	 $fila['item'];
			
			$fila['forma_pago']  =	 $fila['oc_forma_pago'];
			$fila['vendedor']    = $this->usuario($fila['oc_id_usuario']);
			$fila['oc_fecha']  =	 $fila['oc_fecha'];
            //$fila['estatus_oc']  =	 $fila['oc_estatus'];
            /*$fila['item']        =	 $fila['descripcion'];// . ' C.'.$fila['item'];
			$fila['cantidad']       =	 $fila['cantidad'];
			$fila['precio']       =	 $fila['precio'];
			*/
            //$fila['total']       =	 $fila['oc_total'];


            $id_cliente = explode('-', $fila["id_cliente"]);
            $resultado   = sqlsrv_query($dbconn, "
            SELECT top 20 CCCliente.codigo, CCCliente.RazonSocial, CCCliente.canal, CCCliente.subcanal, CCCanal.Descripcion  canalnombre, CCSubCanal.Descripcion subcanalnombre, CCCliente.codigo, CCCliente.Vendedor, FAVendedor.nombre, CCCliente.saldocupo,CCCliente.ruc,CCCliente.dias
            FROM CCCliente
            left join CCCanal on
            CCCanal.Codigo = CCCliente.canal
            left join CCSubCanal on
            CCSubCanal.Codigo = CCCliente.subcanal
            left join FAVendedor on
            FAVendedor.codigo = CCCliente.Vendedor
            WHERE CCCliente.codigo  = '" . $id_cliente[0] . "' ");

            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila["canal"]   =  $row['canal'];
                $fila["subcanal"]   =  $row['subcanal'];
				$fila["dias"]   =  $row['dias'];
            }

			$fila['totalRecords']  	= $totalRecords;
			$data[]              = $fila;
		}
		$mysqli->close();
		return $data;
	}


    
/*=============================================
TABLE IMEIS
=============================================*/
public function table_imeis($txt_id)
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT d.pr_descripcion,i.pr_imei FROM pr_venta_detalle d
                    INNER JOIN pr_venta_imei i
                    ON d.pr_id_venta = i.pr_id_venta
                    WHERE d.pr_id_venta ='".$txt_id."'
                    AND d.pr_item = i.pr_id_articulo";

    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {
        $data[]   = $fila;
    }
    $mysqli->close();
    return $data;
}

private function usuario($txt_id)
{
	$mysqli = conexionMySQL();
	$sql = "SELECT * FROM  gb_usuarios WHERE gb_id    ='$txt_id'";
	$resultado = $mysqli->query($sql);
	$fila = $resultado->fetch_assoc();
   
	return $fila['gb_nombre'];   
}


    private function cadena($txt_id)
	{
		$mysqli = conexionMySQL();
		$sql = "SELECT * FROM  pa_cadenas WHERE id   ='$txt_id'";
		$resultado = $mysqli->query($sql);
		$fila = $resultado->fetch_assoc();
	   
		return $fila['nombre'];   
	}


    private function tienda($txt_id)
	{
		$mysqli = conexionMySQL();
		$sql = "SELECT * FROM  pa_tiendas WHERE id   ='$txt_id'";
		$resultado = $mysqli->query($sql);
		$fila = $resultado->fetch_assoc();
	   
		return $fila['nombre'];   
	}

	
private function cliente($txt_id)
{
	$mysqli = conexionMySQL();
	$sql = "SELECT * FROM  clientes WHERE log_id     ='$txt_id'";
	$resultado = $mysqli->query($sql);
	$fila = $resultado->fetch_assoc();
   
	return $fila['log_nombre'];   
}

private function estado($txt_id)
{
	$mysqli = conexionMySQL();
	$sql = "SELECT * FROM  estados WHERE id_estado  ='$txt_id'";
	$resultado = $mysqli->query($sql);
	$fila = $resultado->fetch_assoc();
   
	return $fila['detalle'];   
}


  /*=============================================
CARGAR CADENAS
=============================================*/	
public function cargar_estados(){

    $dataxr      = array();
    $mysqli      = conexionMySQL();
        $accion = ' =1 ';
    if ($_SESSION["gb_perfil"]==6){
        $accion = ' in (2,4) ';
} 
    $sql         = "SELECT * FROM   estados where estado ".$accion;
    $resultado   = $mysqli->query($sql);
    $n           = $resultado->num_rows;
    if($n>0)
    {
        while ($file =  $resultado->fetch_assoc()) {
            $dataxr[] = $file;
        }
    }
    else
    {
        $dataxr['id_estado']     ='0';
        $dataxr['detalle'] ='NO HAY ESTADO';
    }
    
    return $dataxr;
    $mysqli->close();
}




/*=============================================
EDIT REQUERIMIENTO
=============================================*/
public function editar_estado($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $dataid       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);
		$actualizar = 1;
    if ($_SESSION["gb_perfil"]==5){
			$actualizar = 2;
	} 
	if ($_SESSION["gb_perfil"]==6){
			$actualizar = 4;
	} 
	
    if ($data['tipo']==2){
//es de aprobacion gerencia

$concat= " ,oc_estatus=2,  fecha_hora='".date('Y-m-d h:i:s')."', observacion='".$data['txt_obs_gerencia']."', dato_adjunto='".$data['valorimgf']."',
user_gerencia='".$data['txt_user']."'  ";
    } else {
            $concat = '';
    }
    
                 $sql_insert = "UPDATE ordencompra SET
                 oc_estatus=$actualizar,               
                 id_user_edit='".$data['txt_user']."'  $concat
                  WHERE oc_id   ='".$data['txt_id_edit']."'";

              
            $resultado       = $mysqli->query($sql_insert);
            if ($resultado) {

                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'ORDEN COMPRA ESTADO';
                $data['dp_accion']         =  "EDITAR";
                $data['dp_descripcion']     = 'EDITAR ORDEN COMPRA: '.$data['txt_id_edit'];
                $data['dp_sql']             = $sql_insert;
                $data['dp_user']            = $data['txt_user'];
                $data['dp_fecha_registro']  = date('Y-m-d');
                $data['dp_hora_registro']   = date("g:i:s-a");
                $Global->bitacora_user($data);
              $mysqli->commit();
                //REALIZO INGRESO DE FECHA HORA AUTOMATICA POR FECHA+MENSAJERO

                

            } else {
                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
            }

           
    $mysqli->close();
}





/*=============================================
ELIMINAR guia
=============================================*/
public function eliminar_oc($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);

            $sql_insert      = "update ordencompra set oc_estatus=5 WHERE oc_id  ='".$data["txt_id"]."'  ";
            $resultado       = $mysqli->query($sql_insert);
            if ($resultado) {

                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'ORDEN DE COMPRA';
                $data['dp_accion']          =  "ELIMINAR";
                $data['dp_descripcion']     = 'ELIMINAR ORDEN DE COMPRA: '.$data['txt_nombre'];
                $data['dp_sql']             = $sql_insert;
                $data['dp_user']            = $data['txt_user'];
                $data['dp_fecha_registro']  = date('Y-m-d');
                $data['dp_hora_registro']   = date("g:i:s-a");
                $Global->bitacora_user($data);
                $mysqli->commit();
                $Global->salir_json(1,'');

            } else {
                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
            }
       
    $mysqli->close();
}




/*=============================================
TABLE VENTA DETALLE ORIGINALES BD
=============================================*/
public function table_venta($txt_id)
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT * FROM rv_detalle 
	inner join reserva on
	reserva.oc_id  = rv_detalle.id_ordencompra
	WHERE id_ordencompra='".$txt_id."' and estatus_oc=1 and oc_estatus=1 ";

    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

			//$fila['imei'] = 1;//$this->verificar_imeis($fila['item'],$txt_id);
        
        $data[]   = $fila;
    }
    $mysqli->close();
    return $data;
}




/*=============================================
AGREGRAR ITEM
=============================================*/
public function agregar_item($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


                /** VALIDAMOS NOMBRE DE LA CADENA **/
				$resut = $this->validar_item_cargado($data['txt_id'],$data['id_guia']);
                if($resut == 0)
                {
                    $pvp = ($data['txt_precio']);
                    $sql_insert = "INSERT INTO rv_detalle 
                    ( 	
                        id_ordencompra,
                        `item`,
                        `descripcion`,
                        `cantidad`, 
                        `precio`, 
                        `usuario`,
                        `estatus_oc`

                    ) 						
                    VALUES
                    (
						'" . $data['id_guia'] . "',
                        '" . $data['txt_id'] . "',
                        '" . $data['txt_text'] . "',
                        '" . $data['txt_cantidad'] . "',
                        '" . $data['txt_precio'] . "',
                        '" . $data['txt_user'] . "',
                        '1'
                    )";
                }
                else
                {   
					$sql = "SELECT * FROM  rv_detalle WHERE item ='".$data['txt_id'] ."' AND id_ordencompra='".$data['id_guia'] ."'";
                    $resultado = $mysqli->query($sql);
                    $fila = $resultado->fetch_assoc();
					
                    $sql_insert = "UPDATE rv_detalle SET cantidad=cantidad+'".$data['txt_cantidad']."',precio='".$data['txt_precio']."'
                     WHERE id='".$fila['id'] ."'";
			    }
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {     
                $mysqli->commit();
                $Global->salir_json_total(1,"",$total);
            } else {
                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
            }
       

    $mysqli->close();
}

private function validar_item_cargado($txt_id,$id_guia) 
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM rv_detalle WHERE item ='$txt_id' AND id_ordencompra ='$id_guia'";
    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 1;
    } else {
        $salida = 0;
    }
    return $salida;   
}

private function total_venta($id_usuario)
{
    $mysqli    = conexionMySQL();

    $sql       = "SELECT SUM(total) AS total FROM oc_detalle WHERE id_ordencompra='".$id_usuario."'  and estatus_oc <>5";
    $resultado = $mysqli->query($sql);

        while ($fila = $resultado->fetch_assoc()) {
            
            
            if($fila['total'] == null)
            {
                $total = '0.00';
            }
            else
            {
                $total = $fila['total'];
            }
          
        }

    return $total;
}



 /*=============================================
ELIMINAR ITEM
=============================================*/
public function eliminar_item($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


    $sql_insert = "update oc_detalle set estatus_oc=5 WHERE id ='".$data['txt_id']."'";
    $resultado  = $mysqli->query($sql_insert);

    if ($resultado) {
       
        $mysqli->commit();
        $total = $this->total_venta($data['id_ordencompra']);
        $Global->salir_json_total(1,"",$total);

    } else {
        $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
    }

}



/*=============================================
EDIT CANTIDAD
=============================================*/
public function editar_cantidad($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $dataid       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(true);
	
    /*
    $pvp = round($data['precio'] /1.12,2);
    $dcto = round($data['descuento'] /1.12,2);

    $iva = round(($pvp-$dcto)*0.12,2);

    $total = round($data['cantidad'] *  ($pvp-$dcto+$iva),2);

*/

$fecha =  $Global->formatearFecha($data['txt_fecha']);

//$total = $this->total_venta($data['cliente_edit']);


if($data['cancelar']==1){

                                      //REDUCIMOS LA CANTIDAD DE LA PREVENTA DETALLE  
                                   
                                      
                                      $cantidadejecutar=count($data['cantidadnueva']);
                                      for ($i=0; $i <$cantidadejecutar ; $i++)
                                      { 
                             
                                      
                                                                $item=$data['iditem'][$i];
                                                                $cantidadnueva=$data['cantidadnueva'][$i];
                                                                $rp_detalles = "SELECT * FROM rv_detalle WHERE id='".$item."' and id_ordencompra =".$data['txt_codigo'] ;
                                                                $query_detalles=$mysqli->query($rp_detalles);
                                                                $n= $query_detalles->num_rows;
                                                                if($n>0)
                                                                {
                                                                      while ($registro_detalles=$query_detalles->fetch_assoc())
                                                                      {
                                                                            $cantidadreducida = $registro_detalles['cantidad'] - $cantidadnueva;
                                                                            //REDUCIMOS LA CANTIDAD DE LA PREVENTA DETALLE  
                                                                            $sql_insert = "UPDATE rv_detalle SET cantidad=$cantidadreducida WHERE id='".$item."' and id_ordencompra =".$data['txt_codigo'];
                                                                            $resultado  = $mysqli->query($sql_insert);
                                                                            if ($resultado) 
                                                                            {
                                                                            } 
                                      
                                                                    }
                                                                }


                                                                /** INSERTAR EN BITACORA DE RESERVA**/
                                                                if($data['txt_bodega'] !='')
                                                                {
                                                                        $tipo = 3;
                                                                }
                                                                else
                                                                {
                                                                    $tipo = 1;
                                                                }
                                                                    $sql_insert = "INSERT INTO reserva_bitacora 
                                                                    ( 
                                                                        id_reserva,
                                                                        tipo,
                                                                        cantidad,
                                                                        fecha,
                                                                        id_usuario,
                                                                        bodega
                                                                    ) 						
                                                                    VALUES
                                                                    (
                                                                        '" . $item. "',
                                                                        '" . $tipo. "',
                                                                        '".$cantidadnueva."',
                                                                        '".date('Y-m-d')."',
                                                                        '".$data['txt_user']."',
                                                                        '".$data['txt_bodega']."'
                                                                        ) ";
                                                                    $resultado  = $mysqli->query($sql_insert);
                                                 
                                      }


}
else 
{


            if ($data['txt_observaciones'] !=''){

            } else {
                $data['txt_observaciones'] ='n/a';
            }

            $id_cliente = explode('-',$data['cliente_edit_fact']);
            $sql_insert = "INSERT INTO ordencompra 
            ( 	oc_codigo,
                id_cliente,
                oc_total,
                oc_forma_pago,
                oc_fecha,
                oc_observaciones,
                oc_id_usuario,
                oc_estatus,
                codigo_rv,
                bodega_facturado,
                id_bodega,
				dias_credito
            ) 						
            VALUES
            (
                'RESERVA',
                '" . $data['cliente_edit_fact']. "',
                0,
                '" . $data['txt_formapago'] . "',
                '" . date('Y-m-d'). "',
                '" . $data['txt_observaciones'] . "',
                '" . $data['txt_user'] . "',
                '1',
                '" . $data['txt_codigo'] . "',
                '1',
                '12',
				'" . $data['txt_dias']. "'
                ) ";
				
				 $f = fopen("RESERVA.txt", "w");
                                            fwrite($f, $sql_insert);
                                            fclose($f);


            $resultado  = $mysqli->query($sql_insert);
            $max_id 	=  $mysqli->insert_id;
            if ($resultado)
            {
               
                $sql_insert = "INSERT INTO orden_bitacora 
                ( 
                    id_orden,
                    accion,
                    id_usuario
                ) 						
                VALUES
                (
                    '".$max_id."',
                    'Ingresada',
                    '".$data['txt_user']."'
                ) ";
                $resultado  = $mysqli->query($sql_insert);
               
               
               
                //$mysqli->commit();
                //se guardo, procedemos a guardar el detalle de la RV
                $total_total =0;
                $cantidadejecutar=count($data['cantidadnueva']);
                for ($i=0; $i <$cantidadejecutar ; $i++) 
                { 

                    // SE RECORRE CAMPO DE PRECIO NUEVO
                    $precionuevo=$data['precionuevo'][$i];
                        
                    $item=$data['iditem'][$i];
                    $cantidadnueva=$data['cantidadnueva'][$i];
                    $rp_detalles = "SELECT * FROM rv_detalle WHERE id='".$item."' and id_ordencompra =".$data['txt_codigo'] ;
                    $query_detalles=$mysqli->query($rp_detalles);
                    $n= $query_detalles->num_rows;
                    if($n>0)
                    {
                        while ($registro_detalles=$query_detalles->fetch_assoc())
                        {
                            
                        if($cantidadnueva > 0){
                        
                        	$cantidadreducida = $registro_detalles['cantidad'] - $cantidadnueva;
                            $pvp = round(($precionuevo) /1.15,2);
                            $iva = round(($pvp)*0.15,2);
                            $total = round($cantidadnueva *  ($pvp+$iva),2);
                            $total_total = $total_total + $total;

                            $sql_insert = "INSERT INTO `oc_detalle`( `id_ordencompra`, `item`, `descripcion`,`cantidad`, `precio`, `descuento`, `PVP`, `Dcto_iva`, `iva`, `total`,`direccion_entrega`, `usuario`, `estatus_oc`, `reserva_id`,`id_bodega`)
                                            VALUES
                                            (
                                                '" . $max_id . "',
                                                '" . $registro_detalles['item'] . "',
                                                '" . $registro_detalles['descripcion'] . "',
                                                '" . $cantidadnueva. "',
                                                '" . $precionuevo. "',
                                                '0',
                                                '" . $pvp. "',
                                                '0',
                                                '" . $iva. "',
                                                '" . $total. "',
                                                'n/a',
                                                '" . $data['txt_user'] . "',
                                                '1',
                                                '" . $data['txt_codigo'] . "',
                                                '12'                                        
                                            ) ";

                                            $f = fopen("DETALLERESERVA.txt", "w");
                                            fwrite($f, $sql_insert);
                                            fclose($f);


                                            $resultado  = $mysqli->query($sql_insert);
                                            if ($resultado) 
                                            {
                                                //REDUCIMOS LA CANTIDAD DE LA PREVENTA DETALLE  
                                                $sql_insert = "UPDATE rv_detalle SET cantidad=$cantidadreducida WHERE id='".$item."' and id_ordencompra =".$data['txt_codigo'];
                                                $resultado  = $mysqli->query($sql_insert);
                                                if ($resultado) 
                                                {
                                                } 
                                                 

                                                /** INSERTAR EN BITACORA DE RESERVA**/
                                                $sql_insert = "INSERT INTO reserva_bitacora 
                                                ( 
                                                    id_reserva,
                                                    tipo,
                                                    cantidad,
                                                    fecha,
                                                    id_usuario
                                                ) 						
                                                VALUES
                                                (
                                                    '" . $item. "',
                                                    '2',
                                                    '".$cantidadnueva."',
                                                    '".date('Y-m-d')."',
                                                    '".$data['txt_user']."'
                                                ) ";
                                                $resultado  = $mysqli->query($sql_insert);
                                                    

                                                /** DATOS BITACORA **/
                                                $data['dp_modulo']          = 'ORDEN COMPRA ITEM RESERVA';
                                                $data['dp_accion']         =  "REGISTRO";
                                                $data['dp_descripcion']     = 'REGISTRO ORDEN COMPRA RESERVA: '.$item.' ' .$registro_detalles['descripcion'] . $registro_detalles['cantidadnueva'];
                                                $data['dp_sql']             = $sql_insert;
                                                $data['dp_user']            = $data['txt_user'];
                                                $data['dp_fecha_registro']  = date('Y-m-d');
                                                $data['dp_hora_registro']   = date("g:i:s-a");
                                                $Global->bitacora_user($data);
                                                // $mysqli->commit();
                                                //REALIZO INGRESO DE FECHA HORA AUTOMATICA POR FECHA+MENSAJERO

                                                /* $total = $this->total_venta($data['id_ordencompra']);
                                                $Global->salir_json(1,$total);
                                                */
                            } 
                            else 
                            {
                                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                            }
                        
                        }
                        }
                    }  
                }
                //ACTUALIZAMOS TOTAL DE OC
                $sql_insert = "UPDATE ordencompra SET oc_total='" . $total_total. "' WHERE  oc_id =".$max_id;
                $resultado  = $mysqli->query($sql_insert);
                if ($resultado) 
                {
                    $mysqli->commit();
                }
            }          
        }
    $Global->salir_json(1,'0');
    $mysqli->close();
}

    
/*=============================================
CANCELAR ORDEN
=============================================*/
public function cancelar_orden($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $dataid       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(true);

$sql_insert = "update reserva set oc_estatus=0 where oc_id= '" . $data['txt_id_edit'] . "'  ";
$resultado  = $mysqli->query($sql_insert);

            if ($resultado) {

                $sql_insert = "update rv_detalle set estatus_oc=0 where id_ordencompra= '" . $data['txt_id_edit'] . "'  ";
$resultado  = $mysqli->query($sql_insert);

            if ($resultado) {
            }
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'LIBERACIÓN INVENTARIO';
                $data['dp_accion']         =  "REGISTRO";
                $data['dp_descripcion']     = 'REGISTRO LIBERACIÓN INVENTARIO: '.$data['txt_id_edit'];
                $data['dp_sql']             = $sql_insert;
                $data['dp_user']            = $data['txt_user'];
                $data['dp_fecha_registro']  = date('Y-m-d');
                $data['dp_hora_registro']   = date("g:i:s-a");
                $Global->bitacora_user($data);
             // $mysqli->commit();
                //REALIZO INGRESO DE FECHA HORA AUTOMATICA POR FECHA+MENSAJERO

               /* $total = $this->total_venta($data['id_ordencompra']);
                $Global->salir_json(1,$total);
*/
            }            
                $Global->salir_json(1,'0');

    $mysqli->close();
}



/*=============================================
TABLE RESERVA BITACORA
=============================================*/
public function table_reserva_bitacora($txt_id)
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT * FROM reserva_bitacora WHERE id_reserva='".$txt_id."' ";
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

			$fila['usuario'] = $this->usuario_reserva($fila['id_usuario']);
            if($fila['bodega'] !='')
            {
                $bodega = explode('-',$fila['bodega']);
                $fila['bodega']  = $bodega[1];
            }
            else
            {
                $fila['bodega']  = '';
            }
            
            
        
        $data[]   = $fila;
    }
    $mysqli->close();
    return $data;
}
    private function usuario_reserva($txt_id)
    {
        $mysqli = conexionMySQL();
        $sql = "SELECT * FROM  gb_usuarios WHERE gb_id    ='$txt_id'";
        $resultado = $mysqli->query($sql);
        $fila = $resultado->fetch_assoc();
        return $fila['gb_nombre'];   
    }
	
	
	
/*=============================================
VALIDAR RESERVA
=============================================*/	
public function validar_reserva($data){

    $dataxr      = array();
    $mysqli      = conexionMySQL();
    include 'bdsql.php';
    $dbconn      = conexionSQLSI();
    $sql         = "SELECT * FROM  reserva WHERE oc_id='".$data['txt_reserva']."' ";
    $resultado   = $mysqli->query($sql);
    $n           = $resultado->num_rows;
    if($n>0)
    {
        $fila = $resultado->fetch_assoc();
        $dato['result']     =1;
        $dato["oc_id"]                      = $fila["oc_id"];
		$dato["id_cliente"]                 = $fila["id_cliente"];
		$dato["oc_fecha"]                   = $fila["oc_fecha"];
		$dato["oc_forma_pago"]              = $fila["oc_forma_pago"];
		$dato["oc_observaciones"]           = $fila["oc_observaciones"];


        $id_cliente = explode('-',$fila["id_cliente"]);
        $resultado   = sqlsrv_query($dbconn,"
        SELECT top 20 CCCliente.codigo, CCCliente.RazonSocial, CCCliente.canal, CCCliente.subcanal, CCCanal.Descripcion  canalnombre, CCSubCanal.Descripcion subcanalnombre, CCCliente.codigo, CCCliente.Vendedor, FAVendedor.nombre, CCCliente.saldocupo,CCCliente.ruc,CCCliente.dias
        FROM CCCliente
left join CCCanal on
CCCanal.Codigo = CCCliente.canal
left join CCSubCanal on
CCSubCanal.Codigo = CCCliente.subcanal
left join FAVendedor on
FAVendedor.codigo = CCCliente.Vendedor
WHERE CCCliente.codigo  = '".$id_cliente[0]."' ");

    while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
        $dato["canal"]   =  $row['canal'];
        $dato["subcanal"]   =  $row['subcanal'];
		$dato["dias"]   =  $row['dias'];
    }



    }
    else
    {
        $dato['result']     =0;
        $dato['oc_id']     =0;
    }
    
  echo json_encode($dato);
    $mysqli->close();
    exit();
}



    }