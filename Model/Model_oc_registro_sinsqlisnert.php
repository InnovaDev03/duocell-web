<?php
class ModelPromotor
{
    


    /*=============================================
FUNCION OBTENER SECUENCIA DE CODIGO
=============================================*/
    public function secuencia_codigo($txt_user){
        $data        = array();
        $mysqli      = conexionMySQL();
        $sql         = "SELECT  count(*) AS secuencia  FROM ordencompra";
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
        $resut = 0;// $this->validar_item_cargado($data['txt_id'],$data['txt_user']);
                if($resut == 0)
                {
                    $pvp = round($data['txt_precio'] /1.12,2);
                    $dcto = round($data['txt_descuento'] /1.12,2);
                    $iva = round(($pvp-$dcto)*0.12,2);

                    $total = round($data['txt_cantidad'] *  ($pvp-$dcto+$iva),2);
                    $datoinsert='';
                    $datovalue='';

                    if ($data['txt_direntrega']!=''){
                        $datoinsert=" , direccion_entrega ";
                        $datovalue= " , '".$data['txt_direntrega']."' ";
                    }

                    $sql_insert = "INSERT INTO oc_detalletemp 
                    ( 	
                        `item`, `descripcion`, `cantidad`, `precio`,
                         `descuento`, `PVP`, `Dcto_iva`,  `iva`, `total` $datoinsert ,`usuario`
                        
                    ) 						
                    VALUES
                    (
                        '" . $data['txt_id'] . "',
                        '" . $data['txt_text'] . "',
                        '" . $data['txt_cantidad'] . "',
                        '" . $data['txt_precio'] . "',
                        '" . $data['txt_descuento'] . "',
                        '".$pvp."',
                        '".$dcto."',
                        '".$iva."',
                        '" . $total . "'
                        $datovalue ,
                        '" . $data['txt_user'] . "'
                    ) ";
                }
                else
                {   

                    $sql = "SELECT * FROM  oc_detalletemp WHERE item ='".$data['txt_id'] ."' AND usuario='".$data['txt_user'] ."'";
                    $resultado = $mysqli->query($sql);
                    $fila = $resultado->fetch_assoc();
                    $total = round(($fila['cantidad'] + 1) *  $data['txt_precio'],2);
                    $sql_insert = "UPDATE oc_detalletemp SET cantidad=cantidad+1,total='".$total."',precio='".$data['txt_precio']."'
                     WHERE usuario='".$data['txt_user'] ."'";
                }
            $resultado  = $mysqli->query($sql_insert);
            if ($resultado) {

               
                $mysqli->commit();
                $total = $this->total_venta($data['txt_user']);
                $Global->salir_json_total(1,"",$total);
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
    $sql         = "SELECT * FROM oc_detalletemp WHERE usuario='".$txt_id."'";
    $resultado   = $mysqli->query($sql);
    while ($fila = $resultado->fetch_assoc()) {

        
        $fila['imei']     = $this->verificar_imeis($fila['item'],$txt_id);
        
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


    $sql_insert = "DELETE FROM oc_detalletemp WHERE id ='".$data['txt_id']."'";
    $resultado  = $mysqli->query($sql_insert);

    //$sql_insert = "DELETE FROM pr_venta_imei_temp WHERE pr_id_articulo ='".$data['txt_id_item']."'";
    //$resultado  = $mysqli->query($sql_insert);
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
                            $sql_insert = "INSERT INTO ordencompra 
                            ( 	oc_codigo,
                                id_cliente,
                                oc_total,
                                oc_forma_pago,
                                oc_fecha,
                                oc_observaciones,
                                oc_id_usuario,
                                oc_estatus,
                                cupo_disponible,
                                saldo_vencido,
                                id_cliente_fk,
                                dato_adjunto
                            ) 						
                            VALUES
                            (
                                
                                '" . $data['txt_codigo'] . "',
                                '" . $data['txt_cadena'] . "',
                                '" . $data['txt_total'] . "',
                                '" . $data['txt_pago'] . "',
                                '" . $fecha . "',
                                '" . $observaciones . "',
                                '" . $data['txt_user'] . "',
                                '1',
                                '" . $data['txt_cupodisponible'] . "',
                                '" . $data['txt_saldovencido'] . "',
                                '" . $data['txt_cliente'] . "',
                                '" . $data['valorimg'] . "'
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
                            $rp_detalles = "SELECT * FROM oc_detalletemp WHERE usuario='".$data['txt_user']."'" ;
                            $query_detalles=$mysqli->query($rp_detalles);
                            $n= $query_detalles->num_rows;
                            if($n>0)
                            {
                                while ($registro_detalles=$query_detalles->fetch_assoc())
                                {
                                    $itemid=$registro_detalles['item'] ;
                                    $total=0;
                                    //VALIDAMOS DE ESE PRODUCTO CUANTOS HAY EN OC
                                    $rp_detalles2 = "SELECT sum(cantidad) as total FROM oc_detalle WHERE item='".$itemid."' and estatus_oc=1" ;
                                    $query_detalles2=$mysqli->query($rp_detalles2);
                                        while ($registro_detalles2=$query_detalles2->fetch_assoc())
                                        {
                                            $total=$registro_detalles2['total'] ;
                                        }        
                                    
                                    //AQUI VALIDAMOS PRODUCTO Y LO HACEMOS
                                 
                                    include 'bdsql.php';
                                      $dbconn      = conexionSQLSI();
                                      //query del stock  
                                      
$resultado   = sqlsrv_query($dbconn,"SELECT sum(stock) existencia, codigo  FROM INExistencia
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
          $idinvapi=$row['codigo']; 
    }
} else {
    $paso=1;
}

                                  if( $paso!=0){

                                    $sql_insert = "INSERT INTO oc_detalle 
                                    ( 	
                                        id_ordencompra, `item`, `descripcion`, `cantidad`, `precio`,
                                        `descuento`, `PVP`, `Dcto_iva`,  direccion_entrega, `iva`, `total`, `usuario`
                                        
                                    ) 						
                                    VALUES
                                    (
                                        '" . $max_id . "',
                                        '" . $itemid. "',
                                        '" . $registro_detalles['descripcion'] . "',
                                        '" . $registro_detalles['cantidad'] . "',
                                        '" . $registro_detalles['precio'] . "',
                                        '" . $registro_detalles['descuento'] . "',
                                        '" . $registro_detalles['PVP'] . "',
                                        '" . $registro_detalles['Dcto_iva'] . "',
                                        '" . $registro_detalles['direccion_entrega'] . "',
                                        '" . $registro_detalles['iva'] . "',
                                        '" . $registro_detalles['total'] . "',
                                        '" . $data['txt_user'] . "'
                                    ) ";
                                    $resultado  = $mysqli->query($sql_insert);
                                    if ($resultado) 
                                    {
                                        //guardo en variable para al final enviarlo x api
                                        $descripcion=$registro_detalles['descripcion'];
                                        $cantidad=$registro_detalles['cantidad'];
                                        $precio=$registro_detalles['precio'];
                                        $descuento=$registro_detalles['descuento'];
                                        $PVP=$registro_detalles['PVP'];
                                        $Dcto_iva=$registro_detalles['Dcto_iva'];
                                        $iva=$registro_detalles['iva'];
                                        $total=$registro_detalles['total'];
                                        $direccion_entrega=$registro_detalles['direccion_entrega'];
//CONSULTO COSTO DEL PRODUCTO
$resultadox   = sqlsrv_query($dbconn,"SELECT top 1 costo  FROM INExistencia
WHERE  codigo  = '".$term."'   ");
$costoapi=0;

while ($rowx = sqlsrv_fetch_array($resultadox, SQLSRV_FETCH_ASSOC)) {
    $costoapi=$rowx['costo']; 
}

$arreglodato= $arreglodato .'{
                                            "codigo":"'.$codigo_itemapi.'",
                                            "descripcion":"'.$descripcion.'",
                                            "codigo_item": "'.$itemid.'",
                                            "bodega_id": "6",
                                            "inventario_id": "'.$idinvapi.'",
                                            "cantidad": "'.$cantidad.'", 
                                            "precio": "'.$precio.'",
                                            "costo": "'.$costoapi.'",
                                            "descuento":"'.$descuento.'",
                                            "pvp":"'.$PVP.'",
                                            "dcto_iva":"'.$Dcto_iva.'",
                                            "iva":"'.$iva.'",
                                            "total":"'.$total.'",
                                            "direccion":"'.$direccion_entrega.'"
                                           },';
                                                                
                                    } else 
                                    {
                                        $Global->salir_json(2,"ERROR EN LA BASE DE DATOS CONSULTA " . $sql_insert);
                                    }
                                } else { } //fin si no hay stock



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
                            $sql_insert = "DELETE FROM oc_detalletemp WHERE usuario='".$data['txt_user']."'";
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



//PARA API CONECTAR Y ENVIAR LOS DATOS
$curl = curl_init();

//quitamos un caracter a la cadena
$arreglodato=substr($arreglodato,0,-1);
curl_setopt_array($curl, [
  CURLOPT_PORT => "4080",
  CURLOPT_URL => "http://myocitel.com:4080/fragata-api/index.php/auth/login",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => '{
  "username": "admin",
  "password":"Admin123$"
}',
  CURLOPT_HTTPHEADER => [
    "Auth-Key: fragata-api",
    "Client-Service: frontend-client",
    "Content-Type: application/json"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  //echo "cURL Error #:" . $err;
} else {
  //echo ($response);
}

$nuevo = json_decode($response);

//echo $nuevo->token; 
//FIN CONSULTA TOKEN

//AHORA POST

$codigo=$data['txt_codigo'];
$pago=$data['txt_pago'];
$fecha=$fecha;
$cliente=$data['txt_cliente'];
$total=$data['txt_total'];

$curl = curl_init();
curl_setopt_array($curl, [
  CURLOPT_PORT => "4080",
  CURLOPT_URL => "http://myocitel.com:4080/fragata-api/index.php/venta/store",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => '{
    "idoc": "'.$max_id.'",
    "occodigo": "'.$codigo.'",
    "idcliente": "'.$cliente.'",
  "idusuario": "1",
  "idvendedor": "9",
  "idsucursal": "1",
  "fecha": "'.$fecha.'",
  "formapago": "'.$pago.'",
  "formapago_id": "4",
  "formapago_sri_id": "20",
  "total": "'.$total.'",
  "observaciones": "'.$observaciones.'",
  "items":[
    '.$arreglodato.'
  ]
  
}',
  CURLOPT_HTTPHEADER => [
    "Auth-Key: fragata-api",
    "Authorization: $nuevo->token",
    "Client-Service: frontend-client",
    "User: admin"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
 // echo "cURL Error #:" . $err;
} else {
 
$nuevo = json_decode($response);
}

/*
echo '{
    "idoc": "'.$max_id.'",
    "occodigo": "'.$codigo.'",
    "idcliente": "'.$cliente.'",
    "idusuario": "1",
    "idvendedor": "9",
    "idsucursal": "1",
    "fecha": "'.$fecha.'",
    "formapago": "'.$pago.'",
    "formapago_id": "4",
    "formapago_sri_id": "20",
    "total": "'.$total.'",
    "observaciones": "'.$observaciones.'",
    "items":[
      '.$arreglodato.'
    ]
    
  }';
*/
//SI SE CREO LA PREVENTA, ACTUALIZAMOS EN BD

/*
if ($nuevo->status!=200){
    $mostrarfin='00';                  

} else {
$sql_insert = "UPDATE ordencompra SET preventa=    '" . $nuevo->preventa . "' where oc_id=$max_id  ";
$resultado  = $mysqli->query($sql_insert);
if ($resultado) 
{
    $mostrarfin=$nuevo->preventa;                   
} 
}

*/
                            $data['dp_modulo']          = 'ORDEN COMPRA->CREAR OC';
                            $data['dp_accion']          =  "REGISTRAR";
                            $data['dp_descripcion']     = 'CREAR OC : '.$max_id;
                            $data['dp_sql']             = '';
                            $data['dp_user']            = $data['txt_user'];
                            $data['dp_fecha_registro']  = date('Y-m-d');
                            $data['dp_hora_registro']   = date("g:i:s-a");
                            $Global->bitacora_user($data);
                            $mysqli->commit();
                            //$Global->salir_json(1,$mostrarfin);
                            $Global->salir_json(1,'2020');

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
    $sql = "SELECT SUM(pr_cantidad) as total FROM oc_detalletemp WHERE usuario='$txt_user'";
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
    $sql = "SELECT * FROM  oc_detalletemp WHERE item ='$txt_id' AND usuario='$txt_user'";




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

    $sql       = "SELECT SUM(total) AS total FROM oc_detalletemp WHERE usuario='".$id_usuario."'";
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
if ( $data['canal']=='OPEN MARKET'){
    $tblconsulta ="precios";
} else if ( $data['canal']=='RETAIL'){
    $tblconsulta ="precios_retail";
}  else if ( $data['canal']=='CORPORATIVO'){
    $tblconsulta ="precios_corporativo";
} 

   // $sqlselect2 = " and (minimo>='".$data['valor']."'  or minimo is null  ) ";

// and tipo_credito='".$data['txt_pago']."'
    $sql         = "SELECT * FROM    $tblconsulta  WHERE producto like '".$data['txt_producto']." - %' 
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



 /*=============================================
ELIMINAR IMEI
=============================================*/
public function consultar_vendedorsi($data)
{
    $Global  = new ModelGlobal();
    $dataxr       = array();
    $mysqli       = conexionMySQL();
    $mysqli->autocommit(FALSE);
    
    $sql = "select * FROM gb_usuarios WHERE cod_vendedor ='".$data['txt_id']."' and gb_id='".$data['iduser']."' ";

if($data['perfil']!=4){ //no es vendedor, no pasa nada
    $Global->salir_json(1,"");

} else {
    $resultado   = $mysqli->query($sql);
    $n           = $resultado->num_rows;
    if($n>0)
    {
        while ($file =  $resultado->fetch_assoc()) {
            $Global->salir_json(2,"");
        }
    } else {
        $Global->salir_json(3,"");
    }
}

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




}


