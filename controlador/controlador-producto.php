<?php 
    include_once '../modelo/producto.php';

    $producto=new producto();

    if($_POST['funcion']=='crear'){
        $nombre=$_POST['nombre'];
        $concentracion=$_POST['concentracion'];
        $adicional=$_POST['adicional'];
        $precio=$_POST['precio'];
        $laboratorio=$_POST['laboratorio'];
        $tipo=$_POST['tipo'];
        $presentacion=$_POST['presentacion'];
        $avatar='producto.png';
        $producto->crear($nombre,$concentracion,$adicional,$precio,$avatar,$laboratorio,$tipo,$presentacion);
    }
    if ($_POST['funcion']=='buscar') {
        $json=array();
        $producto->buscar();
        foreach($producto->objetos as $objeto){
            $producto->obtener_stock($objeto->id_producto);
            foreach ($producto->objetos as $key) {
                $total=$key->total;
            }
            $json[]=array(
                'Id_producto'=>$objeto->id_producto,
                'nombre'=>$objeto->nombre,
                'concentracion'=>$objeto->concentracion,
                'adicional'=>$objeto->adicional,
                'precio'=>$objeto->precio,
                'stock'=>$total,
                'laboratorio'=>$objeto->laboratorio,
                'Id_laboratorio'=>$objeto->id_laboratorio,
                'tipo'=>$objeto->tipo,
                'Id_tipo'=>$objeto->id_tipo_producto,
                'presentacion'=>$objeto->presentacion,
                'Id_presentacion'=>$objeto->id_presentacion,
                'avatar'=>'../img/producto/'.$objeto->avatar
            );
        }
            $jsonstring=json_encode($json);
            echo $jsonstring;
    }
    if($_POST['funcion']=='buscar_id'){
        $id_producto=$_POST['id_producto'];
        $producto->buscarId($id_producto);
        $json=array();
        foreach ($producto->objetos as $objeto) {
            $producto->obtener_stock($objeto->id_producto);
            foreach($producto->objetos as $obj){
                $total=$obj->total;
            }
            $json[]=array(
                'Id_producto'=>$objeto->id_producto,
                'nombre'=>$objeto->nombre,
                'concentracion'=>$objeto->concentracion,
                'adicional'=>$objeto->adicional,
                'precio'=>$objeto->precio,
                'stock'=>$total,
                'laboratorio'=>$objeto->laboratorio,
                'Id_laboratorio'=>$objeto->id_laboratorio,
                'tipo'=>$objeto->tipo,
                'Id_tipo'=>$objeto->id_tipo_producto,
                'presentacion'=>$objeto->presentacion,
                'Id_presentacion'=>$objeto->id_presentacion,
                'avatar'=>'../img/producto/'.$objeto->avatar
            );
        }
        $jsonsting=json_encode($json[0]);
        echo $jsonsting;
    }
    if($_POST['funcion']=='editar'){
        $id=$_POST['id'];
        $nombre=$_POST['nombre'];
        $concentracion=$_POST['concentracion'];
        $adicional=$_POST['adicional'];
        $precio=$_POST['precio'];
        $laboratorio=$_POST['laboratorio'];
        $tipo=$_POST['tipo'];
        $presentacion=$_POST['presentacion'];

        $producto->editar($id,$nombre,$concentracion,$adicional,$precio,$laboratorio,$tipo,$presentacion);
    }
    if($_POST['funcion']=='cambiar_avatar'){
        $id=$_POST['id_logo_prod'];
        $avatar=$_POST['avatar'];
        //echo $id;
        if(($_FILES['foto']['type']=='image/jpeg') || ($_FILES['foto']['type']=='image/png') || ($_FILES['foto']['type']=='image/gif')){
            $nombre_foto=uniqid().'-'.$_FILES['foto']['name'];
            //echo $nombre_foto;
            //creamos una ruta//
            $ruta='../img/producto/'.$nombre_foto;
            move_uploaded_file($_FILES['foto']['tmp_name'],$ruta);
            $producto->cambiar_logo($id,$nombre_foto);
            foreach($producto->objetos as $objeto){
                if($avatar!='../img/producto.png'){
                    unlink('../img/producto/'.$objeto->avatar);
                }
            }
            $json=array();
            $json[]=array(
                  'ruta'=>$ruta,
                  'alert'=>'editado'
            );
            $jsonstring=json_encode($json[0]);
            echo $jsonstring;
          }else{
            $json=array();
            $json[]=array(
                 'alert'=>'no-editado'
            );
            $jsonstring=json_encode($json[0]);
            echo $jsonstring;
          }
        //echo $id;
    }
    if($_POST['funcion']=='borrar'){
        $id=$_POST['id'];            
        $producto->borrar($id);
    }
    if($_POST['funcion']=='verificar_stock'){
        $error=0;
        $productos=json_decode($_POST['productos']);

        foreach($productos as $objeto){
            $producto->obtener_stock($objeto->id);
            foreach($producto->objetos as $key){
                $total=$key->total;
            }

            if($total>=$objeto->cantidad && $objeto->cantidad>0){
                $error=$error+0;
            }else{
                $error+$error+1;
            }
        }

        echo $error;

    }
    if($_POST['funcion']=='reporte'){
        require('../lib/pdf/mpdf.php');
        $html='<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Concentración</th>
                            <th scope="col">Adicional</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Presentación</th>
                            <th scope="col">Laboratorio</th>
                        </tr>
                    </thead>';

        $producto->reporte_producto();
        foreach ($producto->objetos as $objeto) {
            $html.='
            <tbody>
                <tr>
                    <th scope="row">'.$objeto->nombre.'</th>
                    <td>'.$objeto->concentracion.'</td>
                    <td>'.$objeto->adicional.'</td>
                    <td>'.$objeto->precio.'</td>
                    <td>'.$objeto->tipo.'</td>
                    <td>'.$objeto->presentacion.'</td>
                    <td>'.$objeto->laboratorio.'</td>
                </tr>
            </tbody>
            </table>';
        }
        $mpdf=new mPDF('c','A4');
        $mpdf->SetDisplayMode('fullpage');
        //$css=file_get_contents('../css/bootstrap.min.css');
        //$mpdf->writeHTML($css,1);
        $mpdf->writeHTML($html);
        $mpdf->Output("../pdf/pdf-".$_POST['funcion'].".pdf","F");
    }
    if($_POST['funcion']=='reporte_excel'){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('America/Guayaquil');

        require('../lib/Classes/PHPExcel.php');
        $producto->reporte_producto();
        $row=2;
        $objetoExcel=new PHPExcel();

        $objetoExcel->getProperties()->setCreator("Diego Jimenez")->setDescription("Reporte Productos");
        $objetoExcel->setActiveSheetIndex(0);
        $objetoExcel->getActiveSheet()->setTitle("Productos");

        $objetoExcel->getActiveSheet()->setCellValue('A1','Nombre');
        $objetoExcel->getActiveSheet()->setCellValue('B1','Concentracion');
        $objetoExcel->getActiveSheet()->setCellValue('C1','Adicional');
        $objetoExcel->getActiveSheet()->setCellValue('D1','Precio');
        $objetoExcel->getActiveSheet()->setCellValue('E1','Tipo');
        $objetoExcel->getActiveSheet()->setCellValue('F1','Presentacion');
        $objetoExcel->getActiveSheet()->setCellValue('G1','Laboratorio');

        foreach ($producto->objetos as $objeto) {
            $objetoExcel->getActiveSheet()->setCellValue('A'.$row,$objeto->nombre);
            $objetoExcel->getActiveSheet()->setCellValue('B'.$row,$objeto->concentracion);
            $objetoExcel->getActiveSheet()->setCellValue('C'.$row,$objeto->adicional);
            $objetoExcel->getActiveSheet()->setCellValue('D'.$row,$objeto->precio);
            $objetoExcel->getActiveSheet()->setCellValue('E'.$row,$objeto->tipo);
            $objetoExcel->getActiveSheet()->setCellValue('F'.$row,$objeto->presentacion);
            $objetoExcel->getActiveSheet()->setCellValue('G'.$row,$objeto->laboratorio);

            $row++;
        }     

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	    header('Content-Disposition: attachment;filename="Productos.xlsx"');
        header('Cache-Control: max-age=0');
        
        $objWriter=PHPExcel_IOFactory::createWriter($objetoExcel,'Excel2007');
        $objWriter->save('php://output');
    }
?> 