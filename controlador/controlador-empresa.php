<?php

 include '../modelo/empresa.php';

 $empresa = new Empresa();

 if($_POST['funcion'] == 'crear'){
     $nombre = $_POST['name'];
     $ruc = $_POST['ruc_number'];
     $telefono = $_POST['phone'];
     $email = $_POST['email'];
     $direccion=$_POST['address'];

     $empresa->crear($nombre,$ruc,$telefono,$direccion,$email);
 }