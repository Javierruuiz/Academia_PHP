<?php
namespace Models;
use Lib\BaseDatos;
use PDOException;
use PDO;


class Alumnos{
    private string|null $id;
    private string $nombre;
    private string $apellidos;
    private string $id_padre;
    private BaseDatos $db;

    public function __construct(string|null $id=null, string $nombre='', string $apellidos='', string $id_padre='') {

        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->id_padre = $id_padre;
        $this->db = new BaseDatos();
    }

    public function getId() : string|null {
        return $this->id;
    }

    public function setId(string|null $value) {
        $this->id = $value;
    }

    public function getNombre() : string {
        return $this->nombre;
    }

    public function setNombre(string $value) {
        $this->nombre = $value;
    }

    public function getApellidos() : string {
        return $this->apellidos;
    }

    public function setApellidos(string $value) {
        $this->apellidos = $value;
    }

    public function getId_padre() : string {
        return $this->id_padre;
    }

    public function setId_padre(string $value) {
        $this->id_padre = $value;
    }


    // Función para insertar valores en la tabla alumnos
    public function save(): bool {
        $id = NULL;
        $nombre = $this->getNombre();
        $apellidos = $this->getApellidos();
        $id_padre = $this->getId_padre();
        try {

            $ins = $this->db->prepare("INSERT INTO alumnos (id, nombre, apellidos, id_padre) VALUES (:id, :nombre, :apellidos, :id_padre)");
            $ins->bindValue( ':id', $id);
            $ins->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $ins->bindValue(':apellidos', $apellidos, PDO::PARAM_STR);
            $ins->bindValue(':id_padre', $id_padre, PDO::PARAM_STR);

            $ins->execute();

            $result = true;

        } catch (PDOException $err) {
            $result = false;
        }
        return $result;
    }


    /**
     * Función para obtener el ID de un alumno basado en su nombre y apellidos.
     * Busca en la base de datos el ID del alumno que coincide con el nombre y apellidos proporcionados.
     * Devuelve el ID del alumno encontrado o NULL si no se encuentra ningún alumno.
     * Maneja excepciones en caso de error en la consulta.
     */

    public function obtenerIdPorNombreYApellidos($nombre, $apellidos) {
        try {
            $query = "SELECT id FROM alumnos WHERE nombre = :nombre AND apellidos = :apellidos LIMIT 1";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $statement->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result['id']; // Devuelve el ID del alumno encontrado
            } else {
                return null; // Si no se encuentra el alumno, devuelve NULL o puedes manejarlo de otra manera según tu lógica de la aplicación
            }
        } catch (PDOException $err) {
            return null;
        }
    }


    /**
     * Función para obtener todos los nombres y apellidos de los alumnos.
     * Realiza una consulta a la base de datos para obtener el ID, nombre y apellidos de todos los alumnos.
     * Devuelve un arreglo con la información de los alumnos encontrados.
     * Maneja excepciones en caso de error en la consulta.
     */

    public function obtenerTodosLosNombresApellidos(): array {
        try {
            $query = "SELECT id, nombre, apellidos FROM alumnos";
            $statement = $this->db->prepare($query);
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $err) {
            return [];
        }
    }


}
