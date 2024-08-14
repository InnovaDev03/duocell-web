<?php
include('../../Conexion/conexion_mysqli.php');
include('../../Model/Model_gb_global.php');
include('../../control_session.php');
include('../menu.php');
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Duocell</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="../../plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="../../plugins/dropzone/min/dropzone.min.css">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../dist/css/uikit.css">

  <link rel="stylesheet" href="../../dist/css/bebasneue.css">
  <link rel="stylesheet" href="../../css_session/Css.css">
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
  <div id="mensaje2"></div>
  <div class="wrapper">

    <!--  SALIR DEL SISTEMA -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i> <?php echo  $_SESSION["gb_nombre"]; ?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu dropdown-user">

            <li><a href="../../session_destroy.php"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- FIN SALIR DEL SISTEMA -->

    <!-- INICIO MENU -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="index3.html" class="brand-link">
        <img src="../../img/logoobsa.png" style="width: 40%; height: 1%;margin-top: -4px" alt="Sistema de Control Grupo OBSA">

      </a>
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo  $_SESSION["gb_nombre"]; ?></a>
          </div>
        </div>
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <?php
            sistema_menu(8, 17, 1);
            ?>



            </li>
          </ul>
        </nav>
      </div>
    </aside>
    <!-- FIN MENU -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <div id="mensaje2"></div>

      <!-- INFORMACION UBICACION SISTEMA-->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Listado de Precios</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">

                <button type="button" class="pull-right btn btn-default" id="sendEmail">Precios
                  <i class="fa fa-arrow-circle-right"></i>
                </button>
                <button type="button" class="pull-right btn btn-default" id="sendEmail">Retail
                  <i class="fa fa-arrow-circle-right"></i>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- FIN INFORMACION UBICACION SISTEMA-->


      <!-- CONTENIDO PAGUINA PRINCIPAL -->

      <div class="content">


        <div class="container-fluid">


          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fa fa-cogs"></i>
                Interfaz del listado de precios.
              </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>

              </div>
            </div>
            <div class="card-body">
             
              <div class="row">

              <div class="col-sm-12 col-md-12 col-lg-2">
                  <div class="form-group">
                      <button type="button" id="btn_importar" onclick="document.getElementById('frmExcelImport').style.display='inherit';" class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-file"></i> Importar</button>                    

<form  style="display: none" action="" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Elija Archivo Excel</label> <input type="file" name="file" required=""
                    id="file" accept=".xlsx">
                <br><BR><button type="submit" id="submit" onclick="cargando()" class="mb-xs mt-xs mr-xs btn btn-success"  name="import"
                       >Importar Registros (.xlsx)</button>
                       <button type="button" style="display:none" id="importando"  class="mb-xs mt-xs mr-xs btn btn-info" 
                       >Cargando...</button>
            <hr>

            </div>
</form>
                  </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-2">
                  <div class="form-group">
                      <a target="_blank" href="excel_retail.php" class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-download"></i> Descargar datos</a>                    
                  </div>
                </div>

                


                <?php
              
              if (isset($_REQUEST["cant"]))
              {?>   
<div class="col-sm-12 col-md-12 col-lg-2">
                  <div class="form-group">
                      <p># de Datos Cargados: <?php echo $_REQUEST['cant']; ?></p>
                  </div>
                </div>
              <?php
              }

include('../dbconnect.php');
require_once('../vendor/php-excel-reader/excel_reader2.php');
require_once('../vendor/SpreadsheetReader.php');

include 'db3.php';

$mysqli    = conexionMySQL();

