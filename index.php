<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Duocell</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css_session/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="css_session/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css_session/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="" class="h1"><b>Duocell</b>Sistema</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Datos inicio de sesión</p>

      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Usuario.." id="login"  name="login">
          <div class="input-group-append">
            
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Clave..." id="password" name="password">
          <div class="input-group-append">
          <button class="btn btn-secondary" type="button" onclick="mostrarContrasena()">👁</button>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
             
              <label for="remember">
                
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="enviar" class="btn btn-primary btn-block">Aceptar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->


</body>
</html>
<script>
  function mostrarContrasena(){
      var tipo = document.getElementById("password");
      if(tipo.type == "password"){
          tipo.type = "text";
      }else{
          tipo.type = "password";
      }
  }
</script>