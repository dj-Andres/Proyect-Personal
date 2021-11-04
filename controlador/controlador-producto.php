<?php
include_once '../modelo/producto.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require '../vendor/autoload.php';

$producto = new producto();

if ($_POST['funcion'] == 'crear') {
    $nombre = $_POST['nombre'];
    $concentracion = $_POST['concentracion'];
    $adicional = $_POST['adicional'];
    $precio = $_POST['precio'];
    $laboratorio = $_POST['laboratorio'];
    $tipo = $_POST['tipo'];
    $presentacion = $_POST['presentacion'];
    $avatar = 'producto.png';
    $producto->crear($nombre, $concentracion, $adicional, $precio, $avatar, $laboratorio, $tipo, $presentacion);
}
if ($_POST['funcion'] == 'buscar') {
    $json = array();
    $producto->buscar();
    foreach ($producto->objetos as $objeto) {
        $producto->obtener_stock($objeto->id_producto);
        foreach ($producto->objetos as $key) {
            $total = $key->total;
        }
        $json[] = array(
            'Id_producto' => $objeto->id_producto,
            'nombre' => $objeto->nombre,
            'concentracion' => $objeto->concentracion,
            'adicional' => $objeto->adicional,
            'precio' => $objeto->precio,
            'stock' => $total,
            'laboratorio' => $objeto->laboratorio,
            'Id_laboratorio' => $objeto->id_laboratorio,
            'tipo' => $objeto->tipo,
            'Id_tipo' => $objeto->id_tipo_producto,
            'presentacion' => $objeto->presentacion,
            'Id_presentacion' => $objeto->id_presentacion,
            'avatar' => '../img/producto/' . $objeto->avatar
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if ($_POST['funcion'] == 'buscar_id') {
    $id_producto = $_POST['id_producto'];
    $producto->buscarId($id_producto);
    $json = array();
    foreach ($producto->objetos as $objeto) {
        $producto->obtener_stock($objeto->id_producto);
        foreach ($producto->objetos as $obj) {
            $total = $obj->total;
        }
        $json[] = array(
            'Id_producto' => $objeto->id_producto,
            'nombre' => $objeto->nombre,
            'concentracion' => $objeto->concentracion,
            'adicional' => $objeto->adicional,
            'precio' => $objeto->precio,
            'stock' => $total,
            'laboratorio' => $objeto->laboratorio,
            'Id_laboratorio' => $objeto->id_laboratorio,
            'tipo' => $objeto->tipo,
            'Id_tipo' => $objeto->id_tipo_producto,
            'presentacion' => $objeto->presentacion,
            'Id_presentacion' => $objeto->id_presentacion,
            'avatar' => '../img/producto/' . $objeto->avatar
        );
    }
    $jsonsting = json_encode($json[0]);
    echo $jsonsting;
}
if ($_POST['funcion'] == 'editar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $concentracion = $_POST['concentracion'];
    $adicional = $_POST['adicional'];
    $precio = $_POST['precio'];
    $laboratorio = $_POST['laboratorio'];
    $tipo = $_POST['tipo'];
    $presentacion = $_POST['presentacion'];

    $producto->editar($id, $nombre, $concentracion, $adicional, $precio, $laboratorio, $tipo, $presentacion);
}
if ($_POST['funcion'] == 'cambiar_avatar') {
    $id = $_POST['id_logo_prod'];
    $avatar = $_POST['avatar'];
    if (($_FILES['foto']['type'] == 'image/jpeg') || ($_FILES['foto']['type'] == 'image/png') || ($_FILES['foto']['type'] == 'image/gif')) {
        $nombre_foto = uniqid() . '-' . $_FILES['foto']['name'];
        $ruta = '../img/producto/' . $nombre_foto;
        move_uploaded_file($_FILES['foto']['tmp_name'], $ruta);
        $producto->cambiar_logo($id, $nombre_foto);
        foreach ($producto->objetos as $objeto) {
            if ($avatar != '../img/producto.png') {
                unlink('../img/producto/' . $objeto->avatar);
            }
        }
        $json = array();
        $json[] = array(
            'ruta' => $ruta,
            'alert' => 'editado'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    } else {
        $json = array();
        $json[] = array(
            'alert' => 'no-editado'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }
}
if ($_POST['funcion'] == 'borrar') {
    $id = $_POST['id'];
    $producto->borrar($id);
}
if ($_POST['funcion'] == 'verificar_stock') {
    $error = 0;
    $productos = json_decode($_POST['productos']);

    foreach ($productos as $objeto) {
        $producto->obtener_stock($objeto->id);
        foreach ($producto->objetos as $obj) {
            $total = $obj->total;
        }

        if ($total >= $objeto->cantidad && $objeto->cantidad > 0) {
            $error = $error + 0;
        } else {
            $error = $error + 1;
        }
    }

    echo $error;
}
if ($_POST['funcion'] == 'reporte') {
    date_default_timezone_set('America/Guayaquil');
    $fecha = date('Y-m-d H:i:s');

    $html = '
        <header>
            <div>
                <img src="../img/LogoSample_ByTailorBrands.jpg" width="90" height="90" style:"text-align:center;">
            </div>
            <h1 style="text-align:center;">Reportes de Productos</h1>
            <div>
                <div>
                    <span>Fecha y Hora</span>' . $fecha . '
                </div>
            </div>
        </header>
        <br>
        <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Concentración</th>
                                <th scope="col">Adicional</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Presentación</th>
                                <th scope="col">Laboratorio</th>
                            </tr>
                        </thead>
                        <tbody>';
    $producto->reporte_producto();
    $contador = 0;
    foreach ($producto->objetos as $objeto) {
        $contador++;

        $producto->obtener_stock($objeto->id_producto);
        foreach ($producto->objetos as $key) {
            $total = $key->total;
        }

        $html .= '

                        <tr>
                            <th scope="row">' . $contador . '</th>
                            <td>' . $objeto->nombre . '</td>
                            <td>' . $objeto->concentracion . '</td>
                            <td>' . $objeto->adicional . '</td>
                            <td>' . $objeto->precio . '</td>
                            <td>' . $total . '</td>
                            <td>' . $objeto->tipo . '</td>
                            <td>' . $objeto->presentacion . '</td>
                            <td>' . $objeto->laboratorio . '</td>
                        </tr>';
    }
    $html .= '</tbody>
        </table>';
    $mpdf = new \Mpdf\Mpdf();
    //$css=file_get_contents("../css/bootstrap.min.css");
    //$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("../pdf/pdf-" . $_POST['funcion'] . ".pdf", "F");
}
if ($_POST['funcion'] == 'reporte_excel') {

    $producto->reporte_producto();

    $row = 2;

    $documento = new Spreadsheet();

    $excel = $documento->getActiveSheet();

    $excel->setCellValue('A1', 'Nombre');
    $excel->setCellValue('B1', 'Concentracion');
    $excel->setCellValue('C1', 'Adicional');
    $excel->setCellValue('D1', 'Precio');
    $excel->setCellValue('E1', 'Tipo');
    $excel->setCellValue('F1', 'Presentacion');
    $excel->setCellValue('G1', 'Laboratorio');

    foreach ($producto->objetos as $objeto) {
        $excel->setCellValue('A' . $row, $objeto->nombre);
        $excel->setCellValue('B' . $row, $objeto->concentracion);
        $excel->setCellValue('C' . $row, $objeto->adicional);
        $excel->setCellValue('D' . $row, $objeto->precio);
        $excel->setCellValue('E' . $row, $objeto->tipo);
        $excel->setCellValue('F' . $row, $objeto->presentacion);
        $excel->setCellValue('G' . $row, $objeto->laboratorio);

        $row++;
    }

    $nombreDelDocumento = "reporte_productos.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
    header('Cache-Control: max-age=0');

    $writter = new Xlsx($documento);
    $writter->save('../excel/reporte_producto.xlsx');
}
