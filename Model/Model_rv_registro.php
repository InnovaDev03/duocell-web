<?php
class ModelPromotor
{
    


    /*=============================================
FUNCION OBTENER SECUENCIA DE CODIGO
=============================================*/
    public function secuencia_codigo($txt_user){
        $data        = array();
        $mysqli      = conexionMySQL();
        $sql         = "SELECT  count(*) AS secuencia  FROM reserva";
        $resultado   = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {

           if($fila['secuencia'] == 0)
           {
            $secuencia   = '10001';
           }
           else
           {
                 $secuencia   = $fila['secuencia'] + 10001;
           }
           
           
        }
        $total = $this->total_venta($txt_user);
        $mysqli->close();
        $result["result"] = 1;
        $result["error"] = '';
        $result["secuencia"] = $secuencia;
        $result["total"] = $total;
        echo json_encode($result);
        exit;
    }




    /*=============================================
CARGAR CADENAS
=============================================*/	
public function cargar_cadenas(){

    $dataxr      = array();
    $mysqli      = conexionMySQL();
    $sql         = "SELECT * FROM   clientes  WHERE log_estatus = '1' ";
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
        $dataxr['log_id']     ='0';
        $dataxr['log_nombre'] ='NO HAY CLIENTE';
    }
    
    return $dataxr;
    $mysqli->close();
}


    /*=============================================
CARGAR TIENDAS
=============================================*/	
public function cargar_tiendas($txt_id){

    $dataxr      = array();
    $mysqli      = conexionMySQL();
    $sql         = "SELECT * FROM   pa_tiendas  WHERE id_cadena ='".$txt_id."' AND estatus = '1' ";
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
        $file['id']     ='0';
        $file['nombre'] ='NO HAY TIENDAS';
        $dataxr[] = $file;
    }
    
    return $dataxr;
    $mysqli->close();
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
                 $resut = $this->validar_item_cargado($data['txt_id'],$data['txt_user']);
                if($resut == 0)
                {

                    $pvp = round($data['txt_precio'],2);
                   
                    $sql_insert = "INSERT INTO rv_detalletemp 
                    ( 	
                        `item`, `descripcion`, `cantidad`,precio, `usuario`
                        
                    ) 						
                    VALUES
                    (
                        '" . $data['txt_id'] . "',
                        '" . $data['txt_text'] . "',
                        '" . $data['txt_cantidad'] . "',
                        '" . $data['txt_precio'] . "',
                        '" . $data['txt_user'] . "'
                    ) ";
                }
                else
                {
                    $Global->salir_json(2,"Item cargado, eliminar y cargar nuevamente!!");
                }
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {
                $mysqli->commit();
                $Global->salir_json_total(1,"",0);
            } else {
                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
            }
       

    $mysqli->close();
}