if (isset($_POST["import"]))
{

  $contador=0;
  echo '<script>cargando()</script>';
$iduserfk = $_SESSION["gb_id_user"];
$fechahoraactual=date('Y-m-d H:i:s');
$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

if(in_array($_FILES["file"]["type"],$allowedFileType)){

      $targetPath = 'masivos/'.$_FILES['file']['name'];
      move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
      

//enviamos todo lo que tnga estatus 1 al historial
$query = "INSERT `precios_historial_retail` 
select null, `id_precio`, `producto`, `subcanal`, `minimo`, `precio`, `id_usuario`, 
`fecha_registro`, `estatus`, tipo_credito,  '" . $iduserfk . "',  '" . $fechahoraactual.  "'  from precios
where estatus=1 ";
$resultados = mysqli_query($con, $query);                
if (! empty($resultados)) {
} else {
}

//ACTUALIZAMOS PRECIO TODO A ESTADO=0
$query = "update `precios_retail` set estatus=0,
`id_user_edit`='".$iduserfk."', `fecha_hora_edit`='".$fechahoraactual."' where estatus=1";

     $resultados = mysqli_query($con, $query);                
     if (! empty($resultados)) {
     } else {
     }


      $Reader = new SpreadsheetReader($targetPath);
      $sheetCount = count($Reader->sheets());
      for($i=0;$i<$sheetCount;$i++)
      {
          $Reader->ChangeSheet($i);
          
          foreach ($Reader as $Row)
          {
            $producto = "";
            if(isset($Row[0])) {
               $producto = mysqli_real_escape_string($con,$Row[0]);
            }
             $subcanal = "";      
              if(isset($Row[1])) {
                  $subcanal = mysqli_real_escape_string($con,$Row[1]);
              }
              $minimo = "";
              if(isset($Row[2])) {
                 $minimo = mysqli_real_escape_string($con,$Row[3]);
              }
              $precio = "";
              if(isset($Row[3])) {
                 $precio = mysqli_real_escape_string($con,$Row[4]);
              }

              $credito = "";
              if(isset($Row[4])) {
                 $credito = mysqli_real_escape_string($con,$Row[4]);
              }
              $redir = '';


              if ($producto=='Producto' or $subcanal=='Subcanal' or $precio=='' ){
              } else {
            $contador=$contador+1;    
                $concatsql='';
                $concatval='';
                if ($credito!=''){
                  $datoconcat=$credito;
                  $concatsql= $concatsql. ' tipo_credito, ';
                  $concatval= $concatval ."'$datoconcat' ,";
                  }

                  if ($minimo!=''){
                    $datoconcat=$minimo;
                    $concatsql= $concatsql. ' minimo, ';
                    $concatval= $concatval ."'$datoconcat' ,";
                    }
                    if ($precio!=''){
                      $datoconcat=$precio;
                      $concatsql= $concatsql. ' precio, ';
                      $concatval= $concatval ."'$datoconcat' ,";
                      }

//INSERTAMOS LO QUE TENGA EL EXCEL
$query = "INSERT INTO `precios_retail`(`producto`, `subcanal`,  $concatsql
`fecha_registro`, `id_usuario`, `estatus`)
 VALUES ('".$producto."','".$subcanal."', $concatval
    '".$fechahoraactual."','".$iduserfk."',1)";

                  $resultados = mysqli_query($con, $query);                
                  if (! empty($resultados)) {
//                        $type = "success";
//                        $message = "Excel importado correctamente";
                  } else {
                      $type = "error";
                      $message = "Hubo un problema al importar registros";
                  }




    } //fin proceso


                }
        
              }
            }
       
echo "<script>location.href='?opc=retail&cant=".$contador."'</script>";      
        }
        
        
else
{  
      $type = "error";
      $message = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
      //echo "<script>location.href='?opc=requerimientos'</script>";      
}
?>










                <div class="col-lg-12">

                <input type="text" class="form-control pull-left"  id="search" placeholder="Escriba lo que desee buscar de la tabla">
											<br>
                      
                      <div class="card card-outline">
                  
                    <div class="card-body">
                      <div class="col-lg-12">
                        

                      
<table id="table_venta" class="table table-striped table-bordered text-rigth tabla_detalle_fp">
                              <thead>
                                <tr>
                                <td style="width:60px"></td>
                                  <td style="width:10px">#</td>
                                  <td colspan="3" style="width:10px">Producto</td>
                                  <td  style="width:10px">
