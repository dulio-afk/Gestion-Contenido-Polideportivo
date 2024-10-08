<?php
class Contenido {
    private $conexion;

    // Constructor que acepta la conexión como argumento
    public function __construct($db) {
        $this->conexion = $db;
    }

    // Método para obtener todos los contenidos
    public function obtenerTodos() {
        try {
            $query = "SELECT * FROM contenidos";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Error al obtener contenidos: " . $e->getMessage());
            return [];
        }
    }

    // Método para obtener un contenido por su ID
    public function obtenerPorId($id) {
        try {
            $query = "SELECT * FROM contenidos WHERE id = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (Exception $e) {
            error_log("Error al obtener contenido por ID: " . $e->getMessage());
            return null;
        }
    }

    // Método para crear un nuevo contenido
    public function crear($titulo, $descripcion, $tipo, $horario, $imagenUrl) {
        try {
            $query = "INSERT INTO contenidos (titulo, descripcion, tipo, horario, imagen) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param('sssss', $titulo, $descripcion, $tipo, $horario, $imagenUrl);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error al crear contenido: " . $e->getMessage());
            return false;
        }
    }

    // Método para editar contenido existente
    public function editar($id, $titulo, $descripcion, $tipo, $horario, $imagenUrl) {
        try {
            $query = "UPDATE contenidos SET titulo = ?, descripcion = ?, tipo = ?, horario = ?, imagen = ? WHERE id = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param('sssssi', $titulo, $descripcion, $tipo, $horario, $imagenUrl, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error al editar contenido: " . $e->getMessage());
            return false;
        }
    }

    // Método para eliminar contenido
    public function eliminar($id) {
        try {
            $query = "DELETE FROM contenidos WHERE id = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param('i', $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error al eliminar contenido: " . $e->getMessage());
            return false;
        }
    }
}
?>
