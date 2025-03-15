<?php
session_start();
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 3) {
    include_once 'layout/header.php';
?>
    <title>Pharmacy System|Gestión Productos</title>

    <?php
    include_once 'layout/nav.php';
    ?>
    <!---Modal para crear usuario-->
    <div class="modal fade" id="crear-producto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Crear Producto</h3>
                        <button class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <!--ALERTAS-->
                        <div class="alert alert-success text-center" id="crear" style="display:none;">
                            <span><i class="fas fa-check m-1"></i>Se creo exitosamento el producto</span>
                        </div>
                        <div class="alert alert-danger text-center" id="nocrear" style="display:none;">
                            <span><i class="fas fa-times m-1"></i>El producto ya existe</span>
                        </div>
                        <div class="alert alert-success text-center" id="editar" style="display:none;">
                            <span><i class="fas fa-check m-1"></i>Se actualizo correctamente</span>
                        </div>
                        <!--FIN-ALERTAS-->
                        <form id="form-crear-producto">
                            <div class="form-group">
                                <label for="nombre_producto">Nombre:</label>
                                <input id="nombre_producto" type="text" class="form-control" placeholder="Ingrese nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="concentracion">Concentración:</label>
                                <input id="concentracion" type="text" class="form-control" placeholder="Ingrese concentracion">
                            </div>
                            <div class="form-group">
                                <label for="adicional">Adicional:</label>
                                <input id="adicional" type="text" class="form-control" placeholder="Ingrese adicional">
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio:</label>
                                <input id="precio" type="number" step="any" class="form-control" placeholder="Ingrese precio" required value="1">
                            </div>
                            <div class="form-group">
                                <label for="laboratorio">Laboratorio:</label>
                                <select name="laboratorio" id="laboratorio" class="form-control select2" style="width:100%"></select>
                            </div>
                            <div class="form-group">
                                <label for="tipo_producto">Tipo Producto:</label>
                                <select name="tipo_producto" id="tipo_producto" class="form-control select2" style="width:100%"></select>
                            </div>
                            <div class="form-group">
                                <label for="presentacion">Presentación:</label>
                                <select name="presentacion" id="presentacion" class="form-control select2" style="width:100%"></select>
                            </div>
                            <input type="hidden" id="id_editar_producto">
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
    <!--Modal para agregar lotes-->
    <div class="modal fade" id="crear-lotes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Crear Lote</h3>
                        <button class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <!--ALERTAS-->
                        <div class="alert alert-success text-center" id="add" style="display:none;">
                            <span><i class="fas fa-check m-1"></i>Se agreggo exitosamente el lote al producto</span>
                        </div>
                        <!--FIN-ALERTAS-->
                        <form id="form-crear-lote">
                            <div class="form-group">
                                <label for="producto">Producto:</label>
                                <label id="producto-name">Nombre:</label>
                            </div>
                            <div class="form-group">
                                <label for="proveedor">Proveedor:</label>
                                <select name="proveedor" id="proveedor" class="form-control select2" style="width:100%"></select>
                            </div>
                            <div class="form-group">
                                <label for="stock">Stock:</label>
                                <input type="number" id="stock" class="form-control" placeholder="Ingrese el stock" value=1>
                            </div>
                            <div class="form-group">
                                <label for="stock">Fecha Vencimiento:</label>
                                <input type="date" id="vencimiento" class="form-control" placeholder="Ingrese la fecha de vencimiento">
                            </div>
                            <input type="hidden" id="id_lote_prod">
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
    <!--Modal para agregar reportes-->
    <div class="modal fade" id="reportes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Formato Reportes</h3>
                        <button class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body text-center">
                        <div class="form-group">
                            <button class="btn btn-outline-danger" id="boton_reporte">Formato PDF<i class="far fa-file-pdf ml-2"></i></button>
                            <button class="btn btn-outline-success" id="reporte_excel">Formato EXCEL<i class="far fa-file-excel ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Fin de modal de reportes--->
    <!---Final de modal de crear usuarios-->
    <!---Modal de cambiar el avatar-->
    <div class="modal fade" id="cambio-logo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar avatar del producto</h5>
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
                            <input type="file" class="input-group" name="foto">
                            <input type="hidden" name="funcion" value="cambiar_avatar">
                            <input type="hidden" name="id_logo_prod" id="id_logo_prod">
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
                        <h1>Gestión Producto
                            <button type="button" data-toggle="modal" data-target="#crear-producto" class="btn bg-gradient-primary ml-2" id="boton-crear">Crear Producto</button>
                            <button type="button" data-toggle="modal" data-target="#reportes" class="btn bg-gradient-success ml-2">Crear Reporte</button>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
                            <li class="breadcrumb-item active">Gestión de Producto</li>
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
                        <h3 class="card-title">Buscar producto</h3>
                        <div class="input-group">
                            <input type="text" class="form-control fload-left" id="buscar-producto" placeholder="Ingrese nombre del producto">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="productos" class="row d-flex align-items-stretch">

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
} else {
    header('Location:../index.php');
}
?>
<script src="../js/producto.js"></script>