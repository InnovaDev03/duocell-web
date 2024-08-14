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
		BUSCADOS PREDICTIVO CLIENTE
		=============================================*/
		public function serarch_cliente($term)
		{
			$mysqli      = conexionMySQL();

			if(is_numeric($term))
			{
				$sql = "SELECT pr_id_cliente,pr_nombre_cliente FROM pr_venta_mercaderista WHERE pr_id_cliente  LIKE '%$term%' limit 20";
			}
			else
			{
				$sql = "SELECT pr_id_cliente,pr_nombre_cliente FROM pr_venta_mercaderista WHERE pr_nombre_cliente  LIKE '%$term%' limit 20";
			}
			$resultado = $mysqli->query($sql);
			$n = $resultado->num_rows;
			$data = array();
			$datax = array();
			if ($n > 0) {
				while ($fila = $resultado->fetch_assoc()) {

					$datax["text"] =  $fila["pr_id_cliente"].'-'.$fila["pr_nombre_cliente"];
					$datax["id"]   =  $fila["pr_id_cliente"];
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
		$txt_cliente    = $dato['txt_cliente'];
			$txt_promotor    = $dato['txt_promotor'];
        $txt_user		= $dato['txt_user'];
        $txt_gb_perfil  = $dato['txt_gb_perfil'];

		
		$data        = array();


			$where_condition = $sqlTot = $sqlRec = "";
			if (!empty($dato['search']['value'])) {
				$where_condition .=	" and ";
				$where_condition .= " ( pr_codigo LIKE '%" . $dato['search']['value'] . "%' ";

			}
		
		$sql_query      = "SELECT v.pr_codigo,v.pr_fecha,v.pr_fecha_registro,v.pr_forma_pago,v.pr_id_cliente,v.pr_nombre_cliente,d.pr_descripcion,i.pr_imei,d.pr_total,v.pr_id_usuario
							FROM pr_venta_detalle_mercaderista d
							INNER JOIN pr_venta_mercaderista v
							ON d.pr_id_venta=v.pr_id
							INNER JOIN pr_venta_imei_mercaderista i
							ON i.pr_id_venta=v.pr_id
							WHERE d.pr_item=i.pr_id_articulo 
							AND v.pr_fecha BETWEEN '".($fechainicio)."' AND '".($fechafin)."' ";
		
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
        
		if($txt_cliente != 0)
		{
			$sql_query         .= " AND v.pr_id_cliente ='". $txt_cliente."'  ";
		}


		
		$sqlTot .= $sql_query;
			
			$sqlRec .= $sql_query;
			$sqlTot .= $where_condition;
			$sqlRec .= $where_condition;
		//	$sqlRec .=  " LIMIT ".$dato['start']." ,".$dato['length']." ";

			$resultado = $mysqli->query($sqlTot);
			$totalRecords = $resultado->num_rows;
            if($totalRecords == 0)
            {
                $totalRecords =0;
            }
			$queryRecords = $mysqli->query($sqlRec);
			
			$a		   = 1;	
 
			while ($fila = $queryRecords->fetch_assoc()) {


			$fila['datos']    = '<strong>Codigo : </strong>'.$fila['pr_codigo'].'<br>'.'<strong>Fecha : </strong>'.$fila['pr_fecha'].
			                    '<br>'.'<strong>Fecha Registro: </strong>'.$fila['pr_fecha_registro'];
			$fila['promotor']    = '<strong>Promotor : </strong>'.$this->promotor($fila['pr_id_usuario']);
			$fila['cliente']      =  $fila['pr_nombre_cliente'];
			$fila['item']        =	 $fila['pr_descripcion'];
			$fila['imei']        =	 $fila['pr_imei'];
			$fila['forma_pago']  =	 $fila['pr_forma_pago'];
			$fila['valor']       =	 $fila['pr_total'];
			
			$fila['totalRecords']  	= $totalRecords;
			$data[]              = $fila;
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
/*=============================================
TABLE IMEIS
=============================================*/
public function table_imeis($txt_id)
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT d.pr_descripcion,i.pr_imei FROM pr_venta_detalle_mercaderista d
                    INNER JOIN pr_venta_imei_mercaderista i
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



}