/*=============================================
TABLE CADENA
=============================================*/
public function table_venta($txt_id)
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT * FROM rv_detalletemp WHERE usuario='".$txt_id."'";
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

        
       // $fila['imei']     = $this->verificar_imeis($fila['item'],$txt_id);
        
        $data[]   = $fila;
    }
    $mysqli->close();
    return $data;
}



 /*=============================================
AGREGAR IMEI
=============================================*/
public function agregar_imei($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);



    /** VALIDAMOS CANTIDAD IME **/
    $resut = $this->contamos_imei($data['txt_user'],$data['txt_id_item']);
    if($resut == $data['txt_cantidad'])
    {
        $Global->salir_json(2,"Total imei cargados! ");
    }

        /** VALIDAMOS IMEI CARGADO **/
        $resut = $this->validar_imei($data['txt_user'],$data['txt_imei']);
        if($resut == 0)
        {

             /** VALIDAMOS IMEI SISTEMA **/
            $resut = $this->validar_imei_sistema($data['txt_imei']);
            if($resut == 0)
            {
                    /** VALIDAMOS IMEI EN BASE DE DUOCEL **/
                    $Consult    = new ModelPg();
                    $resut = $Consult->validar_imei_duocel($data['txt_imei']);
                    if($resut == 1)
                    {
                        
                                
                                $sql_insert = "INSERT INTO pr_venta_imei_temp 
                                ( 	
                                    pr_id_usuario,
                                    pr_id_articulo ,
                                    pr_imei
                                ) 						
                                VALUES
                                (
                                    '" . $data['txt_user'] . "',
                                    '" . $data['txt_id_item'] . "',
                                    '" . $data['txt_imei'] . "'
                                ) ";
                                
                        $resultado  = $mysqli->query($sql_insert);
                        $id_usuario =  $mysqli->insert_id;
                        if ($resultado) {

                            $mysqli->commit();
                            
                            $Global->salir_json(1,"");
                        } else {
                            $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                        }
                    
                }
                else
                {
                    $Global->salir_json(2,"Imei no exstente en duocell!");
                }
            }
            else
            {
                $Global->salir_json(2,"Imei ya registrado en sistema! ");
            }
        }
        else
        {
            $Global->salir_json(2,"Imei cargado! ");
        }

    $mysqli->close();
}


/*=============================================
TABLE CADENA
=============================================*/
public function table_imeis($txt_id,$txt_id_usuario)
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT * FROM pr_venta_imei_temp WHERE pr_id_usuario='".$txt_id_usuario."' AND pr_id_articulo='".$txt_id."'";





    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {
        $data[]   = $fila;
    }
    $mysqli->close();
    return $data;
}



 /*=============================================
ELIMINAR IMEI
=============================================*/
public function eliminar_imei($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);

    $sql_insert = "DELETE FROM pr_venta_imei_temp WHERE pr_id ='".$data['txt_id']."'";
    $resultado  = $mysqli->query($sql_insert);
    if ($resultado) {

        $mysqli->commit();
        
        $Global->salir_json(1,"");
    } else {
        $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
    }

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


    $sql_insert = "DELETE FROM rv_detalletemp WHERE id ='".$data['txt_id']."'";
    $resultado  = $mysqli->query($sql_insert);

    //$sql_insert = "DELETE FROM pr_venta_imei_temp WHERE pr_id_articulo ='".$data['txt_id_item']."'";
    //$resultado  = $mysqli->query($sql_insert);
    if ($resultado) {


       
        $mysqli->commit();
       // $total = $this->total_venta($data['txt_user']);
        $Global->salir_json_total(1,"",0);

    } else {
        $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
    }

}


