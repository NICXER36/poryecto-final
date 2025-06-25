<?php
/**
 * Archivo para editar proyectos existentes
 * Este archivo maneja el formulario y la lógica para modificar
 * proyectos existentes en el portafolio
 */

// Incluir archivos necesarios
include 'auth.php';  // Verificación de autenticación
include 'db.php';    // Conexión a la base de datos

// Obtener el ID del proyecto a editar
$id = $_GET['id'];
// Consultar los datos del proyecto
$sql = "SELECT * FROM proyectos WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $url_github = $_POST['url_github'];
    $url_produccion = $_POST['url_produccion'];
    $categoria = $_POST['categoria'];

    // Verificar si se subió una nueva imagen
    if ($_FILES['imagen']['name']) {
        // Procesar la nueva imagen
        $imagen = $_FILES['imagen']['name'];
        $tmp = $_FILES['imagen']['tmp_name'];
        move_uploaded_file($tmp, "uploads/$imagen");
        // Actualizar proyecto con nueva imagen
        $sql = "UPDATE proyectos SET nombre='$nombre', descripcion='$descripcion', 
                url_github='$url_github', url_produccion='$url_produccion', imagen='$imagen', categoria='$categoria' 
                WHERE id=$id";
    } else {
        // Actualizar proyecto manteniendo la imagen actual
        $sql = "UPDATE proyectos SET nombre='$nombre', descripcion='$descripcion', 
                url_github='$url_github', url_produccion='$url_produccion', categoria='$categoria' 
                WHERE id=$id";
    }

    // Ejecutar la actualización y redirigir
    $conn->query($sql);
    header("Location: upload.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Proyecto</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <!-- Contenedor principal del formulario -->
    <div class="main-content">
        <h2>Editar Proyecto</h2>
        <!-- Formulario para editar proyecto -->
        <form method="post" enctype="multipart/form-data">
            <!-- Campo de nombre -->
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?= $row['nombre'] ?>" required>
            </div>
            <!-- Campo de descripción -->
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" required><?= $row['descripcion'] ?></textarea>
            </div>
            <!-- Selector de categoría -->
            <div class="form-group">
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria" required>
                    <option value="evaluacion" <?= $row['categoria'] == 'evaluacion' ? 'selected' : '' ?>>Evaluación</option>
                    <option value="taller" <?= $row['categoria'] == 'taller' ? 'selected' : '' ?>>Taller</option>
                    <option value="autonoma" <?= $row['categoria'] == 'autonoma' ? 'selected' : '' ?>>Tarea Autónoma</option>
                </select>
            </div>
            <!-- Campo para URL de GitHub -->
            <div class="form-group">
                <label for="url_github">URL GitHub</label>
                <input type="url" id="url_github" name="url_github" value="<?= $row['url_github'] ?>">
            </div>
            <!-- Campo para URL de producción -->
            <div class="form-group">
                <label for="url_produccion">URL Producción</label>
                <input type="url" id="url_produccion" name="url_produccion" value="<?= $row['url_produccion'] ?>">
            </div>
            <!-- Campo para subir nueva imagen -->
            <div class="form-group">
                <label for="imagen">Imagen (dejar vacío para mantener la actual)</label>
                <input type="file" id="imagen" name="imagen">
                <!-- Mostrar imagen actual si existe -->
                <?php if($row['imagen']): ?>
                    <img src="uploads/<?= $row['imagen'] ?>" width="150">
                <?php endif; ?>
            </div>
            <!-- Botones de acción -->
            <button type="submit" class="submit-btn">Actualizar Proyecto</button>
            <a href="index.php" class="cancel-btn">Cancelar</a>
        </form>
    </div>
</body>
</html>