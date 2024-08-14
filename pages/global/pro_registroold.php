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
  <link rel="stylesheet" href="../../css_session/css.css">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

  <!-- daterange picker -->
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">

  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->

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
            sistema_menu(2, 1, 1);
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
              <h1 class="m-0">Registro Promotor/Ventas</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">

                <button type="button" class="pull-right btn btn-default" id="sendEmail">Promotor
                  <i class="fa fa-arrow-circle-right"></i>
                </button>
                <button type="button" class="pull-right btn btn-default" id="sendEmail">Registro
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
                Interfaz para registrar ventas por promotor.
              </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>

              </div>
            </div>
            <div class="card-body">
             
              <div class="row">


                <div class="col-lg-6">

                  <div class="card card-outline">
                  
                    <div class="card-body">
                      <div class="col-lg-12">

                        

                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <strong>Codigo</strong><span style="color:#ff0000;">*</span></label>
                            <input type="text" class="form-control" id="txt_codigo" autocomplete="off" maxlength="100" readonly="true" />
                          </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <div class="form-group">
                            <strong>Fecha</strong><span style="color:#ff0000;">*</span></label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                              <input type="text" id="txt_fecha" name="txt_fecha" value="<?php echo date('d-m-Y') ?>" class="form-control datetimepicker-input" data-target="#reservationdate" />
                              <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
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
                            <strong>Cadena</strong><span style="color:#ff0000;">*</span></label>
                            <select id="txt_cadena" class="form-control" name="txt_cadena">
                            </select>
                          </div>
                        </div>


                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <strong>Tienda</strong><span style="color:#ff0000;">*</span></label>
                            <select id="txt_tienda" class="form-control" name="txt_tienda">
                            </select>
                          </div>
                        </div>
                     
                    </div>
                  </div>
                </div>


                <div class="col-lg-8">
                  <div class="card  card-outline">
                  
                    <div class="card-body">



                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="table-responsive demo-x content">

                          <div class="box-body">


                          <div class="text-left">
															<div class="row" >
																<div class="col-md-12">

																	<form id="registrarPp">	
																		<div id="error_productoP"></div>

																		
																		<div class="col-md-12">

																			<div class="form-group">

																				
																				<div class="input-group">
																					
																					<input type="text"  placeholder="Seleccione Producto..."  class= "form-control producto_auto limpiar" data-input_type="autocomplete" class="form-control"  id="itempv" name="itempv">	
																				</div>
																				

																			</div>
																		</div>
																
																	</form>
																</div>
															</div>
														</div>


                            <table id="table_sistemas" class="table table-striped table-bordered text-rigth tabla_detalle_fp">
                              <thead>
                                <tr>
                                  <td style="width:10px">#</td>
                                  <td style="width:10px">Producto</td>
                                  <td style="width:80px">Imei</td>
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

                <div class="col-lg-4">
                  <div class="card card-outline">
                  
                    <div class="card-body">


                    <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="form-group">
                            <strong>Forma Pago</strong><span style="color:#ff0000;">*</span></label>
                            <select id="txt_cadena" class="form-control" name="txt_cadena">
                            </select>
                          </div>
                        </div>


                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="card card-primary card-outline">
                          <h3> Total : <div id="total_venta"></div></h3>
                          </div>
                        </div>
                     
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              Registro - Consulta Cadenas/Tiendas
            </div>
            <!-- /.card-footer-->
          </div>


        </div>
      </div>

       <!-- MODAL IMEI    -->
	  
   <div class="modal fade" id="modal_imei">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Cargar Imei</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-6">
					  <div class="form-group">
						<strong>Producto</strong>
						<input type="text" class="form-control" id="txt_producto_imei" name="txt_producto_imei" autocomplete="off" readonly="true" />
					  </div>
					</div>
				
          <div class="col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
            <table id="table_cajas" class="table table-striped table-bordered text-center ">
												<thead>
												  <tr>
													<td style="width:5px">#</td>
													<td style="width:40px">Nombre de Marca</td>
													<td style="width:20px">Valor por cajas</td>
                          <td style="width:20px">Peso caja</td>
													<td style="width:20px">Acciones</td>

												  </tr>
												</thead>
												<tbody>
												</tbody>
											  </table>
					</div>
				
				</div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn_cancelar"  data-dismiss="modal">Cancelar</button>

            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
    <!-- FIN  CONTENIDO PAGUINA PRINCIPAL -->



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

  <!-- InputMask -->
  <script src="../../plugins/moment/moment.min.js"></script>
  <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- date-range-picker -->
  <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap color picker -->
  <script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>

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
  <script src="./js/pr_registro.js"></script>
</body>

</html>