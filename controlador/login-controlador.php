<?php
    include_once '../modelo/usuario.php';
    session_start();

    $usuario=$_POST['usuario'];
    $clave=$_POST['clave'];
    $model_usuario=new usuario();
    if(!empty($_SESSION['us_tipo'])){
        switch ($_SESSION['us_tipo']) {
            case '1':
                header('Location:../vista/adm_catalogo.php');
                break;
            
                case '2':
                    header('Location:../vista/adm_catalogo.php');
                break;
                
                case '3':
                    header('Location:../vista/adm_catalogo.php');
                break;
        }
    }else{
        $model_usuario->login($usuario,$clave);
        if(!empty($model_usuario->objetos)){
            foreach ($model_usuario->objetos as $objeto) {
                
                $_SESSION['us_tipo']=$objeto->us_tipo;
                $_SESSION['nombre']=$objeto->nombre;
                $_SESSION['cedula']=$objeto->cedula;
                $_SESSION['usuario']=$objeto->id_usuario;
            }
            switch ($_SESSION['us_tipo']) {
                case '1':
                    header('Location:../vista/adm_catalogo.php');
                    break;
                
                    case '2':
                        header('Location:../vista/adm_catalogo.php');
                    break;
                    
                    case '3':
                        header('Location:../vista/adm_catalogo.php');
                    break;
            }
        }else{
            header('Location:../index.php');
        }
    }
?>