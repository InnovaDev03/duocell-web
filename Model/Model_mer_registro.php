<?php
class ModelPromotor
{
    


    /*=============================================
FUNCION OBTENER SECUENCIA DE CODIGO
=============================================*/
    public function secuencia_codigo($txt_user){
        $data        = array();
        $mysqli      = conexionMySQL();
        $sql         = "SELECT  count(*) AS secuencia  FROM pr_venta_mercaderista";
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
    $sql         = "SELECT * FROM   pa_cadenas  WHERE estatus = '1' ";
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
        $dataxr['id']     ='0';
        $dataxr['nombre'] ='NO HAY CADENAS';
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


                 /** VALIDAMOS IMEI SISTEMA **/
                $resut = $this->validar_imei_sistema($data['txt_imei']);
                if($resut == 1)
                {
                    $Global->salir_json(2,"ERROR : Imei registrado en sistema!!");
                }

                /** VALIDAMOS IMEI NO CARGADO **/
                $resut = $this->validar_item_cargado($data['txt_imei']);
                if($resut == 0)
                {


                      /** BUSCAMOS PRODUCTO POR IMEI **/
                      $Consult    = new ModelPg();
                      $item       = $Consult->buscar_producto_imei_duocel($data['txt_imei']);

                        /** CONSULTAMOS SI INSERTA O EDITA **/
                        $resut = $this->consultar_item_cargado($item[1],$data['txt_user']);
                        if($resut == 0)
                        {
                            $sql_insert = "INSERT INTO pr_venta_imei_temp_mercaderista 
                                ( 	
                                    pr_id_usuario,
                                    pr_id_articulo ,
                                    pr_imei
                                ) 						
                                VALUES
                                (
                                    '" . $data['txt_user'] . "',
                                    '" . $item[1] . "',
                                    '" . $data['txt_imei'] . "'
                                ) ";
                                
                            $resultado  = $mysqli->query($sql_insert);
                            $id_usuario =  $mysqli->insert_id;
                            if ($resultado) {
                            } else {
                                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                            }

IF ($item[2]!=''){
                            $total = $data['txt_cantidad'] *  $data['txt_precio'];
                            $sql_insert = "INSERT INTO pr_venta_deta_templle_mercaderista 
                            ( 	
                                pr_item,
                                pr_descripcion,
                                pr_cantidad,
                                pr_precio,
                                pr_total,
                                pr_usuario
                                
                            ) 						
                            VALUES
                            (
                                '" . $item[1] . "',
                                '" . $item[2] . "',
                                '" . $data['txt_cantidad'] . "',
                                '" . $data['txt_precio'] . "',
                                '" . $total . "',
                                '" . $data['txt_user'] . "'
                            ) ";

                            $resultado  = $mysqli->query($sql_insert);
                            if ($resultado) {
                
                                $mysqli->commit();
                                $total = $this->total_venta($data['txt_user']);
                                $Global->salir_json_total(1,"",$total);
                            } else {
                                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                            }

                        }
                        else {
                            $Global->salir_json(2,"ERROR. IMEI NO EXISTE.");
                        }

                        }
                        else
                        {
                            $sql_insert = "INSERT INTO pr_venta_imei_temp_mercaderista 
                                ( 	
                                    pr_id_usuario,
                                    pr_id_articulo ,
                                    pr_imei
                                ) 						
                                VALUES
                                (
                                    '" . $data['txt_user'] . "',
                                    '" . $item[1] . "',
                                    '" . $data['txt_imei'] . "'
                                ) ";
                                
                            $resultado  = $mysqli->query($sql_insert);
                            $id_usuario =  $mysqli->insert_id;
                            if ($resultado) {
                            } else {
                                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                            }

                            $sql = "SELECT * FROM  pr_venta_deta_templle_mercaderista WHERE pr_item ='".$item[1]  ."' AND pr_usuario='".$data['txt_user'] ."'";
                            $resultado = $mysqli->query($sql);
                            $fila = $resultado->fetch_assoc();
                            $total = ($fila['pr_cantidad'] + 1) *  $data['txt_precio'];
                            $sql_insert = "UPDATE pr_venta_deta_templle_mercaderista SET pr_cantidad=pr_cantidad+1,pr_total='".$total."',pr_precio='".$data['txt_precio']."' WHERE pr_usuario='".$data['txt_user'] ."'";
                            $resultado  = $mysqli->query($sql_insert);
                            if ($resultado) {
                
                                $mysqli->commit();
                                $total = $this->total_venta($data['txt_user']);
                                $Global->salir_json_total(1,"",$total);
                            } else {
                                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                            }
                        }

                      
                }
                else
                {   
                    $Global->salir_json(2,"ERROR : Imei ya cargado!!");
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
    $sql         = "SELECT * FROM pr_venta_deta_templle_mercaderista WHERE pr_usuario='".$txt_id."'";
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

        
        $fila['imei']     = $this->verificar_imeis($fila['pr_item'],$txt_id);
        
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
                    $resut = $Consult->validar_imei_duocel_mercaderista($data['txt_imei'],$data['txt_id_item']);
                    if($resut == 1)
                    {

                                $sql_insert = "INSERT INTO pr_venta_imei_temp_mercaderista 
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
                    $Global->salir_json(2,"Imei no exstente para item!!");
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
    $sql         = "SELECT * FROM pr_venta_imei_temp_mercaderista WHERE pr_id_usuario='".$txt_id_usuario."' AND pr_id_articulo='".$txt_id."'";





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

    $sql_insert = "DELETE FROM pr_venta_imei_temp_mercaderista WHERE pr_id ='".$data['txt_id']."'";
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


    $sql_insert = "DELETE FROM pr_venta_deta_templle_mercaderista WHERE pr_id ='".$data['txt_id']."'";
    $resultado  = $mysqli->query($sql_insert);

    $sql_insert = "DELETE FROM pr_venta_imei_temp_mercaderista WHERE pr_id_articulo ='".$data['txt_id_item']."'";
    $resultado  = $mysqli->query($sql_insert);
    if ($resultado) {


       
        $mysqli->commit();
        $total = $this->total_venta($data['txt_user']);
        $Global->salir_json_total(1,"",$total);

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


                    /**  VALIDAMOS ESTEN CARGADOS TODOS LOS IMEI**/
                    $resut = $this->validar_cantidad_imei($data['txt_user']);
                    if($resut == 0)
                    {   
                            $fecha =  $Global->formatearFecha($data['txt_fecha']);
                            $sql_insert = "INSERT INTO pr_venta_mercaderista 
                            ( 	
                                pr_id_cliente,
                                pr_nombre_cliente,
                                pr_codigo,
                                pr_total,
                                pr_forma_pago,
                                pr_fecha,
                                pr_id_usuario,
                                pr_estatus
                                
                            ) 						
                            VALUES
                            (
                                '" . $data['txt_cadena'] . "',
                                '" . $data['txt_tienda'] . "',
                                '" . $data['txt_codigo'] . "',
                                '" . $data['txt_total'] . "',
                                '" . $data['txt_pago'] . "',
                                '" . $fecha . "',
                                '" . $data['txt_user'] . "',
                                '1'
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
                            $rp_detalles = "SELECT * FROM pr_venta_deta_templle_mercaderista WHERE pr_usuario='".$data['txt_user']."'" ;
                            $query_detalles=$mysqli->query($rp_detalles);
                            $n= $query_detalles->num_rows;
                            if($n>0)
                            {
                                while ($registro_detalles=$query_detalles->fetch_assoc())
                                {
                                    $sql_insert = "INSERT INTO pr_venta_detalle_mercaderista 
                                    ( 	
                                        pr_id_venta,
                                        pr_item,
                                        pr_descripcion,
                                        pr_cantidad,
                                        pr_precio,
                                        pr_total,
                                        pr_usuario
                                        
                                    ) 						
                                    VALUES
                                    (
                                        '" . $max_id . "',
                                        '" . $registro_detalles['pr_item'] . "',
                                        '" . $registro_detalles['pr_descripcion'] . "',
                                        '" . $registro_detalles['pr_cantidad'] . "',
                                        '" . $registro_detalles['pr_precio'] . "',
                                        '" . $registro_detalles['pr_total'] . "',
                                        '" . $data['txt_user'] . "'
                                    ) ";
                                    $resultado  = $mysqli->query($sql_insert);
                                    if ($resultado) 
                                    {
                                                                
                                    } else 
                                    {
                                        $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                                    }
                                }
                            }



                            /**  INSERTAMOS IMEI**/
                            $rp_detalles = "SELECT * FROM pr_venta_imei_temp_mercaderista WHERE pr_id_usuario='".$data['txt_user']."'" ;
                            $query_detalles=$mysqli->query($rp_detalles);
                            $n= $query_detalles->num_rows;
                            if($n>0)
                            {
                                while ($registro_detalles=$query_detalles->fetch_assoc())
                                {
                                    $sql_insert = "INSERT INTO pr_venta_imei_mercaderista 
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
                            }

                            /** VACIAMOS TABLAS**/
                            $sql_insert = "DELETE FROM pr_venta_deta_templle_mercaderista WHERE pr_usuario='".$data['txt_user']."'";
                            $resultado  = $mysqli->query($sql_insert);
                            if ($resultado) 
                            {
                                                        
                            } else 
                            {
                                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                            }

                            $sql_insert = "DELETE FROM pr_venta_imei_temp_mercaderista WHERE pr_id_usuario='".$data['txt_user']."'";
                            $resultado  = $mysqli->query($sql_insert);
                            if ($resultado) 
                            {                          
                            } else 
                            {
                                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                            }


                            $data['dp_modulo']          = 'MERCADERISTA->CREAR VENTA';
                            $data['dp_accion']          =  "REGISTRAR";
                            $data['dp_descripcion']     = 'CREAR VENTA : '.$data['txt_codigo'];
                            $data['dp_sql']             = '';
                            $data['dp_user']            = $data['txt_user'];
                            $data['dp_fecha_registro']  = date('Y-m-d');
                            $data['dp_hora_registro']   = date("g:i:s-a");
                            $Global->bitacora_user($data);
                            $mysqli->commit();
                            $Global->salir_json(1,'');
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
    $sql = "SELECT COUNT(pr_imei) as total FROM pr_venta_imei_temp_mercaderista WHERE pr_id_usuario='$txt_user'";
    $resultado = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {
            
        $total_imei = $fila['total'];
    }

    $total_item = 0;
    $sql = "SELECT SUM(pr_cantidad) as total FROM pr_venta_deta_templle_mercaderista WHERE pr_usuario='$txt_user'";
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

    $sql = "SELECT COUNT(pr_imei) as total FROM  pr_venta_imei_temp_mercaderista WHERE pr_id_usuario='$txt_user' AND pr_id_articulo='$txt_id_item'";
    $resultado = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {
            
        $total = $fila['total'];
    }
    return $total;   
}

private function validar_imei($txt_user,$txt_imei) 
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  pr_venta_imei_temp_mercaderista WHERE pr_imei ='$txt_imei' AND pr_id_usuario='$txt_user'";
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


private function validar_item_cargado($txt_imei) 
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  pr_venta_imei_temp_mercaderista WHERE pr_imei ='$txt_imei'";
    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 1;
    } else {
        $salida = 0;
    }
    return $salida;   
}

private function consultar_item_cargado($txt_item,$txt_user) 
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  pr_venta_deta_templle_mercaderista WHERE pr_item ='$txt_item' AND  pr_usuario ='$txt_user'";
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

    $sql       = "SELECT COUNT(pr_imei) AS total FROM pr_venta_imei_temp_mercaderista WHERE pr_id_usuario='".$id_usuario."' AND pr_id_articulo='".$id_item."'";
    $resultado = $mysqli->query($sql);

        while ($fila = $resultado->fetch_assoc()) {
            
            $total = $fila['total'];
        }

    return $total;
}

private function total_venta($id_usuario)
{
    $mysqli    = conexionMySQL();

    $sql       = "SELECT SUM(pr_total) AS total FROM pr_venta_deta_templle_mercaderista WHERE pr_usuario='".$id_usuario."'";
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

}


