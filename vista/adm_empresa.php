<?php
session_start();
if($_SESSION['us_tipo']==3){
    include_once 'layout/header.php';
?>
  <title>Pharmacy System | Configuración Empresa</title>

    <?php
        include_once 'layout/nav.php';
    ?>
    <div class="modal fade" id="crear-empresa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Configuración Empresa</h3>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <!--ALERTAS-->
                    <div class="alert alert-success text-center" id="nueva-empresa" style="display:none;">
                        <span><i class="fas fa-check m-1"></i>Se creo la Empresa exitosamente</span>
                    </div>
                    <div class="alert alert-success text-center" id="editar-empresa" style="display:none;">
                        <span><i class="fas fa-check m-1"></i>Se actualizo exitosamente</span>
                    </div>
                    <div class="alert alert-danger text-center" id="nocrear-empresa" style="display:none;">
                        <span><i class="fas fa-times m-1"></i>La empresa ya se encuentra registrada</span>
                    </div>
                    <!--FIN-ALERTAS-->
                    <form id="form-empresa">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" class="form-control" placeholder="Ingrese el Nombre">
                            <input type="hidden" id="id_editar_empresa">
                        </div>
                        <div class="form-group">
                            <label for="ruc">Ruc:</label>
                            <input type="text" id="ruc" class="form-control" placeholder="Ingrese el Numero Ruc">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Telefono:</label>
                            <input type="number" id="telefono" class="form-control" placeholder="Ingrese el Telefono">
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección:</label>
                            <input type="text" id="direccion" class="form-control" placeholder="Ingrese la Dirección">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" class="form-control" placeholder="Ingrese el Correo Electronico">
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
    <!--Fin de modal de lotes--->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Configuración Empresa
            <button type="button" data-toggle="modal" data-target="#crear-empresa" class="btn bg-gradient-primary ml-2" id="boton-crear">Crear Empresa</button>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Configuración Empresa</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section>
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-body">
                    <div id ="empresa" class="row d-flex align-items-stretch">

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
<script src="../js/empresa.js"></script>