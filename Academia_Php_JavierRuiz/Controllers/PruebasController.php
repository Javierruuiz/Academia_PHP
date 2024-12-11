<?php
namespace Controllers;
Use Lib\Pages;
use Models\Pruebas;
use Models\Materias;
use Models\Alumnos;
use Dompdf\Dompdf;

use Utils\PDFGenerator;

class PruebasController {
    private Pages $pages;




    function __construct(){

        $this->pages= new Pages();


    }


    /**
     * Función para manejar el registro de pruebas por profesor.
     * Obtiene las materias asignadas al profesor y todas las pruebas existentes.
     * Muestra la interfaz para el registro de pruebas, permitiendo asociarlas a las materias.
     * Redirige si no se encuentra un profesor en sesión o si no tiene el rol adecuado.
     */
    public function registroPrueba(): void {
        if ($_SESSION['identity'] && $_SESSION['identity']->rol === 'profesor') {
            $id_profesor = $_SESSION['identity']->id; // Obtener el ID del profesor desde la sesión

            $materia = new Materias();
            $materias = $materia->obtenerMateriasPorProfesor($id_profesor); // Obtener las materias asignadas al profesor


            $pruebaModel = new Pruebas();
            $pruebas = $pruebaModel->obtenerTodasLasPruebas();

            // Pasar las materias asignadas al profesor a la vista del formulario
            $this->pages->render('pruebas/Pruebas', ['materias' => $materias, 'pruebas' => $pruebas]);


        } else if($_SESSION['identity'] && $_SESSION['identity']->rol === 'admin'){
            $pruebaModel = new Pruebas();
            $pruebas = $pruebaModel->obtenerTodasLasPruebas();
            $materia = new Materias();
            $materias = $materia->obtenerMaterias();
            $this->pages->render('pruebas/Pruebas', ['materias' => $materias, 'pruebas' => $pruebas]);
        }else {
            // Manejar el caso en el que no se encuentra un profesor en la sesión o no tiene el rol adecuado
            $_SESSION['prueba_added'] = "failed";
            header('Location:'.BASE_URL.'pruebas/registroPrueba/');
        }
    }


    /**
     * Función para agregar una nueva prueba al sistema.
     * Valida los datos enviados por POST, verifica si la prueba ya existe y la guarda en la base de datos si es nueva.
     * Establece variables de sesión para informar sobre el resultado de la operación.
     * Redirige a la página de registro de pruebas una vez se completa el proceso.
     */
    public function agregarPrueba(): void {
        if ($_SESSION['identity'] && (($_SESSION['identity']->rol === 'profesor')||($_SESSION['identity']->rol === 'admin'))) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Verificar si el usuario tiene permiso de administrador para registrar usuarios
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Obtener datos del formulario
                    $id_materia = $_POST['id_materia'];
                    $trimestre = $_POST['trimestre'];
                    $nombre_alumno = $_POST['nombre_alumno'];
                    $apellidos_alumno = $_POST['apellidos_alumno'];
                    $horario = $_POST['horario'];
                    $nota = $_POST['nota'];

                    // Buscar el ID del alumno basado en el nombre y apellidos
                    $alumno = new Alumnos();
                    $id_alumno = $alumno->obtenerIdPorNombreYApellidos($nombre_alumno, $apellidos_alumno);

                    if ($id_alumno) {
                        $pruebaModel = new Pruebas();
                        $pruebaExistente = $pruebaModel->verificarNotaExistente($id_alumno, $id_materia, $trimestre);

                        if ($pruebaExistente) {
                            $_SESSION['prueba_added'] = "duplicate";
                        } else {
                            $prueba = new Pruebas(null, $id_materia, $trimestre, $id_alumno, $horario, $nota);
                            $save = $prueba->save();

                            if ($save) {
                                $_SESSION['prueba_added'] = "complete";
                            } else {
                                $_SESSION['prueba_added'] = "failed";
                            }
                        }
                    } else {
                        $_SESSION['prueba_added'] = "failed";
                    }
                }

