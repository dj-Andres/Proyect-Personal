<?php 
  session_start();
  if($_SESSION['us_tipo']==1 || $_SESSION['us_tipo']==3 || $_SESSION['us_tipo']==2){
    include 'layout/header.php';
?>
<title>Proyect | Menú</title>
<?php 
  include 'layout/nav.php';
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Catalogo de Productos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section>
        <div class="container-fluid">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Lotes en riesgo</h3>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover text-nowrap">
                      <thead class="table-success">
                          <tr>
                            <th>Codigo de lote</th>
                            <th>Producto</th>
                            <th>Stock</th>
                            <th>Laboratorio</th>
                            <th>Presentación</th>
                            <th>Proveedor</th>
                            <th>Mes</th>
                            <th>Día</th>
                          </tr>
                      </thead>
                      <tbody id="lotes" class="table-active">

                      </tbody>
                    </table>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </section>

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
                    <div id ="productos" class="row d-flex align-items-stretch">

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
<script src="../js/catalogo.js"></script>
<script src="../js/carrito.js"></script>