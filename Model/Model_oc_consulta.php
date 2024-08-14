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
        $conn1      = conexionSQLSI();
        $factura ='';
		
		ini_set('memory_limit', '300M');
		ini_set('max_execution_time', 9000000);
		
		$fechainicio    = $Global->formatearFecha($dato['txt_fechain']);
		$fechafin   	= $Global->formatearFecha($dato['txt_fechafin']);
		$txt_promotor   = $dato['txt_promotor'];
		$txt_cadena		= $dato['txt_cadena'];
		$txt_estado		= $dato['txt_estado'];
        $txt_pagoC		= $dato['txt_pagoC'];
        $txt_user		= $dato['txt_user'];
        $txt_gb_perfil  = $dato['txt_gb_perfil'];

		
		$data        = array();


			$where_condition = $sqlTot = $sqlRec = "";
			if (!empty($dato['search']['value'])) {
				$where_condition .=	" and ";
				$where_condition .= " ( pr_codigo LIKE '%" . $dato['search']['value'] . "%' ";

			}
		

			/*
			INNER JOIN pr_venta_imei i
			ON i.pr_id_venta=v.pr_id

			, '20' as pr_imei
*/

		$sql_query      = "SELECT *
		FROM ordencompra oc
							WHERE  oc.oc_fecha BETWEEN '".($fechainicio)."' AND '".($fechafin)."' ";
		
	/*	if($txt_gb_perfil != 1)
		{
			$sql_query         .= " AND v.pr_id_usuario ='". $txt_user."'  ";
		}
        else
        {	 }
		*/

		if ($txt_gb_perfil==4) 
{
	$sql_query         .= " AND oc_id_usuario ='". $txt_user ."'  ";
} else {

}


            if($txt_promotor != '')
            {
                $sql_query         .= " AND oc_id_usuario ='". $txt_promotor."'  ";
            }
       
	
        
		if($txt_cadena != 0)
		{
			$sql_query         .= " AND oc.id_cliente LIKE '%". $txt_cadena."%'  ";
		}

        if($txt_pagoC != '')
		{
			$sql_query         .= " AND oc.oc_forma_pago ='". $txt_pagoC."'  ";
		}

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
		
		$sqlTot .= $sql_query;
			
			$sqlRec .= $sql_query;
			$sqlTot .= $where_condition;
			$sqlRec .= $where_condition;
			$sqlRec .=  " LIMIT ".$dato['start'].",".$dato['length']." ";
           //$sqlRec .=  " LIMIT 0 ,2000 ";

			$resultado = $mysqli->query($sqlTot);
			$totalRecords = $resultado->num_rows;
            if($totalRecords == 0)
            {
                $totalRecords =0;
            }
			$queryRecords = $mysqli->query($sqlRec);


			$a		   = 1;	
            $factura='';
			while ($fila = $queryRecords->fetch_assoc()) {
                $factura='';
                $fechadig='';
                $usuario='';

		/*	$fila['datos']    = '<strong>Codigo : </strong>'.$fila['pr_codigo'].'<br>'.'<strong>Fecha : </strong>'.$fila['pr_fecha'].
			                    '<br>'.'<strong>Fecha Registro: </strong>'.$fila['pr_fecha_registro'];
		*/
			$fila['numoc']      = $fila['oc_id'];
			$fila['cliente']    = $fila['id_cliente'];
			$fila['oc_estatus2']    = $this->estado($fila['oc_estatus']);

			//$fila['imei']        =	 $fila['pr_imei'];
			$fila['oc_detalle']      = $fila['oc_id'];
			$fila['oc_observaciones']  =	 $fila['oc_observaciones'];
			
			$fila['forma_pago']  =	 $fila['oc_forma_pago'];
			$fila['vendedor']    = $this->usuario($fila['oc_id_usuario']);
			$fila['oc_fecha']  =	 $fila['oc_fecha'];
			$fila['estatus_oc']  =	 $fila['oc_estatus'];
			/*$fila['item']        =	 $fila['descripcion'];// . ' C.'.$fila['item'];
			$fila['cantidad']       =	 $fila['cantidad'];
			$fila['precio']       =	 $fila['precio'];
			*/
			$fila['total']       =	 $fila['oc_total'];

            /* VERIFICAMOS SI YA POSEE FACTURA EN STARCONF */
            if($fila['num_factura'] =='')
            {
                $sql1 = "SELECT reffactura FROM FAPedido WHERE numero='".$fila['oc_id']."' AND reffactura !=''";
                $resultado1   = sqlsrv_query($conn1, $sql1);
                while ($row1 = sqlsrv_fetch_array($resultado1, SQLSRV_FETCH_ASSOC)) 
                {
                    $factura = $row1['reffactura'];
                }

                if($factura!='')
                {
                    $sql2 = "SELECT fechadig,usuario FROM FAFactura WHERE factura='".$factura."'";
                    $resultado2   = sqlsrv_query($conn1, $sql2);
                    while ($row2 = sqlsrv_fetch_array($resultado2, SQLSRV_FETCH_ASSOC)) 
                    {
                        $fechadig = $row2['fechadig'];


                        // Asegúrate de que $fechadig es un objeto DateTime
                        if ($fechadig instanceof DateTime) {
                            $fechadigStr = $fechadig->format('Y-m-d H:i:s'); // o el formato que necesites
                        } else {
                            // Si no es un objeto DateTime, entonces asignalo directamente
                            $fechadigStr = $fechadig;
                        }


                        $usuario = $row2['usuario'];
                    }
                    $fila['factura']   =   $factura;

                    /* INSERTAMOS EN LA BITACORA */
                    $sql_insert = "INSERT INTO orden_bitacora 
                                            ( 
                                                id_orden,
                                                accion,
                                                id_usuario,
                                                fecha_hora_num_factura,
                                                observaciones,
                                                usuario_starconf
                                            ) 						
                                            VALUES
                                            (
                                                '" . $fila['oc_id'] . "',
                                                'Facturado',
                                                '0',
                                                '" . $fechadigStr . "',
                                                '" . $factura . "',
                                                '" . $usuario . "'

                                            ) ";
                    $resultado  = $mysqli->query($sql_insert);
                    /* ACTULIZAMOS NUMERO DE FACTURA EN ORDEN */
                    $sql_insert2 = "UPDATE ordencompra SET num_factura='".$factura."' WHERE oc_id='".$fila['oc_id']."'";
                    $resultado2  = $mysqli->query($sql_insert2);
                }
                else
                {
                    $fila['factura']   =   '';
                 $fila['num_factura']   =   '';
                }
            }
            else
            {
                $fila['factura']   =   $fila['num_factura'];
            $num_fact = explode("-",$fila['num_factura']);



                $fila['num_factura']   =   $num_fact[0].'-'.$num_fact[1].'-'.$this->autocompletarConCeros($num_fact[2],9);
            }
            
        

            /** CONSULTAMOS LA BODEga**/
            if($fila['id_bodega'] == 0)
            {
                $fila["bodega"]   = 'GUAYAQUIL';
            }   
            else
            {
                $resultado   = sqlsrv_query($conn1,"SELECT codigo,nombre FROM INBodega WHERE codigo='".$fila['id_bodega']."' ");
                while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) 
                {
                    $fila["bodega"]   =  $row['nombre'];
                }
            }
            


			$fila['totalRecords']  	= $totalRecords;
			$data[]              = $fila;
		}
		$mysqli->close();
		return $data;
	}

