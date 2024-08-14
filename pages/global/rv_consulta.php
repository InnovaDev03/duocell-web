<?php
include('../../Conexion/conexion_mysqli.php');
include('../../Model/Model_gb_global.php');
include('../../control_session.php');
include('../menu.php');

if(isset($_REQUEST['txt_reserva']))
{
	$id_reserva = $_REQUEST['txt_reserva'];
}
else
{
	$id_reserva = '';
}

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
  <style>
        #contador {
            font-size: 0.9rem;
            color: #666;
        }
    </style>
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
            sistema_menu(9, 2, 1);
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
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Consulta Reservas</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">

                <button type="button" class="pull-right btn btn-default" id="sendEmail">Reservas
                  <i class="fa fa-arrow-circle-right"></i>
                </button>
                <button type="button" class="pull-right btn btn-default" id="sendEmail">Consulta
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
                Interfaz para consulta de reservas
              </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="card-body">


              <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Consulta</a>
                </li>



              </ul>

              <div class="tab-content" id="custom-content-below-tabContent">


                <div class="tab-pane fade show active" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                  <br>
                  <div class="col-md-12 col-sm-12 col-lg-12">
                    <div class="card card-primary card-outline">

                      <div class="card-body">

                        <div class="row">

                          <div class="col-lg-2 col-md-12 col-sm-12">
                            <div class="form-group">
                              <h6>Desde:</h6>
                              <div class="input-group date" id="fechaindate1" data-target-input="nearest">
                                <input type="text" id="fechain" name="fechain" class="form-control datetimepicker-input" data-target="#fechaindate1" value="<?php echo   date('01-m-Y'); ?>" />
                                <div class="input-group-append" data-target="#fechaindate1" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>



                          <div class="col-lg-2 col-md-12 col-sm-12">
                            <div class="form-group">
                              <h6>Hasta:</h6>

                              <div class="input-group date" id="fechafindate1" data-target-input="nearest">
                                <input type="text" id="fechafin" name="fechafin" class="form-control datetimepicker-input" data-target="#fechafindate1" value="<?php echo  date('t-m-Y'); ?>" />
                                <div class="input-group-append" data-target="#fechafindate1" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                              </div>


                            </div>
                          </div>

                          <?php if ($_SESSION["gb_perfil"] == 1) { ?>
                            <div class="col-sm-2 col-md-12 col-lg-2" style="display:none">
                              <div class="form-group">
                                <h6>Vendedor</h6>

                                <input type="text" class="form-control" id="txt_promotor" name="txt_promotor" autofocus placeholder="Escriba nombre del vendedor">
                              </div>
                            </div>

                          <?php } ?>

                          <div class="col-lg-2 col-md-12 col-sm-12" style="display: none;">
                            <div class="form-group">
                              <h6>Cliente</h6>
                              <input type="text" placeholder="Seleccione Cliente..." class="form-control producto_auto limpiar ui-autocomplete-input" data-input_type="autocomplete" id="txt_cliente" name="txt_cliente" maxlength="100" onkeyup="javascript:this.value=this.value.toUpperCase();" autocomplete="off">
                            </div>
                          </div>


                          <div class="col-lg-2 col-md-12 col-sm-12" style="display:none">
                            <div class="form-group">
                              <h6>Estado</h6>
                              <select id="txt_estado" class="form-control" name="txt_estado">
                              </select>
                            </div>
                          </div>

                          <div class="col-lg-2 col-md-12 col-sm-12" style="display:none">
                            <div class="form-group">
                              <h6>Tienda</h6>
                              <select id="txt_tienda" class="form-control" name="txt_tienda">
                                <option value="">--Seleccionar--</option>
                              </select>
                            </div>
                          </div>



                          <div class="col-lg-2 col-md-12 col-sm-12">
                            <div class="form-group">
                              <br>
                              <button type="button" class="btn btn-block btn-flat btn-info" id="btn_buscar" name="btn_buscar"><i class="fas fa-check"></i> Buscar</button>
                            </div>
                          </div>

                        </div>


                        <br>

                        <div class="row">
                          <div class="col-lg-12 col-ms-12 col-xs-12">

                            <div class="table-responsive demo-x content">
                              <div class="box-body">
                                <input type="text" class="form-control pull-left" id="search" placeholder="Escriba lo que desee buscar de la tabla">
                                <br>
                                <div id="resultado_table">



                                  <table id="table_ventas" class="table table-striped table-bordered text-rigth ">

                                    <!--                                  <td style="width:10px">#</td>-->
                                    <thead>
                                      <tr>
                                        <td style="width:5px">Fecha Reserva</td>
                                        <td style="width:3px"># Reserva</td>
                                        <td style="width:100px">Cliente</td>
                                        <td style="width:200px">Productos</td>
                                        <td style="width:80px">Cantidad</td>
                                        <td style="width:80px">OC's</td>
                                        <td style="width:20px">Acciones</td>
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
            <!-- /.card-body -->
            <div class="card-footer">
              Consulta Reservas.
            </div>
            <!-- /.card-footer-->
          </div>


        </div>
      </div>
    </div>
    <!-- FIN  CONTENIDO PAGUINA PRINCIPAL -->



    <!-- MODAL -->

    <div class="modal fade" id="modal_imei">
      <div class="modal-dialog modal-mg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Productos Imei</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <strong>Venta</strong>
                  <input type="text" class="form-control" id="txt_venta" name="txt_venta" autocomplete="off" readonly="true" />
                </div>
              </div>



              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <table id="table_imeis" class="table table-striped table-bordered text-center ">
                    <thead>
                      <tr>
                        <td style="width:5px">#</td>
                        <td style="width:40px">Producto</td>
                        <td style="width:20px">Imei</td>

                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn_cancelar" data-dismiss="modal">Cancelar</button>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL -->
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


  <!-- MODAL EDITAR OC-->
  <div class="modal fade" id="modal_editar_orden">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">

        <form id="registro_equipos_edit2">
          <div class="card card-primary card-outline">
            <div class="modal-header">
              <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Productos Reservados
              </h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>

              <?php
              $esono = '';
              $esonos = '';
              ?>
            </div>
            <div class="modal-body">
              <div class="card-body">

                <div class="row">


                  <div class="col-lg-6">

                    <div class="card card-outline">

                      <div class="card-body">
                        <div class="col-lg-12">



                          <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <strong>Codigo</strong><span style="color:#ff0000;">*</span></label>
                              <input type="text" class="form-control" id="txt_codigo" name="txt_codigo" autocomplete="off" maxlength="100" readonly="true" />
                              <input type="hidden" class="form-control" id="txt_option" name="txt_option" value="13" />
                            </div>
                          </div>

                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                              <strong>Fecha de Reserva</strong><span style="color:#ff0000;">*</span></label>
                              <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input readonly type="text" id="txt_fecha" name="txt_fecha" value="<?php echo date('d-m-Y') ?>" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                              </div>
                            </div>
                          </div>


                          <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <strong>Forma Pago</strong><span style="color:#ff0000;">*</span></label>
                            <select class="form-control" id="txt_formapago" name="txt_formapago">
                            <option value="">Seleccione método de pago</option>
                            <option value="CONTADO">CONTADO</option>
                            <option value="CREDITO">CREDITO</option>
                          </select>
                          </div>
                        </div>
						  
						  
						  <div class="col-sm-12 col-md-12 col-lg-12" style="display: none;">>
                                <div class="form-group">
                                  <strong>Bodega</strong><span style="color:#ff0000;">*</span>

                                  <select id="txt_bodega" class="form-control" name="txt_bodega" <?php if (!($_SESSION["gb_perfil"] == 1 || $_SESSION["gb_perfil"] == 7 || $_SESSION["gb_perfil"] == 8)) echo 'readonly="true"'; ?> value="12">
                                    <option value="">--Seleccionar--</option>
                                  </select>

                                </div>
                              </div>

                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-lg-6">
                    <div class="card card-outline">

                      <div class="card-body">


                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <strong>Cliente</strong><span style="color:#ff0000;">*</span>
                            <input readonly="true" id="cliente_edit" name="cliente_edit" type="text" placeholder="Seleccione Cliente..." class="form-control producto_auto limpiar ui-autocomplete-input" data-input_type="autocomplete" maxlength="100" onkeyup="javascript:this.value=this.value.toUpperCase();" autocomplete="off">
                          </div>
                        </div>


                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <strong>Cliente a facturar</strong><span style="color:#ff0000;">*</span>
                            <input  id="cliente_edit_fact" name="cliente_edit_fact" type="text" placeholder="Seleccione Cliente..." class="form-control producto_auto limpiar ui-autocomplete-input" data-input_type="autocomplete" maxlength="100" onkeyup="javascript:this.value=this.value.toUpperCase();" autocomplete="off">
                            <input  id="txt_reserva" name="txt_reserva" type="hidden"  value="<?php echo $id_reserva;?>">
                         
						 </div>
                        </div>

                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <strong>Observaciones</strong><span style="color:#ff0000;">*</span>
                            <textarea class="form-control" id="txt_observaciones" name="txt_observaciones" autocomplete="off" row="2" oninput="contarCaracteres()"></textarea>
                            <div id="contador">0 / 200</div>
                          </div>
                        </div>


                        <div class="col-sm-12 col-md-12 col-lg-12" style="display:none">
                          <div class="form-group">
                            <strong>Tienda</strong><span style="color:#ff0000;">*</span></label>
                            <select id="txt_tienda" class="form-control" name="txt_tienda">
                              <option value="">--Seleccionar--</option>
                            </select>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>


                  <div id="claseoriginal" class="col-lg-12">
                    <div class="card  card-outline">

                      <div class="card-body">
                      <?php
                      if ($_SESSION["gb_perfil"] !=4){
?>
<div class="col-lg-12 col-ms-12 col-xs-12">

												<div class="row">

												


													<div class="col-sm-12 col-md-12 col-lg-4">
														<div class="form-group">
															
                              <input type="text"  placeholder="Seleccione Producto..."  class= "form-control producto_auto limpiar" data-input_type="autocomplete" class="form-control"  id="txt_producto" name="txt_producto" maxlength="100" onblur="stock_productos();buscarprecio(this.value);" onkeyup="javascript:this.value=this.value.toUpperCase();"/>	
														</div>
													</div>

                          <div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">
                              <input type="text"  placeholder="0" readonly class= "form-control" id="stock" name="stock" maxlength="100"/>	
														</div>
													</div>

                          <div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">
															

                              <input type="text"  placeholder="Cantidad..."  onblur="buscarprecio2(this.value)"  class= "form-control"  class="form-control"  id="txt_cantidad" name="txt_cantidad" maxlength="100" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"/>	

														</div>
													</div>

                          <div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">
															

                              <input type="text"  placeholder="Precio..."  class= "form-control"  class="form-control" id="txt_precio" name="txt_precio" maxlength="100" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" <?php if (!($_SESSION["gb_perfil"] == 1 || $_SESSION["gb_perfil"] == 7 || $_SESSION["gb_perfil"] == 8)) echo 'readonly="true"'; ?>/>	

														</div>
													</div>

                 
                          <div class="col-sm-12 col-md-12 col-lg-2">
														<div class="form-group">
															

                            <button type="button" class="btn btn-info btn-block btn-flat" id="btn_agregra_item">Agregar</button>
														</div>
													</div>

												</div>
											</div>

                      <?php
                      }