                header('Location:'.BASE_URL.'pruebas/registroPrueba/');
            }
        }else {
            // Manejar el caso en el que no se encuentra un profesor en la sesión o no tiene el rol adecuado
            $_SESSION['prueba_added'] = "failed";
            header('Location:'.BASE_URL.'pruebas/registroPrueba/');
        }
    }




    /**
     * Función para editar una prueba existente.
     * Obtiene los detalles de la prueba por ID y muestra un formulario de edición.
     * Permite modificar los datos y asociar la prueba a un alumno y materia.
     * Maneja casos donde no se encuentra la prueba o el alumno.
     */
    public function editarPrueba() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $pruebaModel = new Pruebas();
            $pruebas = $pruebaModel->obtenerPruebaConAlumnoPorId($id);

            if ($pruebas) {
                $materia = new Materias();
                if ($_SESSION['identity']->rol === 'profesor') {
                    $id_profesor = $_SESSION['identity']->id;
                    $materias = $materia->obtenerMateriasPorProfesor($id_profesor);
                } else if ($_SESSION['identity']->rol === 'admin') {
                    $materias = $materia->obtenerMaterias();
                }

                $alumnoModel = new Alumnos();
                $id_alumno = $alumnoModel->obtenerIdPorNombreYApellidos($pruebas->nombre_alumno, $pruebas->apellidos);

                if ($id_alumno) {
                    // Renderizar la vista del formulario de edición con los datos de la prueba y el ID del alumno
                    $this->pages->render('pruebas/FormularioEdicion', ['pruebas' => $pruebas, 'materias' => $materias, 'id_alumno' => $id_alumno]);
                    return;
                }
            }
            // Manejar la situación si no se encuentra la prueba o el alumno
            echo "La prueba o el alumno no existen.";
        } else {
            echo "No se proporcionó un ID válido para editar la prueba.";
        }
    }


    /**
     * Función para actualizar una prueba existente en la base de datos.
     * Valida los datos enviados por POST, actualiza la prueba y establece mensajes de sesión según el resultado.
     * Redirige a la página de registro de pruebas una vez se completa el proceso.
     */
    public function actualizarPrueba() {
        $id = $_GET['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $id_materia = $_POST['id_materia'];
            $trimestre = $_POST['trimestre'];
            $nombre_alumno = $_POST['nombre_alumno'];
            $apellidos_alumno = $_POST['apellidos_alumno'];
            $horario = $_POST['horario'];
            $nota = $_POST['nota'];

            $alumno = new Alumnos();
            $id_alumno = $alumno->obtenerIdPorNombreYApellidos($nombre_alumno, $apellidos_alumno);

            if ($id_alumno) {
                $pruebaModel = new Pruebas();
                // Verificar si ya existe una prueba con el mismo trimestre, alumno y materia (excluyendo la prueba actual)
                $pruebaExistente = $pruebaModel->verificarNotaExistenteEnOtraPrueba($id_alumno, $id_materia, $trimestre, $id);

                if ($pruebaExistente) {
                    $_SESSION['prueba_updated'] = "duplicate";
                } else {
                    // Actualizar la prueba si no hay duplicados
                    $result = $pruebaModel->actualizarPrueba($id, $id_materia, $trimestre, $id_alumno, $horario, $nota);

                    if ($result) {
                        $_SESSION['prueba_updated'] = "complete";
                    } else {
                        $_SESSION['prueba_updated'] = "failed";
                    }
                }
            } else {
                $_SESSION['prueba_updated'] = "failed";
            }
        }

        header('Location:' . BASE_URL . 'pruebas/registroPrueba/');
    }


    /**
     * Función para eliminar una prueba existente del sistema.
     * Recibe el ID de la prueba a eliminar desde la solicitud GET.
     * Elimina la prueba correspondiente mediante el modelo de Pruebas.
     * Establece una variable de sesión según el resultado de la eliminación.
     * Redirige a la página de registro de pruebas después de completar la operación.
     */
    public function eliminarPrueba() {
        $id = $_GET['id'] ?? null;

        if ($_SESSION['identity'] && ($_SESSION['identity']->rol === 'profesor' || $_SESSION['identity']->rol === 'admin')) {
            if ($id) {
                $pruebaModel = new Pruebas();
                $result = $pruebaModel->eliminarPrueba($id);

                if ($result) {
                    $_SESSION['prueba_deleted'] = "complete";
                } else {
                    $_SESSION['prueba_deleted'] = "failed";
                }
            }
        } else {
            // Manejar el caso en el que el usuario no tiene permisos
            $_SESSION['prueba_deleted'] = "unauthorized";
        }

        header('Location:' . BASE_URL . 'pruebas/registroPrueba/');
    }




    /**
     * Función para generar un PDF con listados de materias y alumnos.
     * Obtiene las materias y todos los nombres de los alumnos para mostrar en el PDF.
     * Renderiza la vista correspondiente para generar el PDF.
     */
    public function generarPDF(): void {
        $materiasModel = new Materias();
        $materias = $materiasModel->obtenerMaterias();

        $alumnoModel = new Alumnos();
        $alumnos = $alumnoModel->obtenerTodosLosNombresApellidos();


        $this->pages->render('pruebas/GeneradorPDF', ['materias' => $materias, 'alumnos' => $alumnos]);
    }




    /**
     * Función para generar un listado de notas por materia y trimestre en formato PDF.
     * Obtiene las notas de las pruebas según la materia y trimestre seleccionados.
     * Genera un PDF con el listado de notas y lo muestra en el navegador.
     */
    public function NotasPorMateriaYTrimestre() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_materia = $_POST['id_materia'] ?? null;
            $trimestre = $_POST['trimestre'] ?? null;

            $pruebaModel = new Pruebas();
            $notas = $pruebaModel->obtenerNotasPorMateriaYTrimestre($id_materia, $trimestre);

            // Obtener el HTML desde la vista
            $pdfContent = PDFGenerator::renderToString('pruebas/ListadodeNotas', ['notas' => $notas]);

            // Generar el PDF
            $dompdf = new Dompdf();
            $dompdf->loadHtml($pdfContent);

            // Opcional: ajustar configuraciones del PDF
            $dompdf->setPaper('A4', 'landscape');

            // Renderizar el PDF
            $dompdf->render();

            // Enviar el PDF al navegador
            $dompdf->stream('Listado_de_Notas.pdf', ['Attachment' => 0]);
        }
    }


    /**
     * Función para generar un listado completo de notas por alumno en formato PDF.
     * Obtiene todas las notas del alumno seleccionado y genera un PDF con el listado completo.
     * Muestra el PDF en el navegador.
     */
    public function ListadoCompletoPorAlumno() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_alumno = $_POST['alumno'] ?? null;

            if ($id_alumno) {
                $pruebaModel = new Pruebas();
                $notas = $pruebaModel->obtenerNotasPorAlumno($id_alumno);

                // Generar el PDF
                $pdfContent = PDFGenerator::renderToString('pruebas/ListadoCompleto', ['notas' => $notas]);

                // Crear una instancia de Dompdf
                $dompdf = new Dompdf();

                // Cargar el HTML en Dompdf
                $dompdf->loadHtml($pdfContent);

                // (Opcional) Configurar el tamaño y orientación del papel
                $dompdf->setPaper('A4', 'landscape');

                // Renderizar el PDF
                $dompdf->render();

                // Mostrar el PDF en el navegador
                $dompdf->stream('Listado_Completo.pdf', ['Attachment' => 0]);
            } else {
                echo "No se seleccionó ningún alumno.";
            }
        }
    }

    /**
     * Función para generar un listado de notas medias por asignatura en formato PDF.
     * Obtiene las notas medias por asignatura y genera un PDF con este listado.
     * Muestra el PDF en el navegador.
     */
    public function NotasMediasPorAsignatura(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_materia = $_POST['id_materia'] ?? null;

            if ($id_materia) {
                $pruebaModel = new Pruebas();
                $alumnosNotasMedias = $pruebaModel->obtenerAlumnosNotasMediasPorAsignatura($id_materia);

                // Renderizar el contenido del PDF
                $pdfContent = PDFGenerator::renderToString('pruebas/ListadoNotasMedias', ['alumnosNotasMedias' => $alumnosNotasMedias]);

                $dompdf = new Dompdf();

                // Cargar el HTML en Dompdf
                $dompdf->loadHtml($pdfContent);

                // (Opcional) Configurar el tamaño y orientación del papel
                $dompdf->setPaper('A4', 'landscape');

                // Renderizar el PDF
                $dompdf->render();

                // Mostrar el PDF en el navegador
                $dompdf->stream('Listado_Notas_Medias.pdf', ['Attachment' => 0]);
            } else {
                echo "No se seleccionó ningún alumno.";
            }
        }
    }

    /**
     * Función para generar un listado de notas medias por alumno en formato PDF.
     * Obtiene las notas medias del alumno seleccionado por asignatura y genera un PDF con este listado.
     * Muestra el PDF en el navegador.
     */
    public function NotasMediasPorAlumno() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_alumno = $_POST['alumno'] ?? null;

            if ($id_alumno) {
                $pruebaModel = new Pruebas();
                $asignaturasNotas = $pruebaModel->obtenerNotasMediasPorAlumno($id_alumno); // Obtener asignaturas y notas medias


                $pdfContent = PDFGenerator::renderToString('pruebas/ListadoNotasMediasPorAlumno', ['asignaturasNotas' => $asignaturasNotas]);
                $dompdf = new Dompdf();

                // Cargar el HTML en Dompdf
                $dompdf->loadHtml($pdfContent);

                // (Opcional) Configurar el tamaño y orientación del papel
                $dompdf->setPaper('A4', 'landscape');

                // Renderizar el PDF
                $dompdf->render();

                // Mostrar el PDF en el navegador
                $dompdf->stream('Listado_Notas_Medias_Por_Alumno.pdf', ['Attachment' => 0]);

            } else {
                echo "No se seleccionó ningún alumno.";
            }
        }
    }



}

?>