public function autocompletarConCeros($numero, $longitud)
    {
        // str_pad (string $input, int $pad_length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): string
    return str_pad($numero, $longitud, '0', STR_PAD_LEFT);
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
  $sql2 = '';
    if ($_SESSION["gb_perfil"]==6){
        $sql2 = ' AND id_estado in (2,4) ';
} 
    $sql         = "SELECT * FROM   estados where estado =1  ".$sql2."";
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
ELIMINAR guia
=============================================*/
/*
public function eliminar_oc($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);

            $sql_insert      = "update ordencompra set oc_estatus=5 WHERE oc_id  ='".$data["txt_id"]."'  ";
            $resultado       = $mysqli->query($sql_insert);
            if ($resultado) {

          
            include 'bdsql.php';
            $conx      = conexionSQLSI();
            $sqlx    = "DELETE FROM STEMPRESA_DUOCELL.dbo.FAPedido WHERE numero='".$data["txt_id"]."'";
            $paramsx = array();
            $stmtx   = sqlsrv_prepare($conx, $sqlx, $paramsx);
            if (sqlsrv_execute($stmtx) === false) {

                if (($errors = sqlsrv_errors()) != null) {
                    $error_details  = '';
                    foreach ($errors as $error) {
                        $error_details =  "SQLSTATE: " . $error['SQLSTATE'] . " - ";
                        $error_details .= "code: " . $error['code'] . " - ";
                        $error_details .= "message: " . $error['message'] . "";
                    }
                }
            }


            $sqlx    = "DELETE FROM STEMPRESA_DUOCELL.dbo.FAPedido_detalle WHERE numero='".$data["txt_id"]."'";
            $paramsx = array();
            $stmtx   = sqlsrv_prepare($conx, $sqlx, $paramsx);
            if (sqlsrv_execute($stmtx) === false) {

                if (($errors = sqlsrv_errors()) != null) {
                    $error_details  = '';
                    foreach ($errors as $error) {
                        $error_details =  "SQLSTATE: " . $error['SQLSTATE'] . " - ";
                        $error_details .= "code: " . $error['code'] . " - ";
                        $error_details .= "message: " . $error['message'] . "";
                    }
                }
            }




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
*/

/*=============================================
ELIMINAR guia
=============================================*/
public function eliminar_oc($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


            /** CONSULTAMOS EXISTENCIA DE FACTURA **/
            include 'bdsql.php';
            $conx      = conexionSQLSI();
            $sqlx    = "SELECT reffactura FROM STEMPRESA_DUOCELL.dbo.FAPedido WHERE numero='".$data["txt_id"]."'";
            $paramsx = array();
            $resultado   = sqlsrv_prepare($conx, $sqlx, $paramsx);
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {

                $numero_factura =  $row["reffactura"];
            }
            if($numero_factura == '')
            {
                $sql_insert      = "update ordencompra set oc_estatus=5 WHERE oc_id  ='".$data["txt_id"]."'  ";
                $resultado       = $mysqli->query($sql_insert);
                if ($resultado) {
                $sqlx    = "DELETE FROM STEMPRESA_DUOCELL.dbo.FAPedido WHERE numero='".$data["txt_id"]."'";
                $paramsx = array();
                $stmtx   = sqlsrv_prepare($conx, $sqlx, $paramsx);
                if (sqlsrv_execute($stmtx) === false) {
    
                    if (($errors = sqlsrv_errors()) != null) {
                        $error_details  = '';
                        foreach ($errors as $error) {
                            $error_details =  "SQLSTATE: " . $error['SQLSTATE'] . " - ";
                            $error_details .= "code: " . $error['code'] . " - ";
                            $error_details .= "message: " . $error['message'] . "";
                        }
                    }
                }
    
    
                $sqlx    = "DELETE FROM STEMPRESA_DUOCELL.dbo.FAPedido_detalle WHERE numero='".$data["txt_id"]."'";
                $paramsx = array();
                $stmtx   = sqlsrv_prepare($conx, $sqlx, $paramsx);
                if (sqlsrv_execute($stmtx) === false) {
    
                    if (($errors = sqlsrv_errors()) != null) {
                        $error_details  = '';
                        foreach ($errors as $error) {
                            $error_details =  "SQLSTATE: " . $error['SQLSTATE'] . " - ";
                            $error_details .= "code: " . $error['code'] . " - ";
                            $error_details .= "message: " . $error['message'] . "";
                        }
                    }
                }
    
                    /** INSERTAR EN BITACORA DE ORDEN**/
                    $sql_insert = "INSERT INTO orden_bitacora 
                    ( 
                        id_orden,
                        accion,
                        id_usuario
                    ) 						
                    VALUES
                    (
                        '".$data['txt_id']."',
                        'Anulada',
                        '".$data['txt_user']."'
                    ) ";
                    $resultado  = $mysqli->query($sql_insert);
    
    
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
            }
            else
            {
                $Global->salir_json(2,"Orden de compra ya posee factura!!");
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
    $sql         = "SELECT oc_detalle.*, oc_total, oc_estatus FROM oc_detalle 
	inner join ordencompra on
	ordencompra.oc_id  = oc_detalle.id_ordencompra
	WHERE id_ordencompra='".$txt_id."' and estatus_oc<>5 ";

    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {


			$fila['imei'] = 1;//$this->verificar_imeis($fila['item'],$txt_id);
        
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
        $resut = 0;// $this->validar_item_cargado($data['txt_id'],$data['txt_user']);
                if($resut == 0)
                {
                    $pvp  = round($data['txt_precio'] /1.15,2);
					$dcto = round($data['txt_descuento'] /1.15,2); 
								
					$subtotal   = round($pvp * $data['txt_cantidad'],2);
					
					if($dcto > 0)
					{
						$dcto_total = round(((($pvp - $dcto) * $data['txt_cantidad'])),2);
					}
					else
					{
						$dcto_total = 0;
					}
					       
                    $iva = round(($subtotal-$dcto_total)*0.15,6);
                    $total = round((($subtotal - $dcto_total) + $iva),6);
                    $sql_insert = "INSERT INTO oc_detalle 
                    ( 	
                        id_ordencompra,`item`, `descripcion`, `cantidad`, `precio`,
                         `descuento`, `PVP`, `Dcto_iva`,  `iva`, `total`, direccion_entrega ,`usuario`
                        
                    ) 						
                    VALUES
                    (
						'" . $data['id_guia'] . "',
                        '" . $data['txt_id'] . "',
                        '" . $data['txt_text'] . "',
                        '" . $data['txt_cantidad'] . "',
                        '" . $data['txt_precio'] . "',
                        '" . $data['txt_descuento'] . "',
                        '".$subtotal."',
                        '".$dcto_total."',
                        '".$iva."',
                        '" . $total . "',
                        '" . $data['txt_direntrega'] . "',
                        '" . $data['txt_user'] . "'
                    ) ";
                }
                else
                {   

			              }
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {
				$mysqli->commit();
                $total = $this->total_venta($data['id_guia']);

				$sql_insert = "UPDATE ordencompra 
				set  `oc_total`= $total where oc_id ='" . $data['id_guia'] . "' ";
				$resultado  = $mysqli->query($sql_insert);
			if ($resultado) {
			}              
                $mysqli->commit();
                $Global->salir_json_total(1,"",$total);
            } else {
                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
            }
       

    $mysqli->close();
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
    $mysqli->autocommit(FALSE);
	
    
    $pvp = round($data['precio'] /1.12,2);
    $dcto = round($data['descuento'] /1.12,2);

    $iva = round(($pvp-$dcto)*0.12,2);

    $total = round($data['cantidad'] *  ($pvp-$dcto+$iva),2);


                 $sql_insert = "UPDATE oc_detalle SET
                 cantidad='".$data['cantidad']."',
                 `PVP`='".$pvp."',
                 `Dcto_iva`='".$dcto."',
                  `iva`='".$iva."', `total`='".$total."'
                  WHERE id ='".$data['txt_id_edit']."'";

              
            $resultado       = $mysqli->query($sql_insert);
            if ($resultado) {
                $mysqli->commit();
                $total = $this->total_venta($data['id_ordencompra']);

				$sql_insert2 = "UPDATE ordencompra 
				set  `oc_total`= $total where oc_id ='" . $data['id_ordencompra'] . "' ";
				$resultado  = $mysqli->query($sql_insert2);
			if ($resultado) {
			}              

                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'ORDEN COMPRA ITEM ESTADO';
                $data['dp_accion']         =  "EDITAR";
                $data['dp_descripcion']     = 'EDITAR ORDEN COMPRA ITEM: '.$data['txt_id_edit'];
                $data['dp_sql']             = $sql_insert;
                $data['dp_user']            = $data['txt_user'];
                $data['dp_fecha_registro']  = date('Y-m-d');
                $data['dp_hora_registro']   = date("g:i:s-a");
                $Global->bitacora_user($data);
              $mysqli->commit();
                //REALIZO INGRESO DE FECHA HORA AUTOMATICA POR FECHA+MENSAJERO

                $total = $this->total_venta($data['id_ordencompra']);
                $Global->salir_json(1,$total);

            } else {
                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
            }
           
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

        /** INSERTAR EN BITACORA DE ORDEN**/
        $sql_insert = "INSERT INTO orden_bitacora 
        ( 
            id_orden,
            accion,
            id_usuario
        ) 						
        VALUES
        (
            '".$data['txt_id_edit']."',
            'Aprobado',
            '".$data['txt_user']."'
        ) ";
        $resultado  = $mysqli->query($sql_insert);
			$actualizar = 2;
           
	} 
	if ($_SESSION["gb_perfil"]==6){
			$actualizar = 4;


            /** INSERTAR EN BITACORA DE ORDEN**/
            $sql_insert = "INSERT INTO orden_bitacora 
            ( 
                id_orden,
                accion,
                id_usuario
            ) 						
            VALUES
            (
                '".$data['txt_id_edit']."',
                'Despacho',
                '".$data['txt_user']."'
            ) ";
            $resultado  = $mysqli->query($sql_insert);
           
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
                

                

            } else {
                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
            }

           
    $mysqli->close();
}

/*=============================================
EDIT REQUERIMIENTO
=============================================*/
public function editar_estado_cobranza_bodega($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $dataid       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);

	

    
                 $sql_insert = "UPDATE ordencompra SET 
                 bodega_facturado='".$data['tipo']."'          
                  WHERE oc_id   ='".$data['txt_id_edit']."'";

              
            $resultado       = $mysqli->query($sql_insert);
            if ($resultado) {



                /** INSERTAR TABLAS SQLSERVER**/
                if($data['tipo'] == 2)
                {

                    //CONSULTAMOS DATOS DE LA ORDEN//
                    $rp_orden = "SELECT * FROM ordencompra WHERE oc_id='".$data['txt_id_edit']."'" ;
                    $query_rp_orden=$mysqli->query($rp_orden);
                    $n= $query_rp_orden->num_rows;
                    if($n>0)
                    {
                        $cod_vendedor   = 0;
						while ($registro_rp_orden=$query_rp_orden->fetch_assoc())
                        {
                            
                            $id_bodega = $registro_rp_orden['id_bodega'];
                            if($id_bodega == 0)
                            {
                                $id_bodega =12;
                            }
                            
                            $id_cliente = explode('-',$registro_rp_orden['id_cliente']);
							/** CONSULTAMOS CODIGO VENDEDOR DE USUARIO LOGEADO  **/
							 include 'bdsql.php';
                             $conx      = conexionSQLSI();
							 $resultado_c   = sqlsrv_query($conx,"SELECT Vendedor FROM CCCliente WHERE codigo='".$id_cliente[0]."'");
							 while ($row_c = sqlsrv_fetch_array($resultado_c, SQLSRV_FETCH_ASSOC)) 
							 {
									$cod_vendedor   =  $row_c['Vendedor']; 
							 }
                             
                             if($registro_rp_orden['dias_credito'] == '' OR $registro_rp_orden['dias_credito'] == NULL)
                             {
                                $dias_credito = 0;
                             }
                             else
                             {
                                $dias_credito = $registro_rp_orden['dias_credito'] ;
                             }
							
                            $fechaHora = date('Y-d-m H:i:s') . '.000';
                            //INSERTAMOS CABECERA DE LA ORDEN//
                            $sqlx    = "INSERT INTO STEMPRESA_DUOCELL.dbo.FAPedido(numero, estado, cliente,  vendedor, fechafac, comentario, total,usuario, fechadig,DiasPlazo)VALUES(?,?,?,?,?,?,?,?,?,?)";
                            $paramsx = array($registro_rp_orden['oc_id'],'1',$id_cliente[0],$cod_vendedor,date('Y-m-d'),$registro_rp_orden['oc_observaciones'],$registro_rp_orden['oc_total'],$cod_vendedor,$fechaHora,$dias_credito);
                            $stmtx   = sqlsrv_prepare($conx, $sqlx, $paramsx);
                            if (sqlsrv_execute($stmtx) === false) {
                                
                                if( ($errors = sqlsrv_errors() ) != null) {
                                    $error_details  ='';
                                    foreach( $errors as $error ) {
                                        $error_details =  "SQLSTATE: ".$error[ 'SQLSTATE']." - ";
                                        $error_details .= "code: ".$error[ 'code']." - ";
                                        $error_details .= "message: ".$error[ 'message']."";
                                    }
                                    
                                }

                                $arch = fopen("SQL_INSERT_FAPedido.txt", "a+"); 
                                fwrite($arch,'Fecha : '.date('Y-m-d H:i:s').' : '.$error_details."\r\n");
                                fclose($arch);
                            
                                
                            }

                            //CONSULTAMOS DETALLE DE LA ORDEN//
                            $cantidaddeitems=0;
                            $rp_detalles = "SELECT * FROM oc_detalle WHERE id_ordencompra='".$data['txt_id_edit']."'" ;
                            $query_detalles=$mysqli->query($rp_detalles);
                            $n= $query_detalles->num_rows;
                            if($n>0)
                            {
                                while ($registro_detalles=$query_detalles->fetch_assoc())
                                {
                                        $cantidaddeitems=$cantidaddeitems+1;

                                        
                                  /*
                                        $dbconn      = conexionSQLSI();
                                        $resultado   = sqlsrv_query($dbconn, "SELECT sum(stock) existencia, codigo  FROM INExistencia
                                                WHERE  codigo  = '" . $registro_detalles['item'] . "' AND bodega='" . $registro_detalles['id_bodega'] . "' group by codigo ");
                                        while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                                            if ($registro_detalles['cantidad'] <= ($row['existencia'])) {
                                                $paso = 1;
                                            } else {
                                                $paso = 0;
                                                $Global->salir_json(2,"Producto : '".$registro_detalles['descripcion']."' Stock Starcom  : '".$row['existencia']."' es inferior al solicitado : '".$registro_detalles['cantidad']."' ");
                                            }
                                        }
                                        */
                                        //if($paso==1)
                                        if(1==1)
                                        {
                                            
											
											$precio  = round($registro_detalles['precio'] /1.15,2);
											$sqly = "INSERT INTO STEMPRESA_DUOCELL.dbo.FAPedido_detalle
                                            (numero, estado, linea, Bodega, Producto,  cantidad, precio,  precioneto,
                                            valordes, valoriva, fecha, cliente)
                                            VALUES(?,?,?,?,?,?,?,?,?,?,?,?) ";
                                            $paramsy = array($registro_rp_orden['oc_id'],'1',$cantidaddeitems,$registro_detalles['id_bodega'],$registro_detalles['item'],$registro_detalles['cantidad'], $precio, $precio,$registro_detalles['descuento'],$registro_detalles['iva'],date('Y-m-d'),$id_cliente[0]);
                                            $stmty = sqlsrv_prepare($conx, $sqly, $paramsy);
                                            if (sqlsrv_execute($stmty) === false) {
                                
                                                if( ($errors2 = sqlsrv_errors() ) != null) {
                                                    $error_details2  ='';
                                                    foreach( $errors2 as $error2 ) {
                                                        $error_details2 =  "SQLSTATE: ".$error2[ 'SQLSTATE']." - ";
                                                        $error_details2 .= "code: ".$error2[ 'code']." - ";
                                                        $error_details2 .= "message: ".$error2[ 'message']."";
                                                    }
                                                    
                                                }
                    
                                                $arch = fopen("SQL_INSERT_FAPedido_detalle.txt", "a+"); 
                                                fwrite($arch,'Fecha : '.date('Y-m-d H:i:s').' : '.$error_details2."\r\n");
                                                fclose($arch);
                                                
                                            }
                                        }
                                }
                            }
                        }
                    }
                    /** FIN INSERTAR TABLAS SQLSERVER**/
                }
                
                /** INSERTAR EN BITACORA DE ORDEN**/
            $sql_insert = "INSERT INTO orden_bitacora 
            ( 
                id_orden,
                accion,
                id_usuario
            ) 						
            VALUES
            (
                '".$data['txt_id_edit']."',
                'Por Facturar',
                '".$data['txt_user']."'
            ) ";
            $resultado  = $mysqli->query($sql_insert);

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
				$Global->salir_json(1,'');
                //REALIZO INGRESO DE FECHA HORA AUTOMATICA POR FECHA+MENSAJERO

                

            } else {
                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
            }

           
    $mysqli->close();
}



/*=============================================
TABLE ORDEN BITACORA
=============================================*/
public function table_orden_bitacora($txt_id)
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT * FROM orden_bitacora WHERE id_orden='".$txt_id."' ";
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

			
        if($fila['id_usuario'] == 0)
        {
            $fila['usuario'] = $fila['usuario_starconf'];
        }
        else
        {
            $fila['usuario'] = $this->usuario_reserva($fila['id_usuario']);
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
ESTADO ORDEN
=============================================*/
public function estado_orden($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


    $sql_insert = "update ordencompra set oc_estatus='".$data["txt_estado_orden"]."' WHERE  oc_id ='".$data['txt_id']."'";
    $resultado  = $mysqli->query($sql_insert);
    if ($resultado) {

        if($data['txt_estado_orden'] == 2)
        {
            $txt_estado_orden = 'Aprobado';
        }
        if($data['txt_estado_orden'] == 3)
        {
            $txt_estado_orden = 'Rechazado';
        }
        if($data['txt_estado_orden'] == 6)
        {
            $txt_estado_orden = 'Observado';
        }


        /** INSERTAR EN BITACORA DE ORDEN**/
        $sql_insert = "INSERT INTO orden_bitacora 
        ( 
            id_orden,
            accion,
            observaciones,
            id_usuario
        ) 						
        VALUES
        (
            '".$data['txt_id']."',
            '".$txt_estado_orden."',
            '".$data['txt_observaciones_orden']."',
            '".$data['txt_user']."'
        ) ";
        $resultado  = $mysqli->query($sql_insert);
       
        $mysqli->commit();
        $Global->salir_json(1,"");

    } else {
        $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
    }

}

}



