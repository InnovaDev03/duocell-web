<?php
class ModelLabor
{


/*=============================================
LOAD GRUPO
=============================================*/	
public function load_rubro(){

    $dataxr      = array();
    $mysqli      = conexionMySQL();
    $sql         = "SELECT *  FROM pa_cadenas where estatus=1 ORDER BY nombre  ASC";
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
        $dataxr[] ='NO HAY RUBROS';
    }
    
    return $dataxr;
    $mysqli->close();
	}


/*=============================================
TABLE LABOR
=============================================*/
public function table_labor()
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT * FROM cf_labores ORDER BY id_labor DESC ";
	
	
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

        $data[]   = $fila;
    }
    $mysqli->close();
    return $data;
}


/*=============================================
TABLE LABOR
=============================================*/
public function table_historial_precio($id_labor)
{
    $mysqli      = conexionMySQL();
    $Global  = new ModelGlobal();
    $data        = array();
    $sql         = "SELECT * FROM cf_historail_labores_precios WHERE id_labor='".$id_labor."'";
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

        $fila['fecha_nueva'] = $Global->formatearFecha($fila['fecha_nueva']);
        $fila['usuario'] = $this->usuario($fila['id_usuario']);
        $data[]          = $fila;
    }
    $mysqli->close();
    return $data;
}

/*=============================================
LOAD SECTOR
=============================================*/	
	
public function usuario($id_usuario)
{
    $mysqli      = conexionMySQL();
     $sql         = "SELECT gb_usuario FROM gb_usuarios WHERE gb_id  =".$id_usuario."";
    $resultado   = $mysqli->query($sql);
    $file =  $resultado->fetch_assoc();
    return $file['gb_usuario'];
}



/*=============================================
REGISTRAR LABOR
=============================================*/
public function registro_labor($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);

        /** VALIDAMOS LABOR **/
        $resut = 0;// $this->validar_labor($data['labor']);
        if($resut == 0)
        {
                    /**INSERT TABLE cf_labores**/
                    $sql_insert = "INSERT INTO `bonificaciones`( `anio`, `rubro`,`enero`, `febrero`, `marzo`, `abril`, `mayo`, 
                     `junio`, `julio`, `agosto`, `septiembre`, `octubre`, `noviembre`,
                      `diciembre`, `fecha_creacion`, `estado`,id_cadena, item, `id_usuariofk`)				
                    VALUES
                    (
                        '" . $data['txt_ano'] . "',
						'" . $data['labor'] . "',
						'" . $data['mes1'] . "',
                        '" . $data['mes2'] . "',
                        '" . $data['mes3'] . "',
                        '" . $data['mes4'] . "',
                        '" . $data['mes5'] . "',
                        '" . $data['mes6'] . "',
                        '" . $data['mes7'] . "',
                        '" . $data['mes8'] . "',
                        '" . $data['mes9'] . "',
                        '" . $data['mes10'] . "',
                        '" . $data['mes11'] . "',
                        '" . $data['mes12'] . "',
                        '" . date('Y-m-d h:i:s').  "',
                        1,
                        '" . $data['labor'] . "',
                        '" . $data['txt_nivel1'] . "',
						'" . $data['txt_user'] . "'
                    ) ";
                    
            $resultado  = $mysqli->query($sql_insert);
            $id_usuario =  $mysqli->insert_id;
            if ($resultado) {
                
                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'BONIFICACION->REGISTRO';
                $data['dp_accion']         =  "INSERTAR";
                $data['dp_descripcion']     = 'CREAR BONIFICACION : '.$data['txt_ano'] . $data['labor'] ;
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
            $Global->salir_json(2,"Bonificación ya registrada! ");
        }

    $mysqli->close();
}



