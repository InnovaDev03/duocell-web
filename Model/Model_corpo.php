<?php
class ModelParametrizacion
{
    /*=============================================
REGISTER CADENA
=============================================*/
public function registrar_cadena($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


        /** VALIDAMOS NOMBRE DE LA CADENA **/
        $resut = $this->validar_cadena($data['txt_nombre_cadena']);
        if($resut == 0)
        {
                    
                    $sql_insert = "INSERT INTO factores 
                    ( 	
                        nombre,
                        factor ,
                        id_usuario,
                        estatus
                    ) 						
                    VALUES
                    (
                        '" . $data['txt_nombre_cadena'] . "',
                        '" . $data['txt_ciudad_cadena'] . "',
                        '" . $data['txt_user'] . "',
                        '1'
                    ) ";
                    
            $resultado  = $mysqli->query($sql_insert);
            $id_usuario =  $mysqli->insert_id;
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'CLIENTES CORPORATIVO->FACTOR';
                $data['dp_accion']         =  "INSERTAR";
                $data['dp_descripcion']     = 'CREAR FACTOR : '.$data['txt_nombre_cadena'];
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
            $Global->salir_json(2,"Factor ya ha sido registrado! ");
        }

    $mysqli->close();
}



/*=============================================
TABLE CADENA
=============================================*/
public function table_cadenas()
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT * FROM factores";
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

        $data[]   = $fila;
    }
    $mysqli->close();
    return $data;
}



 /*=============================================
EDITAR CADENA
=============================================*/
public function editar_cadena($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


        /** VALIDAMOS NOMBRE DE LA CADENA **/
        $resut = $this->validar_cadena_edit($data['txt_id_cadena'],$data['txt_nombre_cadena']);
        if($resut == 0)
        {
                    
            $sql_insert = "UPDATE pa_cadenas SET nombre='".$data['txt_nombre_cadena']."',ciudad='".$data['txt_ciudad_cadena']."',direccion='".$data['txt_nombre_cadena']."' WHERE id='".$data['txt_id_cadena']."'  ";
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'PARAMETRIZACION->CADENA';
                $data['dp_accion']         =  "EDITAR";
                $data['dp_descripcion']     = 'EDITAR CADENA : '.$data['txt_nombre_cadena'];
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
            $Global->salir_json(2,"Nombre cadena  existe! ");
        }

    $mysqli->close();
}



 /*=============================================
DESACTIVAR CADENA
=============================================*/
public function disabled_cadena($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


       
                    
            $sql_insert = "UPDATE factores SET estatus='0' WHERE id='".$data['txt_id']."'  ";
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'CLIENTES CORPORATIVO->FACTOR';
                $data['dp_accion']         =  "DESACTIVAR";
                $data['dp_descripcion']     = 'DESACTIVAR FACTOR : '.$data['txt_nombre'];
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


 /*=============================================
DESACTIVAR CADENA
=============================================*/
public function enabled_cadena($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


       
                    
            $sql_insert = "UPDATE pa_cadenas SET estatus='1' WHERE id='".$data['txt_id']."'  ";
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'PARAMETRIZACION->CADENA';
                $data['dp_accion']         =  "ACTIVAR";
                $data['dp_descripcion']     = 'ACTIVAR CADENA : '.$data['txt_nombre'];
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



/*=============================================
TABLE TIENDAS
=============================================*/
public function table_tiendas($txt_id)
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT * FROM clientescorpo WHERE id_factor='".$txt_id."' ";
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

        //$fila['cadena'] = $this->nombre_cadena($fila['id_cadena']);
        $data[]         = $fila;
    }
    $mysqli->close();
    return $data;
}

 /*=============================================
REGISTER TIENDA
=============================================*/
public function register_tienda($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


        /** VALIDAMOS NOMBRE DE LA CADENA **/
        $resut = 0;//$this->validar_tienda($data['txt_nombre_tienda'],$data['txt_pr_id_cadena']);
        if($resut == 0)
        {
                    
                    $sql_insert = "INSERT INTO clientescorpo 
                    ( 	
                        id_factor,
                        id_cliente,
                        cliente_nombre,
                        id_usuario,
                        estatus
                    ) 						
                    VALUES
                    (
                        '" . $data['txt_pr_id_cadena'] . "',
                        '" . $data['txt_cliente'] . "',
                        '" . $data['txt_cliente_texto'] . "',
                        '" . $data['txt_user'] . "',
                        '1'
                    ) ";
                    
            $resultado  = $mysqli->query($sql_insert);
            $id_usuario =  $mysqli->insert_id;
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'CLIENTES CORPORATIVO->CLIENTE';
                $data['dp_accion']         =  "INSERTAR";
                $data['dp_descripcion']     = 'CREAR CLIENTE : '.$data['txt_cliente'];
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
            $Global->salir_json(2,"Tienda registrada! ");
        }

    $mysqli->close();
}

