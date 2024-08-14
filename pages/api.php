<?php

$curl = curl_init();

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
  echo "cURL Error #:" . $err;
} else {
  //echo ($response);
}
echo '<br>';
//print_r(json_decode($response));
echo '<br>';

$nuevo = json_decode($response);

echo $nuevo->token; 

//echo nuevo['token'];//.token;
//print($response);
  //echo ($response);




//FIN CONSULTA TOKEN

//AHORA POST

$curl = curl_init();

$var = "\$5\$rounds=5000\$fragatausesystri\$5rpaV1csInF0vV.f\/988R6eVyFSfApvUOKoTf.ykwp0";

//$var = "\$5\$rounds=5000\$fragatausesystri\$5rpaV1csInF0vV.f\/988R6eVyFSfApvUOKoTf.ykwp0";

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
  "idoc": "9",
  "occodigo": "P100",
  "idcliente": "2890",
  "idusuario": "1",
  "idvendedor": "9",
  "idsucursal": "3",
  "fecha": "2023-07-21",
  "formapago": "contado",
  "formapago_id": "4",
  "formapago_sri_id": "20",
  "total": "120.1",
  "observaciones": "prueba",
  "items":[
    {
     "codigo":"0000000002264",
     "descripcion":"TABLET XMOBILE X7 1+16GB GOLD",
     "codigo_item": "1576",
     "bodega_id": "59",
     "inventario_id": "62184",
     "cantidad": "1", 
     "precio": "100",
     "costo": "50",
     "descuento":"0",
     "pvp":"100",
     "dcto_iva":"0",
     "iva":"12",
     "total":"112",
     "direccion":"duran"
    }
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
  echo "cURL Error #:" . $err;
} else {
 echo $response;
}
