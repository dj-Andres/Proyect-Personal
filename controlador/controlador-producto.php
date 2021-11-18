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
        <header class="clearfix">
            <h1>Reporte de Productos</h1>
            <div id="company" class="clearfix">
                <div>SofaCount SA</div>
                <div>Machala</div>
                <div>0992294343</div>
                <div>
                    <a href="mailto:sofacount@info.com">sofacount@info.com</a>
                </div>
            </div>
            <div id="project">
                <div><span>Fecha </span> ' . $fecha . '</div>
            </div>
        </header>
        <table>
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th class="service">Nombre</th>
                                <th class="service">Concentración</th>
                                <th class="desc">Adicional</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th class="desc">Tipo</th>
                                <th class="desc">Presentación</th>
                                <th class="desc">Laboratorio</th>
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
                            <th>' . $contador . '</th>
                            <td class="service">' . $objeto->nombre . '</td>
                            <td class="service">' . $objeto->concentracion . '</td>
                            <td class="desc">' . $objeto->adicional . '</td>
                            <td class="unit">' . $objeto->precio . '</td>
                            <td class="qty">' . $total . '</td>
                            <td class="desc">' . $objeto->tipo . '</td>
                            <td class="desc">' . $objeto->presentacion . '</td>
                            <td class="desc">' . $objeto->laboratorio . '</td>
                        </tr>';
    }
    $html .= '</tbody>
        </table>
        <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
    <footer>
      La información presentada se basa a los productos almacenados en la empresa.
    </footer>
        ';
    $mpdf = new \Mpdf\Mpdf();
    $css = file_get_contents("../css/reporte.css");
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("../pdf/pdf-" . $_POST['funcion'] . ".pdf", "F");
}
if ($_POST['funcion'] == 'reporte_excel') {
    date_default_timezone_set('America/Guayaquil');
    $fecha = date('Y-m-d H:i:s');

    $producto->reporte_producto();

    $row = 4;

    $documento = new Spreadsheet();

    $documento->getProperties()
        ->setCreator('Pharmacy System')
        ->setTitle('Reporte de Productos');

    $documento->setActiveSheetIndex(0);
    $excel = $documento->getActiveSheet()
        ->setTitle('Reporte Productos')
        ->mergeCells('A1:C1')
        ->mergeCells('D1:F1')
        ->setCellValue('A1', 'Reporte de Ventas')
        ->setCellValue('D1', 'Fecha  ' . $fecha);

    $excel->getStyle('A1:D1')->getFont()->setBold(true)->setSize(12);

    $excel = $documento->getActiveSheet()
        ->setCellValue('A3', 'Nombre')
        ->setCellValue('B3', 'Concentración')
        ->setCellValue('C3', 'Adicional')
        ->setCellValue('D3', 'Precio')
        ->setCellValue('E3', 'Tipo')
        ->setCellValue('F3', 'Presentacion')
        ->setCellValue('G3', 'Laboratorio');

    $excel->getStyle('A3:G3')->getFont()->setBold(true)->setSize(12);

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

    $excel->getStyle('A' . $row . '')->getAlignment()->setHorizontal('center');
    $excel->getStyle('B' . $row . '')->getAlignment()->setHorizontal('center');
    $excel->getStyle('C' . $row . '')->getAlignment()->setHorizontal('center');
    $excel->getStyle('D' . $row . '')->getAlignment()->setHorizontal('center');
    $excel->getStyle('E' . $row . '')->getAlignment()->setHorizontal('center');
    $excel->getStyle('F' . $row . '')->getAlignment()->setHorizontal('center');
    $excel->getStyle('G' . $row . '')->getAlignment()->setHorizontal('center');

    $nombreDelDocumento = "reporte_productos.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
    header('Cache-Control: max-age=0');

    $writter = new Xlsx($documento);
    $writter->save('../excel/reporte_producto.xlsx');
}
