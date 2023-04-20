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
    <title>Tablero Scrum</title>
    <!-- Importar Bootstrap y los iconos de Google -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        html {
            zoom: 100%;
            /* 100% - 20% = 80% */
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
        }

        .card-body {
            padding: 10px;
        }

        .card-body p {
            margin-bottom: 0;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: none;
            text-align: right;
        }

        .columna {
            padding: 0 10px;
        }

        .columna .card {
            margin-bottom: 10px;
        }

        .columna h5 {
            margin-bottom: 10px;
        }

        .btnadd {
            display: inline-block;
            padding: 2px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 50%;
        }

        .btnadd:hover {
            background-color: #338f37;
            color: white;
        }

        .material-icons {
            vertical-align: middle;
        }

        .contenedor {
            display: flex;
            align-items: center;
        }

        .tablero-contenedor {
            margin-right: 10px;
        }

        .col-custom {
            border-radius: 10px;
            /* Cambia este valor para ajustar el borde redondeado */
        }

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
                        <a class="nav-link" href="/Scrum/historias.php">
                            <span class="material-icons">description</span>
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

    <div class="container mt-5 ">
        <div style="margin-top: 75px;"></div>
        <div class="contenedor ">
            <div class="tablero tablero-contenedor">
                <h2>Tablero Scrum</h2>
            </div>
            <a href="/Scrum/historias.php" class="btnadd">
                <i class="material-icons">add</i>
            </a>
        </div>

        <div class="row" id="tablero">
            <!-- El contenido del tablero se cargará dinámicamente aquí -->
        </div>
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
        function cambiarEstado(id, estado) {
            // Crear objeto XMLHttpRequest
            var xhttp = new XMLHttpRequest();
            // Configurar solicitud HTTP POST asincrónica
            xhttp.open("POST", "cambiar_estado.php", true);
            // Establecer cabecera de solicitud
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            // Enviar solicitud con parámetros de id y estado
            xhttp.send("id=" + id + "&estado=" + estado);
            // Manejar respuesta de solicitud
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (estado === 'hecho') {
                        var card = document.getElementById("card_" + id);
                        card.style.display = "none";
                    } else {
                        // Actualizar página después de recibir respuesta
                        location.reload();
                    }
                }
            };
        }

        function cargarHistorias() {
            // Crear objeto XMLHttpRequest
            var xhttp = new XMLHttpRequest();
            // Configurar solicitud HTTP GET asincrónica
            xhttp.open("GET", "obtener_historias.php", true);
            // Enviar solicitud
            xhttp.send();
            // Manejar respuesta de solicitud
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Actualizar contenido de la página con la respuesta
                    document.getElementById("tablero").innerHTML = this.responseText;
                }
            };
        }
    </script>
    <script>
        // Llamar a cargarHistorias() cuando se cargue la página
        window.addEventListener("load", function() {
            cargarHistorias();
        });

        // Llamar a cargarHistorias() cada N segundos
        setInterval(cargarHistorias, 3000);
    </script>
</body>

</html>