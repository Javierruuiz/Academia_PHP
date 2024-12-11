<?php
namespace Models;
use Lib\BaseDatos;
use PDOException;
use PDO;


class Materias{
    private string|null $id;
    private string $nombre_materia;
    private string $id_profesor;
    private BaseDatos $db;

    public function __construct(string|null $id=null, string $nombre_materia='', string $id_profesor='') {

        $this->id = $id;
        $this->nombre_materia = $nombre_materia;
        $this->id_profesor = $id_profesor;
        $this->db = new BaseDatos();
    }

    public function getId() : string|null {
        return $this->id;
    }

    public function setId(string|null $value) {
        $this->id = $value;
    }

    public function getNombre_materia() : string {
        return $this->nombre_materia;
    }

    public function setNombre_materia(string $value) {
        $this->nombre_materia = $value;
    }

    public function getId_profesor() : string {
        return $this->id_profesor;
    }

    public function setId_profesor(string $value) {
        $this->id_profesor = $value;
    }


    // Función para insertar valores en la tabla materias
    public function save(): bool {
        $id = NULL;
        $nombre_materia = $this->getNombre_Materia();
        $id_profesor = $this->getId_Profesor();
        try {

            $ins = $this->db->prepare("INSERT INTO materias (id, nombre_materia, id_profesor) VALUES (:id, :nombre_materia, :id_profesor)");
            $ins->bindValue( ':id', $id);
            $ins->bindValue(':nombre_materia', $nombre_materia, PDO::PARAM_STR);
            $ins->bindValue(':id_profesor', $id_profesor, PDO::PARAM_STR);
            $ins->execute();

            $result = true;

        } catch (PDOException $err) {
            $result = false;
        }
        return $result;
    }

    /**
     * Función para obtener todas las materias.
     * Realiza una consulta a la base de datos para recuperar todas las materias ordenadas por ID descendente.
     * Devuelve un array de objetos con la información de las materias.
     * Cierra la conexión y libera recursos.
     */
    public function obtenerMaterias(){

        $materia=$this->db->prepare("SELECT * FROM materias ORDER BY id DESC");
        $materia->execute();

        $materias = $materia->fetchAll(PDO::FETCH_OBJ);
        $materia->closeCursor();
        $materia=null;
        return $materias;

    }


    /**
     * Función para buscar una materia por su ID.
     * Realiza una consulta a la base de datos para recuperar la materia que coincide con el ID proporcionado.
     * Devuelve un objeto con la información de la materia encontrada o NULL si no se encuentra.
     * Maneja excepciones en caso de error en la consulta.
     */
    public function buscarPorId(string $id): ?object {
        try {
            $query = $this->db->prepare("SELECT * FROM materias WHERE id = :id");
            $query->bindValue(':id', $id, PDO::PARAM_STR);
            $query->execute();

            $materia = $query->fetch(PDO::FETCH_OBJ);

            return $materia ? $materia : null;
        } catch (PDOException $err) {
            return null;
        }
    }

    /**
     * Función para obtener todas las materias asignadas a un profesor.
     * Realiza una consulta a la base de datos para recuperar las materias asociadas al ID del profesor.
     * Devuelve un array de objetos con la información de las materias encontradas o NULL si no hay ninguna.
     * Maneja excepciones en caso de error en la consulta.
     */

    public function obtenerMateriasPorProfesor(string $idProfesor): ?array {
        try {
            $query = $this->db->prepare("SELECT * FROM materias WHERE id_profesor = :id_profesor");
            $query->bindValue(':id_profesor', $idProfesor, PDO::PARAM_STR);
            $query->execute();

            $materias = $query->fetchAll(PDO::FETCH_OBJ); // Usar fetchAll para obtener todas las materias asignadas al profesor

            return $materias ? $materias : null;
        } catch (PDOException $err) {
            return null;
        }
    }

    /**
     * Función para buscar una materia por su nombre.
     * Realiza una consulta a la base de datos para recuperar la materia que coincide con el nombre proporcionado.
     * Devuelve un objeto con la información de la materia encontrada o NULL si no se encuentra.
     * Maneja excepciones en caso de error en la consulta.
     */
    public function buscarPorNombre(string $nombreMateria): ?object {
        try {
            $query = $this->db->prepare("SELECT * FROM materias WHERE nombre_materia = :nombre_materia");
            $query->bindValue(':nombre_materia', $nombreMateria, PDO::PARAM_STR);
            $query->execute();

            $materia = $query->fetch(PDO::FETCH_OBJ);

            return $materia ? $materia : null;
        } catch (PDOException $err) {
            return null;
        }
    }

}
