<?php
    include_once 'conexion.php';

    class proveedor{
        var $objetos;

        public function __construct()
        {
            $db=new conexion();
            $this->acceso=$db->pdo;    
        }

        function crear($nombre,$telefono,$correo,$direccion,$avatar){
            $sql="SELECT id_proveedor FROM proveedor WHERE nombre=:nombre";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':nombre'=>$nombre));
            $this->objetos=$query->fetchall();

            if(!empty($this->objetos)){
                echo 'no-crear';
            }else{
                $sql2="INSERT INTO proveedor(nombre,telefono,correo,direccion,avatar)VALUES(:nombre,:telefono,:correo,:direccion,:avatar)";
                $query2=$this->acceso->prepare($sql2);
                $query2->execute(array(':nombre'=>$nombre,':telefono'=>$telefono,':correo'=>$correo,':direccion'=>$correo,':direccion'=>$direccion,':avatar'=>$avatar));
                $this->objetos=$query->fetchall();
                echo 'crear';
            }
        }
        function buscar(){
            if(!empty($_POST['consulta'])){
                $consulta=$_POST['consulta'];
                $sql="SELECT * FROM proveedor  WHERE nombre LIKE :consulta";
                $query=$this->acceso->prepare($sql);
                $query->execute(array(':consulta'=>"%$consulta%"));
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }else{
                $sql="SELECT * FROM proveedor  WHERE nombre NOT LIKE ''ORDER BY id_proveedor desc LIMIT 15";
                $query=$this->acceso->prepare($sql);
                $query->execute();
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }
        }
        function editar($id,$nombre,$telefono,$correo,$direccion){
            $sql="SELECT id_proveedor FROM proveedor WHERE id_proveedor=:id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array('id'=>$id));
            $this->objetos=$query->fetchall();

            if(!empty($this->objetos)){
                echo 'no-editado';
            }else{
                $sql="UPDATE proveedor SET nombre=:nombre,telefono=:telefono,correo=:correo,:direccion=:direccion WHERE id_producto=:id";
                $query=$this->acceso->prepare($sql);
                $query->execute(array('id'=>$id,':nombre'=>$nombre,':telefono'=>$telefono,':correo'=>$correo,':direccion'=>$direccion));
                $this->objetos=$query->rowcount();
                echo 'editado';
            }
        }
        function cambiar_logo($id,$nombre_foto){
            $sql="UPDATE proveedor SET avatar=:avatar WHERE id_proveedor=:id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id,':avatar'=>$nombre_foto));
        }
        function rellenar_proveedor(){
            $sql="SELECT * FROM proveedor ORDER BY nombre ASC";
            $query=$this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();          
            return $this->objetos;
        }  
        
    }

?>