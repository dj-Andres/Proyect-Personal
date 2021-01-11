<?php

    include_once '../modelo/usuario.php';

    $usuario=new usuario();

    if($_POST['funcion']=='recuperar_clave') {
        $cedula=$_POST['cedula'];
        $correo=$_POST['correo'];

        $usuario->recuperar_clave($cedula,$correo);
    }
    
    if($_POST['funcion']=='generar') {
        $cedula=$_POST['cedula'];
        $correo=$_POST['correo'];

        $codigo=generar(10);

        $usuario->reemplazar($codigo,$correo,$cedula);
    }

    function generar($longitud){
        $key="";
        $patron="1234567890abcdefghijklnñmopqrszws";
        $max=strlen($patron)-1;

        for ($i=0; $i < $longitud ; $i++) { 
            $key.=$patron{mt_rand(0,$max)};
        }

        return $key;

    }
    

?>