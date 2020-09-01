<?php
    include '../modelo/ventaProducto.php';

    $venta_Producto=new ventaProducto();

    if($_POST['funcion']=='ver'){
        $id=$_POST['id'];
        
        $venta_Producto->ver($id);

        $json=array();
        
        foreach ($venta_Producto->objetos as $objeto) {
            $json[]=$objeto;
        }
        $jsonstring=json_encode($json);
        echo $jsonstring;
    }
?>