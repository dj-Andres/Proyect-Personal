<?php
include_once '../modelo/producto.php';

$producto = new producto();

if (isset($_POST['funcion']) && $_POST['funcion'] == 'crear') {
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
if (isset($_POST['funcion']) && ($_POST['funcion'] == 'buscar')) {
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
if (isset($_POST['funcion']) && ($_POST['funcion'] == 'buscar_id')) {
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
if (isset($_POST['funcion']) && ($_POST['funcion'] == 'editar')) {
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
if (isset($_POST['funcion']) && ($_POST['funcion'] == 'cambiar_avatar')) {
    echo "hola";
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
        $json = [];
        $json[] = [            
            'ruta' => $ruta,
            'alert' => 'editado'
        ];
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
if (isset($_POST['funcion']) && ($_POST['funcion'] == 'borrar')) {
    $id = $_POST['id'];
    $producto->borrar($id);
}
if (isset($_POST['funcion']) && ($_POST['funcion'] == 'verificar_stock')) {
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
