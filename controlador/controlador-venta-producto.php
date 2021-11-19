<?php
include '../modelo/ventaProducto.php';
include_once '../modelo/venta.php';
require '../vendor/autoload.php';
session_start();
$id_usuario = $_SESSION['usuario'];

$venta = new ventas();
$venta_Producto = new ventaProducto();

if ($_POST['funcion'] == 'ver') {
    $id = $_POST['id'];

    $venta_Producto->ver($id);

    $json = array();

    foreach ($venta_Producto->objetos as $objeto) {
        $json[] = $objeto;
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
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
