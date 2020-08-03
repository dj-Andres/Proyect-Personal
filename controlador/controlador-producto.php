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
        $producto->crear($nombre,$concentracion,$adicional,$precio,$avatar,$laboratorio,$tipo,$presentacion);
    }
    if ($_POST['funcion']=='buscar') {
        $json=array();
        $producto->buscar();
        foreach($producto->objetos as $objeto){
            $json[]=array(
                'Id_producto'=>$objeto->id_producto,
                'nombre'=>$objeto->nombre,
                'concentracion'=>$objeto->concentracion,
                'adicional'=>$objeto->adicional,
                'precio'=>$objeto->precio,
                //'stock'=>'stock',
                'laboratorio'=>$objeto->laboratorio,
                'tipo'=>$objeto->tipo,
                'presentacion'=>$objeto->presentacion,
                'avatar'=>'../img/'.$objeto->avatar
            );
        }
            $jsonstring=json_encode($json);
            echo $jsonstring;
    }
?>