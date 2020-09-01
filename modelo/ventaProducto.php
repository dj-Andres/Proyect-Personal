<?php
    include_once 'conexion.php';

    class ventaProducto{
        var $objetos;
        public function __construct()
        {
            $db=new conexion();
            $this->acceso=$db->pdo;
        }

        public function ver($id){
            $sql="SELECT precio,cantidad,productos.nombre as producto,concentracion,adicional,laboratorio.nombre as laboratorio,presentacion,nombre_tipo as tipo,subtotal FROM venta_producto JOIN productos on producto_Id_producto=id_producto JOIN laboratorio on prod_lab=id_laboratorio JOIN tipo_producto on prod_tip_prod=id_tipo_producto JOIN presentacion on prod_present=id_presentacion AND venta_Id_venta=:id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        
    }

?>