/*=============================================
REGISTRAR VENTA
=============================================*/
public function registrar_venta($data)
{
    $Global  = new ModelGlobal();
    
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);
    date_default_timezone_set('America/Guayaquil');

    $arreglodato= '';
                    /**  VALIDAMOS ESTEN CARGADOS TODOS LOS IMEI**/
                   // $resut = $this->validar_cantidad_imei($data['txt_user']);
                    if(1 == 1)
                    {   
                            $fecha =  $Global->formatearFecha($data['txt_fecha']);
                            
            if ($data['txt_observaciones']!=''){
                $observaciones= $data['txt_observaciones'];
            } else {
                $observaciones='N/A';
            }
                            $sql_insert = "INSERT INTO reserva 
                            ( 
                                id_cliente,
                                oc_forma_pago,
                                oc_fecha,
                                oc_observaciones,
                                oc_id_usuario,
                                oc_estatus,
                                cupo_disponible,
                                saldo_vencido,
                                id_cliente_fk,
                                dato_adjunto,
                                cod_vendedor
                            ) 						
                            VALUES
                            (
                                
                                '" . $data['txt_cadena'] . "',
                                '" . $data['txt_pago'] . "',
                                '" . $fecha . "',
                                '" . $observaciones . "',
                                '" . $data['txt_user'] . "',
                                '1',
                                '" . $data['txt_cupodisponible'] . "',
                                '" . $data['txt_saldovencido'] . "',
                                '" . $data['txt_cliente'] . "',
                                '" . $data['valorimg'] . "',
                                '" . $data['txt_codigovendedor'] . "'
                                ) ";
                            $resultado  = $mysqli->query($sql_insert);
                            $max_id 	=  $mysqli->insert_id;
                            if ($resultado) 
                            {
                                                        
                            } else 
                            {
                                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                            }
                    
                            /**  INSERTAMOS DETALLE DE VENTA**/
                            $rp_detalles = "SELECT * FROM rv_detalletemp WHERE usuario='".$data['txt_user']."'" ;
                            $query_detalles=$mysqli->query($rp_detalles);
                            $n= $query_detalles->num_rows;
                            if($n>0)
                            {
                                while ($registro_detalles=$query_detalles->fetch_assoc())
                                {
                                    $itemid=$registro_detalles['item'] ;
                                    $total=0;
                                    //VALIDAMOS DE ESE PRODUCTO CUANTOS HAY EN OC
                                    $rp_detalles2 = "SELECT sum(cantidad) as total FROM rv_detalle WHERE item='".$itemid."' and estatus_oc=1" ;
                                    $query_detalles2=$mysqli->query($rp_detalles2);
                                        while ($registro_detalles2=$query_detalles2->fetch_assoc())
                                        {
                                            $total=$registro_detalles2['total'] ;
                                        }        
                                    
                                    //AQUI VALIDAMOS PRODUCTO Y LO HACEMOS
                                    /*
                                    include 'bdsql.php';
                                    $conx      = conexionSQLSI();                                
                                    $resultado   = sqlsrv_query($conx,"SELECT sum(stock) existencia, codigo  FROM INExistencia
                                    WHERE  codigo  = '".$term."'   group by codigo ");
                                    $contador=0;

                                    while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                                        $contador=$contador+1;
                                    }

                                    if($contador!=0){
                                        while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                                            $contador=$contador+1;
                                            if( $registro_detalles['cantidad']<= ($row['existencia'] - $total)){
                                                $paso=1;
                                            } else {
                                                $paso=0;
                                            }
                                            $codigo_itemapi=$row['codigo']; 
                                            $idinvapi=$row[2]; 
                                        }
                                    } else {
                                        $paso=1;
                                    }

*/
                                if( 1==1)
                                {

                                    $sql_insert = "INSERT INTO rv_detalle 
                                    ( 	
                                        id_ordencompra, `item`, `descripcion`, `cantidad`, precio, `usuario`
                                        
                                    ) 						
                                    VALUES
                                    (
                                        '" . $max_id . "',
                                        '" . $itemid. "',
                                        '" . $registro_detalles['descripcion'] . "',
                                        '" . $registro_detalles['cantidad'] . "',
                                        '" . $registro_detalles['precio'] . "',
                                        '" . $data['txt_user'] . "'
                                    ) ";
                                    $resultado  = $mysqli->query($sql_insert);
                                    if ($resultado) 
                                    {
                                        //guardo en variable para al final enviarlo x api
                                        $descripcion=$registro_detalles['descripcion'];
                                        $cantidad=$registro_detalles['cantidad'];
                                       

                                                                
                                    } else 
                                    {
                                        $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                                    }
                                } 
                                else 
                                { 
                                    $Global->salir_json(2,"No hay stokc cantidad solicitada : ".$registro_detalles['cantidad'].' Stock actual : '.($row['existencia']-$total));

                                } //fin si no hay stock



                                }
                            }



                            /**  INSERTAMOS IMEI**/
                          /*  $rp_detalles = "SELECT * FROM pr_venta_imei_temp WHERE pr_id_usuario='".$data['txt_user']."'" ;
                            $query_detalles=$mysqli->query($rp_detalles);
                            $n= $query_detalles->num_rows;
                            if($n>0)
                            {
                                while ($registro_detalles=$query_detalles->fetch_assoc())
                                {
                                    $sql_insert = "INSERT INTO pr_venta_imei 
                                    ( 	
                                        pr_id_venta,
                                        pr_id_articulo,
                                        pr_imei
                                    ) 						
                                    VALUES
                                    (
                                        '" . $max_id . "',
                                        '" . $registro_detalles['pr_id_articulo'] . "',
                                        '" . $registro_detalles['pr_imei'] . "'
                                    ) ";
                                    $resultado  = $mysqli->query($sql_insert);
                                    if ($resultado) 
                                    {
                                                                
                                    } else 
                                    {
                                        $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                                    }
                                }
                            }*/

                            /** VACIAMOS TABLAS**/
                            $sql_insert = "DELETE FROM rv_detalletemp WHERE usuario='".$data['txt_user']."'";
                            $resultado  = $mysqli->query($sql_insert);
                            if ($resultado) 
                            {
                                                        
                            } else 
                            {
                                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                            }
/*
                            $sql_insert = "DELETE FROM pr_venta_imei_temp WHERE pr_id_usuario='".$data['txt_user']."'";
                            $resultado  = $mysqli->query($sql_insert);
                            if ($resultado) 
                            {                          
                            } else 
                            {
                                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                            }*/


                            $data['dp_modulo']          = 'ORDEN COMPRA->CREAR OC';
                            $data['dp_accion']          =  "REGISTRAR";
                            $data['dp_descripcion']     = 'CREAR OC : '.$max_id;
                            $data['dp_sql']             = '';
                            $data['dp_user']            = $data['txt_user'];
                            $data['dp_fecha_registro']  = date('Y-m-d');
                            $data['dp_hora_registro']   = date("g:i:s-a");
                            $Global->bitacora_user($data);
                            $mysqli->commit();
                            $Global->salir_json(1,'0');


                    }
                    else
                    {
                        $Global->salir_json(2,"Faltan imei por cargar!!");
                    }

                    

    $mysqli->close();
}



