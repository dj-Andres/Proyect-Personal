<?php
session_start();
if($_SESSION['us_tipo']==1 || $_SESSION['us_tipo']==3){
    include_once 'layout/header.php';
?>
  <title>Pharmacy System|Gestión Proveedor</title>

    <?php
        include_once 'layout/nav.php';
    ?>

        <!---Modal para crear proveedor-->
        <div class="modal fade" id="crear-proveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Crear Proveedor</h3>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <!--ALERTAS-->
                    <div class="alert alert-success text-center" id="crear" style="display:none;">
                        <span><i class="fas fa-check m-1"></i>Se creo exitosamento el proveedor</span>
                    </div>
                    <div class="alert alert-danger text-center" id="nocrear" style="display:none;">
                        <span><i class="fas fa-times m-1"></i>El proveedor ya existe</span>
                    </div>
                    <div class="alert alert-danger text-center" id="editar" style="display:none;">
                        <span><i class="fas fa-times m-1"></i>Se actualizo correctamente</span>
                    </div>
                    <!--FIN-ALERTAS-->
                    <form id="form-crear">
                        <div class="form-group">
                            <label for="nombre">Nombres:</label>
                            <input id="nombre" type="text" class="form-control letters" placeholder="Ingrese nombre" require="">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Telefono:</label>
                            <input id="telefono" type="text" class="form-control numbers" placeholder="Ingrese telefono" require="">
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo:</label>
                            <input id="correo" type="email" class="form-control" placeholder="Ingrese correo" require="">
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección:</label>
                            <input id="direccion" type="text" class="form-control" placeholder="Ingrese dirección" require="">
                        </div>
                        <input type="hidden" id="id_editar_proveedor">
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
    <!---Modal de cambiar el avatar-->
    <div class="modal fade" id="cambio-logo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cambiar avatar del proveedor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="text-center">
                <img id="logo-actual" src="../img/user2-160x160.jpg" class="profile-user-img img-fluid img-circle">
            </div>
            <div class="text-center">
                <b id="nombre_logo">

                </b>
            </div>
            <!--Alertas de contraseña-->
            <div class="alert alert-success text-center" id="update" style="display:none;">
                <span><i class="fas fa-check m-1"></i>Se cambio la foto</span>
            </div>
            <div class="alert alert-danger text-center" id="no-update" style="display:none;">
                <span><i class="fas fa-times m-1"></i>Formato no soportado</span>
            </div>
            <form id="form-logo" enctype="multipart/form-data">
                <div class="input-group mb-3 ml-5 mt-2">
                    <input type="file"  class="input-group" name="foto">
                    <input type="hidden" name="funcion" id="funcion">
                    <input type="hidden" name="id_logo_prov" id="id_logo_prov">
                    <input type="hidden" name="avatar" id="avatar">
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
    <!---final de modal de cambio de avatar--->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestión Proveedor <button type="button" data-toggle="modal" data-target="#crear-proveedor" class="btn bg-gradient-primary ml-2">Crear Proveedor</button> </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Gestión Proveedor</li>
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
                    <h3 class="card-title">Buscar Proveedor</h3>
                    <div class="input-group">
                        <input type="text" class="form-control fload-left" id="buscar" placeholder="Ingrese nombre">
                        <div class="input-group-append">
                            <button class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id ="proveedor" class="row d-flex align-items-stretch">

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
<script src="../js/gestion_proveedor.js" type="module"></script>