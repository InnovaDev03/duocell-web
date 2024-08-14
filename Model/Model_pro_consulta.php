<?php
class ModelProCounsulta
{


		/*=============================================
		BUSCADOS PREDICTIVO PROMOTOR
		=============================================*/
		public function serarch_promotor($term)
		{
			$mysqli      = conexionMySQL();


			$sql = "SELECT gb_id,gb_nombre FROM gb_usuarios WHERE gb_nombre  LIKE '%$term%' limit 20";
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
		
		ini_set('memory_limit', '64M');
		ini_set('max_execution_time', 9000000);
		
		$fechainicio    = $Global->formatearFecha($dato['txt_fechain']);
		$fechafin   	= $Global->formatearFecha($dato['txt_fechafin']);
		$txt_promotor   = $dato['txt_promotor'];
		$txt_cadena		= $dato['txt_cadena'];
		$txt_tienda		= $dato['txt_tienda'];
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
		$sql_query      = "SELECT d.pr_id, v.pr_codigo,v.pr_fecha,v.pr_fecha_registro,v.pr_forma_pago,v.pr_id_cadena,v.pr_id_tienda,d.pr_descripcion,d.pr_total,v.pr_id_usuario, d.pr_cantidad as cantidad
							FROM pr_venta_detalle d
							INNER JOIN pr_venta v
							ON d.pr_id_venta=v.pr_id
							WHERE d.estatus <>0 and  v.pr_fecha BETWEEN '".($fechainicio)."' AND '".($fechafin)."' ";
		
		if($txt_gb_perfil != 1)
		{
			$sql_query         .= " AND v.pr_id_usuario ='". $txt_user."'  ";
		}
        else
        {
            if($txt_promotor != 0)
            {
                $sql_query         .= " AND v.pr_id_usuario ='". $txt_promotor."'  ";
            }
        }
        
		if($txt_cadena != 0)
		{
			$sql_query         .= " AND v.pr_id_cadena ='". $txt_cadena."'  ";
		}

		 if($txt_tienda != 0)
		{
			$datoconcat='';
			$totalc = count($_REQUEST['txt_tienda']);
		for ($i=0; $i <$totalc; $i++) { 
			$datoconcat=  $datoconcat.','. $_REQUEST['txt_tienda'][$i];
			# code...
		}
		$datoconcat= substr($datoconcat,1);
			$sql_query         .= " AND v.pr_id_tienda  in (". $datoconcat.")  ";
         
		}
		
		$sqlTot .= $sql_query;
			
			$sqlRec .= $sql_query;
			$sqlTot .= $where_condition;
			$sqlRec .= $where_condition;
			$sqlRec .=  " LIMIT ".$dato['start']." ,".$dato['length']." ";

			//echo $sql_query;
			$resultado = $mysqli->query($sqlTot);
			$totalRecords = $resultado->num_rows;
            if($totalRecords == 0)
            {
                $totalRecords =0;
            }
			$queryRecords = $mysqli->query($sqlRec);
			
			$a		   = 1;	
 
			while ($fila = $queryRecords->fetch_assoc()) {

				$datoid = $fila['pr_id'];
			$fila['datos']    = '<strong>Codigo : </strong>'.$fila['pr_codigo'].'<br>'.'<strong>Fecha : </strong>'.$fila['pr_fecha'].
			                    '<br>'.'<strong>Fecha Registro: </strong>'.$fila['pr_fecha_registro'];
			$fila['promotor']    = '<strong>Promotor : </strong>'.$this->promotor($fila['pr_id_usuario']);
			$fila['cadena']      = '<strong>Cadena : </strong>'.$this->cadena($fila['pr_id_cadena']).'<br>'.'<strong>Tienda : </strong>'.$this->tienda($fila['pr_id_tienda']);
			$fila['item']        =	 $fila['pr_descripcion'];
			//$fila['imei']        =	 $fila['pr_imei'];
			$fila['forma_pago']  =	 $fila['pr_forma_pago'];
			$fila['valor']       =	 $fila['pr_total'];
			$fila['cantidad']       =	 $fila['cantidad'];
			$fila['button']       =	'<button type="button" nombre="'.$datoid.'" class="btn btn-xs btn-danger btn_delete_registro">
			<acronym title="Eliminar registro!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i>
			</acronym></button>';


			
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

private function promotor($txt_id)
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



	
public function disabled_registro($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);

                    
            $sql_insert = "UPDATE pr_venta_detalle SET estatus='0',`id_user_delete`='".$data['txt_user']."',
			`fecha_horamod`='".date('Y-m-d H:i:s')."' WHERE pr_id='".$data['txt_id']."'  ";
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'PARAMETRIZACION->CADENA';
                $data['dp_accion']         =  "DESACTIVAR";
                $data['dp_descripcion']     = 'DESACTIVAR CADENA : '.$data['txt_id'];
                $data['dp_sql']             = $sql_insert;
                $data['dp_user']            = $data['txt_user'];
                $data['dp_fecha_registro']  = date('Y-m-d');
                $data['dp_hora_registro']   = date("g:i:s-a");
                $Global->bitacora_user($data);
                $mysqli->commit();
                
                $Global->salir_json(1,"");
            } else {
                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
            }
       

    $mysqli->close();
}




}