</td>
<td>
                                </td>                                  
                                </tr>
                              </thead>
                              <tbody>
                      
                      <?php 
                      

                      include '../../Model/bdsql.php';
                      $dbconn      = conexionSQLSI();
                  
  //CONSULTA DE LOS SUBCANALES WHERE CANALID=2

  $sql         = "  SELECT Descripcion from CCSubCanal where CodCanal='001'  and estado='A' order by Descripcion desc";
  $resultado   = sqlsrv_query($dbconn, $sql);// $mysqli->query($sql);
  $query = sqlsrv_query($dbconn, $sql, array(), array( "Scrollable" => 'static' ));

  $rows = sqlsrv_num_rows($query);
  $concat='';
if($rows > 0){
  for ($i=1; $i <=$rows ; $i++) { 
    //RECORREMOS POR CADA SUBTIPO Y QUE APAREZCA POR DEFECTO
    while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
      $concat=$concat.'<option>'.$row['Descripcion'].'</option>';
    }

  }
  
}


//CONEXION A LA BD DUOCELL POSTGRES PARA OBTENER DATA
//include '../../Model/bdpostgres.php';

/*
$dbconn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass")
or die('Could not connect: ' . pg_last_error());

if (!$dbconn)
  {
  $result["result"] = 0;
  $result["error"] = 'Ocurrio un error en la conexion!!';
  echo json_encode($result);
  exit;
  }
  pg_set_client_encoding($dbconn, "UNICODE");    
  //CONSULTA DE LOS SUBCANALES WHERE CANALID=2
  $result = pg_query($dbconn," SELECT sc_descripcion from public.subcanal where ca_id=1 order by sc_descripcion desc");
  $rows = pg_num_rows($result);
  $concat='';
if($rows > 0){
  for ($i=1; $i <=$rows ; $i++) { 
    //RECORREMOS POR CADA SUBTIPO Y QUE APAREZCA POR DEFECTO
    while ($row = pg_fetch_row($result)) {
      $concat=$concat.'<option>'.$row[0].'</option>';
    }

  }
  
}
*/

/*
$result = pg_query($dbconn," SELECT descripcion, inv_inventario.codigo_item , sum(existencia) as existencia, sum(comprometido) as comprometido FROM public.inv_inventario 
inner join public.inv_item on
public.inv_item.codigo_item = public.inv_inventario.codigo_item
where bodega_id=6 and inv_item.estado=1
group by descripcion, inv_inventario.codigo_item
order by sum(existencia) desc ");
//and public.inv_inventario.codigo_item=1420
// and ( public.inv_inventario.codigo_item=1420  or public.inv_inventario.codigo_item=20)
$contador=0;
$rows = pg_num_rows($result);
if($rows <= 0){

    $fila["text"]		= "...!0 RESULTADOS!...";
    $fila["id"]			= "0";
    $data[] = $fila;
}
else
{
  while ($row = pg_fetch_row($result)) {
    $contador = $contador + 1;
    $nombreproducto=$row[1]. ' - '.$row[0];
  */
  $contador=0;


  $mysqli      = conexionMySQL();
