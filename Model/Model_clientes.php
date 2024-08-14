<?php
class ModelCliente
{
/*=============================================
REGISTER CLIENTE
=============================================*/
public function registro_cliente($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


        /** VALIDAMOS NOMBRE DE LA BODEGA **/
        $resut = $this->validar_cliente($data['txt_identificacion']);
        if($resut == 0)
        {
                    /**INSERT TABLE clientes**/
                    $sql_insert = "INSERT INTO clientes 
                    ( 	
                        log_identificacion,
                        log_nombre,
                        log_direccion,
                        log_telefono,
                        log_email,
                        logo,						
                        log_id_user,
                        log_fecha_registro,
                        log_hora_registro,
                        log_estatus

                    ) 						
                    VALUES
                    (
                        '" . $data['txt_identificacion'] . "',
                        '" . $data['txt_nombre'] . "',
                        '" . $data['txt_direccion'] . "',
                        '" . $data['txt_telefono'] . "',
                        '" . $data['txt_email'] . "',						
                        '" . $data['url_imagen'] . "',						
                        '" . $data['txt_user'] . "',
                        '" . date('Y-m-d').  "',
                        '" . date("g:i:s-a"). "',
                        '1'
                    ) ";
                    
            $resultado  = $mysqli->query($sql_insert);
            $id_usuario =  $mysqli->insert_id;
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'CLIENTE';
                $data['dp_accion']         =  "INSERTAR";
                $data['dp_descripcion']     = 'CREAR CLIENTE : '.$data['txt_identificacion'].' '.$data['txt_nombre'];
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

        }
        else
        {
            $Global->salir_json(2,"Identificación ya registrada!");
        }

    $mysqli->close();
}


/*=============================================
TABLE CLIENTES
=============================================*/
public function table_clientes()
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT * FROM  clientes WHERE log_estatus='1' ORDER BY log_id DESC ";
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

        $data[]   = $fila;
    }
    $mysqli->close();
    return $data;
}



/*=============================================
VALIDAR IDENTIFICACION
=============================================*/
public function validar_identificacion($data)
{
    $Global  = new ModelGlobal();
    $dataxr  = array();
    $mysqli  = conexionMySQL();

    $sql       = "SELECT * FROM  clientes WHERE log_identificacion  ='".$data['txt_identificacion']."'";
    $resultado = $mysqli->query($sql);
    $n         = $resultado->num_rows;
    if ($n > 0) {
  
        $Global->salir_json(2,"Identificación ya registrada!");

    } else {
 
 
        $Global->salir_json(1,"");
    }
   

    $mysqli->close();
}


/*=============================================
EDITAR CLIENTE
=============================================*/
public function editar_cliente($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


        /** VALIDAMOS NOMBRE DE LA BODEGA **/
        $resut = $this->validar_cliente_edit($data['txt_id'],$data['txt_identificacion']);
        $resut2 = $this->validar_cliente_logo($data['txt_id'],$data['txt_identificacion']);
        if($resut == 0)
        {
            if ($data['url_imagen']!='nologo'){
$concat =" , logo='".$data['url_imagen']."' ";
            } else {
$concat =" , logo='nologo' ";
            }
                   
            $sql_insert = "UPDATE clientes SET 
             log_identificacion='".$data['txt_identificacion']."',
             log_nombre='".$data['txt_nombre']."',
             log_direccion='".$data['txt_direccion']."',
             log_telefono='".$data['txt_telefono']."',
             log_email='".$data['txt_email']."'
             $concat
             WHERE log_id ='".$data['txt_id']."' ";               
            $resultado  = $mysqli->query($sql_insert);
            //$id_usuario =  $mysqli->insert_id;
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'CLIENTE->EDITAR';
                $data['dp_accion']         =  "EDITAR";
                $data['dp_descripcion']     = 'EDITAR CLIENTE : '.$data['txt_identificacion'].' '.$data['txt_nombre'];
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

        }
        else
        {
            $Global->salir_json(2,"Identifación ya registrada! ");
        }

    $mysqli->close();
}




/*=============================================
ELIMINAR CLIENTE
=============================================*/
public function eliminar_cliente($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);

            $sql_insert      = "DELETE FROM clientes WHERE log_id ='".$data["txt_id"]."'  ";
            $resultado       = $mysqli->query($sql_insert);
            if ($resultado) {

                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'LOGISTICA->CLIENTES';
                $data['dp_accion']          =  "ELIMINAR";
                $data['dp_descripcion']     = 'ELIMINAR CLIENTE : '.$data['txt_identificacion'].' - '.$data['txt_identificacion'];
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
CARGAR UNIDADES
=============================================*/	
public function load_unidades(){

    $dataxr      = array();
    $mysqli      = conexionMySQL();
    $sql         = "SELECT * FROM  tr_unidades  WHERE log_estatus=1 ORDER BY log_id  ASC";
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
        $dataxr[] ='NO HAY UNIDAD';
    }
    
    return $dataxr;
    $mysqli->close();
}



