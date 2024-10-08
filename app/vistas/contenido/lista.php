<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Contenidos</title>
    <!-- Incluyendo Bootstrap CSS para una interfaz más moderna -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Contenidos</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href="index.php?action=crear" class="btn btn-primary">Crear nuevo contenido</a>
        </div>

        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contenidos as $contenido): ?>
                <tr>
                    <td><?= $contenido['id'] ?></td>
                    <td><?= htmlspecialchars($contenido['titulo']) ?></td>
                    <td><?= htmlspecialchars($contenido['tipo']) ?></td>
                    <td>
                        <?php if (!empty($contenido['imagen'])): ?>
                            <img src="public/<?= htmlspecialchars($contenido['imagen']) ?>" alt="Imagen del contenido" width="100" class="img-thumbnail">
                        <?php else: ?>
                            <span class="text-muted">Sin imagen</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-success btn-editar" data-id="<?= $contenido['id'] ?>">Editar</button>
                        <a href="index.php?action=eliminar&id=<?= $contenido['id'] ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este contenido?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Contenedor donde se cargará el formulario de edición de manera dinámica -->
        <div id="formulario-editar-contenido" class="mt-5"></div>
    </div>

    <!-- Incluyendo jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    // Script para cargar el formulario de edición mediante AJAX
    document.querySelectorAll('.btn-editar').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');

            // Hacer una solicitud AJAX para cargar el formulario de edición
            fetch(`index.php?action=editar&id=${id}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('formulario-editar-contenido').innerHTML = data;
                    window.scrollTo(0, document.getElementById('formulario-editar-contenido').offsetTop);
                })
                .catch(error => console.error('Error al cargar el formulario:', error));
        });
    });
    </script>
</body>
</html>