?>

                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="table-responsive demo-x content">


                            <div id="tablaoculta">
                              <table id="table_venta" class="table table-striped table-bordered text-rigth tabla_detalle_fp">
                                <thead>
                                  <tr>
                                    <td style="width:10px">#</td>
                                    <td style="width:10px">Producto</td>
                                    <td style="width:10px">Cantidad</td>
                                    <td style="width:60px"></td>
                                    <td style="width:10px">Precio</td>
                                    <td style="width:60px"></td>
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
            </div>


          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" id="btn_edit_orden" class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i>Crear Orden de Compra</button>
            <button type="button" id="btn_consignacion" class="btn btn-outline-warning btn-block btn-flat"><i class="fas fa-bin"></i>Consignacion</button>
            <button type="button" id="btn_cancel_orden" class="btn btn-outline-danger btn-block btn-flat"><i class="fas fa-bin"></i>Liberar Inventario</button>

          </div>
      </div>

      </form>

      <div class="card-footer">

      </div>
    </div>
  </div>

  <!-- MODAL BITACORA RESERVA-->
  <div class="modal fade" id="modal_reserva_bitacora">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">

        <form id="registro_equipos_edit2">
          <div class="card card-primary card-outline">
            <div class="modal-header">
              <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Bitacora Reserva
              </h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="card-body">

                <div class="row">
                  <div id="claseoriginal" class="col-lg-12">
                    <div class="card  card-outline">

                      <div class="card-body">



                        <div class="col-lg-12">
                          <div class="card card-outline">

                            <div class="card-body">


                              <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                  <strong>Producto</strong><span style="color:#ff0000;">*</span>
                                  <input readonly="true" id="producto_reserva" name="producto_reserva" type="text" placeholder="Seleccione Cliente..." class="form-control producto_auto limpiar ui-autocomplete-input" data-input_type="autocomplete" maxlength="100" onkeyup="javascript:this.value=this.value.toUpperCase();" autocomplete="off">
                                </div>
                              </div>



                            </div>
                          </div>
                        </div>


                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="table-responsive demo-x content">


                            <div id="tablaoculta">
                              <table id="table_reserva_bitacora" class="table table-striped table-bordered text-rigth tabla_detalle_fp">
                                <thead>
                                  <tr>
                                    <td style="width:10px">#</td>
                                    <td style="width:10px">Tipo</td>
                                    <td style="width:10px">Cantiad</td>
                                    <td style="width:60px">Fecha</td>
                                    <td style="width:60px">Usuario</td>
                                    <td style="width:60px">Bodega</td>
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
            </div>


          </div>
      </div>

      </form>

      <div class="card-footer">

      </div>
    </div>
  </div>
  <!-- FIN MODAL BITACORA RESERVA-->



  <!--  MODAL BODEGAS CONSIGNACION-->
  <div class="modal fade" id="modal_consignacion">
    <div class="modal-dialog modal-xs">
      <div class="modal-content">

        <form id="">
          <div class="card card-primary card-outline">
            <div class="modal-header">
              <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Bodegas Consignacion
              </h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="card-body">

                <div class="row">
                  <div id="claseoriginal" class="col-lg-12">
                    <div class="card  card-outline">

                      <div class="card-body">



                        <div class="col-lg-12">
                          <div class="card card-outline">

                            <div class="card-body">


                              <div class="col-sm-12 col-md-12 col-lg-12" >
                                <div class="form-group">
                                  <strong>Bodega</strong><span style="color:#ff0000;">*</span>

                                  <select id="txt_bodega_consignacion" class="form-control" name="txt_bodega_consignacion">
                                    <option value="">--Seleccionar--</option>
                                  </select>

                                </div>
                              </div>



                            </div>
                          </div>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                              <br>
                              <button type="button" class="btn btn-block btn-flat btn-info" id="btn_procesar_consignacion" name="btn_procesar_consignacion"><i class="fas fa-check"></i>Procesar</button>
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

      </form>

      <div class="card-footer">

      </div>
    </div>
  </div>
  <!-- FIN MODAL BODEGAS CONSIGNACION-->

  </div>
  <!-- MODAL EDITAR OC -->


  <!-- MODAL APROBAR GERENCIA-->



</body>



</html>






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
<script src="./js/rv_consulta.js?v=<?php print_r(rand()) ?>"></script>


<script>
  // Write on keyup event of keyword input element
  $(document).ready(function() {
    $("#search").keyup(function() {
      _this = this;
      // Show only matching TR, hide rest of them
      $.each($("#table_ventas tbody tr"), function() {
        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
          $(this).hide();
        else
          $(this).show();
      });
    });
  });
</script>