<?php
// Conexión a la base de datos PostgreSQL
$dbconn = pg_connect("host=localhost dbname=exams user=postgres password=1234");

// Verificar si la conexión fue exitosa
if (!$dbconn) {
    echo "Error: No se pudo conectar a la base de datos.";
    exit;
}

// Obtener las historias de la tabla "historias" ordenadas por prioridad y estado, excluyendo las de estado "oculto"
$query = "SELECT * FROM historias WHERE estado != 'oculto' ORDER BY prioridad DESC, estado, id ASC";
$result = pg_query($dbconn, $query);

// Verificar si se obtuvieron resultados
if (!$result) {
    echo "Error: No se pudieron obtener las historias.";
    exit;
}

// Obtener las historias como un array asociativo
$historias = pg_fetch_all($result);



// Cerrar la conexión a la base de datos
pg_close($dbconn);
?>

<!-- Código HTML dinámico de las columnas del tablero -->
<div class="col-md-4 col-custom">
    <div class="card">
        <h5 class="card-header bg-primary text-white">Por hacer <span class="material-icons">pending_actions</span></h5>
        <div class="card-body">
            <?php foreach ($historias as $historia) : ?>
                <?php if ($historia['estado'] == 'por-hacer') : ?>
                    <!-- Código HTML de las tarjetas de historias "Por hacer" -->
                    <div class="card mb-3" id="card_<?php echo $historia['id']; ?>">
                        <div class="card-header"><?php echo $historia['titulo'] . " (prioridad " . $historia['prioridad'] . ")"; ?></div>
                        <div class="card-body">
                            <p><?php
                                // Crear un objeto DateTime a partir de la fecha almacenada en la base de datos
                                $fecha = date_create_from_format('Y-m-d H:i:s', $historia['fecha_creacion']);

                                // Configurar el idioma y la región a español
                                setlocale(LC_TIME, 'spanish');

                                // Formatear la fecha en el formato solicitado: "20 de Abril del 2023"
                                $fecha_formateada = strftime('%e de %B del %Y', $fecha->getTimestamp());

                                // Mostrar la fecha formateada
                                echo "<p>Fecha límite: {$fecha_formateada}</p>";

                                ?></p>
                            <div class="card">
                                <div class="card-header bg-light text-dark"><span style="margin-left: -15px;">Descripción</span></div>
                                <p style="margin-left: 5px;"><?php echo $historia['descripcion']; ?></p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <span class="badge badge-secondary"><?php echo $historia['id']; ?></span>
                            <button type="button" class="btn btn-primary" onclick="cambiarEstado(<?php echo $historia['id']; ?>, 'en-progreso')">Realizar <span class="material-icons">arrow_circle_right</span></button>
                        </div>
                    </div>
                    <!-- ... -->
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="col-md-4 col-custom">
    <div class="card">
        <h5 class="card-header bg-warning text-white">En progreso <span class="material-icons">schedule</span></h5>
        <div class="card-body">
            <?php foreach ($historias as $historia) : ?>
                <?php if ($historia['estado'] == 'en-progreso') : ?>
                    <!-- Código HTML de las tarjetas de historias "En progreso" -->
                    <div class="card mb-3" id="card_<?php echo $historia['id']; ?>">
                        <div class="card-header bg-warning" style="color: black;"><?php echo $historia['titulo'] . " (prioridad " . $historia['prioridad'] . ")"; ?></div>
                        <div class="card-body">
                            <p><?php
                                // Crear un objeto DateTime a partir de la fecha almacenada en la base de datos
                                $fecha = date_create_from_format('Y-m-d H:i:s', $historia['fecha_creacion']);

                                // Configurar el idioma y la región a español
                                setlocale(LC_TIME, 'spanish');

                                // Formatear la fecha en el formato solicitado: "20 de Abril del 2023"
                                $fecha_formateada = strftime('%e de %B del %Y', $fecha->getTimestamp());

                                // Mostrar la fecha formateada
                                echo "<p>Fecha límite: {$fecha_formateada}</p>";

                                ?></p>
                            <div class="card">
                                <div class="card-header bg-light text-dark"><span style="margin-left: -15px;">Descripción</span></div>
                                <p style="margin-left: 5px;"><?php echo $historia['descripcion']; ?></p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <span class="badge badge-secondary"><?php echo $historia['id']; ?></span>
                            <button type="button" class="btn btn-warning" onclick="cambiarEstado(<?php echo $historia['id']; ?>, 'hecho')">Hecho <span class="material-icons">add_task</span></button>
                        </div>
                    </div>
                    <!-- ... -->
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="col-md-4 col-custom">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Hechas <span class="material-icons">check</span></h5>
        </div>
        <div class="card-body">
            <?php foreach ($historias as $historia) : ?>
                <?php if ($historia['estado'] == 'hecho') : ?>
                    <!-- Código HTML de las tarjetas de historias "Hechas" -->
                    <div class="card mb-3" id="card_<?php echo $historia['id']; ?>">
                        <div class="card-header bg-success"><?php echo $historia['titulo'] . " (prioridad " . $historia['prioridad'] . ")"; ?></div>
                        <div class="card-body">
                            <p><?php
                                // Crear un objeto DateTime a partir de la fecha almacenada en la base de datos
                                $fecha = date_create_from_format('Y-m-d H:i:s', $historia['fecha_creacion']);

                                // Configurar el idioma y la región a español
                                setlocale(LC_TIME, 'spanish');

                                // Formatear la fecha en el formato solicitado: "20 de Abril del 2023"
                                $fecha_formateada = strftime('%e de %B del %Y', $fecha->getTimestamp());

                                // Mostrar la fecha formateada
                                echo "<p>Fecha límite: {$fecha_formateada}</p>";

                                ?></p>
                            <div class="card">
                                <div class="card-header bg-light text-dark"><span style="margin-left: -15px;">Descripción</span></div>
                                <p style="margin-left: 5px;"><?php echo $historia['descripcion']; ?></p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <span class="badge badge-secondary"><?php echo $historia['id']; ?></span>
                            <button type="button" class="btn btn-success" onclick="cambiarEstado(<?php echo $historia['id']; ?>, 'oculto', 'card_<?php echo $historia['id']; ?>');">Listo <span class="material-icons">check_circle</span></button>
                        </div>
                    </div>
                    <!-- ... -->
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>