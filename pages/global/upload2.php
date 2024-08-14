<?php

$cantidad = 1;//;$_REQUEST['cantidad'];

date_default_timezone_set('America/Guayaquil');
$fechaadd = date('Y-m-d-h-i-s');
$valortotal='';
for ($i=0; $i < $cantidad; $i++) { 

    /*
    || ($_FILES["file".$i]["type"] == "image/jpeg")
    || ($_FILES["file".$i]["type"] == "image/png")
    || ($_FILES["file".$i]["type"] == "image/gif")
    */
    if (($_FILES["file".$i]["type"] != "")) {
    if (move_uploaded_file($_FILES["file".$i]["tmp_name"], "documentos/".$fechaadd.$_FILES['file'.$i]['name'])) {
        //more code here...
        $valortotal = "documentos/".$fechaadd.$_FILES['file'.$i]['name'];
    } else {
        echo 0;
    }
} else {
    $valortotal = 0;
}
}

echo $valortotal;


?>