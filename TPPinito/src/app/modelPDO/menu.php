<?php
namespace App\Models\PDO;
use App\Models\PDO\AccesoDatos;
include_once __DIR__ . '/AccesoDatos.php';

class Menu
{
    public $id;
    public $precio;
    public $nombre;
    public $sector;

    ///Registra una nueva comida al menu
    public static function Registrar($nombre, $precio, $sector)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $respuesta = "";
        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT ID_tipo_empleado FROM tipoempleado WHERE Descripcion = :sector AND Estado = 'A';");

            $consulta->bindValue(':sector', $sector, \PDO::PARAM_STR);
            $consulta->execute();
            $id_sector = $consulta->fetch();

            if ($id_sector != null) {
                $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO menu (nombre, precio, id_sector) 
                                                                VALUES (:nombre, :precio, :id_sector);");

                $consulta->bindValue(':nombre', $nombre, \PDO::PARAM_STR);
                $consulta->bindValue(':precio', $precio, \PDO::PARAM_INT);
                $consulta->bindValue(':id_sector', $id_sector[0], \PDO::PARAM_INT);

                $consulta->execute();

                return array("Estado" => "OK", "Mensaje" => "Registrado correctamente.");
            } else {
                return array("Estado" => "ERROR", "Mensaje" => "Debe ingresar un sector valido");
            }
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            return array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
    }

    ///Modifica el menu
    public static function Modificar($id, $nombre, $precio, $sector)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $respuesta = "";
        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT ID_tipo_empleado FROM tipoempleado WHERE Descripcion = :sector AND Estado = 'A';");

            $consulta->bindValue(':sector', $sector, \PDO::PARAM_STR);
            $consulta->execute();
            $id_sector = $consulta->fetch();

            if ($id_sector != null) {
                $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE menu SET nombre = :nombre, precio = :precio, id_sector = :id_sector
                                                                WHERE id = :id;");

                $consulta->bindValue(':nombre', $nombre, \PDO::PARAM_STR);
                $consulta->bindValue(':precio', $precio, \PDO::PARAM_INT);
                $consulta->bindValue(':id', $id, \PDO::PARAM_INT);
                $consulta->bindValue(':id_sector', $id_sector[0], \PDO::PARAM_INT);

                $consulta->execute();

                return array("Estado" => "OK", "Mensaje" => "Modificado correctamente.");
            } else {
                return array("Estado" => "ERROR", "Mensaje" => "Debe ingresar un sector valido");
            }
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            return array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
    }
    
    ///Listado completo del menu
    public static function Listar()
    {
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT m.id, m.nombre, m.precio, te.Descripcion as sector FROM menu m INNER JOIN 
                                                        tipoempleado te ON te.ID_tipo_empleado = m.id_sector;");

            $consulta->execute();

            return $consulta->fetchAll();
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            return array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
    }

    ///Baja de comida.
    public static function Baja($id)
    {
        echo ("#Debug - " . $id);
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM menu WHERE id = :id");

            $consulta->bindValue(':id', $id, \PDO::PARAM_INT);

            $consulta->execute();

            return array("Estado" => "OK", "Mensaje" => "Eliminado correctamente.");
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            return array("Estado" => "ERROR", "Mensaje" => "$mensaje");
        }
    }
}
?>