/*=============================================
    FUNCIONES PRIVADAS
=============================================*/



private function validar_cantidad_imei($txt_user) 
{
    $mysqli = conexionMySQL();

    $total_imei = 0;
    $sql = "SELECT COUNT(pr_imei) as total FROM pr_venta_imei_temp WHERE pr_id_usuario='$txt_user'";
    $resultado = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {
            
        $total_imei = $fila['total'];
    }

    $total_item = 0;
    $sql = "SELECT SUM(pr_cantidad) as total FROM rv_detalletemp WHERE usuario='$txt_user'";
    $resultado = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {
            
        $total_item = $fila['total'];
    }

    if($total_imei == $total_item)
    {
        $salida = 0;
    }
    else
    {
        $salida = 1;
    }

    return $salida;   
}

private function contamos_imei($txt_user,$txt_id_item) 
{
    $mysqli = conexionMySQL();

    $sql = "SELECT COUNT(pr_imei) as total FROM  pr_venta_imei_temp WHERE pr_id_usuario='$txt_user' AND pr_id_articulo='$txt_id_item'";
    $resultado = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {
            
        $total = $fila['total'];
    }
    return $total;   
}

private function validar_imei($txt_user,$txt_imei) 
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  pr_venta_imei_temp WHERE pr_imei ='$txt_imei' AND pr_id_usuario='$txt_user'";
    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 1;
    } else {
        $salida = 0;
    }
    return $salida;   
}

private function validar_imei_sistema($txt_imei) 
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  pr_venta_imei WHERE pr_imei ='$txt_imei' ";
    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 1;
    } else {

        $sql = "SELECT * FROM  pr_venta_imei_mercaderista WHERE pr_imei ='$txt_imei' ";
        $resultado = $mysqli->query($sql);
        $n = $resultado->num_rows;
        if ($n > 0) {
            $salida = 1;
        } else {
            $salida = 0;
        }
    }
    return $salida;   
}


