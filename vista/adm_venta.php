<?php
session_start();
if($_SESSION['us_tipo']==3 || $_SESSION['us_tipo']==1){
    include_once 'layout/header.php';
?>
  <title>Proyect|Gestión de ventas</title>

    <?php 
        include_once 'layout/nav.php';
    ?>
    
    <div class="modal fade" id="vista_venta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Registro de Ventas</h3>
                    <button class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                      <label for="codigo_venta">Codigo Venta</label>
                      <span id="codigo_venta"></span>
                    </div>
                    <div class="form-group">
                      <label for="Fecha">Fecha</label>
                      <span id="Fecha"></span>
                    </div>
                    <div class="form-group">
                      <label for="cliente">Cliente</label>
                      <span id="cliente"></span>
                    </div>
                    <div class="form-group">
                      <label for="cedula">Cedula</label>
                      <span id="cedula"></span>
                    </div>
                    <div class="form-group">
                      <label for="vendedor">Vendedor</label>
                      <span id="vendedor"></span>
                    </div>
                    <table class="table table-hover text-nowrap">
                      <thead class="table-success">
                        <tr>
                          <th>Cantidad</th>
                          <th>Precio</th>
                          <th>Producto</th>
                          <th>Concentración</th>
                          <th>Adicional</th>
                          <th>Laboratorio</th>
                          <th>Presentación</th>
                          <th>Tipo</th>
                          <th>Subtotal</th>
                        </tr>
                      </thead>
                      <tbody class="table-warning" id="registros">
                        
                      </tbody>
                    </table>
                    <div class="float-right input-group-append">
                      <h3 class="m-3">Total:</h3>
                      <h3 class="m-3" id="total"></h3>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-secondary float-rigth m-1" type="button" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestión de Ventas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Gestión de Ventas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section>
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Consultas</h3>
                </div>
                <div class="card-body">
                  <div class="row">
                      <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                          <div class="inner">
                            <h3 id="venta_dia_vendedor"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">0</font></font></h3>

                            <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Venta del dia por Vendedor</font></font></p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-user"></i>
                          </div>
                          <a href="#" class="small-box-footer"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Más información </font></font><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                      <!-- ./col -->
                      <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                          <div class="inner">
                            <h3 id="venta_diaria"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">0</font></font></h3>

                            <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Venta Diaria</font></font></p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-shopping-bag"></i>
                          </div>
                          <a href="#" class="small-box-footer"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Más información </font></font><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                      <!-- ./col -->
                      <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                          <div class="inner">
                            <h3 id="venta_mensual"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">0</font></font></h3>

                            <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Venta Mensual</font></font></p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                          </div>
                          <a href="#" class="small-box-footer"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Más información </font></font><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                      <!-- ./col -->
                      <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                          <div class="inner">
                            <h3 id="venta_anual"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">0</font></font></h3>

                            <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Venta Anual</font></font></p>
                          </div>
                          <div class="icon">
                            <i class="fas fa-signal"></i>
                          </div>
                          <a href="#" class="small-box-footer"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Más información </font></font><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                      </div>
                      <!-- ./col -->
                  </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section>
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Buscar Ventas</h3>
                </div>
                <div class="card-body">
                    <table id="tabla_venta" class="display table table-hover text-nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Fecha de Venta</th>
                                <th>Cliente</th>
                                <th>Cedula</th>
                                <th>Total</th>
                                <th>Vendedor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
<script src="../js/datatables.js"></script>
<script src="../js/ventas.js"></script>