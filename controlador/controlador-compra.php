<?php
    include '../modelo/venta.php';
    include_once '../modelo/conexion.php';

    $venta=new ventas();

    session_start();
    $vendedor=$_SESSION['usuario'];

    if($_POST['funcion']=='registrar_compra'){
        $total=$_POST['total'];
        $nombre=$_POST['nombre'];
        $cedula=$_POST['cedula'];
        $productos=json_decode($_POST['json']);
        print_r($productos);
        date_default_timezone_set('America/Guayaquil');
        $fecha=date('Y-m-d H:i:s');

        $venta->crear($nombre,$cedula,$total,$fecha,$vendedor);

        $venta->ultima_venta();

        foreach ($venta->objetos as $objeto) {
            $id_venta=$objeto->ultima_venta;
            echo $id_venta;
        }

        try {
            $db=new conexion();
            $con=$db->pdo;
            $con->beginTransaction();
            foreach ($productos as $prod) {
                $cantidad=$prod->cantidad;
                while ($cantidad!=0) {
                    $sql="SELECT * FROM lote WHERE vencimiento = (SELECT MIN(vencimiento) FROM lote WHERE lote_Id_prod=:id) AND lote_Id_prod=:id";
                    $query=$con->prepare($sql);
                    $query->execute(array(':id'=>$prod->id));
                    $lote=$query->fetchall();
                    foreach ($lote as $lote) {
                        if($cantidad < $lote->stock){
                            $sql="INSERT INTO detalle_venta (det_cantidad,det_vencimiento,Id_det_lote,Id_det_prod,Id_det_prov,Id_det_venta)VALUES('$cantidad','$lote->vencimiento','$lote->id_lote','$prod->id','$lote->lote_Id_prov','$id_venta')";
                            $con->exec($sql);
                            $con->exec("UPDATE lote SET stock=stock-'$cantidad' WHERE id_lote=:'$lote->id_lote'");
                            $cantidad=0;
                        }
                        if($cantidad == $lote->stock){
                            $sql="INSERT INTO detalle_venta (det_cantidad,det_vencimiento,Id_det_lote,Id_det_prod,Id_det_prov,Id_det_venta)VALUES('$cantidad','$lote->vencimiento','$lote->id_lote','$prod->id','$lote->lote_Id_prov','$id_venta')";
                            $con->exec($sql);
                            $con->exec("DELETE FROM lote  WHERE id_lote=:'$lote->id_lote'");
                            $cantidad=0;
                        }
                        if($cantidad > $lote->stock){
                            $sql="INSERT INTO detalle_venta (det_cantidad,det_vencimiento,Id_det_lote,Id_det_prod,Id_det_prov,Id_det_venta)VALUES('$lote->stock','$lote->vencimiento','$lote->id_lote','$prod->id','$lote->lote_Id_prov','$id_venta')";
                            $con->exec($sql);
                            $con->exec("DELETE FROM lote  WHERE id_lote=:'$lote->id_lote'");
                            $cantidad=$cantidad-$lote->stock;
                        }
                        
                    }
                }
                $subtotal=$prod->cantidad*$prod->precio;
                $con->exec("INSERT INTO venta_producto(cantidad,precio,subtotal,producto_Id_producto,venta_Id_venta)VALUES('$prod->cantidad','$prod->precio','$subtotal','$prod->id','$id_venta')");
                $con->commit();
            }

        } catch (Exception $error) {
            //roll se usa para analuar la transaccion tras un error
            $con->rollBack();
            $venta->borrar($id_venta);
            echo $error->getMessage();
        }
    }

?>