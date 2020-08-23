<?php
session_start();
if($_SESSION['us_tipo']==3){
    include_once 'layout/header.php';
?>
  <title>Proyect|Gestión Lote</title>

    <?php 
        include_once 'layout/nav.php';
    ?>
    <div class="modal fade" id="editar-lote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Editar Lote</h3>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <!--ALERTAS-->
                    <div class="alert alert-success text-center" id="edit-lote" style="display:none;">
                        <span><i class="fas fa-check m-1"></i>Se actualizo exitosamente el lote al producto</span>
                    </div>
                    <!--FIN-ALERTAS-->
                    <form id="form-editar-lote">
                        <div class="form-group">
                            <label for="codigo_lote">Codigo lote:</label>
                            <label id="codigo_lote"></label>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock:</label>
                            <input type="number" id="stock" class="form-control" placeholder="Ingrese el stock">
                        </div>
                        <input type="hidden" id="id_editar_lote">
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
            <h1>Gestión de lotes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Gestión de lotes</li>
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
                    <h3 class="card-title">Buscar lotes</h3>
                    <div class="input-group">
                        <input type="text" class="form-control fload-left" id="buscar-lote" placeholder="Ingrese el nombre del producto">
                        <div class="input-group-append">
                            <button class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id ="lotes" class="row d-flex align-items-stretch">

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
<script src="../js/lote.js"></script>