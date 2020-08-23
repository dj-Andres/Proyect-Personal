<?php
    include_once '../modelo/lote.php';

        $lote=new lote();

        if($_POST['funcion']=='crear_stock'){
            $id_producto=$_POST['id_producto'];
            $proveedor=$_POST['proveedor'];
            $stock=$_POST['stock'];
            $vencimiento=$_POST['vencimiento'];
            $lote->crear($id_producto,$proveedor,$stock,$vencimiento);
        }
        if($_POST['funcion']=='buscar'){
            $lote->buscar();
            foreach ($lote->objetos as $objeto) {
                $json[]=array(
                    'Id_lote'=>$objeto->id_lote,
                    'stock'=>$objeto->stock,
                    'vencimiento'=>$objeto->vencimiento,
                    'concentracion'=>$objeto->concentracion,
                    'adicional'=>$objeto->adicional,
                    //'nombre'=>$prod_nombre,
                    'laboratorio'=>$objeto->nombre_laboratorio,
                    'presentacion'=>$objeto->presentacion,
                    'proveedor'=>$objeto->nombre_proveedor,
                    'avatar'=>'../img/producto/'.$objeto->logo,
                    //'mes'=>$mes,
                    //'dia'=>$dia,
                    //'estado'=>$estado
                    //'invert'=>$verificado
                );   
            }
            $jsonsting=json_encode($json);
            echo $jsonsting;
        }

?>