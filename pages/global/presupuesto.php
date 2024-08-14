<?php
include('../../Conexion/conexion_mysqli.php');
include('../../Model/Model_gb_global.php');
include('../../control_session.php');
include('../menu.php');
$mysqli2      = conexionMySQL();

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
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
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
            sistema_menu(4, 26, 4);
            ?>



            </li>
          </ul>
        </nav>
      </div>
    </aside>
    <!-- FIN MENU -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- INFORMACION UBICACION SISTEMA-->
      <div class="content-header" style="display: none">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Registro de Presupuesto</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">

                <button type="button" class="pull-right btn btn-default" id="sendEmail">Control de Hacienda
                  <i class="fa fa-arrow-circle-right"></i>
                </button>
                <button type="button" class="pull-right btn btn-default" id="sendEmail">Labor
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
                <i class="fas fa-address-card"></i>
                Interfaz para la gestión del presupuesto
              </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="card-body">
              <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                <li class="nav-item" style="display: none;">
                  <a class="nav-link" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="false"> Listado Presupuesto</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="true">Registro Presupuesto</a>
                </li>

              </ul>

              <div class="tab-content" id="custom-content-below-tabContent">

                <div class="tab-pane fade " id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                  <br>
                  <div class="col-md-12 col-sm-12 col-lg-12">
                    <div class="card card-primary card-outline">
                      <div class="card-header">
                        <h5 class="m-0">Consulta</h5>
                      </div>
                      
                      <div class="card-body">

                      <div class="col-lg-12">
                      <div class="col-sm-12 col-md-12 col-lg-12">
<form action="?">
<input type="hidden" class="form-control" required name="opc" value="presupuesto">

          <select class="form-control" id="txt_ano_2" required name="txt_ano_2">
            <?php
            $fecha_actual = date("d-m-Y");
            $anomas1= date("Y",strtotime($fecha_actual."+ 1 year"));
            $anomenos1= date("Y",strtotime($fecha_actual."- 1 year"));
             ?>
            <option value="<?php echo$anomenos1 ?>"><?php echo $anomenos1 ?></option>
            <option selected value="<?php echo date('Y') ?>"><?php echo date('Y') ?></option>
            <option value="<?php echo $anomas1 ?>"><?php echo $anomas1 ?></option>
          </select>
          <br>
          <select class="form-control" id="txt_documento" required name="txt_documento">
            <?php
           
//CONSULTAMOS LOS DIFERENTES RUBROS DEL NIVEL 3 ASOCIADOS AL ANTERIOR
$sql01         = "SELECT * FROM  tipo_documento WHERE estado='1'  ";
$resultado01   = $mysqli2->query($sql01);
//   echo $sql2;
while ($fila01 = $resultado01->fetch_assoc()) {
  $descripcion=$fila01['descripcion'];
  $id_td =$fila01['id_td'];
  echo '<option value="'.$id_td .'">'.$descripcion .'</option>';
}
             ?>            
          </select>
          <br>

          <button type="submit" id="btn_filtrar"  class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-search"></i>Búsqueda</button>
</form>

<br>
</div>


</div>
                      
                        <div class="col-sm-12 col-md-12 col-lg-12">

                          <div class="table-responsive demo-x content">

                            <div class="box-body">

                              <table id="table_ppto" class="table table-striped table-bordered text-center ">
                                <thead>
                                  <tr>
                                  <th style="width:5px">#NÚM</th>
                                    <th style="width:10px">Denominación</th>
                                    <th style="width:10px">ENE</th>
                                    <th style="width:10px">FEB</th>
                                    <th style="width:10px">MAR</th>
                                    <th style="width:10px">ABR</th>
                                    <th style="width:10px">MAY</th>
                                    <th style="width:10px">JUN</th>
                                    <th style="width:10px">JUL</th>
                                    <th style="width:10px">AGO</th>
                                    <th style="width:10px">SEP</th>
                                    <th style="width:10px">OCT</th>
                                    <th style="width:10px">NOV</th>
                                    <th style="width:10px">DIC</th>
                                    <th style="width:10px">TOTAL CAJA</th>
                                    <th style="width:10px">TOTAL IYG</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
 $filtroaño = '';