private function validar_item_cargado($txt_id,$txt_user) 
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  rv_detalletemp WHERE item ='$txt_id' AND usuario='$txt_user'";




    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 1;
    } else {
        $salida = 0;
    }
    return $salida;   
}


private function verificar_imeis($id_item,$id_usuario)
{
    $mysqli    = conexionMySQL();

    $sql       = "SELECT COUNT(pr_imei) AS total FROM pr_venta_imei_temp WHERE pr_id_usuario='".$id_usuario."' AND pr_id_articulo='".$id_item."'";
    $resultado = $mysqli->query($sql);

        while ($fila = $resultado->fetch_assoc()) {
            
            $total = $fila['total'];
        }

    return $total;
}

private function total_venta($id_usuario)
{
    $mysqli    = conexionMySQL();

    $sql       = "SELECT SUM(total) AS total FROM rv_detalletemp WHERE usuario='".$id_usuario."'";
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
CARGAR CADENAS
=============================================*/	
public function buscar_precio($data){

    $dataxr      = array();
    $mysqli      = conexionMySQL();

    $sqlselect2='';
    if ($data['txt_pago']=='CREDITO'){
    $sqlselect2 = ' and (tipo_credito="CREDITO" or tipo_credito is null  ) ';
    }
    
    if ($data['txt_pago']=='CONTADO'){
        $sqlselect2 = ' and (tipo_credito="CONTADO" or tipo_credito is null  ) ';
    
    }
    
    $tblconsulta='';
    if ( $data['canal']=='002'){
        $tblconsulta ="precios";
    } else if ( $data['canal']=='001'){
        $tblconsulta ="precios_retail";
    }  else if ( $data['canal']=='003'){
        $tblconsulta ="precios_corporativo";
    } 
    
    
    $sql         = "SELECT * FROM   $tblconsulta  WHERE producto like '".$data['txt_producto']." - %' 
    and subcanal='".$data['subcanal']."'  $sqlselect2 and estatus = '1' ";
     $resultado   = $mysqli->query($sql);
    $n           = $resultado->num_rows;
    if($n>0)
    {
        while ($file =  $resultado->fetch_assoc()) {
            if ($tblconsulta=="precios_corporativo"){
                $file['precio'] = $file['precio'] * $this->factor($data['txt_cliente2']);
            }
            $dataxr[] = $file;
                }
    }
    else
    {
        $dataxr['precio']     ='0';
    }
    
    return $dataxr;
    $mysqli->close();
}



private function factor($codigocliente)
{
    $mysqli    = conexionMySQL();

    $sql       = "SELECT factor FROM clientescorpo
     inner join factores ON factores.id = clientescorpo.id_factor
      WHERE id_cliente='".$codigocliente."'";
    $resultado = $mysqli->query($sql);
    $total = 1;

        while ($fila = $resultado->fetch_assoc()) {
            
            
            if($fila['factor'] == null)
            {
                $total = 1;
            }
            else
            {
                $total = 1+($fila['factor']/100);
            }
          
        }

    return $total;
}

/*=============================================
VALIDAR RESERVA
=============================================*/	
public function validar_reserva($data){


    $mysqli      = conexionMySQL();
    $sql         = "SELECT oc_id FROM  reserva WHERE id_cliente LIKE '%".$data['txt_cliente']."%' AND oc_estatus=1 ";
     $resultado   = $mysqli->query($sql);
    $n           = $resultado->num_rows;
    if($n>0)
    {
        $fila = $resultado->fetch_assoc();
        $dataxr['result']     =1;
        $dataxr['oc_id']     =$fila['oc_id'];
    }
    else
    {
        $dataxr['result']     =0;
        $dataxr['oc_id']     =0;
    }
    
    echo json_encode($dataxr);
    $mysqli->close();
    exit();
}


}


