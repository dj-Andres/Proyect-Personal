<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyect|Login</title>
    <!---BOOTSTRAP---->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!---CSS---->
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="shortcut icon" href="../img/LogoSample_ByTailorBrands.ico" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center pt-5 mt-5 m-1">
            <div class="col-md-6 col-sm-8 col-xl-4 col-lg-5 formulario">
                <form action="" method="POST" id="form-recuperar-clave">
                    <div class="form-group text-center pt-3">
                        <h1 class="text-light">Recuperar Contraseña</h1>
                    </div>
                    <div class="form-group mx-sm-4 pt-3">
                        <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Ingrese su cedula">
                    </div>
                    <div class="form-group mx-sm-4 pt-3">
                        <input type="emai" name="correo" id="correo" class="form-control" placeholder="Ingrese su correo">
                    </div>
                    <div class="from-group mx-sm-4 pb-2">
                        <input type="submit" value="Recuperar" class="btn btn-block ingresar">
                    </div>
                </form> 
                <span id="aviso1" class="text-success text-bold">Texto</span>
                <span id="aviso2" class="text-danger text-bold">Texto</span>
            </div>
        </div>
    </div>
    <!---JQUERY---->
    <script src="../js/jquery.min.js"></script>
    <!---BOOTSTRAP---->
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/recuperar_clave.js"></script>
</body>
</html>