if (isset($_REQUEST['txt_documento'])){
  $filtroaño =  $filtroaño .'and mt_tipo='.$_REQUEST['txt_documento'];
} else {
  $filtroaño = '';
}

                      
                      
                      $sql         = "SELECT * FROM  rubros WHERE mt_estatus='1'  $filtroaño ";
                      $resultado   = $mysqli2->query($sql);
                      $totaliyg=0;
                      $filtroaño = '';
                      if (isset($_REQUEST['txt_ano'])){
                        $filtroaño = 'and anio='.$_REQUEST['txt_ano'];
                      } else {
                        $filtroaño = '';
                      }

                     
                      
                      while ($fila0 = $resultado->fetch_assoc()) {
                           $id0 =$fila0['mt_id'];
                           $d0 =$fila0['mt_nombre'];

                           $sql         = "SELECT sum(enero) as enero, sum(febrero)  as febrero, sum(marzo)  as marzo,
                           sum(abril)  as abril, sum(mayo)  as mayo, sum(junio)  as junio , sum(julio)  as julio,
                            sum(agosto)  as agosto, sum(septiembre)  as septiembre,
                           sum(octubre)  as octubre, sum(noviembre)  as noviembre, sum(diciembre)  as diciembre
                            FROM  presupuesto WHERE rubro=  $id0   $filtroaño ";
                           $resultado1   = $mysqli2->query($sql);
                           while ($fila1 = $resultado1->fetch_assoc()) {
                            $m11 =$fila1['enero'];
                            $m12 =$fila1['febrero'];
                            $m13 =$fila1['marzo'];
                            $m14 =$fila1['abril'];
                            $m15 =$fila1['mayo'];
                            $m16 =$fila1['junio'];
                            $m17 =$fila1['julio'];
                            $m18 =$fila1['agosto'];
                            $m19 =$fila1['septiembre'];
                            $m110 =$fila1['octubre'];
                            $m111 =$fila1['noviembre'];
                            $m112 =$fila1['diciembre'];
                            $totalmx=$m11 +$m12 +$m13 +$m14 +$m15+$m16+$m17 +$m18+$m19 +$m110 +$m111 +$m112 ;

                           }

                     
                          echo '<tr id="rubro'.$id0.'" >
                          <th>'.$id0.'</th>
                          <th>'.$d0.'</th>
                          <th>'.$m11.'</th>
                          <th>'.$m12.'</th>
                          <th>'.$m13.'</th>
                          <th>'.$m14.'</th>
                          <th>'.$m15.'</th>
                          <th>'.$m16.'</th>
                          <th>'.$m17.'</th>
                          <th>'.$m18.'</th>
                          <th>'.$m19.'</th>
                          <th>'.$m110.'</th>
                          <th>'.$m111.'</th>
                          <th>'.$m112.'</th>
                          <th>'.($totalmx).'</th>
                          <th>'.$totaliyg.'</th>
                          </tr>';
                         
//CONSULTAMOS LOS DIFERENTES RUBROS DEL NIVEL 1 ASOCIADOS AL ANTERIOR
                         $sql2         = "SELECT * FROM  rubros_n1 WHERE mt_estatus='1' AND  mt_id_rubro=  $id0  ";
                          $resultado2   = $mysqli2->query($sql2);
                          $totaliyg=0;
                       //   echo $sql2;
                       $contador=0;
                          while ($fila1 = $resultado2->fetch_assoc()) {
                            $contador+=1;
                               $id1 =$fila1['mt_id'];
                               $d1 =$fila1['mt_nombre'];
/*ECHO $id1;
ECHO $d1;*/
                          $sql3         = "SELECT sum(enero) as enero, sum(febrero)  as febrero, sum(marzo)  as marzo,
                          sum(abril)  as abril, sum(mayo)  as mayo, sum(junio)  as junio , sum(julio)  as julio,
                           sum(agosto)  as agosto, sum(septiembre)  as septiembre,
                          sum(octubre)  as octubre, sum(noviembre)  as noviembre, sum(diciembre)  as diciembre
                           FROM  presupuesto WHERE  rubro=  $id0 and nivel1=  $id1  $filtroaño ";

           //                echo '<BR>'.$sql3;
                          $resultado3   = $mysqli2->query($sql3);
                          //CONSULTAMOS NIVEL 1
                          while ($fila2 = $resultado3->fetch_assoc()) {
                            $m21 =$fila2['enero'];
                            $m22 =$fila2['febrero'];
                            $m23 =$fila2['marzo'];
                            $m24 =$fila2['abril'];
                            $m25 =$fila2['mayo'];
                            $m26 =$fila2['junio'];
                            $m27 =$fila2['julio'];
                            $m28 =$fila2['agosto'];
                            $m29 =$fila2['septiembre'];
                            $m210 =$fila2['octubre'];
                            $m211 =$fila2['noviembre'];
                            $m212 =$fila2['diciembre'];
                            $totalmx2=$m21 +$m22 +$m23 +$m24 +$m25+$m26+$m27 +$m28+$m29 +$m210 +$m211 +$m212 ;

                          }

                          
                     
                          echo '<tr id="rubro'.$id0.$id1.'" ><strong>
                          <td>'.$id0.'.'.$contador.'</td>
                          <td>'.$d1.'</td>
                          <td>'.$m21.'</td>
                          <td>'.$m22.'</td>
                          <td>'.$m23.'</td>
                          <td>'.$m24.'</td>
                          <td>'.$m25.'</td>
                          <td>'.$m26.'</td>
                          <td>'.$m27.'</td>
                          <td>'.$m28.'</td>
                          <td>'.$m29.'</td>
                          <td>'.$m210.'</td>
                          <td>'.$m211.'</td>
                          <td>'.$m212.'</td>
                          <td>'.($totalmx2).'</td>
                          <td>'.$totaliyg.'</td></strong>
                          </tr>';
                         


                   
//CONSULTAMOS LOS DIFERENTES RUBROS DEL NIVEL 2 ASOCIADOS AL ANTERIOR
$sql4         = "SELECT * FROM  rubros_n2 WHERE mt_estatus='1' AND  mt_id_n1  =  $id1  ";
$resultado4   = $mysqli2->query($sql4);
$totaliyg=0;
//   echo $sql2;
$contador1=0;
while ($fila1 = $resultado4->fetch_assoc()) {
  $contador1+=1;
     $id2 =$fila1['mt_id'];
     $d2 =$fila1['mt_nombre'];
/*ECHO $id1;
ECHO $d1;*/
$sql5         = "SELECT sum(enero) as enero, sum(febrero)  as febrero, sum(marzo)  as marzo,
sum(abril)  as abril, sum(mayo)  as mayo, sum(junio)  as junio , sum(julio)  as julio,
 sum(agosto)  as agosto, sum(septiembre)  as septiembre,
sum(octubre)  as octubre, sum(noviembre)  as noviembre, sum(diciembre)  as diciembre
 FROM  presupuesto WHERE   rubro=  $id0 and nivel1=  $id1  and nivel2=  $id2  $filtroaño ";

//                echo '<BR>'.$sql3;
$resultado5   = $mysqli2->query($sql5);
//CONSULTAMOS NIVEL 1
while ($fila3 = $resultado5->fetch_assoc()) {
  $m31 =$fila3['enero'];
  $m32 =$fila3['febrero'];
  $m33 =$fila3['marzo'];
  $m34 =$fila3['abril'];
  $m35 =$fila3['mayo'];
  $m36 =$fila3['junio'];
  $m37 =$fila3['julio'];
  $m38 =$fila3['agosto'];
  $m39 =$fila3['septiembre'];
  $m310 =$fila3['octubre'];
  $m311 =$fila3['noviembre'];
  $m312 =$fila3['diciembre'];
  $totalmx3=$m31 +$m32 +$m33 +$m34 +$m35+$m36+$m37 +$m38+$m39 +$m310 +$m311 +$m312 ;
}



echo '<tr id="rubro'.$id0.$id1.$id2.'" ><strong>
<td>'.$id0.'.'.$contador.'.'.$contador1.'</td>
<td>'.$d2.'</td>
<td>'.$m31.'</td>
<td>'.$m32.'</td>
<td>'.$m33.'</td>
<td>'.$m34.'</td>
<td>'.$m35.'</td>
<td>'.$m36.'</td>
<td>'.$m37.'</td>
<td>'.$m38.'</td>
<td>'.$m39.'</td>
<td>'.$m310.'</td>
<td>'.$m311.'</td>
<td>'.$m312.'</td>
<td>'.($totalmx3).'</td>
<td>'.$totaliyg.'</td></strong>
</tr>';

//} //PASADO AL FINAL



//CONSULTAMOS LOS DIFERENTES RUBROS DEL NIVEL 3 ASOCIADOS AL ANTERIOR
$sql6         = "SELECT * FROM  rubros_n3 WHERE mt_estatus='1' AND  mt_id_n2   =  $id2  ";
$resultado6   = $mysqli2->query($sql6);
$totaliyg=0;
//   echo $sql2;
$contador2=0;
while ($fila4 = $resultado6->fetch_assoc()) {
  $contador2+=1;
     $id3 =$fila4['mt_id'];
     $d3 =$fila4['mt_nombre'];
/*ECHO $id1;
ECHO $d1;*/
$sql7         = "SELECT sum(enero) as enero, sum(febrero)  as febrero, sum(marzo)  as marzo,
sum(abril)  as abril, sum(mayo)  as mayo, sum(junio)  as junio , sum(julio)  as julio,
 sum(agosto)  as agosto, sum(septiembre)  as septiembre,
sum(octubre)  as octubre, sum(noviembre)  as noviembre, sum(diciembre)  as diciembre
 FROM  presupuesto WHERE   rubro=  $id0 and nivel1=  $id1  and nivel2=  $id2 and nivel3=$id3   $filtroaño ";

//                echo '<BR>'.$sql3;
$resultado7   = $mysqli2->query($sql7);
//CONSULTAMOS NIVEL 1
while ($fila5 = $resultado7->fetch_assoc()) {
  $m41 =$fila5['enero'];
  $m42 =$fila5['febrero'];
  $m43 =$fila5['marzo'];
  $m44 =$fila5['abril'];
  $m45 =$fila5['mayo'];
  $m46 =$fila5['junio'];
  $m47 =$fila5['julio'];
  $m48 =$fila5['agosto'];
  $m49 =$fila5['septiembre'];
  $m410 =$fila5['octubre'];
  $m411 =$fila5['noviembre'];
  $m412 =$fila5['diciembre'];
  $totalmx4=$m41 +$m42 +$m43 +$m44 +$m45+$m46+$m47 +$m48+$m49 +$m410 +$m411 +$m412 ;
}



echo '<tr id="rubro'.$id0.$id1.$id2.$id3.'" ><strong>
<td>'.$id0.'.'.$contador.'.'.$contador1.'.'.$contador2.'</td>
<td>'.$d3.'</td>
<td>'.$m41.'</td>
<td>'.$m42.'</td>
<td>'.$m43.'</td>
<td>'.$m44.'</td>
<td>'.$m45.'</td>
<td>'.$m46.'</td>
<td>'.$m47.'</td>
<td>'.$m48.'</td>
<td>'.$m49.'</td>
<td>'.$m410.'</td>
<td>'.$m411.'</td>
<td>'.$m412.'</td>
<td>'.($totalmx4).'</td>
<td>'.$totaliyg.'</td></strong>
</tr>';

}

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
                </div>




                

                <div class="tab-pane fade active show " id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile">
                  <br>
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-lg-12">

                      <div class="card card-primary card-outline">
                        <div class="card-header">
                          <h5 class="m-0">Registro</h5>
                        </div>
                        <div class="card-body">
                          <div class="col-lg-12">
                            <span style="color:#ff0000; font-size:12px;"> Todos los Campos Con (*) Son Obligatorios</span>
                            <div class="row">

                              <div class="col-sm-12 col-md-12 col-lg-4">

                                <div class="form-group">
                                  <h6>Año <span style="color:#ff0000;">*</span> </h6>
                                  <select class="form-control" id="txt_ano" required name="txt_ano">
                                    <?php
                                    $fecha_actual = date("d-m-Y");
                                    $anomas1= date("Y",strtotime($fecha_actual."+ 1 year"));
                                    $anomenos1= date("Y",strtotime($fecha_actual."- 1 year"));
                                     ?>
                                    <option value="<?php echo$anomenos1 ?>"><?php echo $anomenos1 ?></option>
                                    <option selected value="<?php echo date('Y') ?>"><?php echo date('Y') ?></option>
                                    <option value="<?php echo $anomas1 ?>"><?php echo $anomas1 ?></option>
                                  </select>

</div>
</div>
<div class="col-sm-12 col-md-12 col-lg-4">

                                <div class="form-group">
                                  <h6>Cadena<span style="color:#ff0000;">*</span></h6>
                                  <select class="form-control" id="txt_rubro" required name="txt_rubro" onchange="nivel1(this.value);">
                                  </select>
                                </div>
                                </div>

<div class="col-sm-12 col-md-12 col-lg-4" style="display: none;">
                                <div class="form-group">
                                  <h6>Nivel 1<span style="color:#ff0000;">*</span></h6>
                                  <!--<select class="form-control" id="txt_nivel1" required name="txt_nivel1"  onchange="nivel2(this.value);">
                                  <option value= '0'> -- Seleccione una opción -- </option>
                                  </select>-->
                                </div>
                                </div>
<div class="col-sm-12 col-md-12 col-lg-4"  style="display: none;">
                                <div class="form-group">
                                  <h6>Nivel 2</h6>
                                  <select class="form-control" id="txt_nivel2" required name="txt_nivel2" onchange="nivel3(this.value);">
                                  <option value= '0'> -- Seleccione una opción -- </option>
                                </select>
                                </div>
                                </div>
<div class="col-sm-12 col-md-12 col-lg-4"  style="display: none;">
                                <div class="form-group">
                                  <h6>Nivel 3</h6>
                                  <select class="form-control" id="txt_nivel3" required name="txt_nivel3" onchange="nivel4(this.value);">
                                  <option value= '0'> -- Seleccione una opción -- </option>
                                </select>
                                </div>
                                </div>

                              </div>

                            </div>




                            <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="table-responsive demo-x content">

                            <div class="box-body">

                              <table id="table_registro" class="table table-striped table-bordered text-center ">
  <thead>
  <th>Tienda</th>
    <th>Enero</th>
    <th>Febrero</th>
    <th>Marzo</th>
    <th>Abril</th>
    <th>Mayo</th>
    <th>Junio</th>
    <th>Julio</th>
    <th>Agosto</th>
    <th>Septiembre</th>
    <th>Octubre</th>
    <th>Noviembre</th>
    <th>Diciembre</th>
  </thead>
  <tbody>
<tr>
  <td>
  <select class="form-control" id="txt_nivel1" required name="txt_nivel1" >
                                  <option value= '0'> -- Seleccione una opción -- </option>
                                </select>  
                                <label style="display: none;" class="form-control" id="nivel1txt">                              
                              </td>
  <td>
<input type="text" class="form-control" id="mes1">
  </td>
  <td>
<input type="text" class="form-control" id="mes2">
  </td>
  <td>
<input type="text" class="form-control" id="mes3">
  </td>
  <td>
<input type="text" class="form-control" id="mes4">
  </td>
  <td>
<input type="text" class="form-control" id="mes5">
  </td>
  <td>
<input type="text" class="form-control" id="mes6">
  </td>
  <td>
<input type="text" class="form-control" id="mes7">
  </td>
  <td>
<input type="text" class="form-control" id="mes8">
  </td>
  <td>
<input type="text" class="form-control" id="mes9">
  </td>
  <td>
<input type="text" class="form-control" id="mes10">
  </td>
  <td>
<input type="text" class="form-control" id="mes11">
  </td>
  <td>
<input type="text" class="form-control" id="mes12">
  </td>
</tr>
</tbody>
</table>
                            </div>
                          </div>
                        </div>




                            <div class="col-sm-12 col-md-12 col-lg-4">
                            <div class="form-group">

                           

                            </div>
</div>

                            <div class="row">
                              <div class="col-sm-0 col-md-0 col-lg-8">

                              </div>


                              <div class="col-sm-12 col-md-6 col-lg-4"><br>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                <button type="button" id="btn_save_labor" class="btn btn-info btn-block btn-flat"><i class="fas fa-save"></i> Registrar Presupuesto</button>
                                <button style="display: none;" type="button" id="btn_editar_labor" class="btn btn-info btn-block btn-flat"><i class="fas fa-save"></i> Editar Presupuesto</button>
                                </div>
                              </div>
                            </div>



                            
            <div class="row">
													<div class="col-lg-12 col-ms-12 col-xs-12">

														<div class="table-responsive demo-x content">
															<div class="box-body">
															<input  style="display: none;" type="text" class="form-control pull-left"  id="search" placeholder="Escriba lo que desee buscar de la tabla">
											<br>





                      
																<div id="resultado_table"  style="overflow-x:auto;">
<br>

																	<table id="table_ventas" class="table table-bordered table-hover no-footer dataTable ">
																		
<!--                                  <td style="width:10px">#</td>-->
																		<thead>
																			<tr>
     <th>#</th>
  <th>Tienda</th> 
    <th>Enero</th>
    <th>Febrero</th>
    <th>Marzo</th>
    <th>Abril</th>
    <th>Mayo</th>
    <th>Junio</th>
    <th>Julio</th>
    <th>Agosto</th>
    <th>Septiembre</th>
    <th>Octubre</th>
    <th>Noviembre</th>
    <th>Diciembre</th>
    <th>Acción</th>
																			</tr>
																		</thead>
																		<tbody>
																		</tbody>
																	</table>
																<!--	<td style="width:120px">Item</td>
																				<td style="width:10px">Cantidad</td>
                                                                                <td style="width:10px">Precio</td>
													-->
																</div>

															</div>
														</div>
													</div>
												</div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

              </div>
            </div>



            <!-- /.card-body -->
            <div class="card-footer">
              Registro/Consulta Labores
            </div>
            <!-- /.card-footer-->
          </div>


        </div>
      </div>



      <div class="modal " id="modal_labor">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar labor</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-4">
                  <div class="form-group">
                    <h6>Labor</h6>
                    <input type="text" class="form-control" id="txt_labor_e" autocomplete="off" />
                  </div>
                  <div class="form-group">
                    <h6>Unidad</h6>
                    <input type="text" class="form-control" id="txt_unidad_e" autocomplete="off" />
                  </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-4">
                  <div class="form-group">
                    <h6>Tipo labor</h6>
                    <select class="form-control" id="txt_tipo_labor_e" required>
                      <option value="no">-- Seleccione --</option>
                      <option value="Campo">Campo</option>
                      <option value="Cosecha">Cosecha</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <h6>Valor unitario</h6>
                    <input type="text" class="form-control" id="txt_valor_e" autocomplete="off" onkeypress="return filterFloat(event,this);"/>
                  </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-4">
                  <div class="form-group">
                    <h6>Rendimiento semanal</h6>
                    <input type="text" class="form-control" id="txt_rendimiento_e" autocomplete="off" />
                  </div>
                  <div class="form-group">
                    <h6>Grupo al que pertenece</h6>
                    <select id="txt_grupo_e" name="txt_grupo_e" class="form-control">
                    </select>
                  </div>

                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-info" id="btn_editar_labor">Editar Labor</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

    </div>
    <!-- FIN  CONTENIDO PAGUINA PRINCIPAL -->


    <!-- MODAL VER HISTORIAL PRECIOSW-->
    <div class="modal fade" id="modal_historial_precio" data-backdrop="static" data-keyboard="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="card card-primary card-outline">
            <div class="modal-header">
              <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Historial Precios
              </h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="row">


                <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                    <h6>Labor</h6>
                    <input type="text" class="form-control" id="labor_historial" name="labor_historial"  readonly="true"/>
                  </div>
                </div>

                <div class="col-lg-12 col-ms-12 col-xs-12">
                  <div class="box-body">

                    <table id="table_historial_precio" class="table table-striped table-bordered text-rigth ">
                      <thead>
                        <tr>
                          <td style="width:40px">#</td>
                          <td style="width:30px">Precio Anterior</td>
                          <td style="width:20px;">Precio Nuevo</td>
                          <td style="width:20px;">Fecha Actualizacion</td>
                          <td style="width:120px">Usuario</td>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
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
      <strong>Copyright &copy; <?php echo date('Y') ?><a href="#">PRODATAIN S.A.</a>.</strong> All rights reserved.
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
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>

  <script src="../funciones.js"></script>
  <script src="./js/presupuesto.js"></script>
</body>

</html>