$data        = array();
$sqlx         = "select producto, codigo, nombre   from productos_habilitados 
WHERE  estatus =1 ";
$resultadox   = $mysqli->query($sqlx);
$contadorproducto=0;
while ($row = $resultadox->fetch_assoc()) {



  $rows=1;
  if($rows <= 0){
  
      $fila["text"]		= "...!0 RESULTADOS!...";
      $fila["id"]			= "0";
      $data[] = $fila;
  }
  else
  {
    while ($row = $resultadox->fetch_assoc()) {
      $contador = $contador + 1;
     // $nombreproducto=$row['codigo']. ' - '.$row['producto'];
      $nombreproducto=$row['nombre'];
     // echo $nombreproducto.'<br>';
       

                      ?>
<form id="formulario<?php echo $contador ?>" name="formulario<?php echo $contador ?>">
                                <tr>
                                  <td>
                                  <button type="button" id="btnver<?php echo $contador ?>" onclick="ver(<?php echo $contador ?>)" class="btn btn-xs btn-success btn_select_cadena"><acronym title="Ver precios!" lang="es"><i class="fa fa-eye"></i></acronym></button> 
                                  <button type="button" style="display: none;" id="btnnover<?php echo $contador ?>"  onclick="nover(<?php echo $contador ?>)" class="btn btn-xs btn-success"><acronym title="Ocultar precios!" lang="es"><i class="fa fa-eye-slash"></i></acronym></button> 
                                  </td>
                                <td><?php echo $contador?></td>
                                  <td  colspan="2" ><?php echo $nombreproducto?></td>
                                <!--  <td  style="width:10px">
                                <button type="button" contadores="<?php echo $contador ?>"  nombreproducto="<?php echo $nombreproducto ?>"  class="btn btn-xs btn-secondary btn_guardar_precio"><acronym title="Guardar precios!" lang="es"><i class="far fa-save"></i></acronym></button>
                                </td>-->
                                <td  style="width:10px">
                                  <button type="button"  contadores="<?php echo $contador ?>"  nombreproducto="<?php echo $nombreproducto ?>"  class="btn btn-xs btn-warning btn_edit_precio"><acronym title="Editar precios!" lang="es"><i class="far fa-edit"></i></acronym></button>
                                </td>
                                <td>
                                  <button type="button" class="btn btn-xs btn-danger btn_delete_cadena"><acronym title="Eliminar precios!" lang="es"><i class="fa fa-trash" aria-hidden="true"></i></acronym></button>
                                </td>   
                               </tr>

                                <tr id="<?php echo $contador?>" style="display:none">

  <td colspan="6">
  <div class="col-lg-12 col-ms-12 col-xs-12">

												<div class="row">

                        <div class="col-sm-1 col-md-1 col-lg-1">
														<div class="form-group">
                            <button type="button" onclick='aggitem(<?php echo $contador?>)' class="btn btn-info btn-block btn-flat" id="btn_agregra_item_2">+</button>
														</div>
													</div>


													<div class="col-sm-12 col-md-12 col-lg-4">
														<div class="form-group">
                            <select id="subcanal1<?php echo $contador?>" name="subcanal<?php echo $contador?>[]" class="form-control">
  <?php echo $concat ?>
  </select>														</div>
													</div>


                          <div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">															
                            <input type="text"  placeholder="Cantidad"  class= "form-control"  class="form-control"  id="cantidad<?php echo $contador?>" name="cantidad<?php echo $contador?>[]" maxlength="100" >	
														</div>
													</div>

													<div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">
                            <input type="text"  placeholder="Precio $"  class= "form-control"  class="form-control"  id="precio<?php echo $contador?>" name="precio<?php echo $contador?>[]" maxlength="100" >	
														</div>
													</div>

                          <div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">
                            <input type="text"  placeholder="Tipo de Crédito"  class= "form-control"  class="form-control"  id="tipocredito<?php echo $contador?>" name="tipocredito<?php echo $contador?>[]" >	
														</div>
													</div>

                    

												</div>
											</div>



                      <div class="col-lg-12 col-ms-12 col-xs-12">

<div class="row">

<div class="col-sm-1 col-md-1 col-lg-1">
    <div class="form-group">
    </div>
  </div>


  <div class="col-sm-12 col-md-12 col-lg-4">
    <div class="form-group">
    <select id="subcanal2<?php echo $contador?>" name="subcanal<?php echo $contador?>[]" class="form-control">
<?php echo $concat ?>
</select>											
			</div>
  </div>


  <div class="col-sm-12 col-md-12 col-lg-2">
    <div class="form-group">															
    <input type="text"  placeholder="Cantidad"  class= "form-control"  class="form-control"  id="cantidad<?php echo $contador?>" name="cantidad<?php echo $contador?>[]" maxlength="100" >	
    </div>
  </div>

  <div class="col-sm-12 col-md-12 col-lg-2">
    <div class="form-group">
    <input type="text"  placeholder="Precio $"  class= "form-control"  class="form-control"  id="precio<?php echo $contador?>" name="precio<?php echo $contador?>[]" maxlength="100" >	
    </div>
  </div>

  <div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">
                            <input type="text"  placeholder="Tipo de Crédito"  class= "form-control"  class="form-control"  id="tipocredito<?php echo $contador?>" name="tipocredito<?php echo $contador?>[]" >	
														</div>
													</div>

</div>
</div>



<div class="col-lg-12 col-ms-12 col-xs-12">

												<div class="row">

                        <div class="col-sm-1 col-md-1 col-lg-1">
														<div class="form-group">
														</div>
													</div>


													<div class="col-sm-12 col-md-12 col-lg-4">
														<div class="form-group">
                            <select id="subcanal3<?php echo $contador?>" name="subcanal<?php echo $contador?>[]" class="form-control">
  <?php echo $concat ?>
  </select>														</div>
													</div>


                          <div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">															
                            <input type="text"  placeholder="Cantidad"  class= "form-control"  class="form-control"  id="cantidad<?php echo $contador?>" name="cantidad<?php echo $contador?>[]" maxlength="100" >	
														</div>
													</div>

													<div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">
                            <input type="text"  placeholder="Precio $"  class= "form-control"  class="form-control"  id="precio<?php echo $contador?>" name="precio<?php echo $contador?>[]" maxlength="100" >	
														</div>
													</div>


                          <div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">
                            <input type="text"  placeholder="Tipo de Crédito"  class= "form-control"  class="form-control"  id="tipocredito<?php echo $contador?>" name="tipocredito<?php echo $contador?>[]" >	
														</div>
													</div>
                    

												</div>
											</div>



                      <div class="col-lg-12 col-ms-12 col-xs-12">

												<div class="row">

                        <div class="col-sm-1 col-md-1 col-lg-1">
														<div class="form-group">
														</div>
													</div>


													<div class="col-sm-12 col-md-12 col-lg-4">
														<div class="form-group">
                            <select id="subcanal4<?php echo $contador?>" name="subcanal<?php echo $contador?>[]" class="form-control">
  <?php echo $concat ?>
  </select>														</div>
													</div>


                          <div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">															
                            <input type="text"  placeholder="Cantidad"  class= "form-control"  class="form-control"  id="cantidad<?php echo $contador?>" name="cantidad<?php echo $contador?>[]" maxlength="100" >	
														</div>
													</div>

													<div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">
                            <input type="text"  placeholder="Precio $"  class= "form-control"  class="form-control"  id="precio<?php echo $contador?>" name="precio<?php echo $contador?>[]" maxlength="100" >	
														</div>
													</div>

                    <div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">
                            <input type="text"  placeholder="Tipo de Crédito"  class= "form-control"  class="form-control"  id="tipocredito<?php echo $contador?>" name="tipocredito<?php echo $contador?>[]" >	
														</div>
													</div>

												</div>
											</div>


<!--
                          <div class="col-lg-12 col-ms-12 col-xs-12">

												<div class="row">

                        <div class="col-sm-1 col-md-1 col-lg-1">
														<div class="form-group">
														</div>
													</div>


													<div class="col-sm-12 col-md-12 col-lg-4">
														<div class="form-group">
                            <select id="subcanal5<?php echo $contador?>" name="subcanal<?php echo $contador?>[]" class="form-control">
  <?php echo $concat ?>
  </select>														</div>
													</div>


                          <div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">															
                            <input type="text"  placeholder="Cantidad"  class= "form-control"  class="form-control"  id="cantidad<?php echo $contador?>" name="cantidad<?php echo $contador?>[]" maxlength="100" >	
														</div>
													</div>

													<div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">
                            <input type="text"  placeholder="Precio $"  class= "form-control"  class="form-control"  id="precio<?php echo $contador?>" name="precio<?php echo $contador?>[]" maxlength="100" >	
														</div>
													</div>

                          
                          <div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">
                            <input type="text"  placeholder="Tipo de Crédito"  class= "form-control"  class="form-control"  id="tipocredito<?php echo $contador?>" name="tipocredito<?php echo $contador?>[]" >	
														</div>
													</div>

                          
												</div>
											</div>
  -->


 <!-- aqui va el otro-->
 <?php
                  
                  
  //  $mysqli      = conexionMySQL();
    $data        = array();
    $sql         = "SELECT * FROM precios_retail WHERE producto = '".$nombreproducto. "' and estatus=1 ";
    $resultado   = $mysqli->query($sql);
    $contadorproducto=0;
    while ($fila = $resultado->fetch_assoc()) {
      $contadorproducto=$contadorproducto+1;
     // $data[]   = $fila;
      ?>

<div class="col-lg-12 col-ms-12 col-xs-12">

<div class="row">

<div class="col-sm-1 col-md-1 col-lg-1">
    <div class="form-group">
    </div>
  </div>

  <input type="hidden" name="id_precio<?php echo $contador?>[]" value="<?php echo $fila['id_precio']?>">
  <div class="col-sm-12 col-md-12 col-lg-4">
    <div class="form-group">
    <select data="<?php echo $fila['subcanal']?>" id="subcanallisto<?php echo $contador.'-'.$contadorproducto?>" name="subcanallisto<?php echo $contador?>[]" class="form-control">
<?php echo $concat ?>
</select>														</div>
  </div>


  <div class="col-sm-12 col-md-12 col-lg-2">
    <div class="form-group">															
    <input type="text"  placeholder="Cantidad"  class= "form-control"  class="form-control"  name="cantidadlisto<?php echo $contador?>[]" maxlength="100" value="<?php echo $fila['minimo']?>" >	
    </div>
  </div>

  <div class="col-sm-12 col-md-12 col-lg-2">
    <div class="form-group">
    <input type="text"  placeholder="Precio $"  class= "form-control"  class="form-control"  name="preciolisto<?php echo $contador?>[]" maxlength="100"  value="<?php echo $fila['precio']?>"  >	
    </div>
  </div>

  <div class="col-sm-12 col-md-12 col-lg-2">
    <div class="form-group">
    <input type="text"  placeholder="Tipo de Crédito"  class= "form-control"  class="form-control"  name="tipocrelisto<?php echo $contador?>[]"  value="<?php echo $fila['tipo_credito']?>"  >	
    </div>
  </div>

</div>
</div>

<?php
    }
  
  //  $mysqli->close();
?>
  <input type="hidden" id="cantidadregistros<?php echo $contador?>"  name="cantidadregistros<?php echo $contador?>"  value="<?php echo $contadorproducto?>">
 <!--FIN   aqui va el otro-->
                      <!-- aqui va el otro-->
                      <div id="enlacesnuevos<?php echo $contador?>">
</div>

                                </tr>
 
</form> 
                        <?php 
        //FIN DEL FORM Y FIN DE LA PRIMERA PARTE
                      }
                      }
                    }
                    ?>



