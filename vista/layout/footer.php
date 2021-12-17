<footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.2-pre
    </div>
  </footer>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/adminlte.js"></script>
<script src="../js/demo.js"></script>
<script src="../js/sweetalert2.js"></script>
<script src="../js/select2.js"></script>
<script src="../js/toastr.min.js"></script>
<script>
  let funcion='devolver_avatar';
  $.post('../controlador/usuario-controlador.php',{funcion},(response)=>{
      const avatar=JSON.parse(response);
      $('#avatar4').attr('src','../img/'+avatar.avatar);
  })
  funcion='tipo_usuario';
  $.post('../controlador/usuario-controlador.php',{funcion},(response)=>{
      if(response==1){
        $('#gestion_lote').hide();
      }else if(response==2){
        $('#gestion_lote').hide();
        $('#gestion_usuario').hide();
        $('#gestion_producto').hide();
        $('#gestion_atributo').hide();
        $('#gestion_proveedor').hide();
      }
  })
</script>
</body>
</html>
