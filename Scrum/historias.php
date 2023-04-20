<?php
$notificaciones = array(
    "Notificación 1: Nueva tarea asignada",
    "Notificación 2: Cambio de estado en el proyecto"
);
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="shortcut icon" href="/Scrum/zeusico.png" />
    <title>Formulario de inserción de historias</title>
    <!-- Importar Bootstrap y los iconos de Google -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .navbar-custom-shadow {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030;
            /* Asegúrate de que la barra de navegación esté siempre en la parte superior */
        }
        .custom-form{
            height: 80%;
        }
        .reduced-height {
            height: 80%;
        }
        .container {
            transform: scale(0.9);
            margin-top: -45px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom-shadow navbar-fixed">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/Scrum/zeusdev.png" alt="zeusdev" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/Scrum/tablero_scrum.php">
                            <span class="material-icons">dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="material-icons" style="position: relative;">
                                notifications
                                <?php if (count($notificaciones) > 0) : ?>
                                    <span style="position: absolute; top: -5px; right: -5px; background-color: red; width: 10px; height: 10px; border-radius: 50%;"></span>
                                <?php endif; ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <?php foreach ($notificaciones as $notificacion) : ?>
                                <a class="dropdown-item" href="#"><?php echo $notificacion; ?></a>
                            <?php endforeach; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Ver todas las notificaciones</a>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="#">
                            <span class="material-icons">
                                account_circle
                            </span>
                            <span class="ms-2">Jorman Pacherre</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">

        <div style="margin-top: 35px;"></div>
        <h2>Insertar nueva historia</h2>
        <form id="form-insertar-historia" action="insertar_historia.php" method="POST">
            <div class="form-group ">
                <label for="usuario">Usuario:</label>
                <select id="usuario" class="form-control reduced-height">
                    <option value="usuario1">Usuario 1</option>
                    <option value="usuario2">Usuario 2</option>
                    <option value="usuario3">Usuario 3</option>
                    <!-- Agrega más opciones de usuarios aquí -->
                </select>
            </div>
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control reduced-height" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control reduced-height" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="prioridad">Prioridad:</label>
                <select class="form-control reduced-height" id="prioridad" name="prioridad" required>
                    <option value="1">Baja</option>
                    <option value="2">Media</option>
                    <option value="3">Alta</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_limite">Fecha límite</label>
                <input type="date" class="form-control reduced-height" id="fecha_limite" name="fecha_limite">
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label>
                <select class="form-control reduced-height" id="estado" name="estado" required>
                    <option value="por-hacer">Por hacer</option>
                    <option value="en-progreso">En progreso</option>
                    <option value="hecho">Hecho</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="material-icons align-middle">add_circle_outline</i> Insertar historia
            </button>
        </form>
    </div>
    <!-- Importar jQuery, Popper.js y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Importar los iconos de Google -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Modal alerta -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#form-insertar-historia').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'insertar_historia.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        // Crear el modal con el resultado de la operación
                        var modal = $('<div class="modal fade" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Mensaje</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><p></p></div><div class="modal-footer"><button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button></div></div></div></div>');
                        modal.find('.modal-body p').text(response.message);
                        modal.modal('show');
                        // Limpiar el formulario
                        $('#form-insertar-historia').trigger('reset');
                    },
                    error: function() {
                        // Crear el modal con el mensaje de error
                        var modal = $('<div class="modal fade" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Error</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><p>Ocurrió un error al procesar la solicitud.</p></div><div class="modal-footer"><button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button></div></div></div></div>');
                        modal.modal('show');
                    }
                });
            });
        });
    </script>

</body>

</html>