</tbody>
                            </table>

                      </div>
                    </div>
                  </div>
                </div>



              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              Listado de Precios
            </div>
            <!-- /.card-footer-->
          </div>


        </div>
      </div>
    </div>
    <!-- FIN  CONTENIDO PAGUINA PRINCIPAL -->


<div style="display:none">
    <div class="col-lg-12 col-ms-12 col-xs-12" id="clonar">

<div class="row">

<div class="col-sm-1 col-md-1 col-lg-1">
    <div class="form-group">
    </div>
  </div>


  <div class="col-sm-12 col-md-12 col-lg-4">
    <div class="form-group">
    <select id="subcanalx<?php echo $contador?>" name="subcanal<?php echo $contador?>[]" class="form-control">
    <option value="0">Seleccione un canal...</option>
<?php echo $concat ?>
</select>														</div>
  </div>


  <div class="col-sm-12 col-md-12 col-lg-2">
    <div class="form-group">															
    <input type="text"  placeholder="Cantidad"  class= "form-control"  class="form-control"  id="cantidad<?php echo $contador?>[]" name="cantidad<?php echo $contador?>" maxlength="100" >	
    </div>
  </div>

  <div class="col-sm-12 col-md-12 col-lg-2">
    <div class="form-group">
    <input type="text"  placeholder="Precio $"  class= "form-control"  class="form-control"  id="precio<?php echo $contador?>[]" name="precio<?php echo $contador?>" maxlength="100" >	
    </div>
  </div>
