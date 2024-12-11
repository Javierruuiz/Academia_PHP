<?php
namespace Models;
use Lib\BaseDatos;
use PDOException;
use PDO;


class Pruebas{
    private string|null $id;
    private string $id_materia;
    private string $trimestre;
    private string $id_alumno;
    private string $horario;
    private string $nota;
    private BaseDatos $db;

    public function __construct(string|null $id=null, string $id_materia='', string $trimestre='', string $id_alumno='', string $horario='', string $nota='') {

        $this->id = $id;
        $this->id_materia = $id_materia;
        $this->trimestre = $trimestre;
        $this->id_alumno = $id_alumno;
        $this->horario = $horario;
        $this->nota = $nota;
        $this->db = new BaseDatos();
    }
    public function getId() : string|null {
        return $this->id;
    }

    public function setId(string|null $value) {
        $this->id = $value;
    }


    public function getId_materia() : string {
        return $this->id_materia;
    }

    public function setId_materia(string $value) {
        $this->id_materia = $value;
    }

    public function getTrimestre() : string{
        return $this->trimestre;
    }

    public function setTrimestre(string $value) {
        $this->trimestre = $value;
    }

    public function getId_alumno() : string {
        return $this->id_alumno;
    }

    public function setId_alumno(string $value) {
        $this->id_alumno = $value;
    }

    public function getHorario() : string {
        return $this->horario;
    }

    public function setHorario(string $value) {
        $this->horario = $value;
    }

    public function getNota() : string {
        return $this->nota;
    }

    public function setNota(string $value) {
        $this->nota = $value;
    }



    // Función para insertar valores en la tabla pruebas
    public function save(): bool {
        $id = NULL;
        $id_materia = $this->getId_materia();
        $trimestre = $this->getTrimestre();
        $id_alumno = $this->getId_alumno();
        $horario = $this->getHorario();
        $nota = $this->getNota();
        try {

            $ins = $this->db->prepare("INSERT INTO pruebas (id, id_materia, trimestre, id_alumno, nota, horario) VALUES (:id, :id_materia, :trimestre, :id_alumno, :nota, :horario)");
            $ins->bindValue( ':id', $id);
            $ins->bindValue(':id_materia', $id_materia, PDO::PARAM_STR);
            $ins->bindValue(':trimestre', $trimestre, PDO::PARAM_STR);
            $ins->bindValue(':id_alumno', $id_alumno, PDO::PARAM_STR);
            $ins->bindValue(':nota', $nota, PDO::PARAM_STR);
            $ins->bindValue(':horario', $horario, PDO::PARAM_STR);


            $ins->execute();
            $result = true;


        } catch (PDOException $err) {
            $result = false;
        }
        return $result;
    }

    /**
     * Verifica si existe una nota para un alumno, materia y trimestre específicos.
     * Realiza una consulta a la base de datos para contar la cantidad de notas que coinciden con los parámetros dados.
     * Devuelve true si existe al menos una nota para esos datos, false en caso contrario.
     * Maneja excepciones en caso de error en la consulta.
     */
    public function verificarNotaExistente($id_alumno, $id_materia, $trimestre) {
        try {
            $query = "SELECT COUNT(*) AS count FROM pruebas WHERE id_alumno = :id_alumno AND id_materia = :id_materia AND trimestre = :trimestre";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id_alumno', $id_alumno, PDO::PARAM_STR);
            $statement->bindParam(':id_materia', $id_materia, PDO::PARAM_STR);
            $statement->bindParam(':trimestre', $trimestre, PDO::PARAM_STR);
            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if ($result && $result['count'] > 0) {
                return true; // Existe una nota para el alumno, asignatura y trimestre dados
            } else {
                return false; // No existe una nota para el alumno, asignatura y trimestre dados
            }
        } catch (PDOException $err) {
            return false;
        }
    }

