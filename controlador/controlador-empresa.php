<?php

 include '../modelo/empresa.php';

 $empresa = new Empresa();

 if($_POST['funcion'] == 'crear'){
     $nombre = $_POST['name'];
     $ruc = $_POST['ruc_number'];
     $telefono = $_POST['phone'];
     $email = $_POST['email'];
     $direccion=$_POST['address'];
     $avatar='empresa.jpg';

     $empresa->crear($nombre,$avatar,$ruc,$telefono,$direccion,$email);
 }
 if($_POST['funcion'] == 'search'){
    $empresa->search();
        $json=[];
        foreach ($empresa->objetos as $objeto) {
            $json[]=[
                'id'=>$objeto->id,
                'nombre'=>$objeto->nombre,
                'avatar'=>'../img/business/'.$objeto->logo,
                'ruc' => $objeto->ruc,
                'telefono' => $objeto->telefono,
                'direccion' => $objeto->direccion,
                'email' => $objeto->email
            ];
        }
        $jsonsting=json_encode($json[0]);
        echo $jsonsting;
 }