</div>
</div>

                    </div>


     <aside class="control-sidebar control-sidebar-dark">
      <div class="p-3">
        <h5>Duocell</h5>
        <p>Duocell</p>
      </div>
    </aside>

    <footer class="main-footer">
      <div class="float-right d-none d-sm-inline">
        Duocell
      </div>
      <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#">PRODATAIN S.A.</a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->
	  
  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="../../plugins/toastr/toastr.min.js"></script>

  <!-- DataTables  & Plugins -->
  <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../../plugins/jszip/jszip.min.js"></script>
  <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Select2 -->
  <script src="../../plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- InputMask -->
  <script src="../../plugins/moment/moment.min.js"></script>
  <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- date-range-picker -->
  <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap color picker -->
  <script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Bootstrap Switch -->
  <script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  <!-- BS-Stepper -->
  <script src="../../plugins/bs-stepper/js/bs-stepper.min.js"></script>
  <!-- dropzonejs -->
  <script src="../../plugins/dropzone/min/dropzone.min.js"></script>


  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>

  <!-- AdminLTE PREDICTIVO -->
  <script src="../../plugins/jquery-ui/jquery-ui.js" type="text/javascript"></script>

  <script src="../funciones.js"></script>
  <script src="./js/retail.js"></script>

  <script>
