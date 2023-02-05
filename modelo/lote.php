<?php
    include_once 'conexion.php';
    require 'baseModel.php';

    class lote  extends baseModel{
        var $objetos;
        public function __construct()
        {
            $db=new conexion();
            $this->acceso=$db->pdo;
        }
        function crear($id_producto,$proveedor,$stock,$vencimiento){
            $this->insert('lote',['stock'=>$stock,'vencimiento'=>$vencimiento,'lote_Id_prod'=>$id_producto,'lote_Id_prov'=>$proveedor]);
            echo 'crear';
        }
        function buscar(){
            if(!empty($_POST['consulta'])){
                $consulta=$_POST['consulta'];
                $sql="SELECT id_lote,stock,vencimiento,concentracion,adicional,productos.nombre as prod_nombre,laboratorio.nombre as nombre_laboratorio,presentacion,proveedor.nombre as nombre_proveedor,productos.avatar as logo FROM lote JOIN proveedor  on lote_Id_prov=id_proveedor JOIN productos on lote_Id_prod=id_producto JOIN laboratorio on prod_lab=id_laboratorio JOIN tipo_producto on prod_tip_prod=id_tipo_producto JOIN presentacion on prod_present=id_presentacion WHERE productos.nombre  LIKE :consulta ORDER BY productos.nombre LIMIT 25";
                $query=$this->acceso->prepare($sql);
                $query->execute(array(':consulta'=>"%$consulta%"));
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }else{
                $sql="SELECT id_lote,stock,vencimiento,concentracion,adicional,productos.nombre as prod_nombre,laboratorio.nombre as nombre_laboratorio,presentacion,proveedor.nombre as nombre_proveedor,productos.avatar as logo FROM lote JOIN proveedor  on lote_Id_prov=id_proveedor JOIN productos on lote_Id_prod=id_producto JOIN laboratorio on prod_lab=id_laboratorio JOIN tipo_producto on prod_tip_prod=id_tipo_producto JOIN presentacion on prod_present=id_presentacion WHERE productos.nombre NOT LIKE '' ORDER BY productos.nombre LIMIT 25";
                $query=$this->acceso->prepare($sql);
                $query->execute();
                $this->objetos=$query->fetchall();
                return $this->objetos;
            }
        }
        function editar($id_lote,$stock){
            $sql="UPDATE lote SET stock=:stock WHERE id_lote=:id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':stock'=>$stock,':id'=>$id_lote));
            //$this->objetos=$query->rowcount();
            echo 'editado';

        }
        function borrar($id_lote){
            $sql="DELETE FROM lote  WHERE id_lote=:Id_lote";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':Id_lote'=>$id_lote));
            $this->objetos=$query->rowcount();
            if(!empty($this->objetos)){
                echo 'borrado';
            }else{
                echo 'noborrado';
            }
        }
    }

?>