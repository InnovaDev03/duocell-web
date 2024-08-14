<?php
// Ruta del archivo en el servidor local
$archivoLocal = '/mnt/samba_share/FE_STARTCOM/DUOCELL/Autorizados/FACTURA_001-002-000053238.PDF';

// Nombre del archivo que se enviará al usuario
$nombreArchivo = 'archivo.pdf';

// Establecer los encabezados para forzar la descarga
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');

// Leer y enviar el archivo al navegador
readfile($archivoLocal);
exit;
?>