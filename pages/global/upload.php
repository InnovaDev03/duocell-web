<?php

$cantidad=1;//$_REQUEST['cantidad'];

date_default_timezone_set('America/Guayaquil');
$fechaadd = date('Y-m-d-h-i-s');
$valortotal='';
//for ($i=0; $i < $cantidad; $i++) { 
    $i='';
    if (($_FILES["file".$i]["type"] == "image/pjpeg")
    || ($_FILES["file".$i]["type"] == "image/jpeg")
    || ($_FILES["file".$i]["type"] == "image/png")
    || ($_FILES["file".$i]["type"] == "image/gif")) {
    if (move_uploaded_file($_FILES["file".$i]["tmp_name"], "images/".$fechaadd.$_FILES['file'.$i]['name'])) {
        //more code here...
        $valortotal = $valortotal . "images/".$fechaadd.$_FILES['file'.$i]['name'];
    } else {
        echo 0;
    }
} else {
    $valortotal = 0;
}
//}

echo $valortotal;


?>