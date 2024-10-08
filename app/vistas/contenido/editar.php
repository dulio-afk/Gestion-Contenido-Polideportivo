<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Contenido</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Contenido</h1>

        <!-- Formulario para editar contenido -->
        <form action="index.php?action=editar&id=<?= htmlspecialchars($contenido['id']) ?>" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" value="<?= htmlspecialchars($contenido['titulo']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label for="tipo" class="form-label">Tipo:</label>
                    <select id="tipo" name="tipo" class="form-select" required>
                        <option value="curso" <?= $contenido['tipo'] == 'curso' ? 'selected' : '' ?>>Curso</option>
                        <option value="taller" <?= $contenido['tipo'] == 'taller' ? 'selected' : '' ?>>Taller</option>
                        <option value="evento" <?= $contenido['tipo'] == 'evento' ? 'selected' : '' ?>>Evento</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="4"><?= htmlspecialchars($contenido['descripcion']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="horario" class="form-label">Horario:</label>
                <input type="text" id="horario" name="horario" class="form-control" value="<?= htmlspecialchars($contenido['horario']) ?>">
            </div>

            <div class="mb-3">
                <label for="imagen_actual" class="form-label">Imagen Actual:</label><br>
                <?php if (!empty($contenido['imagen'])): ?>
                    <img src="/public/<?= htmlspecialchars($contenido['imagen']) ?>" alt="Imagen del contenido" class="img-thumbnail mb-3" width="150">
                    <input type="hidden" name="imagen_actual" value="<?= htmlspecialchars($contenido['imagen']) ?>">
                <?php else: ?>
                    <p>No hay imagen disponible.</p>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Nueva Imagen (opcional):</label>
                <input type="file" id="imagen" name="imagen" class="form-control">
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="index.php" class="btn btn-secondary">Volver a la lista de contenidos</a>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
