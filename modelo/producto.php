<?php

    include_once 'conexion.php';

    class producto{
        public function __construct()
        {
            $db=new conexion();
            $this->acceso=$db->pdo;
        }

        function crear($nombre,$concentracion,$adicional,$precio,$laboratorio,$tipo,$presentacion,$avatar){
            $sql="SELECT id_producto FROM productos WHERE nombre=:nombre AND concentracion=:concentracion AND adicional=:adicional AND  prod_lab=:laboratorio AND prod_present=:presentacion AND prod_tip_prod=:tipo";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':nombre'=>$nombre,':concentracion'=>$concentracion,':adicional'=>$adicional,':laboratorio'=>$laboratorio,':presentacion'=>$presentacion,':tipo'=>$tipo));
            $this->objetos=$query->fetchall();
            if(!empty($this->objetos)){
                echo 'nocrear';                      
            }else{
                $sql="INSERT INTO productos(nombre,concentracion,adicional,precio,avatar,prod_lab,prod_tip_prod,prod_present) VALUES(:nombre,:concentracion,:adicional,:precio,:avatar,:laboratorio,:tipo,:presentacion)";
                $query=$this->acceso->prepare($sql);
                $query->execute(array(':nombre'=>$nombre,':concentracion'=>$concentracion,':adicional'=>$adicional,':precio'=>$precio,':avatar'=>$avatar,':laboratorio'=>$laboratorio,':presentacion'=>$presentacion,':tipo'=>$tipo));
                echo 'crear';
            }        

        }
        function buscar(){
            if(!empty($_POST['consulta'])){
                $consulta=$_POST['consulta'];
                $sql="SELECT id_producto,productos.nombre as nombre,concentracion,adicional,precio,productos.avatar as avatar,tipo_producto.nombre_tipo as tipo,presentacion.presentacion as presentacion ,laboratorio.nombre as laboratorio,id_laboratorio,id_tipo_producto,id_presentacion FROM productos JOIN laboratorio ON prod_lab=id_laboratorio JOIN tipo_producto ON  prod_tip_prod=id_tipo_producto JOIN presentacion ON  prod_present=id_presentacion  AND productos.nombre LIKE :consulta";
                $query=$this->acceso->prepare($sql);
                $query->execute(array(':consulta'=>"%$consulta%"));
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }else{
                
                $sql="SELECT id_producto,productos.nombre as nombre,concentracion,adicional,precio,productos.avatar as avatar,tipo_producto.nombre_tipo as tipo,presentacion.presentacion as presentacion ,laboratorio.nombre as laboratorio,id_laboratorio,id_tipo_producto,id_presentacion FROM productos JOIN laboratorio ON prod_lab=id_laboratorio JOIN tipo_producto ON  prod_tip_prod=id_tipo_producto JOIN presentacion ON  prod_present=id_presentacion  AND productos.nombre ORDER BY productos.nombre  NOT LIKE '' LIMIT 25";
                $query=$this->acceso->prepare($sql);
                $query->execute();
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }
        }

    }

?>