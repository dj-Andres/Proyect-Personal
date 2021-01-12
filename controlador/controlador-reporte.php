<?php
    include_once '../modelo/producto.php';
    if($_POST['funcion']=='reporte'){
        require('../lib/pdf/mpdf.php');
        $html='<h1>Hola mundo</h1>';

        $mpdf=new mPDF('c','A4');
        $css=file_get_contents('../css/bootstrap.min.css');
        $mpdf->writeHTML($css,1);
        $mpdf->writeHTML($html,2);
        $mpdf->Output("../pdf-".$_POST['funcion'].".pdf","F");
    }   
?>