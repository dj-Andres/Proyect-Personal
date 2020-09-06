<?php
session_start();
if($_SESSION['us_tipo']==1 || $_SESSION['us_tipo']==3){
    include_once 'layout/header.php';
?>
  <title>Proyect| Gestión Usuarios</title>

    <?php 
        include_once 'layout/nav.php';
    ?>
<!---Modal para crear usuario-->
<div class="modal fade" id="crear-usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Crear Usuario</h3>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <!--ALERTAS-->
                    <div class="alert alert-success text-center" id="crear" style="display:none;">
                        <span><i class="fas fa-check m-1"></i>Se creo exitosamento el usuario</span>
                    </div>
                    <div class="alert alert-danger text-center" id="nocrear" style="display:none;">
                        <span><i class="fas fa-times m-1"></i>El usuario ya existe</span>
                    </div>
                    <!--FIN-ALERTAS-->
                    <form id="form-crear">
                        <div class="form-group">
                            <label for="nombre">Nombres:</label>
                            <input id="nombre" type="text" class="form-control" placeholder="Ingrese nombre" require="">
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellidos:</label>
                            <input id="apellido" type="text" class="form-control" placeholder="Ingrese apellido" require="">
                        </div>
                        <div class="form-group">
                            <label for="nacimiento">Fecha Nacimiento:</label>
                            <input id="nacimiento" type="date" class="form-control" placeholder="Ingrese nacimiento" require="">
                        </div>
                        <div class="form-group">
                            <label for="cedula">Cedula:</label>
                            <input id="cedula" type="text" class="form-control" placeholder="Ingrese cedula" require="">
                        </div>
                        <div class="form-group">
                            <label for="clave">Contraseña:</label>
                            <input id="clave" type="password" class="form-control" placeholder="Ingrese la contraseña" require="">
                        </div>
                    
                </div>
                <div class="card-footer">
                    <button class="btn bg-gradient-primary float-rigth m-1" type="submit">Guardar</button>
                    <button class="btn btn.outline-secundary float-rigth m-1" type="button" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!---Final de modal de crear usuarios-->
    <div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirmar acción</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="text-center">
                <img id="avatar3" src="../img/user2-160x160.jpg" class="profile-user-img img-fluid img-circle">
            </div>
            <div class="text-center">
                <b>
                    <?php echo $_SESSION['nombre'];?>
                </b>
            </div>
            <span>Necesitamos su contraseña para realizar la acción</span>
            <!--Alertas de contraseña-->
            <div class="alert alert-success text-center" id="confirmado" style="display:none;">
                <span><i class="fas fa-check m-1"></i>El usuario ha sido ascendido exitosamente.</span>
            </div>
            <div class="alert alert-danger text-center" id="rechazado" style="display:none;">
                <span><i class="fas fa-times m-1"></i>La contraseña no es la correctamente</span>
            </div>
            <form id="form-confirmar">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                    </div>
                    <input class="form-control" type="password" placeholder="Ingresar su contraseña actual" id="clave-vieja">
                    <input type="hidden" id="Id_usuario">
                    <input type="hidden" id="funcion">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    </div>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestión Usuarios <button type="button" data-toggle="modal" data-target="#crear-usuario" class="btn bg-gradient-primary ml-2" id="boton-crear">Crear usuario</button> </h1>
            <input type="hidden" id="tipo_usuario" value="<?php  echo $_SESSION['us_tipo'];?>">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Gestión usuario</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section>
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Buscar usuario</h3>
                    <div class="input-group">
                        <input type="text" class="form-control fload-left" id="buscar" placeholder="Ingrese nombre del usuario">
                        <div class="input-group-append">
                            <button class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id ="usuarios" class="row d-flex align-items-stretch">

                    </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include_once 'layout/footer.php';
}else{
    header('Location:../index.php');
}
?>
<script src="../js/gestion_usuario.js"></script>