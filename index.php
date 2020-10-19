<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyect|Login</title>
    <!---BOOTSTRAP---->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!---CSS---->
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="shortcut icon" href="img/LogoSample_ByTailorBrands.ico" type="image/x-icon">
</head>
<?php
session_start();
if(!empty($_SESSION['us_tipo'])){
    header('Location:controlador/controlador-login.php');
}else{
    session_destroy();
?>
<body>
    <div class="container">
        <div class="row justify-content-center pt-5 mt-5 m-1">
            <div class="col-md-6 col-sm-8 col-xl-4 col-lg-5 formulario">
                <form action="controlador/login-controlador.php" method="POST">
                    <div class="form-group text-center pt-3">
                        <h1 class="text-light">Iniciar Sessión</h1>
                    </div>
                    <div class="form-group mx-sm-4 pt-3">
                        <input type="text" name="usuario" class="form-control" placeholder="Ingrese el usuario" required>
                    </div>
                    <div class="form-group mx-sm-4 pb-3">
                        <input type="password" name="clave" class="form-control" placeholder="Ingrese su contraseña" required>
                    </div>
                    <div class="from-group mx-sm-4 pb-2">
                        <input type="submit" value="Ingresar" class="btn btn-block ingresar">
                    </div>
                    <div class="form-group mx-sm-4 text-right">
                        <span><a href="vista/recuperar_clave.php" class="olvide">Olvide mi contraseña</a></span>
                    </div>
                </form> 
            </div>
        </div>
    </div>
    <!---JQUERY---->
    <script src="js/jquery.min.js"></script>
    <!---BOOTSTRAP---->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
}
?>