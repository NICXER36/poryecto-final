<?php
/**
 * Función para mostrar un carrusel de proyectos
 * Esta función genera un carrusel de Bootstrap que muestra los proyectos
 * con sus imágenes, descripciones y enlaces
 * 
 * @param array $proyectos Array de proyectos a mostrar
 * @param string $id Identificador único para el carrusel
 * @param bool $solo_lectura Si es true, oculta los botones de editar y eliminar
 */
function mostrar_carrusel($proyectos, $id, $solo_lectura = false) {
    // Mostrar mensaje si no hay proyectos
    if (count($proyectos) === 0) {
        echo '<p class="text-center text-muted">No hay proyectos en esta sección.</p>';
        return;
    }
    ?>
    <!-- Contenedor principal del carrusel -->
    <div id="carousel-<?= $id ?>" class="carousel slide mb-4" data-bs-ride="carousel">
        <!-- Indicadores del carrusel -->
        <div class="carousel-indicators">
            <?php foreach ($proyectos as $i => $p): ?>
                <button type="button" data-bs-target="#carousel-<?= $id ?>" data-bs-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>" aria-current="<?= $i === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $i+1 ?>"></button>
            <?php endforeach; ?>
        </div>

        <!-- Contenido del carrusel -->
        <div class="carousel-inner">
            <?php foreach ($proyectos as $i => $p): ?>
                <!-- Item del carrusel -->
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <!-- Tarjeta del proyecto -->
                    <div class="card bg-dark text-light border-0" style="max-width: 700px; margin: 0 auto;">
                        <!-- Imagen del proyecto -->
                        <?php if (!empty($p['imagen'])): ?>
                            <img src="uploads/<?= htmlspecialchars($p['imagen']) ?>" class="d-block w-100 project-image" alt="<?= isset($p['nombre']) ? htmlspecialchars($p['nombre']) : 'Proyecto' ?>">
                        <?php endif; ?>
                        <!-- Contenido de la tarjeta -->
                        <div class="card-body">
                            <!-- Nombre del proyecto -->
                            <h5 class="card-title"><?= isset($p['nombre']) ? htmlspecialchars($p['nombre']) : 'Sin nombre' ?></h5>
                            <!-- Descripción del proyecto -->
                            <p class="card-text"><?= isset($p['descripcion']) ? htmlspecialchars($p['descripcion']) : '' ?></p>
                            <!-- Enlaces externos -->
                            <div class="mb-2">
                                <?php if (!empty($p['url_github'])): ?>
                                    <a href="<?= htmlspecialchars($p['url_github']) ?>" target="_blank" class="btn btn-outline-info btn-sm me-2">GitHub</a>
                                <?php endif; ?>
                                <?php if (!empty($p['url_produccion'])): ?>
                                    <a href="<?= htmlspecialchars($p['url_produccion']) ?>" target="_blank" class="btn btn-outline-success btn-sm">Enlace</a>
                                <?php endif; ?>
                            </div>
                            <!-- Botones de acción -->
                            <?php if (!$solo_lectura): ?>
                            <div>
                                <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="delete.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este proyecto?')">Eliminar</a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Controles de navegación del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?= $id ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?= $id ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
    <?php
} 