/*=============================================
BUSCADOR PREDICTIVO SERVICIOS
=============================================*/
    public function predictivo_servicios($term)
    {
        $mysqli      = conexionMySQL();


        $sql = "  SELECT log_id,log_nombre
						FROM tr_servicios
						WHERE log_estatus='1' AND log_nombre LIKE '%$term%' limit 20";
        

        $resultado = $mysqli->query($sql);
        $n = $resultado->num_rows;
        $data = array();
        $datax = array();
        if ($n > 0) {
            while ($fila = $resultado->fetch_assoc()) {

                $datax["text"] =  $fila["log_nombre"];
                $datax["id"]   =  $fila["log_id"];
                $data[] = $datax;
            }
        } else {
            $fila["text"]                   = "...!0 RESULTADOS!...";
            $fila["id"]                     = "0";
            $data[] = $fila;
        }

        return $data;
    }



/*=============================================
CARGAR SERVICIOS
=============================================*/	
public function load_servicios(){

    $dataxr      = array();
    $mysqli      = conexionMySQL();
    $sql         = "SELECT * FROM tr_servicios  WHERE log_estatus=1 ORDER BY log_id  ASC";
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
        $dataxr[] ='NO HAY UNIDAD';
    }
    
    return $dataxr;
    $mysqli->close();
}


/*=============================================
CARGAR ZONAS
=============================================*/	
public function load_zona(){

    $dataxr      = array();
    $mysqli      = conexionMySQL();
    $sql         = "SELECT * FROM gb_zona_finca  WHERE estado=1 ORDER BY nombre_zona  ASC";
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
        $dataxr[] ='NO HAY UNIDAD';
    }
    
    return $dataxr;
    $mysqli->close();
}


/*=============================================
TABLE SERICIOS CLIENTES
=============================================*/
public function table_servicios_clientes($id)
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT * FROM clientes_servicios WHERE log_id_cliente='".$id."' ORDER BY log_id DESC ";
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

        /*$fila['log_servicio']   =  $this->servicio($fila['log_id_servicio']);
        $fila['log_unidad']     =  $this->unidad($fila['log_id_unidad']);
		$fila['ciudad_ini']     =  $this->ciudad($fila['id_ciudad_ini']);
		$fila['ciudad_fin']     =  $this->ciudad($fila['id_ciudad_fin']);
		$fila['zona']     =  $this->zona($fila['id_zona']);
        */
        $fila['log_precio']     = $fila['log_precio'];
        $fila['log_descripcion']     = $fila['log_descripcion'];
        $data[]   = $fila;
    }
    $mysqli->close();
    return $data;
}


/*=============================================
REGISTER SERVICIO CLIENTE
=============================================*/
public function registro_servicio_cliente($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);

            /** VALIDAMOS QUE NO TENGA SERVICO EL CLIENTE**/
            $resut = 0;//$this->validar_servicio($data['txt_ciudad_ini'],$data['txt_ciudad_fin'],$data['txt_zona'],$data['txt_id_cliente'],$data['txt_descripcion']);
            if ($resut == 0) {

                
                /**INSERT TABLE  log_clientes_servicios**/
                $sql_insert = "INSERT INTO  clientes_servicios 
                     ( 	
                        log_id_cliente,                       
                        log_precio,
                        log_descripcion,
                        log_id_user,
                        log_fecha_registro,
                        log_hora_registro,
                        log_estatus
                     ) 						
                     VALUES
                     (
                         '" . $data['txt_id_cliente'] . "',
                         '" . $data['txt_precio'] . "',
                         '" . $data['txt_descripcion'] . "',
                         '" . $data['txt_user'] . "',
                         '" . date('Y-m-d') .  "',
                         '" . date("g:i:s-a") . "',
                         '1'
                     ) ";
				
                $resultado  = $mysqli->query($sql_insert);
                $id_usuario =  $mysqli->insert_id;
                if ($resultado) {

                    /** DATOS BITACORA **/
                    $data['dp_modulo']          = 'CLIENTE->TARIFAS';
                    $data['dp_accion']         =  "INSERTAR";
                    $data['dp_descripcion']     = 'CREAR TARIFA CLIENTE : ';
                    $data['dp_sql']             = $sql_insert;
                    $data['dp_user']            = $data['txt_user'];
                    $data['dp_fecha_registro']  = date('Y-m-d');
                    $data['dp_hora_registro']   = date("g:i:s-a");
                    $Global->bitacora_user($data);
                    $mysqli->commit();
					
                    $Global->salir_json(1, "");
                    
                } else {
                    $Global->salir_json(2, "ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                }
				
            }else
        {
            $Global->salir_json(2,"Servicio ya registrado!");
        } 
    
    $mysqli->close();
}



/*=============================================
EDITAR SERVICIO CLIENTE
=============================================*/
public function editar_servicio_cliente($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);

	$resut =0;// $this->validar_servicio($data['txt_ciudad_ini'],$data['txt_ciudad_fin'],$data['txt_zona'],$data['txt_id_servicio'],$data['txt_servicio']);

    if ($resut == 0) {

                /**INSERT TABLE  log_clientes_servicios**/
                $sql_insert = "UPDATE clientes_servicios 
							   SET log_precio='".$data['txt_precio']."',
							   log_descripcion='".$data['txt_descripcion']."'
							   WHERE log_id ='".$data['txt_id_servicio']."' ";
                $resultado  = $mysqli->query($sql_insert);
                $id_usuario =  $mysqli->insert_id;
                if ($resultado) {

                    /** DATOS BITACORA **/
                    $data['dp_modulo']          = 'CLIENTE->TARIFA';
                    $data['dp_accion']         =  "EDITAR";
                    $data['dp_descripcion']     = 'EDITAR TARIFA CLIENTE PRECIO : '.$data['txt_precio'].' DESCRIPCION :'.$data['txt_descripcion'];
                    $data['dp_sql']             = $sql_insert;
                    $data['dp_user']            = $data['txt_user'];
                    $data['dp_fecha_registro']  = date('Y-m-d');
                    $data['dp_hora_registro']   = date("g:i:s-a");
                    $Global->bitacora_user($data);
                    $mysqli->commit();
                    $Global->salir_json(1, "");
                } else {
                    $Global->salir_json(2, "ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                }
    }else
        {
            $Global->salir_json(2,"Servicio ya registrado!");
        } 
    $mysqli->close();
}






/*=============================================
ELIMINAR SERVICO CLIENTE
=============================================*/
public function eliminar_servicio_cliente($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);

            $sql_insert      = "DELETE FROM clientes_servicios WHERE log_id ='".$data["txt_id"]."'  ";
            $resultado       = $mysqli->query($sql_insert);
            if ($resultado) {

                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'CLIENTES->TARIFA';
                $data['dp_accion']          =  "ELIMINAR";
                $data['dp_descripcion']     = 'ELIMINAR TARIFA : '.$data['txt_id'];
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
FUNCIONES PRIVADAS
=============================================*/
private function validar_cliente($txt_identificacion)
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  clientes WHERE log_identificacion  ='$txt_identificacion'";
    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 1;
    } else {
        $salida = 0;
    }
    return $salida;   
}


private function validar_cliente_edit($txt_id,$txt_identificacion)
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  clientes WHERE log_identificacion  ='$txt_identificacion' AND log_id !='$txt_id' ";
    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 1;
    } else {
        $salida = 0;
    }
    return $salida;   
}

