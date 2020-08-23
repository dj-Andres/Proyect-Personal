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
            date_default_timezone_set('America/Guayaquil');
            $lote->buscar();
            $fecha_actual=new DateTime();
            foreach ($lote->objetos as $objeto) {
                $vencimiento=new DateTime($objeto->vencimiento);
                $diferencia=$vencimiento->diff($fecha_actual);
                $mes=$diferencia->m;
                $dia=$diferencia->d;
                $verificado=$diferencia->invert;
                if($verificado==0){
                    $estado='secondary';
                }else{
                    if($mes>3){
                    $estado='ligth';
                    }
                    if($mes<=3){
                    $estado='warning';
                    }
                }
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
                    'mes'=>$mes,
                    'dia'=>$dia,
                    'estado'=>$estado,
                    'invert'=>$verificado
                );   
            }
            $jsonsting=json_encode($json);
            echo $jsonsting;
        }
        if($_POST['funcion']=='editar'){
            $id_lote=$_POST['id_lote'];
            $stock=$_POST['stock'];
            $lote->editar($id_lote,$stock);
        }
        if($_POST['funcion']=='borrar'){
            $id_lote=$_POST['id'];
            $lote->borrar($id_lote);
        }
?>