/*=============================================
ELIMINAR LABOR
=============================================*/
public function eliminar_labor($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);

            $sql_insert      = "UPDATE bonificaciones SET estado = 0  WHERE id_bonificacion ='".$data["txt_id"]."'  ";
            $resultado       = $mysqli->query($sql_insert);
            if ($resultado) {

                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'BONIFICACION->ELIMINACION';
                $data['dp_accion']          = "ELIMINAR";
                $data['dp_descripcion']     = 'ELIMINAR BONIFICACION ID : '.$data['txt_id'];
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
ACTIVAR LABOR
=============================================*/
public function activar_labor($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);

            $sql_insert      = "UPDATE cf_labores SET estado = 'A' WHERE id_labor ='".$data["txt_id"]."'  ";
            $resultado       = $mysqli->query($sql_insert);
            if ($resultado) {

                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'CHACIENDA->LABOR';
                $data['dp_accion']          = "ACTIVAR";
                $data['dp_descripcion']     = 'ACTIVAR LABOR : '.$data['labor'];
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
EDITAR LABOR
=============================================*/
function editar_labor($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);


        /** VALIDAMOS NOMBRE DEL LABOR **/
       // $resut = $this->validar_labor_edit($data['txt_id'],$data['txt_labor_e']);
        if(0 == 0)
        {     
            /** INSERTAMOS EN HISTORIAS DE CAMBIO DE PRECIO**/
            //$this->historial_precio($data['txt_id'],$data['txt_valor_e'],$data['txt_user']);
            
            $sql_insert = "UPDATE  bonificaciones SET
            `enero`='".$data['mes1']."',`febrero`='".$data['mes2']."',`marzo`='".$data['mes3']."',
            `abril`='".$data['mes4']."',`mayo`='".$data['mes5']."',`junio`='".$data['mes6']."',
            `julio`='".$data['mes7']."',`agosto`='".$data['mes8']."',`septiembre`='".$data['mes9']."',
            `octubre`='".$data['mes10']."',`noviembre`='".$data['mes11']."',`diciembre`='".$data['mes12']."',
            `id_usuariofk`='".$data['txt_user']."' WHERE id_bonificacion='".$data['txt_id']."' "; 
            $resultado  = $mysqli->query($sql_insert);
            $id_usuario =  $mysqli->insert_id;
            if ($resultado) {

                /** DATOS BITACORA **/
                $data['dp_modulo']          = 'BONIFICACION->EDICION';
                $data['dp_accion']         =  "EDITAR";
                $data['dp_descripcion']     = 'EDITAR ID : '.$data['txt_id'];
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
            $Global->salir_json(2,"Bonificación editado! ");
        }

    $mysqli->close();
}


/*=============================================
    FUNCIONES PRIVADAS
=============================================*/
private function historial_precio($id_labor,$precio_nuevo,$id_usuario)
{
    $mysqli          = conexionMySQL();
    $Global          = new ModelGlobal();
    $sql             = "SELECT valorunitario FROM  cf_labores WHERE id_labor  ='$id_labor'";
    $resultado       = $mysqli->query($sql);
    $fila            = $resultado->fetch_assoc();
    $precio_anterior = $fila['valorunitario'];

    $sql_insert = "INSERT INTO cf_historail_labores_precios 
                    ( 	
                            id_labor,
							precio_anterior,
							precio_nuevo,
							id_usuario,
                            fecha_nueva,
                            hora_actualizacion
							
                    ) 						
                    VALUES
                    (
                        '" . $id_labor . "',
						'" . $precio_anterior.  "',
                        '" . $precio_nuevo . "',
						'" . $id_usuario . "',
                        '" . date('Y-m-d') . "',
                        '" . date("g:i:s-a") . "'
                    ) ";
            $resultado  = $mysqli->query($sql_insert);
            $id_usuario =  $mysqli->insert_id;
            if ($resultado) {
            } else {
                $Global->salir_json(2,"ERROR INSERCION " . $sql_insert);
            }
}   


/*=============================================
    FUNCIONES PRIVADAS
=============================================*/
private function validar_labor($labor)
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  cf_labores WHERE labor ='$labor'";
    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 1;
    } else {
        $salida = 0;
    }
    return $salida;   
}

private function validar_labor_edit($txt_id,$labor)
{
    $mysqli = conexionMySQL();
    $sql = "SELECT * FROM  cf_labores WHERE labor ='$labor' AND id_labor !='$txt_id' ";
    $resultado = $mysqli->query($sql);
    $n = $resultado->num_rows;
    if ($n > 0) {
        $salida = 0;
    } else {
        $salida = 1;
    }
    return $salida;   
}




/*=============================================
LOAD GRUPO
=============================================*/	
public function cargar_n1($data1,$data2){

    $dataxr      = array();
    $mysqli      = conexionMySQL();
    $sql         = "SELECT *  FROM pa_tiendas where id_cadena =".$data1." and estatus=1 ORDER BY nombre  ASC";
    $resultado   = $mysqli->query($sql);
    $n           = $resultado->num_rows;
    if($n>0)
    {
        while ($file =  $resultado->fetch_assoc()) {
            $resut =  $this->validar_tiendaanio($file['id'],$data2);
if($resut==1){
} else {
    $dataxr[] = $file;
}
        }
    }
    
    return $dataxr;
    $mysqli->close();
	}

    private function validar_tiendaanio($labor,$datax)
    {
        $mysqli = conexionMySQL();
        $sql = "SELECT * FROM  presupuesto WHERE id_tienda ='$labor' and anio='$datax' and estado=1 ";
        $resultado = $mysqli->query($sql);
        $n = $resultado->num_rows;
        if ($n > 0) {
            $salida = 1;
        } else {
            $salida = 0;
        }
        return $salida;   
    }
    

    
    public function cargar_n2($data1){

        $dataxr      = array();
        $mysqli      = conexionMySQL();
        $sql         = "SELECT *  FROM rubros_n2 where mt_id_n1  =".$data1." ORDER BY mt_id  ASC";
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
            $dataxr[] ='NO HAY RUBROS';
        }
        
        return $dataxr;
        $mysqli->close();
        }
    

        
        public function cargar_n3($data1){

            $dataxr      = array();
            $mysqli      = conexionMySQL();
            $sql         = "SELECT *  FROM rubros_n3 where mt_id_n2  =".$data1." ORDER BY mt_id  ASC";
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
                $dataxr[] ='NO HAY RUBROS';
            }
            
            return $dataxr;
            $mysqli->close();
            }
        


public function table_ventas($data1,$data2)
{
    $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT * FROM bonificaciones 
   
 where  id_cadena =".$data1." and anio=".$data2." and estado=1   ";
	
	
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

        $data[]   = $fila;
    }
    $mysqli->close();
    return $data;
}


        


}