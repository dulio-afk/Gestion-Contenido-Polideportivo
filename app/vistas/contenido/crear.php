<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Contenido</title>
</head>
<body>
    <h1>Crear Nuevo Contenido</h1>
    <form action="index.php?action=crear" method="POST" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
        <br><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion"></textarea>
        <br><br>

        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
            <option value="curso">Curso</option>
            <option value="taller">Taller</option>
            <option value="evento">Evento</option>
        </select>
        <br><br>

        <label for="horario">Horario:</label>
        <input type="text" id="horario" name="horario">
        <br><br>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen">
        <br><br>

        <input type="submit" value="Crear Contenido">
    </form>
    <br>
    <a href="index.php">Volver a la lista de contenidos</a>
</body>
</html>
