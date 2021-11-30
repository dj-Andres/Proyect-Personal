<?php
include_once '../modelo/producto.php';
include '../modelo/ventaProducto.php';
include '../modelo/venta.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



$producto = new producto();
$venta = new ventas();
$venta_Producto = new ventaProducto();

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

if ($_POST['funcion'] == 'reporte-venta') {
    $id = $_POST['id'];

    date_default_timezone_set('America/Guayaquil');
    $fecha = date('Y-m-d H:i:s');

    $html = '
        <header class="clearfix">
            <h1>Factura de Venta</h1>
            <div id="company" class="clearfix">
                <div>SofaCount SA</div>
                <div>Machala</div>
                <div>0992294343</div>
                <div>
                    <a href="mailto:sofacount@info.com">sofacount@info.com</a>
                </div>
            </div>
            <div id="project">';
    $venta->reporte_ventas($id);
    foreach ($venta->objetos as $objeto) {
        $html .= '<div><span>Codigo Venta  </span>' . $objeto->id_venta . ' </div>
                <div><span>Cliente  </span> ' . $objeto->cliente . ' </div>
                <div><span>Vendedor </span> ' . $objeto->vendedor . ' </div>
                <div><span>Fecha </span> ' . $fecha . '</div>';
    }
    $html .= '</div>
        </header>
        <table>
                        <thead>
                            <tr>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th class="desc">Producto</th>
                                <th class="service">Concentración</th>
                                <th class="desc">Adicional</th>
                                <th class="desc">Laboratorio</th>
                                <th class="desc">Presentación</th>
                                <th class="desc">Tipo</th>
                                <th>SubTotal</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>';
    $venta_Producto->ver($id);
    foreach ($venta_Producto->objetos as $objeto) {
        $html .= '

                        <tr>
                            <th>' . $objeto->cantidad . '</th>
                            <td class="unit">' . $objeto->precio . '</td>
                            <td class="service">' . $objeto->producto . '</td>
                            <td class="service">' . $objeto->concentracion . '</td>
                            <td class="service">' . $objeto->adicional . '</td>
                            <td class="desc">' . $objeto->laboratorio . '</td>
                            <td class="desc">' . $objeto->presentacion . '</td>
                            <td class="desc">' . $objeto->tipo . '</td>
                            <td>' . $objeto->subtotal . '</td>
                            <td class="total">' . $objeto->cantidad + $objeto->subtotal . '</td>
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
