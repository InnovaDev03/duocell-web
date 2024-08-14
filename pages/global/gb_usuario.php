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
            sistema_menu(1,16,1);
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
              <h1 class="m-0">Registro de usuario</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">

                <button type="button" class="pull-right btn btn-default" id="sendEmail">Usuarios
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
                    <i class="fas fa-user-circle"></i>
                    Interfaz para registrar/editar/eliminar usuarios del sistema.
                  </h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          
          </div>
        </div>
        <div class="card-body">
		<div class="form-group uk-text-center">

                          <span style="color:#ff0000; font-size:12px;"> Todos los Campos Con (*) Son Obligatorios</span>

                        </div>
        <div class="row">
            <div class="col-lg-3">

              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="m-0">Registro</h5>
                </div>
                <div class="card-body">
                  <div class="col-lg-12">
				  
				  
				  <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <strong>Perfil :</strong><span style="color:#ff0000;">*</span></label>
                        <select id="txt_categoria" class="form-control">
                        </select>
                      </div>
                    </div>

                  <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <strong>Nombre</strong><span style="color:#ff0000;">*</span></label>
                        <input type="text" class="form-control" id="txt_nombre" autocomplete="off" />
                      </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <strong>Usuario</strong><span style="color:#ff0000;">*</span></label>
                        <input type="text" class="form-control" id="txt_usuario" autocomplete="off" />
                      </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <strong>Teléfono</strong><span style="color:#ff0000;">*</span></label>
                        <input type="text" class="form-control" id="txt_tfno" autocomplete="off" />
                      </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12" id="div_cod_vendedor" style="display: none;">
                      <div class="form-group">
                        <strong>Cod. Vendedor</strong></label>
                        <input type="text" class="form-control" id="txt_codvendedor" autocomplete="off" />
                      </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <strong>Email</strong>
                        <input type="text" class="form-control" id="txt_email" autocomplete="off" onChange='validarEmail()' />

                      </div>
                    </div>


                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <strong>Clave :</strong><span style="color:#ff0000;">*</span></label>
                        <input type="password" class="form-control" id="txt_clave" autocomplete="off" />
                      </div>
                    </div>

                    


                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">

                        <br>
                        <div class="text-rihgt" id="create_usuario">
                          
                          <button type="button" id="btn_save_usuario"  class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Usuario</button>
                        </div>

                        <div class="text-rihgt" id="editar_usuario" style="display: none;">


                          <button type="button" id="btn_editar_usuario"  class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-edit"></i> Editar Usuario</button>
                        </div>


                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-lg-9">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="m-0">Consulta</h5>
                </div>
                <div class="card-body">


                
                <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="table-responsive demo-x content">

                        <div class="box-body">

                          <table id="table_usuario" class="table table-striped table-bordered text-center tabla_detalle_fp">
                            <thead>
                              <tr>
                                <td style="width:10px">#</td>
                                <td style="width:10px">Nombre</td>
                                <td style="width:80px">Usuario</td>
                                <td style="width:80px">Teléfono</td>
                                <td style="width:80px">Cod. Vendedor</td>
                                <td style="width:80px">Email</td>
                                <td style="width:40px">Perfil</td>
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
        <!-- /.card-body -->
        <div class="card-footer">
          Registro/Consulta usuarios
        </div>
        <!-- /.card-footer-->
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
  <script src="./js/gb_usuario.js"></script>
</body>

</html>