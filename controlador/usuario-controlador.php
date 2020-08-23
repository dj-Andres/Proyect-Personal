<?php
    include_once '../modelo/usuario.php';

    $usuario=new usuario();

    session_start();
    $Id_usuario=$_SESSION['cedula'];
    if ($_POST['funcion']=='buscar_usuario') {
        $json=array();
        date_default_timezone_set('America/Guayaquil');
        $fecha_actual=new DateTime();
        $usuario->obtener_datos($_POST['dato']);
        foreach($usuario->objetos as $objeto){
            $naciiento=new DateTime($objeto->edad);
            //comparacion de la fecha actual con la fecha de nacimiento//
            $edad=$naciiento->diff($fecha_actual);
            $edad_año=$edad->y;
            $json[]=array(
                //el ultimo nombre es la columna de la tabla usuario//
                    'nombre'=>$objeto->nombre,
                    'apellido'=>$objeto->apellido,
                    'edad'=>$edad_año,
                    'cedula'=>$objeto->cedula,
                    'tipo_usuario'=>$objeto->nombre_tipo,
                    'telefono'=>$objeto->telefono,
                    'residencia'=>$objeto->residencia,
                    'correo'=>$objeto->correo,
                    'sexo'=>$objeto->sexo,
                    'adicional'=>$objeto->adicional,
                    'avatar'=>'../img/'.$objeto->avatar
            );
        }
            $jsonstring=json_encode($json[0]);
            echo $jsonstring;
    }
    if($_POST['funcion']=='capturar_datos') {
        $json=array();
        // esta es la variable que se envia desde el js en la funcion de capturar datos como parametro//
        $Id_usuario=$_POST['Id_usuario'];
        // se usa el mismo metodo de la modelo del usuario pero con diferente parametro este caso el id//
        $usuario->obtener_datos($Id_usuario);
        foreach($usuario->objetos as $objeto){
          $json[]=array(
              //el ultimo nombre es la columna de la tabla usuario//
              'telefono'=>$objeto->telefono,
              'residencia'=>$objeto->residencia,
              'correo'=>$objeto->correo,
              'sexo'=>$objeto->sexo,
              'adicional'=>$objeto->adicional
          );
        }
        $jsonstring=json_encode($json[0]);
        echo $jsonstring;
    }
    if($_POST['funcion']=='editar_usuario'){
        // esta es la variable que se envia desde el js en la funcion de capturar datos como parametro//
        $Id_usuario=$_POST['Id_usuario'];
        $telefono=$_POST['telefono'];
        $correo=$_POST['correo'];
        $residencia=$_POST['residencia'];
        $sexo=$_POST['sexo'];
        $adicional=$_POST['adicional'];
        // se envia todos los parametros al modelo usuario para la editar
        $usuario->actualizar_usuario($Id_usuario,$telefono,$correo,$residencia,$sexo,$adicional);
        // envio una respuesta del modelo  bd a js para confirmar que se complio el metodo//
        echo 'edicion';
    }
    if($_POST['funcion']=='cambiar_clave'){
        $Id_usuario=$_POST['Id_usuario'];
        $vieja_clave=$_POST['vieja_clave'];
        $nueva_clave=$_POST['nueva_clave'];
        
        $usuario->actualizar_clave($Id_usuario,$vieja_clave,$nueva_clave);
        
    }
    if($_POST['funcion']=='cambiar_foto'){
        if(($_FILES['foto']['type']=='image/jpeg') || ($_FILES['foto']['type']=='image/png') || ($_FILES['foto']['type']=='image/gif')){
            $nombre_foto=uniqid().'-'.$_FILES['foto']['name'];
            //echo $nombre_foto;
            $ruta='../img/'.$nombre_foto;
            move_uploaded_file($_FILES['foto']['tmp_name'],$ruta);
            $usuario->cambiar_foto($Id_usuario,$nombre_foto);
            foreach($usuario->objetos as $objeto){
                unlink('../img/'.$objeto->avatar);
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
    }
    if($_POST['funcion']=='buscar_usuarios_adm') {
        $json=array();
        //$fecha_actual=new DateTime();
        $usuario->buscar();
        foreach($usuario->objetos as $objeto){
          //$naciiento=new DateTime($objeto->edad);
          //comparacion de la fecha actual con la fecha de nacimiento//
          //$edad=$naciiento->diff($fecha_actual);
          //$edad_año=$edad->y;
          $json[]=array(
              //el ultimo nombre es la columna de la tabla usuario//
                  //'Id'=>$objeto->Id_usuario,
                  'nombre'=>$objeto->nombre,
                  'apellido'=>$objeto->apellido,
                  'edad'=>$objeto->edad,
                  'cedula'=>$objeto->cedula,
                  'tipo'=>$objeto->nombre_tipo,
                  'telefono'=>$objeto->telefono,
                  'residencia'=>$objeto->residencia,
                  'correo'=>$objeto->correo,
                  'sexo'=>$objeto->sexo,
                  'adicional'=>$objeto->adicional,
                  'avatar'=>'../img/'.$objeto->avatar,
                  'tipo_usuario'=>$objeto->us_tipo
          );
        }
          $jsonstring=json_encode($json);
          echo $jsonstring;
    }
    if($_POST['funcion']=='crear_usuario'){
        $nombre=$_POST['nombre'];
        $apellido=$_POST['apellido'];
        $cedula=$_POST['cedula'];
        $nacimiento=$_POST['nacimiento'];
        $clave=$_POST['clave'];
        $tipo=2;
        $avatar='user2-160x160.jpg';
        $usuario->crear($nombre,$apellido,$nacimiento,$cedula,$clave,$tipo,$avatar);
    }
    if($_POST['funcion']=='ascender'){
        $clave=$_POST['clave'];
        $Id_ascendido=$_POST['Id_usuario'];
        $usuario->ascender($clave,$Id_ascendido,$Id_usuario);
    }
    if($_POST['funcion']=='descender'){
        $clave=$_POST['clave'];
        $Id_descendido=$_POST['Id_usuario'];
        $usuario->descender($clave,$Id_descendido,$Id_usuario);
    }
    if($_POST['funcion']=='borrar_usuario') {
        $clave=$_POST['clave'];
        $Id_borrado=$_POST['Id_usuario'];
        $usuario->borrar($clave,$Id_borrado,$Id_usuario);
    }

?>