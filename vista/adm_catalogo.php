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
            <h1 class="m-0 text-dark">Dashboard</h1>
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
    <div class="container">
       <input type="text" name="" id="" value="<?php echo $_SESSION['cedula'] ?>">
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php 
    include_once 'layout/footer.php';
    }else{
    header('Location:../index.php');
    }
?>
