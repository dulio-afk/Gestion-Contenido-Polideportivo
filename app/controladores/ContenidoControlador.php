<?php
require_once 'app/modelos/Contenido.php';

class ContenidoControlador {
    private $contenido;

    public function __construct($db) {
        $this->contenido = new Contenido($db);
    }

    // Método para listar todos los contenidos
    public function listar() {
        $contenidos = $this->contenido->obtenerTodos();

        // Almacenamos el título de la página y el contenido para pasar al layout
        $titulo_pagina = 'Lista de Contenidos';

        // Iniciamos el buffer de salida para la vista
        ob_start();
        include 'app/vistas/contenido/lista.php';
        $contenido = ob_get_clean();

        // Incluir el layout principal con el contenido generado
        include 'app/vistas/layout.php';
    }

    // Método para crear nuevo contenido
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $tipo = $_POST['tipo'];
            $horario = $_POST['horario'];

            // Manejo de la imagen
            $imagenUrl = '';
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $nombreImagen = uniqid() . '_' . basename($_FILES['imagen']['name']);
                $rutaDestino = __DIR__ . '/../../public/uploads/' . $nombreImagen;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    $imagenUrl = 'uploads/' . $nombreImagen;
                }
            }

            // Crear el contenido
            $this->contenido->crear($titulo, $descripcion, $tipo, $horario, $imagenUrl);

            // Redireccionar a la lista de contenidos
            header('Location: index.php');
            exit;
        } else {
            // Renderizamos la vista de creación de contenido
            $titulo_pagina = 'Crear Contenido';

            ob_start();
            include 'app/vistas/contenido/crear.php';
            $contenido = ob_get_clean();

            // Incluir el layout principal con el contenido generado
            include 'app/vistas/layout.php';
        }
    }

    // Método para editar un contenido existente
    public function editar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $tipo = $_POST['tipo'];
            $horario = $_POST['horario'];

            // Manejo de la imagen
            $imagenUrl = $_POST['imagen_actual'];
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $nombreImagen = uniqid() . '_' . basename($_FILES['imagen']['name']);
                $rutaDestino = __DIR__ . '/../../public/uploads/' . $nombreImagen;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    $imagenUrl = 'uploads/' . $nombreImagen;
                }
            }

            // Actualizar el contenido
            $this->contenido->editar($id, $titulo, $descripcion, $tipo, $horario, $imagenUrl);

            // Redireccionar a la lista de contenidos
            header('Location: index.php');
            exit;
        } else {
            // Obtener el contenido por ID
            $contenido = $this->contenido->obtenerPorId($id);

            // Renderizar la vista de edición de contenido
            $titulo_pagina = 'Editar Contenido';

            ob_start();
            include 'app/vistas/contenido/editar.php';
            $contenidoVista = ob_get_clean();

            // Incluir el layout principal con el contenido generado
            include 'app/vistas/layout.php';
        }
    }

    // Método para eliminar un contenido
    public function eliminar($id) {
        // Eliminar el contenido
        $this->contenido->eliminar($id);

        // Redireccionar a la lista de contenidos
        header('Location: index.php');
    }
}
