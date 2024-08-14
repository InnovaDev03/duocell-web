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
        $resut =0;// $this->validar_cadena($data['txt_nombre_cadena']);
        if($resut == 0)
        {
                    
                    $sql_insert = "INSERT INTO gamas 
                    ( 	
                        nombre,
                        gama,
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
                $data['dp_modulo']          = 'GAMAS->REGISTRO';
                $data['dp_accion']         =  "INSERTAR";
                $data['dp_descripcion']     = 'CREAR GAMA DE PRODUCTO : '.$data['txt_nombre_cadena'];
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
            $Global->salir_json(2,"Cadena registrada! ");
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
    $sql         = "SELECT * FROM gamas where estatus=1";
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
        $resut = 0;//$this->validar_cadena_edit($data['txt_id_cadena'],$data['txt_nombre_cadena']);
        if($resut == 0)
        {
                    
            $sql_insert = "UPDATE gamas SET nombre='".$data['txt_nombre_cadena']."',GAMA='".$data['txt_ciudad_cadena']."' WHERE id='".$data['txt_id_cadena']."'  ";
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'ACTUALIZAR->GAMAS';
                $data['dp_accion']         =  "EDITAR";
                $data['dp_descripcion']     = 'EDITAR GAMA : '.$data['txt_nombre_cadena'];
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
            $Global->salir_json(2,"Gama  existe! ");
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


       
                    
            $sql_insert = "UPDATE gamas SET estatus='0' WHERE id='".$data['txt_id']."'  ";
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'ELIMINAR->GAMA';
                $data['dp_accion']         =  "DESACTIVAR";
                $data['dp_descripcion']     = 'DESACTIVAR GAMA : '.$data['txt_nombre'];
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
    $sql         = "SELECT pa_tiendas.*, gb_usuarios.gb_nombre FROM pa_tiendas
    left join gb_usuarios on
    gb_usuarios.gb_id = pa_tiendas.pr_vendedor
     WHERE pa_tiendas.id_cadena='".$txt_id."' ";
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

        $fila['cadena'] = $this->nombre_cadena($fila['id_cadena']);
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
        $resut = $this->validar_tienda($data['txt_nombre_tienda'],$data['txt_pr_id_cadena']);
        if($resut == 0)
        {
                    
                    $sql_insert = "INSERT INTO pa_tiendas 
                    ( 	
                        id_cadena, 
                        nombre,
                        ciudad ,
                        direccion,
                        id_usuario,
                        estatus
                    ) 						
                    VALUES
                    (
                        '" . $data['txt_pr_id_cadena'] . "',
                        '" . $data['txt_nombre_tienda'] . "',
                        '" . $data['txt_ciudad_tienda'] . "',
                        '" . $data['txt_direccion_tienda'] . "',
                        '" . $data['txt_user'] . "',
                        '1'
                    ) ";
                    
            $resultado  = $mysqli->query($sql_insert);
            $id_usuario =  $mysqli->insert_id;
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'PARAMETRIZACION->CADENA';
                $data['dp_accion']         =  "INSERTAR";
                $data['dp_descripcion']     = 'CREAR TIENDA : '.$data['txt_nombre_tienda'];
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
                    
            if ($data["txt_vendedor_cadena"]!=''){
$concats=  " pr_vendedor='".$data['txt_vendedor_cadena']."' , ";
            } else {
                $concats=  "";
            }
            $sql_insert = "UPDATE pa_tiendas SET nombre='".$data['txt_nombre_tienda']."', $concats  ciudad='".$data['txt_ciudad_tienda']."',direccion='".$data['txt_nombre_tienda']."' WHERE id='".$data['txt_id_tienda']."'  ";
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




    /*=============================================
CARGAR CADENAS
=============================================*/	
public function cargar_vendedores(){

    $dataxr      = array();
    $mysqli      = conexionMySQL();
    $sql         = "SELECT * FROM   gb_usuarios  WHERE gb_estatus = '1' and gb_id_perfil=2";
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
        $dataxr['gb_id']     ='0';
        $dataxr['gb_nombre'] ='NO HAY CLIENTE';
    }
    
    return $dataxr;
    $mysqli->close();
}


}