private function validar_cliente_logo($txt_id,$txt_identificacion)
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  clientes WHERE log_identificacion  ='$txt_identificacion' and log_estatus=1 ";
    $resultado = $mysqli->query($sql);
    $fila = $resultado->fetch_assoc();
   
    return $fila['logo'];  
}


private function servicio($txt_id)
{
    $mysqli = conexionMySQL();
    $sql = "SELECT log_nombre FROM tr_servicios WHERE log_id   ='$txt_id'  ";
    $resultado = $mysqli->query($sql);
    $fila = $resultado->fetch_assoc();
   
    return $fila['log_nombre'];   
}


private function unidad($txt_id)
{
    $mysqli = conexionMySQL();
    $sql = "SELECT log_nombre FROM tr_unidades WHERE log_id   ='$txt_id'  ";
    $resultado = $mysqli->query($sql);
    $fila = $resultado->fetch_assoc();
   
    return $fila['log_nombre'];   
}


private function ciudad($txt_id)
{
    $mysqli = conexionMySQL();
    $sql = "SELECT nombre_procan FROM gb_cantones WHERE id_canton   ='$txt_id'  ";
    $resultado = $mysqli->query($sql);
    $fila = $resultado->fetch_assoc();
   
    return $fila['nombre_procan'];   
}

private function zona($txt_id)
{
    $mysqli = conexionMySQL();
    $sql = "SELECT nombre_zona FROM gb_zona_finca WHERE id_zona   ='$txt_id'  ";
    $resultado = $mysqli->query($sql);
    $fila = $resultado->fetch_assoc();
   
    return $fila['nombre_zona'];   
}


private function validar_servicio($id_ciudad_ini,$txt_ciudad_fin,$txt_zona,$id_cliente,$detallesrv)
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  clientes_servicios 
	WHERE log_id_cliente  ='$id_cliente' AND id_ciudad_ini ='$id_ciudad_ini' 
										 AND id_ciudad_fin ='$txt_ciudad_fin'
										 AND id_zona ='$txt_zona'
                                         AND log_descripcion ='$detallesrv'";

    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 1;
    } else {
        $salida = 0;
    }
    return $salida;   
}

private function validar_servicio_e($id_ciudad_ini,$txt_ciudad_fin,$txt_zona,$id_cliente,$id_servicio)
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  clientes_servicios 
	WHERE log_id_cliente  ='$id_cliente' AND id_ciudad_ini ='$id_ciudad_ini' 
										 AND id_ciudad_fin ='$txt_ciudad_fin'
										 AND id_zona ='$txt_zona',
										 AND log_id !='$id_servicio'
										 ";
    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 1;
    } else {
        $salida = 0;
    }
    return $salida;   
}





}
?>