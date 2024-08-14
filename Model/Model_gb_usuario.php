<?php
class ModelUsuario
{

/*=============================================
LOAD CATEGORIAS
=============================================*/	
public function load_categoria(){

    $dataxr      = array();
    $mysqli      = conexionMySQL();
    $sql         = "SELECT * FROM  gb_perfiles  WHERE gb_estatus=1 ORDER BY gb_id ASC";
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
        $dataxr[] ='NO HAY CATEGORIAS';
    }
    
    return $dataxr;
    $mysqli->close();
}



/*=============================================
REGISTER USERSA
=============================================*/
public function register_user($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


        /** VALIDAMOS NOMBRE DEL FACTOR **/
        $resut = $this->validar_usuario($data['txt_usuario']);
        if($resut == 0)
        {
                    /**INSERT TABLE dp_usuario**/
                    $sql_insert = "INSERT INTO gb_usuarios 
                    ( 	
                        gb_nombre,
                        gb_usuario,
                        telefono,
                        cod_vendedor,
                        gb_email,
                        gb_clave,
                        gb_id_perfil,
                        gb_user,
                        gb_fecha_registro,
                        gb_hora_registro,	
                        gb_estatus
                    ) 						
                    VALUES
                    (
                        '" . $data['txt_nombre'] . "',
                        '" . $data['txt_usuario'] . "',
                        '" . $data['txt_tfno'] . "',
                        '" . $data['txt_codvendedor'] . "',
                        '" . $data['txt_email'] . "',
                        '" . $data['txt_clave'] . "',
                        '" . $data['txt_categoria'] . "',
                        '" . $data['txt_user'] . "',
                        '" . date('Y-m-d').  "',
                        '" . date("g:i:s-a"). "',
                        '1'
                    ) ";
                    
            $resultado  = $mysqli->query($sql_insert);
            $id_usuario =  $mysqli->insert_id;
            if ($resultado) {

                 
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'USUARIO';
                $data['dp_accion']         =  "INSERTAR";
                $data['dp_descripcion']     = 'CREAR USUARIO : '.$data['txt_usuario'];
                $data['dp_sql']             = $sql_insert;
                $data['dp_user']            = $data['txt_user'];
                $data['dp_fecha_registro']  = date('Y-m-d');
                $data['dp_hora_registro']   = date("g:i:s-a");
                $Global->bitacora_user($data);
                $mysqli->commit();
                

            } else {
                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
            }

            /** INSERTAMOS PERMISOS POR PERFIL**/
            $this->usuario_modulo($id_usuario,$data['txt_categoria']);
        }
        else
        {
            $Global->salir_json(2,"Usuario ya registrado! ");
        }

    $mysqli->close();
}


/*=============================================
TABLE USER
=============================================*/
public function table_user()
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT * FROM  gb_usuarios WHERE gb_estatus='1' ORDER BY gb_id  DESC ";
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

        $fila['dp_id_perfil'] = $fila['gb_id_perfil'];
        $fila['dp_perfil']    = $this->perfil_usuario($fila['gb_id_perfil']);
        $data[]   = $fila;
    }
    $mysqli->close();
    return $data;
}




/*=============================================
EDIT USERS
=============================================*/
public function edit_user($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


        /** VALIDAMOS NOMBRE DEL FACTOR **/
        $resut = $this->validar_usuario_edit($data['txt_id_user'],$data['txt_usuario']);
        if($resut == 0)
        {
                
            if($data['txt_clave'] !='')
            {
                $sql_insert  = "UPDATE gb_usuarios SET gb_nombre='".$data['txt_nombre']."',
                gb_usuario='".$data['txt_usuario']."',gb_email='".$data['txt_email']."',
                cod_vendedor='".$data['txt_codvendedor']."',telefono='".$data['txt_tfno']."',
                gb_clave='".$data['txt_clave']."',gb_id_perfil ='".$data['txt_categoria']."' WHERE gb_id='".$data['txt_id_user']."'"; 
            }   
            else
            {
                $sql_insert  = "UPDATE gb_usuarios SET gb_nombre='".$data['txt_nombre']."',
                gb_usuario='".$data['txt_usuario']."',gb_email='".$data['txt_email']."',
                cod_vendedor='".$data['txt_codvendedor']."',telefono='".$data['txt_tfno']."',
                gb_id_perfil ='".$data['txt_categoria']."' WHERE gb_id='".$data['txt_id_user']."'"; 
            }     
                     
            $resultado       = $mysqli->query($sql_insert);
            if ($resultado) {

                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'USUARIO';
                $data['dp_accion']         =  "EDITAR";
                $data['dp_descripcion']     = 'EDITAR USUARIO : '.$data['txt_nombre'];
                $data['dp_sql']             = $sql_insert;
                $data['dp_user']            = $data['txt_user'];
                $data['dp_fecha_registro']  = date('Y-m-d');
                $data['dp_hora_registro']   = date("g:i:s-a");
                $Global->bitacora_user($data);
                $mysqli->commit();
                

            } else {
                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
            }

            /** INSERTAMOS PERMISOS POR PERFIL**/
            $this->usuario_modulo($data['txt_id_user'],$data['txt_categoria']);
        }
        else
        {
            $Global->salir_json(2,"Nombre usuario ya existe! ");
        }
    $mysqli->close();
}



