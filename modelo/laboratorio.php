<?php
 include 'conexion.php';
  class laboratorio{
      var $objetos;
      public function __construct()
      {
        $db=new conexion();
        $this->acceso=$db->pdo;
      }
      function crear($nombre,$avatar){
            $sql="SELECT id_laboratorio FROM laboratorio  WHERE nombre=:nombre";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':nombre'=>$nombre));
            $this->objetos=$query->fetchall();
            if(!empty($this->objetos)){
                echo 'nocrear';                      
            }else{
                $sql="INSERT INTO laboratorio(nombre,avatar) VALUES(:nombre,:avatar)";
                $query=$this->acceso->prepare($sql);
                $query->execute(array(':nombre'=>$nombre,':avatar'=>$avatar));
                echo 'crear';
            }
       }
       function buscar(){
            if(!empty($_POST['consulta'])){
                $consulta=$_POST['consulta'];
                $sql="SELECT * FROM laboratorio  WHERE nombre LIKE :consulta";
                $query=$this->acceso->prepare($sql);
                $query->execute(array(':consulta'=>"%$consulta%"));
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }else{
                $sql="SELECT * FROM laboratorio  WHERE nombre NOT LIKE ''ORDER BY id_laboratorio LIMIT 15";
                $query=$this->acceso->prepare($sql);
                $query->execute();
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }
        }
        function cambiar_logo($id,$nombre_foto){
            $sql="SELECT avatar FROM laboratorio WHERE id_laboratorio=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':Id'=>$id));
            $this->objetos=$query->fetchall();
            
                $sql="UPDATE laboratorio SET avatar=:nombre_foto WHERE Id_laboratorio=:Id";
                $query=$this->acceso->prepare($sql);
                $query->execute(array(':Id'=>$id,':nombre_foto'=>$nombre_foto));
                
            return $this->objetos;
            
        
        }
       function borrar($id){
            $sql="DELETE FROM laboratorio WHERE id_laboratorio=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':Id'=>$id));
            $this->objetos=$query->rowcount();
           
            if(!empty($this->objetos)){
                echo 'borrado';
            }else{
                echo 'no-borrado';
            }
       }
       function editar($nombre,$id_editado){
            $sql="UPDATE laboratorio SET nombre=:nombre WHERE id_laboratorio=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':Id'=>$id_editado,':nombre'=>$nombre));
            $this->objetos=$query->rowcount();
            echo 'editado';
        }
        function rellenar_laboratorio(){
            $sql="SELECT * FROM laboratorio ORDER BY nombre ASC";
            $query=$this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();          
            return $this->objetos;
        }      
  }
?>