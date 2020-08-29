<?php
    include_once 'conexion.php';

    class ventas{
        var $objetos;
        public function __construct()
        {
            $db=new conexion();
            $this->acceso=$db->pdo;
        }

        function crear($nombre,$cedula,$total,$fecha,$vendedor){
            $sql="INSERT INTO venta (fecha,cliente,cedula,total,vendedor) VALUES(:fecha,:nombre,:cedula,:total,:vendedor)";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':fecha'=>$fecha,':nombre'=>$nombre,':cedula'=>$cedula,':total'=>$total,':vendedor'=>$vendedor)); 
        }
        function ultima_venta(){
            $sql="SELECT MAX(id_venta) as ultima_venta FROM venta";
            $query=$this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        function borrar($id_venta){
            $sql="DELETE FROM venta WHERE id_venta=:Id_venta";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':Id_venta'=>$id_venta));
        }
    }

?>