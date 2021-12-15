<?php

    include_once '../modelo/tipo.php';

    $tipo=new tipo();

    if($_POST['funcion']=='crear'){
        $nombre=$_POST['nombre_tipo'];
        $tipo->crear($nombre);
    }
    if($_POST['funcion']=='buscar'){
        $tipo->buscar();
        $json=array();
        foreach ($tipo->objetos as $objeto) {
            $json[]=array(
                'Id_tipo'=>$objeto->id_tipo_producto,
                'nombre'=>$objeto->nombre_tipo
            );
        }
        $jsonsting=json_encode($json);
        echo $jsonsting;
    }
    if($_POST['funcion']=='actualizar'){
        $nombre=$_POST['nombre_tipo'];
        $id_editado=$_POST['id_editado'];
        $tipo->editar($nombre,$id_editado);
    }
    if($_POST['funcion']=='borrar'){
        $id=$_POST['id'];
        $tipo->borrar($id);
    }
    if($_POST['funcion']=='rellenar_tipos'){
        $tipo->rellenar_tipo();
        $json=array();
        foreach($tipo->objetos as $objeto){
            $json[]=array(
                'Id_tipo'=>$objeto->id_tipo_producto,
                'nombre'=>$objeto->nombre_tipo
            );
        }
        $jsonsting=json_encode($json);
        echo $jsonsting;
    }
