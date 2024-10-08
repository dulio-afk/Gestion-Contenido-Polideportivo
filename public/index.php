<?php
require_once __DIR__ . '/../config/configuracion.php';
require_once __DIR__ . '/../app/modelos/Contenido.php';
require_once __DIR__ . '/../app/modelos/conexion.php';

// Inicializar la conexión
$conexionObj = new Conexion();
$conexion = $conexionObj->abrirConexion();
if (!$conexion) {
    die("Error: No se pudo conectar a la base de datos.");
}

// Inicializamos el modelo de contenido utilizando la conexión devuelta
$modeloContenido = new Contenido($conexion);

// Verificamos la acción solicitada
$accion = isset($_GET['action']) ? $_GET['action'] : 'listar';

// Procesar la acción
switch ($accion) {
    case 'listar':
        $contenidos = $modeloContenido->obtenerTodos();
        break;

    case 'crear':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Procesar el formulario de creación
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $tipo = $_POST['tipo'];
            $horario = $_POST['horario'];
            $imagen = '';

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $imagen = 'uploads/' . basename($_FILES['imagen']['name']);
                move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../public/' . $imagen);
            }

            $modeloContenido->crear($titulo, $descripcion, $tipo, $horario, $imagen);
            header('Location: index.php');
            exit;
        } else {
            if (file_exists(__DIR__ . '/../app/vistas/contenido/crear.php')) {
                require_once __DIR__ . '/../app/vistas/contenido/crear.php';
            } else {
                echo "Error: la vista de creación no existe.";
            }
            exit;
        }
        break;

    case 'editar':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Procesar el formulario de edición
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $tipo = $_POST['tipo'];
            $horario = $_POST['horario'];
            $imagen = $_POST['imagen_actual'];

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $imagen = 'uploads/' . basename($_FILES['imagen']['name']);
                move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../public/' . $imagen);
            }

            $modeloContenido->editar($id, $titulo, $descripcion, $tipo, $horario, $imagen);
            header('Location: index.php');
            exit;
        } else {
            $contenido = $modeloContenido->obtenerPorId($id);
            if (file_exists(__DIR__ . '/../app/vistas/contenido/editar.php')) {
                require_once __DIR__ . '/../app/vistas/contenido/editar.php';
            } else {
                echo "Error: la vista de edición no existe.";
            }
            exit;
        }
        break;

    case 'eliminar':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $modeloContenido->eliminar($id);
        header('Location: index.php');
        exit;
        break;

    default:
        header('Location: index.php');
        exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panel de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Polideportivo</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="?action=listar">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Contenidos</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="?action=crear">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>Crear Contenido</span>
                </a>
            </li>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrador</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">
                    <div class="d-flex justify-content-end mb-4">
                        <a href="?action=crear" class="btn btn-success">+ Crear Nuevo Contenido</a>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de Contenidos</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Título</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($contenidos) && is_array($contenidos) && count($contenidos) > 0) : ?>
                                            <?php foreach ($contenidos as $contenido) : ?>
                                                <tr>
                                                    <td><?= $contenido['id'] ?></td>
                                                    <td><?= $contenido['titulo'] ?></td>
                                                    <td>
                                                        <a href="?action=editar&id=<?= $contenido['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                                                        <a href="?action=eliminar&id=<?= $contenido['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este contenido?');">Eliminar</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="3" class="text-center">No hay contenidos disponibles.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Polideportivo 2024</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