function ver(valor){
  //document.getElementById(valor).style.display = 'none';
  //document.getElementById(valor).style.display = 'inline-bock';
  $('#'+valor).css('display', '');
 for (let index = 1; index < 5; index++) {
  const select = document.querySelector('#subcanal'+index+valor);
 //A LA OPCION CON INDICE 2 LE PONEMOS EL ATRIBUTO SELECTED
select.options[index-1].setAttribute('selected',true);
 }

  //document.getElementById('subcanal'+valor);

  //ejecutar funcion de la busqueda del select
  seleccionarjs(valor);
  $('#btnnover'+valor).css('display', '');
  $('#btnver'+valor).css('display', 'none');

  
}


function nover(valor){
  //document.getElementById(valor).style.display = 'none';
  //document.getElementById(valor).style.display = 'inline-bock';
  $('#'+valor).css('display', 'none');
  
  $('#btnnover'+valor).css('display', 'none');
  $('#btnver'+valor).css('display', '');
}


function seleccionarjs(valor){
  var total = document.getElementById('cantidadregistros'+valor).value;
  for (let index = 1; index <=total; index++) {
   var datofin= $("#subcanallisto"+valor+"-"+index).attr('data');
   //alert(datofin);
    document.getElementById("subcanallisto"+valor+"-"+index).value=datofin;
  }

}


var orden=1;

function aggitem(valor){


  var id=document.getElementById("clonar");
  var nuevos=id.cloneNode(true);
  nuevos.style.id='enlaces'+orden;
  orden++;
  id=document.getElementById("enlacesnuevos"+valor);
  id.appendChild(nuevos);
 
}



$(document).ready(function(){
 $("#search").keyup(function(){
 _this = this;
 // Show only matching TR, hide rest of them
 $.each($("#table_venta tbody tr"), function() {
 if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
 $(this).hide();
 else
 $(this).show();
 });
 });
});

function cargando(){
  document.getElementById('importando').style.display='inherit';
  document.getElementById('submit').style.display='none';
}
    </script>
</body>

</html>