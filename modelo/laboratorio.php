<?php
 include 'conexion.php';
  class laboratorio{
      var $objetos;
      public function __construct()
      {
        $db=new conexion();
        $this->acceso=$db->pdo;
      }
      public function crear(string $nombre,string $avatar){
            $sql="SELECT id_laboratorio FROM laboratorio  WHERE nombre=:nombre";
            $query=$this->acceso->prepare($sql);
            $query->execute([':nombre'=>$nombre]);
            $this->objetos=$query->fetchall();
            if(!empty($this->objetos)){
                echo 'nocrear';
            }else{
                $sql="INSERT INTO laboratorio(nombre,avatar) VALUES(:nombre,:avatar)";
                $query=$this->acceso->prepare($sql);
                $query->execute([':nombre'=>$nombre,':avatar'=>$avatar]);
                echo 'crear';
            }
       }
       public function buscar(){
            if(!empty($_POST['consulta'])){
                $consulta=$_POST['consulta'];
                $sql="SELECT * FROM laboratorio  WHERE nombre LIKE :consulta";
                $query=$this->acceso->prepare($sql);
                $query->execute([':consulta'=>"%$consulta%"]);
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
        public function cambiar_logo(int $id,string $nombre_foto){
            $sql="SELECT avatar FROM laboratorio WHERE id_laboratorio=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute([':Id'=>$id]);
            $this->objetos=$query->fetchall();

                $sql="UPDATE laboratorio SET avatar=:nombre_foto WHERE Id_laboratorio=:Id";
                $query=$this->acceso->prepare($sql);
                $query->execute([':Id'=>$id,':nombre_foto'=>$nombre_foto]);

            return $this->objetos;


        }
       public function borrar(int $id){
            $sql="DELETE FROM laboratorio WHERE id_laboratorio=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute([':Id'=>$id]);
            $this->objetos=$query->rowcount();

            if(!empty($this->objetos)){
                echo 'borrado';
            }else{
                echo 'no-borrado';
            }
       }
       public function editar(string $nombre,int $id_editado){
            $sql="UPDATE laboratorio SET nombre=:nombre WHERE id_laboratorio=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute([':Id'=>$id_editado,':nombre'=>$nombre]);
            $this->objetos=$query->rowcount();
            echo 'editado';
        }
        public function rellenar_laboratorio(){
            $sql="SELECT * FROM laboratorio ORDER BY nombre ASC";
            $query=$this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
  }
