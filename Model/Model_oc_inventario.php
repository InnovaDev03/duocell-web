<?php
class ModelOcInventario
{


		/*=============================================
		BUSCADOS PREDICTIVO PROMOTOR
		=============================================*/
		public function serarch_promotor($term)
		{
			$mysqli      = conexionMySQL();


			$sql = "SELECT gb_id,gb_nombre FROM gb_usuarios WHERE gb_nombre  LIKE '%$term%'  and gb_id_perfil=3 limit 20";
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
		
		/*	$fechainicio    = $Global->formatearFecha($dato['txt_fechain']);
		$fechafin   	= $Global->formatearFecha($dato['txt_fechafin']);
		$txt_promotor   = $dato['txt_promotor'];
		$txt_cadena		= $dato['txt_cadena'];
		$txt_estado		= $dato['txt_estado'];
		*/
        $txt_user		= $dato['txt_user'];
        $txt_gb_perfil  = $dato['txt_gb_perfil'];
		$contador = 0;


		
		$data        = array();


//CONEXION A LA BD DUOCELL POSTGRES PARA OBTENER DATA
include 'bdsql.php';
$conn      = conexionSQLSI();
$sql         = "select nombre, INProducto.codigo, sum(INExistencia.stock) AS stock from INProducto inner join INExistencia on
INExistencia.codigo  = INProducto.codigo 
 WHERE  INProducto.estado='A'
 AND bodega='".$dato['txt_bodega']."'
group by INProducto.codigo, nombre
ORDER BY nombre ASC
 ";
//$resultado   = $mysqli->query($sql);
//echo $sql;
$resultado   = sqlsrv_query($conn, $sql);// $mysqli->query($sql);
    
$contador=0;

while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {




  //  $data[]   = $fila;
$contador=$contador+1;
//echo $fila['ruc'].'<br>';

//consultamos cuanto se han vendido
$mysqli       = conexionMySQL();
$mysqli->autocommit(FALSE);
//CONSULTAMOS EL PRODUCTO EN ORDENES DE COMPRA PREVIAS
$total=0;
$total_facturado = 0;
$total_anulado =0;
$rp_detalles = "SELECT sum(cantidad) as total FROM oc_detalle WHERE item='".$row['codigo']."' AND id_ordencompra NOT IN (336,339,453) AND id_bodega='".$dato['txt_bodega']."' ";
$query_detalles=$mysqli->query($rp_detalles);
while ($registro_detalles2=$query_detalles->fetch_assoc())
{
	if ($registro_detalles2['total'] !=''){

		/** CONSULTAMOS QUE ESTA FACTURADO **/
		$rp_detalles1 = "SELECT id_ordencompra,cantidad FROM oc_detalle WHERE item='".$row['codigo']."' AND id_bodega='".$dato['txt_bodega']."' " ;
		$query_detalles1=$mysqli->query($rp_detalles1);
		while ($registro_detalles21=$query_detalles1->fetch_assoc())
		{
			/** VERIFICAMOS CANTIDADES ANULADAS **/
			$rp_detalles2 = "SELECT oc_id,oc_estatus FROM ordencompra WHERE oc_id='".$registro_detalles21['id_ordencompra']."' AND oc_estatus =5" ;
			$query_detalles2=$mysqli->query($rp_detalles2);
			while ($registro_detalles22=$query_detalles2->fetch_assoc())
			{
				$total_anulado = $total_anulado + $registro_detalles21['cantidad'];
				$oc_estatus = $registro_detalles22['oc_estatus'];
			}




			$rp_detalles23 = "SELECT oc_id,oc_estatus FROM ordencompra WHERE oc_id='".$registro_detalles21['id_ordencompra']."'" ;
			$query_detalles23=$mysqli->query($rp_detalles23);
			$registro_detalles223=$query_detalles23->fetch_assoc();
			if($registro_detalles223['oc_estatus'] != 5)
			{
				$sql1 = "SELECT numero FROM FAPedido WHERE numero='".$registro_detalles21['id_ordencompra']."' AND reffactura !=''";
				$resultado1   = sqlsrv_query($conn, $sql1);
				while ($row1 = sqlsrv_fetch_array($resultado1, SQLSRV_FETCH_ASSOC)) 
				{
					$total_facturado = $total_facturado + $registro_detalles21['cantidad'];
				}
			}
		}	
		
	

		$total=$registro_detalles2['total'] - $total_facturado - $total_anulado;
		 
	} 
	else 
	{
		$total = 0;
	}
}



//reserva
$total2=0;
$rp_detalles = "SELECT sum(cantidad) as total FROM  rv_detalle WHERE item='".$row['codigo']."' and estatus_oc <>0" ;
$query_detalles=$mysqli->query($rp_detalles);
while ($registro_detalles2=$query_detalles->fetch_assoc())
{
	if ($registro_detalles2['total'] !=''){
		$total2=$registro_detalles2['total'] ;
		 
	} else {
						$total2 = 0;
	}
}
			//	echo 'el total esde ' . $total . ' y tambien '.$row[0] . ' es '. $row[1];
//$mysqli->close();
if($row['stock'] == '' OR $row['stock'] == NULL)
{
	$row['stock'] = 0;
}
else
{
	$row['stock'] = $row['stock'];
}

			  $datax["stock"] = ($row['stock'])- $total -$total2;
				$datax["id"] = $contador;
				$datax["descripcion"] =	$row['nombre'];
				$datax["stockfragata"] =	($row['stock']);
				$datax["totalreserva"] =	$total2;
				$datax["ocsproceso"] =	$total;
			  $datax["item"]   =  $row['codigo'];
			  $data[] = $datax;



  }

  
if($contador!=0){
    
} else {
    
    $fila["text"]		= "...!0 RESULTADOS!...";
    $fila["id"]			= "0";
    $data[] = $fila;
}


		$mysqli->close();
		return $data;
	}

private function orden_facturadas($codigo)
{
	$mysqli      = conexionMySQL();
	$total=0;
	$rp_detalles = "SELECT id_ordencompra,cantidad FROM oc_detalle WHERE item='".$codigo."' and estatus_oc <4" ;
	$query_detalles=$mysqli->query($rp_detalles);
	while ($registro_detalles2=$query_detalles->fetch_assoc())
	{
		$sql = "SELECT numero FROM FAPedido WHERE numero='".$registro_detalles2['id_ordencompra']."' AND reffactura !=''";
		$resultado   = sqlsrv_query($conn, $sql);
		while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) 
		{
			$total = $total + $registro_detalles2['cantidad'];
		}
	}
	return $total;
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
    $sql         = "SELECT * FROM   estados ";
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

    
                 $sql_insert = "UPDATE oc_detalle SET
                 estatus_oc=4,               
                 usuario='".$data['txt_user']."'
                  WHERE id  ='".$data['txt_id_edit']."'";

              
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
TABLE VENTA DETALLE ORIGINALES BD
=============================================*/
public function table_venta($txt_id)
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT sum(cantidad) as cantidad, id_cliente, oc_fecha FROM rv_detalle 
	inner join reserva on
	reserva.oc_id  = rv_detalle.id_ordencompra
	WHERE item='".$txt_id."' and estatus_oc=1 and oc_estatus=1 group by id_cliente, oc_fecha order by id_cliente asc ";

    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