/*=============================================
EDITAR TIENDA
=============================================*/
public function edit_tienda($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


        /** VALIDAMOS NOMBRE DE LA CADENA **/
        $resut = $this->validar_tienda_edit($data['txt_id_tienda'],$data['txt_nombre_tienda']);
        if($resut == 0)
        {
                    
            $sql_insert = "UPDATE pa_tiendas SET nombre='".$data['txt_nombre_tienda']."',ciudad='".$data['txt_ciudad_tienda']."',direccion='".$data['txt_nombre_tienda']."' WHERE id='".$data['txt_id_tienda']."'  ";
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'PARAMETRIZACION->CADENA';
                $data['dp_accion']         =  "EDITAR";
                $data['dp_descripcion']     = 'EDITAR TIENDA : '.$data['txt_nombre_tienda'];
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
            $Global->salir_json(2,"Nombre tienda  existe! ");
        }

    $mysqli->close();
}


 /*=============================================
DESACTIVAR TIENDA
=============================================*/
public function disabled_tienda($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


       
                    
            $sql_insert = "UPDATE pa_tiendas SET estatus='0' WHERE id='".$data['txt_id']."'  ";
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'PARAMETRIZACION->CADENA';
                $data['dp_accion']         =  "DESACTIVAR";
                $data['dp_descripcion']     = 'DESACTIVAR TIENDA : '.$data['txt_nombre'];
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


 /*=============================================
DESACTIVAR TIENDA
=============================================*/
public function enabled_tienda($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


       
                    
            $sql_insert = "UPDATE pa_tiendas SET estatus='1' WHERE id='".$data['txt_id']."'  ";
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'PARAMETRIZACION->CADENA';
                $data['dp_accion']         =  "ACTIVAR";
                $data['dp_descripcion']     = 'ACTIVAR TIENDA : '.$data['txt_nombre'];
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


/*=============================================
    FUNCIONES PRIVADAS
=============================================*/
private function validar_cadena($txt_nombre) 
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  pa_cadenas WHERE nombre ='$txt_nombre'";
    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 1;
    } else {
        $salida = 0;
    }
    return $salida;   
}
private function validar_cadena_edit($txt_id,$txt_nombre) 
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  pa_cadenas WHERE nombre ='$txt_nombre'  AND id !='$txt_id'";
    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 1;
    } else {
        $salida = 0;
    }
    return $salida;   
}

private function nombre_cadena($txt_id)
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  pa_cadenas WHERE id  ='$txt_id'";
    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $fila = $resultado->fetch_assoc();
        $salida =$fila['nombre'];

    } else {
        $salida ='NO POSEE';
    }
    
    return $salida;  
}

private function validar_tienda($txt_nombre,$txt_idcadena) 
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  pa_tiendas WHERE nombre ='$txt_nombre' and  id_cadena='$txt_nombre'  ";
    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 1;
    } else {
        $salida = 0;
    }
    return $salida;   
}
private function validar_tienda_edit($txt_id,$txt_nombre) 
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  pa_tiendas WHERE nombre ='$txt_nombre'  AND id !='$txt_id'";
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