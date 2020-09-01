<?php
    include '../modelo/venta.php';
    $venta=new ventas();

    if($_POST['funcion']=='listar'){
        $venta->buscar();

       $json=array();
        
        foreach ($venta->objetos as $objeto) {
            $json['data'][]=$objeto;
        }
        $jsonstring=json_encode($json);
        echo $jsonstring;
    }

?>