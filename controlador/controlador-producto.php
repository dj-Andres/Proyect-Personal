<?php 
    include_once '../modelo/producto.php';

    $producto=new producto();

    if($_POST['funcion']=='crear'){
        $nombre=$_POST['nombre'];
        $concentracion=$_POST['concentracion'];
        $adicional=$_POST['adicional'];
        $precio=$_POST['precio'];
        $laboratorio=$_POST['laboratorio'];
        $tipo=$_POST['tipo'];
        $presentacion=$_POST['presentacion'];
        $avatar='producto.png';
        $producto->crear($nombre,$concentracion,$adicional,$precio,$laboratorio,$tipo,$presentacion,$avatar);
    }
    if($_POST['funcion']=='buscar'){
        $producto->buscar();
        $json=array();
        foreach ($producto->objetos as $objeto) {
            $json[]=array(
                'Id_producto'=>$objeto->id_producto,
                'nombre'=>$objeto->nombre,
                'concentracion'=>$objeto->concentracion,
                'adicional'=>$objeto->adicional,
                'precio'=>$objeto->precio,
                //'stock'=>$total,
                'laboratorio'=>$objeto->laboratorio,
                'tipo'=>$objeto->tipo,
                'presentacion'=>$objeto->presentacion,
                'Id_laboratorio'=>$objeto->id_laboratorio,
                'Id_tipo'=>$objeto->id_tipo_producto,
                'Id_presentacion'=>$objeto->id_presentacion,
                'avatar'=>'../img/producto/'.$objeto->avatar
            );
        }
        $jsonsting=json_encode($json);
        echo $jsonsting;
    }
?>