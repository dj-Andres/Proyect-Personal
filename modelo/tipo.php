<?php
    include 'conexion.php';
    class tipo{
        var $objetos;
       
        public function __construct()
        {
            $db=new conexion();
            $this->acceso=$db->pdo;
        }
        function crear($nombre){
            $sql="SELECT id_tipo_producto FROM tipo_producto  WHERE nombre_tipo=:nombre";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':nombre'=>$nombre));
            $this->objetos=$query->fetchall();
            if(!empty($this->objetos)){
                echo 'nocrear';                      
            }else{
                $sql="INSERT INTO tipo_producto(nombre_tipo) VALUES(:nombre)";
                $query=$this->acceso->prepare($sql);
                $query->execute(array(':nombre'=>$nombre));
                echo 'crear';
            }
       }
       function borrar($id){
            $sql="DELETE FROM tipo_producto WHERE id_tipo_producto=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':Id'=>$id));
            $this->objetos=$query->rowcount();
        
            if(!empty($this->objetos)){
                echo 'borrado';
            }else{
                echo 'no-borrado';
            }
        }
       function buscar(){
            if(!empty($_POST['consulta'])){
                $consulta=$_POST['consulta'];
                $sql="SELECT * FROM tipo_producto  WHERE nombre_tipo LIKE :consulta";
                $query=$this->acceso->prepare($sql);
                $query->execute(array(':consulta'=>"%$consulta%"));
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }else{
                $sql="SELECT * FROM tipo_producto  WHERE nombre_tipo NOT LIKE '' ORDER BY id_tipo_producto LIMIT 15";
                $query=$this->acceso->prepare($sql);
                $query->execute();
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }
        }
        function editar($nombre,$id_editado){
            $sql="UPDATE tipo_producto SET nombre_tipo=:nombre WHERE id_tipo_producto=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':Id'=>$id_editado,':nombre'=>$nombre));
            $this->objetos=$query->rowcount();
            echo 'editado';
        }
        function rellenar_tipo(){
            $sql="SELECT * FROM tipo_producto ORDER BY nombre_tipo ASC";
            $query=$this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();          
            return $this->objetos;
        }      
              
    }
?>