/*=============================================
EDIT USERS
=============================================*/
public function delete_user($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);

            $sql_insert      = "DELETE FROM gb_usuarios WHERE gb_id='".$data["txt_id"]."'  ";
            $resultado       = $mysqli->query($sql_insert);
            if ($resultado) {

                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'USUARIO';
                $data['dp_accion']          =  "ELIMINAR";
                $data['dp_descripcion']     = 'ELIMINAR USUARIO : '.$data['txt_usuario'];
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
ELIMINAR USUARIO
=============================================*/


/*=============================================
    FUNCIONES PRIVADAS
=============================================*/
    private function validar_usuario($txt_user)
    {
        $mysqli = conexionMySQL();
        $sql = "SELECT * FROM  gb_usuarios WHERE gb_usuario ='$txt_user'";
        $resultado = $mysqli->query($sql);
        $n = $resultado->num_rows;
        if ($n > 0) {
            $salida = 1;
        } else {
            $salida = 0;
        }
        return $salida;   
    }

    private function validar_usuario_edit($txt_id,$txt_user)
    {
        $mysqli = conexionMySQL();
        $sql = "SELECT * FROM  gb_usuarios WHERE gb_usuario ='$txt_user' AND gb_id !='$txt_id' ";
        $resultado = $mysqli->query($sql);
        $n = $resultado->num_rows;
        if ($n > 0) {
            $salida = 1;
        } else {
            $salida = 0;
        }
        return $salida;   
    }


    private function perfil_usuario($txt_perfil)
    {
        $mysqli = conexionMySQL();
        $sql = "SELECT * FROM  gb_perfiles WHERE gb_id   ='$txt_perfil'";
        $resultado = $mysqli->query($sql);
        $fila = $resultado->fetch_assoc();
        
        return $fila['gb_nombre'];   
    }



    public function usuario_modulo($id_usuario,$id_perfil)
    {
        $Global      = new ModelGlobal();
        $mysqli      = conexionMySQL();
        $mysqli->autocommit(FALSE);


        /** BORRAMOS PERMISOS PREVIOS**/
        $sql1         = "DELETE FROM  gb_usuario_modulo WHERE gb_id_user   ='$id_usuario' ";
        $resultado1   = $mysqli->query($sql1);

        $sql1         = "DELETE FROM  gb_modulo_menu WHERE gb_id_user ='$id_usuario' ";
        $resultado1   = $mysqli->query($sql1);

        $sql         = "SELECT * FROM  gb_modulo_perfil WHERE gb_id_perfil ='$id_perfil'";
        $resultado   = $mysqli->query($sql);
        $n = $resultado->num_rows;
        if ($n > 0) {

            while ($fila = $resultado->fetch_assoc()) {

               
                    /** INSERTAMOS MENUS PERMITOS POR MODULO **/
                    $sql_menu         = "SELECT * FROM  gb_menu WHERE gb_id_modulo  ='".$fila['gb_id_modulo']."'";
                    $resultado_menu   = $mysqli->query($sql_menu);
                    $n_menu = $resultado_menu->num_rows;
                    if ($n_menu > 0) {

                        while ($fila_menu = $resultado_menu->fetch_assoc()) {


                             /**INSERT TABLE gb_modulo_menu**/
                            $sql_insert = "INSERT INTO gb_modulo_menu 
                            ( 	
                            gb_id_modulo,
                            gb_id_menu,
                            gb_id_user,
                            gb_estatus
                            ) 						
                            VALUES
                            (
                                '" . $fila['gb_id_modulo'] . "',
                                '" . $fila_menu['gb_id_menu'] . "',
                                '" . $id_usuario . "',
                                '1'
                            ) ";
                            $resultado_insert  = $mysqli->query($sql_insert);
                            if ($resultado_insert) {
            
                                } else {
                                    $Global->salir_json(2, "ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                                }

                        }
                    }
               
                    /**INSERT TABLE dp_usuario_modulo**/
                    $sql_insert = "INSERT INTO gb_usuario_modulo 
                    ( 	
                    gb_id_modulo,
                    gb_id_user,
                    gb_estatus
                    ) 						
                    VALUES
                    (
                        '" . $fila['gb_id_modulo'] . "',
                        '" . $id_usuario . "',
                        '1'
                    ) ";
                $resultado_insert  = $mysqli->query($sql_insert);
                if ($resultado_insert) {
                    
                    $mysqli->commit();
                        } else {
                            $Global->salir_json(2, "ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                        }
                   
                   }

                  
                   $Global->salir_json(1,'');


        }
        else
        {
            $Global->salir_json(1,'');
        }
  
    }
}
?>