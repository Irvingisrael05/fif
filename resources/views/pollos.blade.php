<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Inteligente de Control para Nacederas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8B4513;
            --secondary-color: #DEB887;
            --accent-color: #CD853F;
            --light-color: #FAEBD7;
            --dark-color: #654321;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 2rem 0;
            border-bottom: 5px solid var(--secondary-color);
        }

        .project-title {
            color: var(--dark-color);
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: bold;
        }

        .sensor-panel {
            background-color: var(--light-color);
            border-left: 4px solid var(--accent-color);
            padding: 15px;
            margin-bottom: 15px;
        }

        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .status-ok {
            background-color: #28a745;
        }

        .status-warning {
            background-color: #ffc107;
        }

        .status-danger {
            background-color: #dc3545;
        }

        .temperature-display {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .humidity-display {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1E90FF;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--dark-color);
            border-color: var(--dark-color);
        }

        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 1.5rem 0;
            margin-top: 2rem;
        }

        .diagram-container {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .alert-notification {
            border-left: 4px solid #dc3545;
            background-color: #f8d7da;
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        .nav-tabs .nav-link.active {
            background-color: var(--light-color);
            color: var(--dark-color);
            border-bottom: 3px solid var(--accent-color);
        }
    </style>
</head>
<body>
<!-- Encabezado -->
<div class="header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                <img src="/media/image2.png" alt="Logo del sistema" class="img-fluid" style="max-height: 100px;">
            </div>
            <div class="col-md-10">
                <h1>Sistema Inteligente de Control de Temperatura y Humedad</h1>
                <p class="lead">Para nacederas de pollos - Monitoreo en tiempo real</p>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <!-- Panel de estado actual -->
    <div class="row">
        <div class="col-md-8">
            <h2 class="project-title">Estado Actual del Sistema</h2>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Temperatura</div>
                        <div class="card-body text-center">
                            <div class="temperature-display" id="current-temp">37.2 °C</div>
                            <p class="mt-2">
                                <span class="status-indicator status-ok"></span>
                                Estado: Óptimo
                            </p>
                            <div class="progress mt-2">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 85%"
                                     aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Humedad</div>
                        <div class="card-body text-center">
                            <div class="humidity-display" id="current-humidity">58 %</div>
                            <p class="mt-2">
                                <span class="status-indicator status-ok"></span>
                                Estado: Óptimo
                            </p>
                            <div class="progress mt-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 58%"
                                     aria-valuenow="58" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel de control -->
            <div class="card mt-4">
                <div class="card-header">Control del Sistema</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Configuración de Temperatura</h5>
                            <div class="sensor-panel">
                                <p><strong>Temperatura objetivo:</strong> <span id="target-temp">37.0 °C</span></p>
                                <p><strong>Reducción semanal:</strong> 2 °C por semana</p>
                                <p><strong>Histeresis:</strong> 0.5 °C</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Configuración de Humedad</h5>
                            <div class="sensor-panel">
                                <p><strong>Humedad máxima:</strong> 60 %</p>
                                <p><strong>Ventilación:</strong> <span class="status-indicator status-ok"></span> Activa</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-primary" id="adjust-settings">Ajustar Configuración</button>
                        <button class="btn btn-outline-secondary" id="view-logs">Ver Registros</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <h2 class="project-title">Alertas y Notificaciones</h2>

            <div class="alert alert-warning">
                <h5><span class="status-indicator status-warning"></span> Reducción programada</h5>
                <p>La temperatura se reducirá a 35 °C en 2 días según el programa establecido.</p>
            </div>

            <div class="alert alert-success">
                <h5><span class="status-indicator status-ok"></span> Sistema funcionando correctamente</h5>
                <p>Todos los sensores y actuadores operan dentro de los parámetros normales.</p>
            </div>

            <div class="card">
                <div class="card-header">Estado de los Componentes</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Sensor de temperatura
                            <span class="badge bg-success rounded-pill">OK</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Sensor de humedad
                            <span class="badge bg-success rounded-pill">OK</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Focos de calor
                            <span class="badge bg-success rounded-pill">OK</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Sistema de ventilación
                            <span class="badge bg-success rounded-pill">OK</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestañas de información -->
    <div class="row mt-4">
        <div class="col-12">
            <ul class="nav nav-tabs" id="infoTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="diagrams-tab" data-bs-toggle="tab" data-bs-target="#diagrams" type="button" role="tab">Diagramas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="objectives-tab" data-bs-toggle="tab" data-bs-target="#objectives" type="button" role="tab">Objetivos</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="development-tab" data-bs-toggle="tab" data-bs-target="#development" type="button" role="tab">Desarrollo</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="recommendations-tab" data-bs-toggle="tab" data-bs-target="#recommendations" type="button" role="tab">Recomendaciones</button>
                </li>
            </ul>

            <div class="tab-content p-3 border border-top-0" id="infoTabsContent">
                <div class="tab-pane fade show active" id="diagrams" role="tabpanel">
                    <h4>Diagramas del Sistema</h4>
                    <div class="diagram-container">
                        <p>Diagrama de conexión del sistema:</p>
                        <!-- Aquí irían tus imágenes de diagramas -->
                        <div class="text-center p-4 bg-light">
                            <p>Imagen de diagrama de conexión</p>
                            <small>Reemplaza con: media/image3.jpeg</small>
                        </div>
                        <div class="text-center p-4 bg-light mt-3">
                            <p>Diagrama de componentes</p>
                            <small>Reemplaza con: media/image4.jpeg</small>
                        </div>
                        <div class="text-center p-4 bg-light mt-3">
                            <p>Esquema eléctrico</p>
                            <small>Reemplaza con: media/image5.jpeg</small>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="objectives" role="tabpanel">
                    <h4>Objetivos del Proyecto</h4>
                    <ul>
                        <li>Mantener la temperatura óptima de 37 °C durante el nacimiento de los pollitos.</li>
                        <li>Regular automáticamente la temperatura disminuyéndola 2 °C por semana hasta alcanzar la temperatura ambiente.</li>
                        <li>Controlar la humedad sin exceder el 60 %, garantizando una ventilación adecuada.</li>
                        <li>Alertar al usuario mediante notificaciones en caso de fallas en los focos de calor.</li>
                        <li>Proporcionar una interfaz web que permita visualizar el estado de la nacedera en tiempo real.</li>
                    </ul>
                </div>

                <div class="tab-pane fade" id="development" role="tabpanel">
                    <h4>Desarrollo del Sistema</h4>
                    <p>El sistema se basa en un prototipo de nacedera inteligente que integra sensores de temperatura y humedad (por ejemplo, DHT11 o DHT22). Estos sensores envían lecturas continuas a un microcontrolador (Arduino, ESP32 u otro similar), que evalúa los valores y ejecuta acciones automáticas:</p>

                    <div class="sensor-panel">
                        <p><strong>Si la temperatura baja de 37 °C</strong>, el sistema enciende el foco de calor.</p>
                        <p><strong>Si la temperatura supera el límite</strong>, el sistema apaga el foco.</p>
                        <p><strong>En caso de detectar que el foco no responde</strong>, se envía una notificación de fallo al usuario.</p>
                    </div>

                    <p>La información capturada por los sensores se transmita a una aplicación web, donde el usuario puede observar la temperatura, humedad y estado del sistema en tiempo real.</p>
                </div>

                <div class="tab-pane fade" id="recommendations" role="tabpanel">
                    <h4>Recomendaciones</h4>
                    <ul>
                        <li>Usar sensores de buena precisión para evitar lecturas erróneas (DHT22 o BME280).</li>
                        <li>Calibrar los sensores periódicamente.</li>
                        <li>Implementar una fuente de energía de respaldo en caso de cortes eléctricos.</li>
                        <li>Mantener la cama de los pollitos limpia y seca para conservar la humedad adecuada.</li>
                        <li>Revisar los focos de calor semanalmente y reemplazarlos en caso de fallas.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del equipo -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Información del Proyecto</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Equipo de Desarrollo</h5>
                            <ul>
                                <li>Pedro Guillermo Garcia</li>
                                <li>Irving Israel Rubio Bastida</li>
                                <li>Misael Nadir Salgado Sanchez</li>
                                <li>Gustavo Villafaña Cruz</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Institución</h5>
                            <p>Tecnológico de Estudios Superiores de Valle de Bravo</p>
                            <p>División de Ingeniería en Sistemas Computacionales</p>
                            <p><strong>Asesor:</strong> M. en ISC. Antonio Soto Luis</p>
                            <p>Valle de Bravo, Estado de México</p>
                            <p>Septiembre 2025</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pie de página -->
<div class="footer">
    <div class="container text-center">
        <p>Sistema Inteligente de Control de Temperatura y Humedad para Nacederas de Pollos &copy; 2025</p>
        <p>Tecnológico de Estudios Superiores de Valle de Bravo</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Simulación de actualización de datos en tiempo real
    function updateSensorData() {
        // Simular pequeñas variaciones en temperatura y humedad
        const currentTemp = document.getElementById('current-temp');
        const currentHumidity = document.getElementById('current-humidity');

        let temp = parseFloat(currentTemp.textContent);
        let humidity = parseFloat(currentHumidity.textContent);

        // Variación aleatoria pequeña
        temp += (Math.random() - 0.5) * 0.2;
        humidity += (Math.random() - 0.5) * 0.5;

        // Mantener dentro de rangos razonables
        temp = Math.max(36.5, Math.min(37.5, temp));
        humidity = Math.max(55, Math.min(60, humidity));

        currentTemp.textContent = temp.toFixed(1) + ' °C';
        currentHumidity.textContent = Math.round(humidity) + ' %';
    }

    // Actualizar cada 5 segundos
    setInterval(updateSensorData, 5000);

    // Manejo de botones
    document.getElementById('adjust-settings').addEventListener('click', function() {
        alert('Funcionalidad de ajuste de configuración en desarrollo');
    });

    document.getElementById('view-logs').addEventListener('click', function() {
        alert('Funcionalidad de visualización de registros en desarrollo');
    });
</script>
</body>
</html>
