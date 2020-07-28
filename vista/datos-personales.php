<?php
    session_start();
    if($_SESSION['us_tipo']==1 || $_SESSION['us_tipo']==3 || $_SESSION['us_tipo']==2){
        include_once 'layout/header.php';
?>
<title>Proyect|Editar datos Personales</title>
<?php include_once 'layout/nav.php'; ?>

<div class="modal fade" id="cambio-contrasena" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cambiar la clave del usuario</h5>
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
            <!--Alertas de contraseña-->
            <div class="alert alert-success text-center" id="actualizado" style="display:none;">
                <span><i class="fas fa-check m-1"></i>Se cambio la contraseña correctamente</span>
            </div>
            <div class="alert alert-danger text-center" id="no-actualizado" style="display:none;">
                <span><i class="fas fa-times m-1"></i>La contraseña no es la correctamente</span>
            </div>
            <form id="form-clave">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                    </div>
                    <input class="form-control" type="password" placeholder="Ingresar su contraseña actual" id="clave-vieja">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-unlock"></i></span>
                    </div>
                    <input class="form-control" type="text" placeholder="Ingresar la nueva contraseña" id="clave-nueva">
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
    <div class="modal fade" id="cambio-avatar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cambiar foto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="text-center">
                <img id="avatar1" src="../img/user2-160x160.jpg" class="profile-user-img img-fluid img-circle">
            </div>
            <div class="text-center">
                <b>
                    <?php echo $_SESSION['nombre'];?>
                </b>
            </div>
            <!--Alertas de contraseña-->
            <div class="alert alert-success text-center" id="update" style="display:none;">
                <span><i class="fas fa-check m-1"></i>Se cambio la foto</span>
            </div>
            <div class="alert alert-danger text-center" id="no-update" style="display:none;">
                <span><i class="fas fa-times m-1"></i>Formato no soportado</span>
            </div>
            <form id="form-foto" enctype="multipart/form-data">
                <div class="input-group mb-3 ml-5 mt-2">
                    <input type="file"  class="input-group" name="foto">
                    <input type="hidden" name="funcion" value="cambiar_foto">
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
            <h1>Datos Personales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Datos Personales</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-success card-outline">
                            <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img id="avatar2" src="../img/user2-160x160.jpg" alt="" class="profile-user-img img-fluid img-circle">
                                    </div>
                                    <div class="text-center">
                                        <button  type="button" data-toggle="modal" data-target="#cambio-avatar" class="btn btn-primary btn-sm mt-1">Cambiar el avatar</button>
                                    </div>
                                    <input id="Id_usuario" type="hidden" value="<?php echo $_SESSION['cedula'] ?>">
                                    <h3 class="profile-username text-center text-success" id="nombre">Nombre:</h3>
                                    <p class="text-muted text-center" id="apellido">Apellido:</p>
                                    <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                            <b style="color:#0B7300">Edad:</b><a class="float-rigth" id="edad"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b style="color:#0B7300">Cedula:</b><a class="float-rigth" id="cedula"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b style="color:#0B7300">Tipo Ususario:</b><a class="float-rigth" id="us_tipo"></a>
                                            <spam class="float-rigth badge badge-primary"></spam>
                                        </li>
                                        <button type="button" class="btn btn-block btn-outline-warning btn-sm" data-toggle="modal" data-target="#cambio-contrasena">Cambiar clave</button>
                                    </ul>
                                </div>
                            </div>
                        </div>                  
                    </div>
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Información</h3>
                        </div>
                        <div class="card-body">
                            <strong style="color:#0B7300">
                                <i class="fas fa-phone mr-1"></i>Telefono
                            </strong>
                            <p class="text-center" id="telefono">0992294342</p>

                            <strong style="color:#0B7300">
                                <i class="fas fa-home mr-1"></i>Residencia
                            </strong>
                            <p class="text-center" id="residencia">0992294342</p>

                            <strong style="color:#0B7300">
                                <i class="fas fa-at mr-1"></i>Email
                            </strong>
                            <p class="text-center" id="correo">andres96jimenez@gmail.com</p>

                            <strong style="color:#0B7300">
                                <i class="fas fa-smile-wink mr-1"></i>Sexo
                            </strong>
                            <p class="text-center" id="sexo">andres96jimenez@gmail.com</p>
                        </div>

                        <strong style="color:#0B7300">
                                <i class="fas fa-pencil-alt mr-1"></i>Información adicional
                            </strong>
                            <p class="text-center" id="adicioanl-use">andres96jimenez@gmail.com</p>
                            <button class="edit btn btn-block bg-gradient-danger">Editar</button>
                        <div class="card-footer">
                            <p class="text-muted">Click en el botón que desea editar</p>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card-success">
                            <div class="card-header">
                                <h3 class="card-title">Editar los datos que desea editar</h3>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-success text-center" id="editado" style="display:none;">
                                        <span><i class="fas fa-check m-1"></i>Editado</span>
                                </div>
                                <div class="alert alert-danger text-center" id="no-editado" style="display:none;">
                                        <span><i class="fas fa-times m-1"></i>No se pudo editar</span>
                                </div>
                                <form id="form-usuario" class="form-horizontal">
                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="telefono1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="recidencia" class="col-sm-2 col-form-label">Residencia</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="recidencia" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Eamil</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="email1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sexo" class="col-sm-2 col-form-label">Sexo</label>
                                        <div class="col-sm-10">
                                            <input type="sexo" id="sexo1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="adicional" class="col-sm-2 col-form-label">Información adicional</label>
                                        <div class="col-sm-10">
                                            <textarea name="adicional" id="adicional1" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10 float-rigth">
                                            <button class="btn btn-block btn-outline-success">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <p class="text-muted">¡ Cuidado al ingresar datos erroneos!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
include_once 'layout/footer.php';
}else{
    header('Location:../index.php');
}
?>
<script src="../js/usuario.js"></script>