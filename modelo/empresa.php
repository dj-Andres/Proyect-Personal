<?php
include 'conexion.php';

class Empresa
{
    var $objetos;
    public function __construct()
    {
        $db = new conexion();
        $this->acceso = $db->pdo;
    }
    public function crear(string $nombre, string $logo, string $ruc, string $telefono, string $direccion, string $email)
    {
        $sql = "SELECT nombre FROM empresa  WHERE nombre=:nombre";
        $query = $this->acceso->prepare($sql);
        $query->execute([':nombre' => $nombre]);
        $this->objetos = $query->fetchall();
        if (!empty($this->objetos)) {
            echo 'nocrear';
        } else {
            $sql = "INSERT INTO empresa(nombre,logo,ruc,telefono,direccion,email) VALUES(:nombre,:logo,:ruc,:telefono,:direccion,:email)";
            $query = $this->acceso->prepare($sql);
            $query->execute([
                ':nombre' => $nombre,
                ':logo' => $logo,
                ':ruc' => $ruc,
                ':telefono' => $telefono,
                ':direccion' => $direccion,
                ':email' => $email
            ]);
            echo 'crear';
        }
    }
    public function cambiar_logo(int $id, string $nombre_foto)
    {
        $sql = "SELECT avatar FROM laboratorio WHERE id_laboratorio=:Id";
        $query = $this->acceso->prepare($sql);
        $query->execute([':Id' => $id]);
        $this->objetos = $query->fetchall();

        $sql = "UPDATE laboratorio SET avatar=:nombre_foto WHERE Id_laboratorio=:Id";
        $query = $this->acceso->prepare($sql);
        $query->execute([':Id' => $id, ':nombre_foto' => $nombre_foto]);

        return $this->objetos;
    }
    public function editar(string $nombre, int $id_editado)
    {
        $sql = "UPDATE laboratorio SET nombre=:nombre WHERE id_laboratorio=:Id";
        $query = $this->acceso->prepare($sql);
        $query->execute([':Id' => $id_editado, ':nombre' => $nombre]);
        $this->objetos = $query->rowcount();
        echo 'editado';
    }
    public function search()
    {
        $sql = "SELECT * FROM empresa  WHERE nombre NOT LIKE ''ORDER BY id LIMIT 15";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }
}
