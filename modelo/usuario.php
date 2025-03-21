<?php
include_once 'conexion.php';

class usuario
{
  var $objetos;
  public function __construct()
  {
    $db = new conexion();
    $this->acceso = $db->pdo;
  }
  public function login(string $usuario, string $clave)
  {
    $sql = "SELECT * FROM usuario JOIN tipo_us on us_tipo=Id_tipo_us WHERE cedula=:usuario AND clave=:clave";
    $query = $this->acceso->prepare($sql);
    $query->execute([':usuario' => $usuario, 'clave' => $clave]);
    $this->objetos = $query->fetchall();
    return $this->objetos;
  }
  public function obtener_datos(string $id)
  {
    $sql = "SELECT * FROM usuario  join tipo_us on us_tipo=Id_tipo_us  AND cedula=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute([':id' => $id]);
    $this->objetos = $query->fetchall();
    return $this->objetos;
  }
  public function actualizar_usuario(string $Id_usuario, string $telefono, string $resedencia, string $correo, string $sexo, string $adiconal)
  {
    $sql = "UPDATE usuario SET telefono=:telefono,residencia=:residencia,correo=:correo,sexo=:sexo,adicional=:adicional WHERE cedula=:Id_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute([
      ':Id_usuario' => $Id_usuario,
      ':residencia' => $resedencia,
      ':telefono' => $telefono,
      ':correo' => $correo,
      ':sexo' => $sexo,
      ':adicional' => $adiconal
    ]);
  }
  public function actualizar_clave(string $Id_usuario, string $vieja_clave, string $nueva_clave)
  {
    $sql = "SELECT * FROM usuario WHERE cedula=:Id_usuario AND clave=:vieja_clave";
    $query = $this->acceso->prepare($sql);
    $query->execute([':Id_usuario' => $Id_usuario, ':vieja_clave' => $vieja_clave]);
    $this->objetos = $query->fetchall();

    if (!empty($this->objetos)) {
      $sql = "UPDATE usuario SET clave=:nueva_clave WHERE cedula=:Id_usuario";
      $query = $this->acceso->prepare($sql);
      $query->execute([':Id_usuario' => $Id_usuario, ':nueva_clave' => $nueva_clave]);
      echo 'update';
    } else {
      echo 'no-update';
    }
  }
  public function cambiar_foto(string $Id_usuario, string $nombre_foto)
  {
    $sql = "SELECT avatar FROM usuario WHERE cedula=:Id_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute([':Id_usuario' => $Id_usuario]);
    $this->objetos = $query->fetchall();

    $sql = "UPDATE usuario SET avatar=:nombre_foto WHERE cedula=:Id_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute([':Id_usuario' => $Id_usuario, ':nombre_foto' => $nombre_foto]);

    return $this->objetos;
  }
  public function buscar()
  {
    if (!empty($_POST['consulta'])) {
      $consulta = $_POST['consulta'];
      $sql = "SELECT * FROM usuario join tipo_us on us_tipo=Id_tipo_us WHERE nombre LIKE :sql";
      $query = $this->acceso->prepare($sql);
      $query->execute([':sql' => "%$consulta%"]);
      $this->objetos = $query->fetchall();
      return $this->objetos;
    } else {
      $sql = "SELECT * FROM usuario join tipo_us on us_tipo=Id_tipo_us WHERE nombre NOT LIKE '' ORDER BY Id_usuario LIMIT 25";
      $query = $this->acceso->prepare($sql);
      $query->execute();
      $this->objetos = $query->fetchall();
      return $this->objetos;
    }
  }
  public function crear(string $cedula, string $nombre, string $apellido, string $nacimiento, string $clave, string $avatar, int $tipo_us)
  {
    $sql = "SELECT cedula FROM usuario  WHERE cedula=:cedula";
    $query = $this->acceso->prepare($sql);
    $query->execute([':cedula' => $cedula]);
    $this->objetos = $query->fetchall();
    if (!empty($this->objetos)) {
      echo 'nocrear';
    } else {
      $sql = "INSERT INTO usuario(cedula,nombre,apellido,edad,clave,avatar,us_tipo) VALUES(:cedula,:nombre,:apllido,:edad,:clave,:avatar,:us_tipo)";
      $query = $this->acceso->prepare($sql);
      $query->execute([
        ':cedula' => $cedula,
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':edad' => $nacimiento,
        ':clave' => $clave,
        ':avatar' => $avatar,
        ':us_tipo' => $tipo_us
      ]);
      echo 'crear';
    }
  }
  public function ascender(string $clave, int $Id_ascendido, int $Id_usuario)
  {
    $sql = "SELECT cedula FROM usuario  WHERE cedula=:Id_usuario AND clave=:clave";
    $query = $this->acceso->prepare($sql);
    $query->execute([':Id_usuario' => $Id_usuario, ':clave' => $clave]);
    $this->objetos = $query->fetchall();
    if (!empty($this->objetos)) {
      $tipo = 1;
      $sql = "UPDATE usuario set us_tipo=:tipo WHERE cedula=:Id";
      $query = $this->acceso->prepare($sql);
      $query->execute([':Id' => $Id_ascendido, ':tipo' => $tipo]);
      $this->objetos = $query->fetchall();
      echo 'ascendido';
    } else {
      echo 'no-ascendido';
    }
  }
  public function descender(string $clave, int $Id_descendido, int $Id_usuario)
  {
    $sql = "SELECT cedula FROM usuario  WHERE cedula=:Id_usuario AND clave=:clave";
    $query = $this->acceso->prepare($sql);
    $query->execute([':Id_usuario' => $Id_usuario, ':clave' => $clave]);
    $this->objetos = $query->fetchall();
    if (!empty($this->objetos)) {
      $tipo = 2;
      $sql = "UPDATE usuario set us_tipo=:tipo WHERE cedula=:Id";
      $query = $this->acceso->prepare($sql);
      $query->execute([':Id' => $Id_descendido, ':tipo' => $tipo]);
      $this->objetos = $query->fetchall();
      echo 'descendido';
    } else {
      echo 'no-descendido';
    }
  }
  public function borrar(string $clave, int $Id_borrado, int $Id_usuario)
  {
    $sql = "SELECT cedula FROM usuario  WHERE cedula=:Id_usuario AND clave=:clave";
    $query = $this->acceso->prepare($sql);
    $query->execute([':Id_usuario' => $Id_usuario, ':clave' => $clave]);
    $this->objetos = $query->fetchall();
    if (!empty($this->objetos)) {
      $tipo = 2;
      $sql = "DELETE FROM usuario  WHERE cedula=:Id";
      $query = $this->acceso->prepare($sql);
      $query->execute([':Id' => $Id_borrado, ':tipo' => $tipo]);
      $this->objetos = $query->fetchall();
      echo 'borrado';
    } else {
      echo 'no-borrado';
    }
  }
  public function devolver_avatar($Id_usuario)
  {
    $sql = "SELECT avatar FROM usuario WHERE cedula=:Id_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute([':Id_usuario' => $Id_usuario]);
    $this->objetos = $query->fetchall();
    return $this->objetos;
  }
  public function recuperar_clave(string $cedula, string $correo)
  {
    $sql = "SELECT * FROM usuario WHERE correo=:correo AND cedula=:cedula";
    $query = $this->acceso->prepare($sql);
    $query->execute([':correo' => $correo, ':cedula' => $cedula]);
    $this->objetos = $query->fetchall();

    if (!empty($this->objetos)) {
      if ($query->rowCount() == 1) {
        echo 'encontrado';
      } else {
        echo 'no-encontrado';
      }
    } else {
      echo 'no-encratado';
    }
  }
  public function reemplazar(string $codigo, string $correo, string $cedula)
  {
    $sql = "UPDATE usuario set clave=:codigo WHERE correo=:correo AND cedula=:cedula";
    $query = $this->acceso->prepare($sql);
    $query->execute([':codigo' => $codigo, ':cedula' => $cedula, ':correo' => $correo]);
  }
}