    /**
     * Esta función hace lo mismo que la anterior, cogiendo un parámetro más,
     * así evitamos que al editar pruebas haya duplicados.
     */
    public function verificarNotaExistenteEnOtraPrueba($id_alumno, $id_materia, $trimestre, $id_prueba_actual) {
        try {
            $query = "SELECT COUNT(*) AS count FROM pruebas WHERE id_alumno = :id_alumno AND id_materia = :id_materia AND trimestre = :trimestre AND id <> :id_prueba_actual";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id_alumno', $id_alumno, PDO::PARAM_STR);
            $statement->bindParam(':id_materia', $id_materia, PDO::PARAM_STR);
            $statement->bindParam(':trimestre', $trimestre, PDO::PARAM_STR);
            $statement->bindParam(':id_prueba_actual', $id_prueba_actual, PDO::PARAM_INT);
            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if ($result && $result['count'] > 0) {
                return true; // Existe una nota para el alumno, asignatura y trimestre dados (excluyendo la prueba actual)
            } else {
                return false; // No existe una nota para el alumno, asignatura y trimestre dados (excluyendo la prueba actual)
            }
        } catch (PDOException $err) {
            return false;
        }
    }


    /**
     * Obtiene todas las pruebas con información adicional (nombre del alumno y nombre de la materia).
     * Realiza una consulta a la base de datos para recuperar todas las pruebas con detalles de alumnos y materias asociadas.
     * Devuelve un array de objetos con la información de las pruebas.
     * Maneja excepciones en caso de error en la consulta.
     */

    public function obtenerTodasLasPruebas() {
        try {
            $query = "SELECT pruebas.*, alumnos.nombre AS nombre_alumno, alumnos.apellidos, materias.nombre_materia AS nombre_materia 
			FROM pruebas 
			INNER JOIN alumnos ON pruebas.id_alumno = alumnos.id 
			INNER JOIN materias ON pruebas.id_materia = materias.id";
            $statement = $this->db->query($query);
            $pruebas = $statement->fetchAll(PDO::FETCH_OBJ);
            $statement->closeCursor();

            return $pruebas;
        } catch (PDOException $err) {
            return [];
        }
    }



    /**
     * Obtiene una prueba con información adicional del alumno a partir de su ID.
     * Realiza una consulta a la base de datos para recuperar la prueba y detalles del alumno asociado.
     * Devuelve un objeto con la información de la prueba y el alumno.
     * Maneja excepciones en caso de error en la consulta.
     */
    public function obtenerPruebaConAlumnoPorId($id) {
        try {
            $query = "SELECT pruebas.*, alumnos.nombre AS nombre_alumno, alumnos.apellidos
				FROM pruebas
				INNER JOIN alumnos ON pruebas.id_alumno = alumnos.id
				WHERE pruebas.id = :id";

            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $prueba = $statement->fetch(PDO::FETCH_OBJ);
            $statement->closeCursor();

            return $prueba;
        } catch (PDOException $err) {
            return null;
        }
    }

    /**
     * Actualiza una prueba en la base de datos con la información proporcionada.
     * Realiza una consulta para actualizar los datos de una prueba existente con el ID dado.
     * Devuelve true si la actualización se realiza correctamente, false en caso contrario.
     * Maneja excepciones en caso de error en la consulta.
     */
    public function actualizarPrueba($id, $id_materia, $trimestre, $id_alumno, $horario, $nota) {
        try {
            $query = "UPDATE pruebas SET id_materia = :id_materia, trimestre = :trimestre, id_alumno = :id_alumno, nota = :nota, horario = :horario WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->bindParam(':id_materia', $id_materia, PDO::PARAM_STR);
            $statement->bindParam(':trimestre', $trimestre, PDO::PARAM_STR);
            $statement->bindParam(':id_alumno', $id_alumno, PDO::PARAM_STR);
            $statement->bindParam(':nota', $nota, PDO::PARAM_STR);
            $statement->bindParam(':horario', $horario, PDO::PARAM_STR);
            $result = $statement->execute();
            $statement->closeCursor();

            return $result;
        } catch (PDOException $err) {
            return false;
        }
    }


