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
	<link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

	<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">

	<!-- Theme style -->
	<link rel="stylesheet" href="../../dist/css/adminlte.min.css">
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
						sistema_menu(2, 2, 1);
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
							<h1 class="m-0">Consulta Ventas Promotor</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">

								<button type="button" class="pull-right btn btn-default" id="sendEmail">Promotoria
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
								Interfaz para consulta de ventas promotor.
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
											<form action="excel2.php" method="get" target="_blank"> 

												<div class="row">

													<div class="col-lg-2 col-md-12 col-sm-12">
														<div class="form-group">
															<h6>Desde:</h6>
															<div class="input-group date" id="fechaindate1" data-target-input="nearest">
																<input type="text" id="fechain" name="fechain" class="form-control datetimepicker-input" data-target="#fechaindate1" value="<?php echo  date('d-m-Y'); ?>" />
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
																<input type="text" id="fechafin" name="fechafin" class="form-control datetimepicker-input" data-target="#fechafindate1" value="<?php echo  date('d-m-Y'); ?>" />
																<div class="input-group-append" data-target="#fechafindate1" data-toggle="datetimepicker">
																	<div class="input-group-text"><i class="fa fa-calendar"></i></div>
																</div>
															</div>


														</div>
													</div>

													<?php if($_SESSION["gb_perfil"] == 1){ ?>
													<div class="col-sm-2 col-md-12 col-lg-2">
														<div class="form-group">
															<h6>Promotor</h6>
															<input type="text" class="form-control" id="txt_promotor" name="txt_promotor" autofocus placeholder="Ingrese mayordomo">
														</div>
													</div>

													<?php }?>
													<div class="col-lg-2 col-md-12 col-sm-12">
														<div class="form-group">
															<h6>Cadena</h6>
															<select id="txt_cadena" class="form-control" name="txt_cadena">
                            								</select>
														</div>
													</div>

													<div class="col-lg-2 col-md-12 col-sm-12">
														<div class="form-group">
															<h6>Tienda</h6>
															<select id="txt_tienda" multiple class="form-control select" name="txt_tienda">
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






												<div class="row">
<div class="col-lg-6 col-md-12 col-sm-12">
	<div class="form-group">
		<div class="input-group date" id="fechaindate1" data-target-input="nearest">
		<input type="text" class="form-control pull-left"  id="search" placeholder="Escriba lo que desee buscar de la tabla">
			</div>
		</div>
	</div>

<div class="col-lg-2 col-md-12 col-sm-12">
	<div class="form-group">	
	<button  type="submit"  target="_blank" href="excel2.php" class="btn btn-success btn-flat"><i class="fas fa-download"></i> Descargar datos</button>                    
	</div>
</div>
</div>
</form>



												<br>

												<div class="row">
													<div class="col-lg-12 col-ms-12 col-xs-12">

														<div class="table-responsive demo-x content">
															<div class="box-body">
											<br>
																<div id="resultado_table">



																	<table id="table_ventas" class="table table-striped table-bordered text-rigth ">
																		
																		<thead>
																			<tr>
																				<td style="width:10px">#</td>
																				<td style="width:150px">Datos</td>
																				<td style="width:80px">Promotor</td>
																				<td style="width:70px">Cadena&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
																				<td style="width:5px">Item</td>
																				<td style="width:40px">Forma Pago</td>
																				<td style="width:10px">Cantidad</td>
																				<td style="width:20px">Valor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
																				<td></td>
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
						<!-- /.card-body -->
						<div class="card-footer">
							Promotoria consulta venta.
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
              <button type="button" class="btn btn-default btn_cancelar"  data-dismiss="modal">Cancelar</button>

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

	<!-- jQuery -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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

	<!-- InputMask -->
	<script src="../../plugins/moment/moment.min.js"></script>
	<script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
	<!-- date-range-picker -->
	<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap color picker -->
	<script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>


	<!-- AdminLTE App -->
	<script src="../../dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="../../dist/js/demo.js"></script>

	<!-- AdminLTE PREDICTIVO -->
	<script src="../../plugins/jquery-ui/jquery-ui.js" type="text/javascript"></script>

	<script src="../funciones.js"></script>
	<script src="./js/pro_consulta.js"></script>
</body>

</html>

<script>
 // Write on keyup event of keyword input element
 $(document).ready(function(){
 $("#search").keyup(function(){
 _this = this;
 // Show only matching TR, hide rest of them
 $.each($("#table_ventas tbody tr"), function() {
 if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
 $(this).hide();
 else
 $(this).show();
 });
 });
});
</script>