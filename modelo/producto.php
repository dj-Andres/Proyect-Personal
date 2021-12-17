<?php

    include_once 'conexion.php';

    class producto{
        var $objetos;
        public function __construct()
        {
            $db=new conexion();
            $this->acceso=$db->pdo;
        }

        function crear($nombre,$concentracion,$adicional,$precio,$avatar,$laboratorio,$tipo,$presentacion){
            $sql="SELECT id_producto FROM productos WHERE nombre=:nombre AND concentracion=:concentracion AND adicional=:adicional AND prod_lab=:laboratorio AND prod_present=:presentacion AND prod_tip_prod=:tipo";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':nombre'=>$nombre,':concentracion'=>$concentracion,':adicional'=>$adicional,':laboratorio'=>$laboratorio,':presentacion'=>$presentacion,':tipo'=>$tipo));
            $this->objetos=$query->fetchall();
            if(!empty($this->objetos)){
                echo 'nocrear';
            }else{
                $sql="INSERT INTO productos(nombre,concentracion,adicional,precio,avatar,prod_lab,prod_tip_prod,prod_present) VALUES(:nombre,:concentracion,:adicional,:precio,:avatar,:laboratorio,:presentacion,:tipo)";
                $query=$this->acceso->prepare($sql);
                $query->execute(array(':nombre'=>$nombre,':concentracion'=>$concentracion,':adicional'=>$adicional,':precio'=>$precio,':avatar'=>$avatar,':laboratorio'=>$laboratorio,':presentacion'=>$presentacion,':tipo'=>$tipo));
                echo 'crear';
            }
        }
        function buscar(){
            if(!empty($_POST['consulta'])){
                $sql=$_POST['consulta'];
                $sql="SELECT id_producto,productos.nombre as nombre,concentracion,adicional,precio,productos.avatar as avatar,tipo_producto.nombre_tipo as tipo,presentacion.presentacion as presentacion ,laboratorio.nombre as laboratorio,id_laboratorio,id_tipo_producto,id_presentacion FROM productos JOIN laboratorio ON prod_lab=id_laboratorio JOIN tipo_producto ON  prod_tip_prod=id_tipo_producto JOIN presentacion ON  prod_present=id_presentacion WHERE productos.nombre  LIKE :consulta";
                $query=$this->acceso->prepare($sql);
                $query->execute(array(':consulta'=>"%$sql%"));
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }else{
                $sql="SELECT id_producto,productos.nombre as nombre,concentracion,adicional,precio,productos.avatar as avatar,tipo_producto.nombre_tipo as tipo,presentacion.presentacion as presentacion ,laboratorio.nombre as laboratorio,id_laboratorio,id_tipo_producto,id_presentacion FROM productos JOIN laboratorio ON prod_lab=id_laboratorio JOIN tipo_producto ON  prod_tip_prod=id_tipo_producto JOIN presentacion ON  prod_present=id_presentacion WHERE productos.nombre NOT LIKE ''ORDER BY id_producto LIMIT 15";
                $query=$this->acceso->prepare($sql);
                $query->execute();
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }
        }
        function buscarId($id_producto){
            $sql="SELECT id_producto,productos.nombre as nombre,concentracion,adicional,precio,productos.avatar as avatar,tipo_producto.nombre_tipo as tipo,presentacion.presentacion as presentacion ,laboratorio.nombre as laboratorio,id_laboratorio,id_tipo_producto,id_presentacion FROM productos JOIN laboratorio ON prod_lab=id_laboratorio JOIN tipo_producto ON  prod_tip_prod=id_tipo_producto JOIN presentacion ON  prod_present=id_presentacion WHERE productos.id_producto=:id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id_producto));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        function editar($id,$nombre,$concentracion,$adicional,$precio,$laboratorio,$tipo,$presentacion){
            $sql="SELECT id_producto FROM productos WHERE id_producto!=:id AND nombre=:nombre AND concentracion=:concentracion AND adicional=:adicional AND  prod_lab=:laboratorio AND prod_present=:presentacion AND prod_tip_prod=:tipo";
            $query=$this->acceso->prepare($sql);
            $query->execute(array('id'=>$id,':nombre'=>$nombre,':concentracion'=>$concentracion,':adicional'=>$adicional,':laboratorio'=>$laboratorio,':presentacion'=>$presentacion,':tipo'=>$tipo));
            $this->objetos=$query->fetchall();

            if(!empty($this->objetos)){
                echo 'noeditado';
            }else{
                $sql="UPDATE productos SET nombre=:nombre,concentracion=:concentracion,adicional=:adicional,precio=:precio,prod_lab=:laboratorio,prod_tip_prod=:tipo,prod_present=:presentacion WHERE id_producto=:id";
                $query=$this->acceso->prepare($sql);
                $query->execute(array('id'=>$id,':nombre'=>$nombre,':concentracion'=>$concentracion,':adicional'=>$adicional,':laboratorio'=>$laboratorio,':presentacion'=>$presentacion,':tipo'=>$tipo,':precio'=>$precio));
                $this->objetos=$query->rowcount();
                echo 'editado';
            }
        }
        function cambiar_logo($id,$nombre_foto){
            $sql="UPDATE productos SET avatar=:avatar WHERE id_producto=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':Id'=>$id,':avatar'=>$nombre_foto));

        }
        function borrar($id){
            $sql="DELETE FROM productos WHERE id_producto=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':Id'=>$id));
            $this->objetos=$query->rowcount();

            if(!empty($this->objetos)){
                echo 'borrado';
            }else{
                echo 'no-borrado';
            }
       }
       function obtener_stock($id){
            $sql="SELECT SUM(stock) as total FROM lote WHERE lote_Id_prod=:id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id));
            $this->objetos=$query->fetchall();
            return $this->objetos;
       }
       function reporte_producto(){
            $sql="SELECT id_producto,productos.nombre as nombre,concentracion,adicional,precio,productos.avatar as avatar,tipo_producto.nombre_tipo as tipo,presentacion.presentacion as presentacion ,laboratorio.nombre as laboratorio,id_laboratorio,id_tipo_producto,id_presentacion FROM productos JOIN laboratorio ON prod_lab=id_laboratorio JOIN tipo_producto ON  prod_tip_prod=id_tipo_producto JOIN presentacion ON  prod_present=id_presentacion WHERE productos.nombre NOT LIKE '' ORDER BY productos.nombre";
            $query=$this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }

?>