    /**
     * Elimina una prueba de la base de datos según su ID.
     * Realiza una consulta para eliminar una prueba específica.
     * Devuelve true si la eliminación se realiza correctamente, false en caso contrario.
     * Maneja excepciones en caso de error en la consulta.
     */
    public function eliminarPrueba($id) {
        try {
            $query = "DELETE FROM pruebas WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);

            $result = $statement->execute();
            $statement->closeCursor();

            return $result;
        } catch (PDOException $err) {
            return false;
        }
    }


    /**
     * Obtiene las notas de los alumnos para una materia y trimestre específicos.
     * Realiza una consulta para obtener las notas de los alumnos asociadas a una materia y trimestre dados.
     * Devuelve un array con la información de las notas.
     * Maneja excepciones en caso de error en la consulta.
     */
    public function obtenerNotasPorMateriaYTrimestre($id_materia, $trimestre) {
        try {
            $query = "SELECT alumnos.nombre, alumnos.apellidos, pruebas.horario, pruebas.nota 
					  FROM pruebas 
					  INNER JOIN alumnos ON pruebas.id_alumno = alumnos.id 
					  WHERE pruebas.id_materia = :id_materia 
					  AND pruebas.trimestre = :trimestre";

            $statement = $this->db->prepare($query);
            $statement->bindParam(':id_materia', $id_materia, PDO::PARAM_STR);
            $statement->bindParam(':trimestre', $trimestre, PDO::PARAM_STR);
            $statement->execute();

            $notas = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();

            return $notas ? $notas : [];
        } catch (PDOException $err) {
            return [];
        }
    }


    /**
     * Obtiene las notas de un alumno específico.
     * Realiza una consulta para obtener las notas de un alumno según su ID.
     * Devuelve un array con la información de las notas del alumno.
     * Maneja excepciones en caso de error en la consulta.
     */
    public function obtenerNotasPorAlumno($id_alumno): array {
        try {
            $query = "SELECT p.trimestre, p.nota, m.nombre_materia 
					  FROM pruebas p 
					  JOIN materias m ON p.id_materia = m.id 
					  WHERE p.id_alumno = :id_alumno ORDER BY p.trimestre asc";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $err) {
            return [];
        }
    }


    /**
     * Obtiene las notas medias de los alumnos para una asignatura específica.
     * Realiza una consulta para calcular las notas medias de los alumnos asociadas a una asignatura dada.
     * Devuelve un array con la información de las notas medias por alumno.
     * Maneja excepciones en caso de error en la consulta.
     */
    public function obtenerAlumnosNotasMediasPorAsignatura($id_materia): array {
        try {
            $query = "SELECT a.nombre, a.apellidos, AVG(p.nota) AS nota_media 
					  FROM pruebas p 
					  JOIN alumnos a ON p.id_alumno = a.id 
					  WHERE p.id_materia = :id_materia 
					  GROUP BY a.id";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $err) {
            return [];
        }
    }

    /**
     * Obtiene las notas medias de un alumno para todas sus asignaturas.
     * Realiza una consulta para calcular las notas medias de un alumno según su ID.
     * Devuelve un array con la información de las notas medias por asignatura.
     * Maneja excepciones en caso de error en la consulta.
     */
    public function obtenerNotasMediasPorAlumno($id_alumno): array {
        try {
            $query = "SELECT materias.nombre_materia, AVG(pruebas.nota) as nota_media 
					  FROM pruebas 
					  INNER JOIN materias ON pruebas.id_materia = materias.id 
					  WHERE pruebas.id_alumno = :id_alumno 
					  GROUP BY pruebas.id_materia";

            $statement = $this->db->prepare($query);
            $statement->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $err) {
            return [];
        }
    }



}
