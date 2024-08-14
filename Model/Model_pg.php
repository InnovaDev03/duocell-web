<?php
class ModelPg
{
    /*=============================================
    BUSCADOS PREDICTIVO DE ARTICULOS
    =============================================*/
    public function serarch_productos($term)
    {
      include 'bdsql.php';

      
$conn      = conexionSQLSI();
$sql         = "select top 20 nombre, codigo,categoria from INProducto  WHERE nombre  LIKE '%".$term."%'  ";
$resultado   = sqlsrv_query($conn, $sql);// $mysqli->query($sql);
$contador=0;
while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
  //  $data[]   = $fila;
$contador=$contador+1;
//echo $fila['ruc'].'<br>';

$datax["text"] =  $row['nombre'];
$datax["id"]   =  $row['codigo'];
$datax["categoria"]   =  $row['categoria'];
$data[] = $datax;

  }

  
if($contador!=0){
    
} else {
    
    $fila["text"]		= "...!0 RESULTADOS!...";
    $fila["id"]			= "0";
    $data[] = $fila;
}

        return $data;
    }


    /*=============================================
    BUSCADOS PREDICTIVO DE CLIENTES
    =============================================*/
    public function serarch_cliente($term,$id_usuario)
    {
        /** CONSULTAMOS CODIGO VENDEDOR DE USUARIO LOGEADO  **/
        $mysqli       = conexionMySQL();
        $sql_codigo      = "SELECT cod_vendedor,gb_id_perfil FROM gb_usuarios WHERE gb_id='".$id_usuario."'" ;
        $query_codigo    = $mysqli->query($sql_codigo);
        $registro_codigo = $query_codigo->fetch_assoc();
        $cod_vendedor    = $registro_codigo['cod_vendedor'];
        $gb_id_perfil    = $registro_codigo['gb_id_perfil'];

        if ($gb_id_perfil == 1 || $gb_id_perfil == 7 || $gb_id_perfil == 8 || $gb_id_perfil == 6) {
            $concat = '';
        } else {
            $concat = " AND CCCliente.Vendedor='" . $cod_vendedor . "' ";
        }


        
        include 'bdsql.php';

      
        $dbconn      = conexionSQLSI();
       
       
        $contador=0;
        
          //  $data[]   = $fila;

        
            if(is_numeric($term))
            {
                $resultado   = sqlsrv_query($dbconn,"
                SELECT top 20 CCCliente.codigo, CCCliente.RazonSocial, CCCliente.canal, CCCliente.subcanal, CCCanal.Descripcion  canalnombre, CCSubCanal.Descripcion subcanalnombre, CCCliente.codigo, CCCliente.Vendedor, FAVendedor.nombre, CCCliente.saldocupo,CCCliente.ruc,CCCliente.dias
                FROM CCCliente
left join CCCanal on
CCCanal.Codigo = CCCliente.canal
left join CCSubCanal on
CCSubCanal.Codigo = CCCliente.subcanal
left join FAVendedor on
FAVendedor.codigo = CCCliente.Vendedor
  WHERE CCCliente.codigo LIKE '%".$term."%' AND CCCliente.activo='S' AND CCCliente.estado='A' $concat ");
            }
            else
            {
                $resultado   = sqlsrv_query($dbconn,"
                SELECT top 20 CCCliente.codigo, CCCliente.RazonSocial, CCCliente.canal, CCCliente.subcanal, CCCanal.Descripcion  canalnombre, CCSubCanal.Descripcion subcanalnombre, CCCliente.codigo, CCCliente.Vendedor, FAVendedor.nombre, CCCliente.saldocupo,CCCliente.ruc,CCCliente.dias
                FROM CCCliente
left join CCCanal on
CCCanal.Codigo = CCCliente.canal
left join CCSubCanal on
CCSubCanal.Codigo = CCCliente.subcanal
left join FAVendedor on
FAVendedor.codigo = CCCliente.Vendedor
 WHERE CCCliente.RazonSocial  LIKE '%".$term."%' AND CCCliente.activo='S'  AND CCCliente.estado='A' $concat ");
            }
     // echo $resultado;

 

            $contador=0;
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {

                $contador=$contador+1;

                $datax["text"] =  $row['codigo'].'-'.$row['RazonSocial'].'-'.$row['nombre'].'-'.$row['ruc'];
                $datax["id"]   =  $row['codigo'];
                $datax["canal"]   =  $row['canal'];
                $datax["subcanal"]   =  $row['subcanal'];
                $datax["canalnombre"]   =  $row['canalnombre'];
                $datax["subcanalnombre"]   =  $row['subcanalnombre'];
                $datax["codigocliente"]   =  $row['codigo'];
                $datax["codigovendedor"]   =  $row['Vendedor'];
                $datax["dias"]   =  $row['dias'];

                /* CALCULAMOS SALDO VENCIDO*/
                $saldo_vencido =0;
                $sql_saldo_vencido   = sqlsrv_query($dbconn,"SELECT SUM(saldos) as saldos FROM Vcc_Facturas_Vencidas WHERE codcliente='".$row['codigo']."'");
                while ($row_sql_saldo_vencido = sqlsrv_fetch_array($sql_saldo_vencido, SQLSRV_FETCH_ASSOC)) 
                {
                    $saldo_vencido = $row_sql_saldo_vencido['saldos'];  
                }
                $datax["saldo_vencido"]   =  $saldo_vencido;


                /* CALCULAMOS CUPO DISPONIBLE */
                $cupo_disponible =0;
                $sql_cupo_disponible   = sqlsrv_query($dbconn,"SELECT CUPODISPONIBLE as cupo FROM VCc_clientes_cupo WHERE CODIGO='".$row['codigo']."'");
                while ($row_sql_cupo_disponible = sqlsrv_fetch_array($sql_cupo_disponible, SQLSRV_FETCH_ASSOC)) 
                {
                    $cupo_disponible = $row_sql_cupo_disponible['cupo'];  
                }
                $datax["cupo_disponible"]   =  $cupo_disponible;

               
                $data[] = $datax;
                
            }


            if($contador!=0){
    
            } else {
                $fila["text"]		= "...!0 RESULTADOS!...";
                $fila["id"]			= "0";
                $datax["canal"]   =  "0";
                $datax["subcanal"]   = "0";
                $datax["canalnombre"]   ="0";
                $datax["subcanalnombre"]   ="0";
                $datax["codigocliente"]   = "0";
                $datax["codigovendedor"]   =  "0";
                $datax["txt_cupodisponible"]   =  "0";
                $datax["txt_saldovencido"]   =  "0";

                $data[] = $fila;
            }
        return $data;
    }


     /*=============================================
    VALIDAR IMEI
    =============================================*/
    public function validar_imei_duocel($txt_imei)
    {
    
        include 'bdpostgres.php';
          $dbconn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass")
          or die('Could not connect: ' . pg_last_error());

          if (!$dbconn)
            {
            $result["result"] = 0;
            $result["error"] = 'Ocurrio un error en la conexion!!';
            echo json_encode($result);
            exit;
            }

        

        $result = pg_query($dbconn,"SELECT id_ref_doc_in FROM public.inv_inventario_serie where serie = $txt_imei");
        $rows = pg_num_rows($result);
        if($rows <= 0){

                $salida = 0;
        }
        else
        {
             $salida = 1;
        }
        return $salida;
    }

    /*=============================================
    VALIDAR IMEI MERCADERISTA
    =============================================*/
    public function validar_imei_duocel_mercaderista($txt_imei,$txt_item)
    {
    
        include 'bdpostgres.php';

          $dbconn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass")
          or die('Could not connect: ' . pg_last_error());

          if (!$dbconn)
            {
            $result["result"] = 0;
            $result["error"] = 'Ocurrio un error en la conexion!!';
            echo json_encode($result);
            exit;
            }

        

            $result = pg_query($dbconn,"SELECT t.item_id,t.descripcion_abrev FROM public.inv_inventario_serie s
            INNER JOIN  public.inv_inventario i
            ON s.id_inventario=i.id
            INNER JOIN public.inv_item t
            ON i.codigo_item=t.codigo_item
            WHERE s.serie = $txt_imei
            AND t.item_id=$txt_item
            LIMIT 1");
        $rows = pg_num_rows($result);
        if($rows <= 0){

                $salida = 0;
        }
        else
        {
             $salida = 1;
        }
        return $salida;
    }


    /*=============================================
    BUSCAR PRODUCTO POR IME
    =============================================*/
    public function buscar_producto_imei_duocel($txt_imei)
    {
        include 'bdpostgres.php';

          $dbconn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass")
          or die('Could not connect: ' . pg_last_error());

          if (!$dbconn)
            {
            $result["result"] = 0;
            $result["error"] = 'Ocurrio un error en la conexion!!';
            echo json_encode($result);
            exit;
            }

        

        $result = pg_query($dbconn,"SELECT t.item_id,t.descripcion_abrev FROM public.inv_inventario_serie s
                                    INNER JOIN  public.inv_inventario i
                                    ON s.id_inventario=i.id
                                    INNER JOIN public.inv_item t
                                    ON i.codigo_item=t.codigo_item
                                    WHERE s.serie = $txt_imei
                                    LIMIT 1");
        $rows = pg_num_rows($result);
        if($rows > 0){

            $row = pg_fetch_row($result);


            $salida[0] =1;
            $salida[1] =$row[0];
            $salida[2] =$row[1];

        }
        else
        {
            $salida[0] =0;
            $salida[1] ='';
            $salida[2] ='';
        }
        return $salida;
    }



/*=============================================
    BUSCADOS PREDICTIVO DE ARTICULOS
    =============================================*/
    public function serarch_stockproductos($term,$txt_bodega)
    {
        $Global  = new ModelGlobal();
        
        $dataxr       = array();
        $mysqli       = conexionMySQL();
        $mysqli->autocommit(FALSE);

        include 'bdsql.php'; 
        $dbconn      = conexionSQLSI();
        //CONSULTAMOS EL PRODUCTO EN ORDENES DE COMPRA PREVIAS
        $total=0;
        $total2=0;
        $total_facturado =0;
        $total_anulado =0;

    $rp_detalles = "SELECT sum(cantidad) as total FROM oc_detalle WHERE item='".$term."' AND id_bodega='".$txt_bodega."' AND id_ordencompra NOT IN (336,339,453)" ;
    $query_detalles=$mysqli->query($rp_detalles);
    while ($registro_detalles2=$query_detalles->fetch_assoc())
    {
        
        /** CONSULTAMOS QUE ESTA FACTURADO **/
		$rp_detalles1 = "SELECT id_ordencompra,cantidad FROM oc_detalle WHERE item='".$term."' AND id_bodega='".$txt_bodega."'" ;
		$query_detalles1=$mysqli->query($rp_detalles1);
		while ($registro_detalles21=$query_detalles1->fetch_assoc())
		{
			
            /** VERIFICAMOS CANTIDADES ANULADAS **/
			$rp_detalles2 = "SELECT oc_id FROM ordencompra WHERE oc_id='".$registro_detalles21['id_ordencompra']."' AND oc_estatus =5" ;
			$query_detalles2=$mysqli->query($rp_detalles2);
			while ($registro_detalles22=$query_detalles2->fetch_assoc())
			{
				$total_anulado = $total_anulado + $registro_detalles21['cantidad'];
			}
            
            $rp_detalles23 = "SELECT oc_id,oc_estatus FROM ordencompra WHERE oc_id='".$registro_detalles21['id_ordencompra']."'" ;
			$query_detalles23=$mysqli->query($rp_detalles23);
			$registro_detalles223=$query_detalles23->fetch_assoc();
			if($registro_detalles223['oc_estatus'] != 5)
			{
                $sql1 = "SELECT numero FROM FAPedido WHERE numero='".$registro_detalles21['id_ordencompra']."' AND reffactura !=''";
                $resultado1   = sqlsrv_query($dbconn, $sql1);
                while ($row1 = sqlsrv_fetch_array($resultado1, SQLSRV_FETCH_ASSOC)) 
                {
                    $total_facturado = $total_facturado + $registro_detalles21['cantidad'];
                }
            }

           
		}
        
        $total=$total + $registro_detalles2['total'] - $total_facturado - $total_anulado;
    }   
    
    
    //total de reserva de ese prodyucto
    if($txt_bodega == 12)
    {
        $rp_detalles = "SELECT sum(cantidad) as total FROM rv_detalle WHERE item='".$term."' and estatus_oc <>0 and cantidad>0" ;
        $query_detalles=$mysqli->query($rp_detalles);
        while ($registro_detalles2=$query_detalles->fetch_assoc())
        {
            $total2= $total2 + $registro_detalles2['total'] ;
        }
    }
    else
    {
        $total2=0;
    }
    
       
    $mysqli->close();

 
$resultado   = sqlsrv_query($dbconn,"SELECT sum(stock) existencia  FROM INExistencia
         WHERE  codigo  = '".$term."' AND bodega='".$txt_bodega."'");
$contador=0;

            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $contador=$contador+1;

                $datax["text"] =  $row['existencia'] - ($total + $total2);
                $datax["id"]   =  $row['existencia'];
                $data[] = $datax;
                
            }
        if($contador!=0){
    
        } else {
            
            $fila["text"]		= "...!0 RESULTADOS!...";
            $fila["id"]			= "0";
            $data[] = $fila;
        }

        return $data;
    }




    /*=============================================
    BUSCADOS PREDICTIVO DE CLIENTES
    =============================================*/
    public function bodegas_consignacion()
    {
        include 'bdsql.php';
        $dbconn  = conexionSQLSI();
        $resultado   = sqlsrv_query($dbconn,"SELECT codigo,nombre FROM INBodega WHERE estado='A'");
        while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) 
        {
            $datax["codigo"]   =  $row['codigo'];
            $datax["nombre"]   =  $row['nombre'];
            $data[] = $datax;   
        }
        return $data;
    }
}