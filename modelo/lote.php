<?php
    include_once 'conexion.php';

    class lote{
        var $objetos;
        public function __construct()
        {
            $db=new conexion();
            $this->acceso=$db->pdo;
        }
        function crear($id_producto,$proveedor,$stock,$vencimiento){
            $sql="INSERT INTO lote(stock,vencimiento,lote_Id_prod,lote_Id_prov) VALUES(:stock,:vencimiento,:producto,:proveedor)";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':stock'=>$stock,':vencimiento'=>$vencimiento,':producto'=>$id_producto,':proveedor'=>$proveedor));
            echo 'crear';
        }
    }

?>