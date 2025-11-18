<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Resultados - Árbitro FIF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --verde-principal: #2ecc71;
            --verde-oscuro: #145a32;
            --dorado: #f1c40f;
            --gris-oscuro: #1e272e;
            --blanco: #ffffff;
        }

        body {
            background: linear-gradient(135deg, var(--verde-oscuro) 0%, var(--gris-oscuro) 100%);
            color: var(--blanco);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            padding: 20px;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(30, 39, 46, 0.95);
            border-radius: 20px;
            border: 3px solid var(--dorado);
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--verde-principal);
        }

        .header h1 {
            color: var(--dorado);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .match-info {
            background: rgba(46, 204, 113, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid var(--dorado);
        }

        .team-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-label {
            color: var(--verde-principal);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--verde-principal);
            color: var(--blanco);
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--dorado);
            box-shadow: 0 0 10px rgba(241, 196, 15, 0.3);
            color: var(--blanco);
        }

        .btn-submit {
            background: linear-gradient(45deg, var(--verde-principal), var(--verde-oscuro));
            border: none;
            border-radius: 25px;
            padding: 15px 40px;
            color: var(--blanco);
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        .btn-submit:hover:not(:disabled) {
            background: linear-gradient(45deg, var(--dorado), var(--verde-principal));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(241, 196, 15, 0.4);
        }

        .btn-submit:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            opacity: 0.6;
        }

        .btn-back {
            background: transparent;
            border: 2px solid #e74c3c;
            color: #e74c3c;
            border-radius: 25px;
            padding: 10px 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .btn-back:hover {
            background: #e74c3c;
            color: white;
        }

        .score-input {
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            max-width: 100px;
            margin: 0 auto;
        }

        .vs-text {
            color: var(--dorado);
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }

        .points-display {
            background: rgba(241, 196, 15, 0.1);
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
            text-align: center;
            border: 1px dashed var(--dorado);
        }

        .points-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--dorado);
        }

        .team-name {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .alert-result {
            background: rgba(46, 204, 113, 0.2);
            border: 1px solid var(--verde-principal);
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            text-align: center;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<div class="form-container">
    <!-- Botón Volver -->
    <a href="/menu_arbitro" class="btn-back">
        <i class="fas fa-arrow-left"></i> Volver al Menu
    </a>

    <!-- Header -->
    <div class="header">
        <h1><i class="fas fa-clipboard-check"></i> Registrar Resultados del Partido</h1>
        <p class="text-muted">Complete la información del partido arbitrado</p>
    </div>

    <form id="resultForm" method="POST" action="{{ route(\'resultados.store\') }}">
        @csrf
        <!-- Información del Partido -->
        <div class="match-info">
            <h4 class="text-warning mb-3"><i class="fas fa-info-circle"></i> Información del Partido</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Seleccionar Partido</label>
                    <select class="form-select" id="partidoSelect" required name="id_partido">
                        <option value="" selected disabled>-- Seleccione un partido --</option>
                        <!-- Los partidos se cargarán dinámicamente -->
                    </select>
                    <div class="form-text text-info">Solo se muestran partidos jugados sin resultados registrados</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Torneo</label>
                    <input type="text" class="form-control" id="torneoInput" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="text" class="form-control" id="fechaInput" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Hora</label>
                    <input type="text" class="form-control" id="horaInput" readonly>
                </div>
            </div>
        </div>

        <!-- Marcador Final -->
        <div class="team-section">
            <h4 class="text-warning mb-4"><i class="fas fa-futbol"></i> Marcador Final</h4>
            <div class="row align-items-center">
                <div class="col-md-5 text-center">
                    <div class="team-name text-success" id="localTeamName">Equipo Local</div>
                    <input type="number" class="form-control score-input" id="golesLocal" value="0" min="0" max="20" required name="goles_local">
                    <div class="points-display">
                        <div>Puntos:</div>
                        <div class="points-value" id="puntosLocal">0</div>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <div class="vs-text">VS</div>
                </div>
                <div class="col-md-5 text-center">
                    <div class="team-name text-warning" id="visitanteTeamName">Equipo Visitante</div>
                    <input type="number" class="form-control score-input" id="golesVisitante" value="0" min="0" max="20" required name="goles_visitante">
                    <div class="points-display">
                        <div>Puntos:</div>
                        <div class="points-value" id="puntosVisitante">0</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen del Resultado -->
        <div id="resultAlert" class="alert-result hidden">
            <h5 class="text-warning"><i class="fas fa-trophy"></i> Resumen del Resultado</h5>
            <p id="resultText">El equipo local ganó y recibe 3 puntos</p>
        </div>

        <!-- Botón Enviar -->
        <button type="submit" class="btn-submit" id="submitButton" disabled>
            <i class="fas fa-save"></i> Registrar Resultado
        </button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elementos del DOM
        const partidoSelect = document.getElementById('partidoSelect');
        const torneoInput = document.getElementById('torneoInput');
        const fechaInput = document.getElementById('fechaInput');
        const horaInput = document.getElementById('horaInput');
        const localTeamName = document.getElementById('localTeamName');
        const visitanteTeamName = document.getElementById('visitanteTeamName');
        const golesLocal = document.getElementById('golesLocal');
        const golesVisitante = document.getElementById('golesVisitante');
        const puntosLocal = document.getElementById('puntosLocal');
        const puntosVisitante = document.getElementById('puntosVisitante');
        const resultAlert = document.getElementById('resultAlert');
        const resultText = document.getElementById('resultText');
        const submitButton = document.getElementById('submitButton');
        const resultForm = document.getElementById('resultForm');

        // Simulación de datos de partidos (en una implementación real, estos vendrían de la base de datos)
        const partidos = [
            {
                id: 1,
                torneo: "Torneo Verano Valle 2025",
                fecha: "2025-06-10",
                hora: "15:00",
                local: "Tigres del Valle",
                visitante: "Águilas de Bravo",
                jugado: true,
                resultadoRegistrado: false
            },
            {
                id: 2,
                torneo: "Torneo Verano Valle 2025",
                fecha: "2025-06-11",
                hora: "16:00",
                local: "Leones FC",
                visitante: "Panteras FC",
                jugado: true,
                resultadoRegistrado: false
            },
            {
                id: 3,
                torneo: "Torneo Verano Valle 2025",
                fecha: "2025-06-12",
                hora: "17:00",
                local: "Halcones United",
                visitante: "Zorros Rojos",
                jugado: true,
                resultadoRegistrado: true  // Este partido ya tiene resultado registrado
            },
            {
                id: 4,
                torneo: "Torneo Verano Valle 2025",
                fecha: "2025-06-13",
                hora: "18:00",
                local: "Coyotes FC",
                visitante: "Dragones Azules",
                jugado: false,  // Este partido aún no se ha jugado
                resultadoRegistrado: false
            }
        ];

        // Cargar partidos en el select (solo los jugados sin resultados)
        function cargarPartidos() {
            partidoSelect.innerHTML = '<option value="" selected disabled>-- Seleccione un partido --</option>';

            const partidosFiltrados = partidos.filter(p => p.jugado && !p.resultadoRegistrado);

            if (partidosFiltrados.length === 0) {
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "No hay partidos pendientes de registro";
                partidoSelect.appendChild(option);
                partidoSelect.disabled = true;
                return;
            }

            partidosFiltrados.forEach(partido => {
                const option = document.createElement('option');
                option.value = partido.id;
                option.textContent = `${partido.local} vs ${partido.visitante} - ${formatearFecha(partido.fecha)} ${partido.hora}`;
                option.dataset.partido = JSON.stringify(partido);
                partidoSelect.appendChild(option);
            });
        }

        // Formatear fecha para mostrar
        function formatearFecha(fecha) {
            const opciones = { day: '2-digit', month: '2-digit', year: 'numeric' };
            return new Date(fecha).toLocaleDateString('es-ES', opciones);
        }

        // Actualizar información del partido seleccionado
        function actualizarInfoPartido() {
            const partidoSeleccionado = partidoSelect.options[partidoSelect.selectedIndex];

            if (!partidoSeleccionado.value) {
                resetearFormulario();
                return;
            }

            const partido = JSON.parse(partidoSeleccionado.dataset.partido);

            torneoInput.value = partido.torneo;
            fechaInput.value = formatearFecha(partido.fecha);
            horaInput.value = partido.hora;
            localTeamName.textContent = partido.local;
            visitanteTeamName.textContent = partido.visitante;

            // Habilitar campos de goles
            golesLocal.disabled = false;
            golesVisitante.disabled = false;

            // Calcular puntos iniciales
            calcularPuntos();
        }

        // Resetear formulario
        function resetearFormulario() {
            torneoInput.value = "";
            fechaInput.value = "";
            horaInput.value = "";
            localTeamName.textContent = "Equipo Local";
            visitanteTeamName.textContent = "Equipo Visitante";
            golesLocal.value = "0";
            golesVisitante.value = "0";
            golesLocal.disabled = true;
            golesVisitante.disabled = true;
            puntosLocal.textContent = "0";
            puntosVisitante.textContent = "0";
            resultAlert.classList.add('hidden');
            submitButton.disabled = true;
        }

        // Calcular puntos basados en los goles
        function calcularPuntos() {
            const golesLoc = parseInt(golesLocal.value) || 0;
            const golesVis = parseInt(golesVisitante.value) || 0;

            let puntosLoc = 0;
            let puntosVis = 0;
            let mensaje = "";

            if (golesLoc > golesVis) {
                puntosLoc = 3;
                puntosVis = 0;
                mensaje = `${localTeamName.textContent} ganó y recibe 3 puntos`;
            } else if (golesLoc < golesVis) {
                puntosLoc = 0;
                puntosVis = 3;
                mensaje = `${visitanteTeamName.textContent} ganó y recibe 3 puntos`;
            } else {
                puntosLoc = 1;
                puntosVis = 1;
                mensaje = "Empate - Ambos equipos reciben 1 punto";
            }

            puntosLocal.textContent = puntosLoc;
            puntosVisitante.textContent = puntosVis;
            resultText.textContent = mensaje;
            resultAlert.classList.remove('hidden');

            // Habilitar botón de envío si hay un partido seleccionado
            submitButton.disabled = !partidoSelect.value;
        }

        // Enviar formulario
        function enviarFormulario(event) {
            event.preventDefault();

            const partidoSeleccionado = partidoSelect.options[partidoSelect.selectedIndex];
            const partido = JSON.parse(partidoSeleccionado.dataset.partido);

            const datos = {
                id_partido: partido.id,
                goles_local: parseInt(golesLocal.value),
                goles_visitante: parseInt(golesVisitante.value),
                puntos_local: parseInt(puntosLocal.textContent),
                puntos_visitante: parseInt(puntosVisitante.textContent)
            };

            // Aquí en una implementación real, enviaríamos los datos al servidor
            console.log("Datos a enviar:", datos);

            // Simulación de envío exitoso
            alert('¡Resultado registrado exitosamente!');

            // En una implementación real, aquí actualizaríamos la base de datos
            // marcando el partido como con resultado registrado

            // Recargar la lista de partidos
            cargarPartidos();
            resetearFormulario();
        }

        // Event Listeners
        partidoSelect.addEventListener('change', actualizarInfoPartido);
        golesLocal.addEventListener('input', calcularPuntos);
        golesVisitante.addEventListener('input', calcularPuntos);
        resultForm.addEventListener('submit', enviarFormulario);

        // Inicializar
        cargarPartidos();
        resetearFormulario();
    });
</script>
</body>
</html>