        $data[]   = $fila;
    }
    $mysqli->close();
    return $data;
}




   /*=============================================
	TABLE ITEM BLOQUEADOS
	=============================================*/
	public function table_ventas_bloeuqeo($dato)
	{
		$mysqli      = conexionMySQL();
		$Global         = new ModelGlobal();
		
		ini_set('memory_limit', '64M');
		ini_set('max_execution_time', 9000000);
		$data        = array();
		include 'bdsql.php';
		$conn      = conexionSQLSI();
		$sql         = "SELECT  nombre,codigo FROM  INProducto";
		$resultado   = sqlsrv_query($conn, $sql);
		$contador=0;
		while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) 
		{
			$mysqli         = conexionMySQL();
			$rp_detalles    = "SELECT codigo,tiempo FROM item_bloqueados WHERE codigo='".$row['codigo']."'";
			$query_detalles = $mysqli->query($rp_detalles);
			$n              = $resultado->num_rows;
			if ($n > 0) {
				$registro_detalles2=$query_detalles->fetch_assoc();

				$fila['estado'] = '<stron><span style="color: red;"> TIEMPO BLOQUEO '.$registro_detalles2['tiempo'].'</span></stron>';
			}
			else
			{
				$fila['estado'] ='';
			}
		}
		if($contador!=0)
		{
			
		} else 
		{
			$fila["text"]		= "...!0 RESULTADOS!...";
			$fila["id"]			= "0";
			$data[] = $fila;
		}
		$mysqli->close();
		return $data;
	}

}
