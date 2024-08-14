<?php
class ModelInventarioBlo
{
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
        $contador=0;
		$rp_detalles    = "SELECT *  FROM gb_perfiles WHERE  gb_id =4 ";
		$query_detalles = $mysqli->query($rp_detalles);
        while ($fila = $query_detalles->fetch_assoc()) {
           
            if($fila['gb_bloqueo'] == 1)
            {
                $fila['estado'] = '<stron><span style="color: red;">BLOQUEADO : </span></stron>'.$fila['fecha_actualizacion'].'<input type="checkbox" checked class="custom-checkbox" onChange="mostrar('.$fila['gb_id'].',0);">';
            }
            else
            {
                $fila['estado'] = '<input type="checkbox"  class="custom-checkbox" onChange="mostrar('.$fila['gb_id'].',1);">';
            }


            
            $data[] = $fila;
		}
		
		$mysqli->close();
		return $data;
	}


	public function bloqueo($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);




            $sql_insert = "UPDATE  gb_perfiles SET gb_bloqueo='".$data['estado']."',fecha_actualizacion='".date('d-m-Y g:i:s-a')."' WHERE gb_id='".$data['id']."'"; 
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {

                /** DATOS BITACORA **/
                $mysqli->commit();
                
                $Global->salir_json(1,"");
            } else {
                $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
            }

      

    $mysqli->close();
}

}