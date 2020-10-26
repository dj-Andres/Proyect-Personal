<?php
  include_once 'conexion.php';

  class usuario{
      var $objetos;
      public function __construct()
      {
        $db=new conexion();
        $this->acceso=$db->pdo;
      }
      function login($usuario,$clave){
        $sql="SELECT * FROM usuario JOIN tipo_us on us_tipo=Id_tipo_us WHERE cedula=:usuario AND clave=:clave";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':usuario' =>$usuario,'clave'=>$clave));
        $this->objetos = $query->fetchall();
        return $this->objetos;
            
      }
      function obtener_datos($id){
        $sql="SELECT * FROM usuario  join tipo_us on us_tipo=Id_tipo_us  AND cedula=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id' =>$id));
        $this->objetos = $query->fetchall();
        return $this->objetos;
      }
      function actualizar_usuario($Id_usuario,$telefono,$resedencia,$correo,$sexo,$adiconal){
        $sql="UPDATE usuario SET telefono=:telefono,residencia=:residencia,correo=:correo,sexo=:sexo,adicional=:adicional WHERE cedula=:Id_usuario";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':Id_usuario'=>$Id_usuario,':residencia'=>$resedencia,':telefono'=>$telefono,':correo'=>$correo,':sexo'=>$sexo,':adicional'=>$adiconal));
      }
      function actualizar_clave($Id_usuario,$vieja_clave,$nueva_clave){
        $sql="SELECT * FROM usuario WHERE cedula=:Id_usuario AND clave=:vieja_clave";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':Id_usuario'=>$Id_usuario,':vieja_clave'=>$vieja_clave));
        $this->objetos=$query->fetchall();

        if(!empty($this->objetos)){
          $sql="UPDATE usuario SET clave=:nueva_clave WHERE cedula=:Id_usuario";
          $query=$this->acceso->prepare($sql);
          $query->execute(array(':Id_usuario'=>$Id_usuario,':nueva_clave'=>$nueva_clave));
          echo 'update';
        }else{
          echo 'no-update';
        }
      }
      function cambiar_foto($Id_usuario,$nombre_foto){
        $sql="SELECT avatar FROM usuario WHERE cedula=:Id_usuario";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':Id_usuario'=>$Id_usuario));
        $this->objetos=$query->fetchall();
        
            $sql="UPDATE usuario SET avatar=:nombre_foto WHERE cedula=:Id_usuario";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':Id_usuario'=>$Id_usuario,':nombre_foto'=>$nombre_foto));
            
        return $this->objetos;
        
      }
      function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM usuario join tipo_us on us_tipo=Id_tipo_us WHERE nombre LIKE :sql";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':sql'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }else{
            $sql="SELECT * FROM usuario join tipo_us on us_tipo=Id_tipo_us WHERE nombre NOT LIKE '' ORDER BY Id_usuario LIMIT 25";
            $query=$this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
      }
      function crear($nombre,$apellido,$cedula,$nacimiento,$clave,$tipo,$avatar){
        $sql="SELECT cedula FROM usuario  WHERE cedula=:cedula";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':cedula'=>$cedula));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            echo 'nocrear';                      
        }else{
            $sql="INSERT INTO usuario(cedula,nombre,apellido,edad,clave,avatar,us_tipo) VALUES(:cedula,:nombre,:apllido,:edad,:clave,:avatar,:tipo)";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':cedula'=>$cedula,':nombre'=>$nombre,':apellido'=>$apellido,':edad'=>$nacimiento,':clave'=>$clave,':avatar'=>$avatar,':tipo'=>$tipo));
            echo 'crear';
        }
      }
      function ascender($clave,$Id_ascendido,$Id_usuario){
        $sql="SELECT cedula FROM usuario  WHERE cedula=:Id_usuario AND clave=:clave";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':Id_usuario'=>$Id_usuario,':clave'=>$clave));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            $tipo=1;
            $sql="UPDATE usuario set us_tipo=:tipo WHERE cedula=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':Id'=>$Id_ascendido,':tipo'=>$tipo));
            $this->objetos=$query->fetchall();
            echo 'ascendido';
        }else{
            echo 'no-ascendido';
        }
      }
      function descender($clave,$Id_descendido,$Id_usuario){
        $sql="SELECT cedula FROM usuario  WHERE cedula=:Id_usuario AND clave=:clave";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':Id_usuario'=>$Id_usuario,':clave'=>$clave));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            $tipo=2;
            $sql="UPDATE usuario set us_tipo=:tipo WHERE cedula=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':Id'=>$Id_descendido,':tipo'=>$tipo));
            $this->objetos=$query->fetchall();
            echo 'descendido';
        }else{
            echo 'no-descendido';
        }
      }
      function borrar($clave,$Id_borrado,$Id_usuario){
        $sql="SELECT cedula FROM usuario  WHERE cedula=:Id_usuario AND clave=:clave";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':Id_usuario'=>$Id_usuario,':clave'=>$clave));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            $tipo=2;
            $sql="DELETE FROM usuario  WHERE cedula=:Id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':Id'=>$Id_borrado,':tipo'=>$tipo));
            $this->objetos=$query->fetchall();
            echo 'borrado';
        }else{
            echo 'no-borrado';
        }
      }
      function devolver_avatar($Id_usuario){
        $sql="SELECT avatar FROM usuario WHERE cedula=:Id_usuario";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':Id_usuario'=>$Id_usuario));
        $this->objetos=$query->fetchall();      
        return $this->objetos;
      }
      function recuperar_clave($cedula,$correo){
        $sql="SELECT * FROM usuario WHERE correo=:correo AND cedula=:cedula";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':correo'=>$correo,':cedula'=>$cedula));
        $this->objetos=$query->fetchall();

        if(!empty($this->objetos)){
              if($query->rowCount()==1){
                  echo 'encontrado';
              }else{
                echo 'no-encontrado';
              }
        }else{
            echo 'no-encratado';
        }

      }
      function reemplazar($codigo,$correo,$cedula){
        $sql="UPDATE usuario set clave=:codigo WHERE correo=:correo AND cedula=:cedula";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':codigo'=>$codigo,':cedula'=>$cedula,':correo'=>$correo));
         echo 'reemplazado';
      }
  }
?>