<?php
    include_once '../modelo/presentacion.php';

    $presentacion=new presentacion();
    
    if($_POST['funcion']=='crear'){
        $nombre=$_POST['nombre_presentacion'];
        $presentacion->crear($nombre);
    }
    if($_POST['funcion']=='buscar'){
        $presentacion->buscar();
        $json=array();
        foreach ($presentacion->objetos as $objeto) {
            $json[]=array(
                'Id_presentacion'=>$objeto->id_presentacion,
                'nombre'=>$objeto->presentacion
            );
        }
        $jsonsting=json_encode($json);
        echo $jsonsting;
    }
    if($_POST['funcion']=='actualizar'){
        $nombre=$_POST['nombre_presentacion'];
        $id_editado=$_POST['id_editado'];
        $presentacion->editar($nombre,$id_editado);
    }
    if($_POST['funcion']=='borrar'){
        $id=$_POST['id'];            
        $presentacion->borrar($id);
    }
    if($_POST['funcion']=='rellenar_presentaciones'){
        $presentacion->rellenar_presentacion();
        $json=array();
        foreach($presentacion->objetos as $objeto){
            $json[]=array(
                'Id_presentacion'=>$objeto->id_presentacion,
                'nombre'=>$objeto->presentacion
            );
        }
        $jsonsting=json_encode($json);
        echo $jsonsting;
    }
?>