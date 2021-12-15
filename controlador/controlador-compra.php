<?php
include '../modelo/venta.php';
include_once '../modelo/conexion.php';
require '../vendor/autoload.php';

use Twilio\Rest\Client;

$venta = new ventas();

session_start();
$vendedor = $_SESSION['usuario'];

if ($_POST['funcion'] == 'registar_compra') {
    $total = $_POST['total'];
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $productos = json_decode($_POST['json']);


    date_default_timezone_set('America/Guayaquil');
    $fecha = date('Y-m-d H:i:s');

    $venta->crear($nombre, $cedula, $total, $fecha, $vendedor);

    $venta->ultima_venta();

    foreach ($venta->objetos as $objeto) {
        $id_venta = $objeto->ultima_venta;
    }

    try {
        $db = new conexion();
        $conexion = $db->pdo;
        $conexion->beginTransaction();
        foreach ($productos as $prod) {
            $cantidad = $prod->cantidad;
            while ($cantidad != 0) {
                $sql = "SELECT * FROM lote WHERE vencimiento = (SELECT MIN(vencimiento) FROM lote WHERE lote_Id_prod=:id) AND lote_Id_prod=:id";
                $query = $conexion->prepare($sql);
                $query->execute(array(':id' => $prod->id));
                $lote = $query->fetchall();
                foreach ($lote as $lote) {
                    if ($cantidad < $lote->stock) {
                        $sql = "INSERT INTO detalle_venta (det_cantidad,det_vencimiento,Id_det_lote,Id_det_prod,lote_Id_prov,Id_det_venta)
                                                        VALUES('$cantidad','$lote->vencimiento','$lote->id_lote','$prod->id','$lote->lote_id_prov','$id_venta')";
                        $conexion->exec($sql);
                        $conexion->exec("UPDATE lote SET stock=stock-'$cantidad' WHERE id_lote='$lote->id_lote'");
                        $cantidad = 0;
                    }
                    if ($cantidad == $lote->stock) {
                        $sql = "INSERT INTO detalle_venta (det_cantidad,det_vencimiento,Id_det_lote,Id_det_prod,lote_Id_prov,Id_det_venta)
                                                        VALUES('$cantidad','$lote->vencimiento','$lote->id_lote','$prod->id','$lote->lote_id_prov','$id_venta')";
                        $conexion->exec($sql);
                        $conexion->exec("DELETE FROM lote  WHERE id_lote='$lote->id_lote'");
                        $cantidad = 0;
                    }
                    if ($cantidad > $lote->stock) {
                        $sql = "INSERT INTO detalle_venta (det_cantidad,det_vencimiento,Id_det_lote,Id_det_prod,lote_Id_prov,Id_det_venta)
                                                        VALUES('$lote->stock','$lote->vencimiento','$lote->id_lote','$prod->id','$lote->lote_id_prov','$id_venta')";
                        $conexion->exec($sql);
                        $conexion->exec("DELETE FROM lote  WHERE id_lote='$lote->id_lote'");
                        $cantidad = $cantidad - $lote->stock;
                    }
                }
            }
            $subtotal = $prod->cantidad * $prod->precio;
            $conexion->exec("INSERT INTO venta_producto(cantidad,precio,subtotal,producto_Id_producto,venta_Id_venta)VALUES('$prod->cantidad','$prod->precio','$subtotal','$prod->id','$id_venta')");
            $conexion->commit();
            sendSMS($nombre, $fecha, $subtotal);
        }
    } catch (Exception $error) {
        $conexion->rollBack();
        $venta->borrar($id_venta);
        echo $error->getMessage();
    }
}

function sendSMS(string $name, string $date, float $total)
{
    $account_sid = "ACe2e3efc92c8272119799e9dec36d0e67";
    $auth_token = "dfcbe2db24c1e7e69d40bae399d799c5";
    $twilio_number = "+12182506139";

    $client = new Client($account_sid, $auth_token);
    $client->messages->create('+593992294342', [
        'from' => $twilio_number,
        'body' => $name . ' ha realizado una compra con la fecha ' . $date . ' y tuvo un total de pagar de ' . $total . 'Gracias por su compra esperamos su pronto regreso'
    ]);
}
