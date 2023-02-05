<?php

    include_once 'conexion.php';

    class presentacion{
        var $objetos;

        public function __construct()
        {
            $db=new conexion();
            $this->acceso=$db->pdo;
        }
        public function crear(string $nombre){
            $sql="SELECT id_presentacion FROM presentacion  WHERE presentacion=:nombre";
            $query=$this->acceso->prepare($sql);
            $query->execute([':nombre'=>$nombre]);
            $this->objetos=$query->fetchall();
            if(!empty($this->objetos)){
                echo 'nocrear';
            }else{
                $sql="INSERT INTO presentacion(presentacion) VALUES(:nombre)";
                $query=$this->acceso->prepare($sql);
                $query->execute([':nombre'=>$nombre]);
                echo 'crear';
            }
       }
       public function borrar(int $id){
            $sql="DELETE FROM presentacion WHERE id_presentacion=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute([':Id'=>$id]);
            $this->objetos=$query->rowcount();

            if(!empty($this->objetos)){
                echo 'borrado';
            }else{
                echo 'no-borrado';
            }
        }
       public function buscar(){
            if(!empty($_POST['consulta'])){
                $consulta=$_POST['consulta'];
                $sql="SELECT * FROM presentacion  WHERE presentacion LIKE :consulta";
                $query=$this->acceso->prepare($sql);
                $query->execute([':consulta'=>"%$consulta%"]);
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }else{
                $sql="SELECT * FROM presentacion  WHERE presentacion NOT LIKE '' ORDER BY id_presentacion LIMIT 25";
                $query=$this->acceso->prepare($sql);
                $query->execute();
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }
        }
        public function editar(string $nombre,int $id_editado){
            $sql="UPDATE presentacion SET presentacion=:nombre WHERE id_presentacion=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute([':Id'=>$id_editado,':nombre'=>$nombre]);
            $this->objetos=$query->rowcount();
            echo 'editado';
        }
        public function rellenar_presentacion(){
            $sql="SELECT * FROM presentacion ORDER BY presentacion ASC";
            $query=$this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
