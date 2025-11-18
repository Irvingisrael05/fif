<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Partidos - Árbitro FIF</title>
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

        .container-custom {
            max-width: 1000px;
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

        .match-card {
            background: rgba(46, 204, 113, 0.1);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            border-left: 4px solid var(--dorado);
        }

        .match-card.pendiente {
            border-left-color: var(--dorado);
        }

        .match-card.jugado {
            border-left-color: var(--verde-principal);
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

        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
        }

        .status-pendiente {
            background: rgba(241, 196, 15, 0.2);
            color: var(--dorado);
        }

        .status-jugado {
            background: rgba(46, 204, 113, 0.2);
            color: var(--verde-principal);
        }

        .section-title {
            color: var(--dorado);
            border-bottom: 2px solid var(--verde-principal);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .no-matches {
            text-align: center;
            padding: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .btn-registrar {
            background: linear-gradient(45deg, var(--verde-principal), var(--verde-oscuro));
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            color: var(--blanco);
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-registrar:hover {
            background: linear-gradient(45deg, var(--dorado), var(--verde-principal));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(241, 196, 15, 0.4);
            color: var(--blanco);
        }
    </style>
</head>
<body>
<div class="container-custom">
    <!-- Botón Volver -->
    <a href="/menu_arbitro" class="btn-back">
        <i class="fas fa-arrow-left"></i> Volver al Menu
    </a>

    <!-- Header -->
    <div class="header">
        <h1><i class="fas fa-calendar-alt"></i> Mis Partidos Asignados</h1>
        <p class="text-muted">Partidos designados para arbitraje</p>
    </div>

    <!-- Botón para registrar resultados -->
    <div class="text-center mb-4">
        <a href="/registro_resultados"  class="btn-registrar">
            <i class="fas fa-clipboard-check"></i> Ir a Registrar Resultados
        </a>
    </div>

    <!-- Partidos Pendientes -->
    <h3 class="section-title"><i class="fas fa-clock"></i> Próximos Partidos</h3>

    <div id="partidosPendientes">
        <!-- Los partidos pendientes se cargarán aquí -->
    </div>

    <!-- Partidos Jugados -->
    <h3 class="section-title"><i class="fas fa-history"></i> Partidos Arbitrados</h3>

    <div id="partidosJugados">
        <!-- Los partidos jugados se cargarán aquí -->
    </div>

    <!-- Sin partidos asignados -->
    <div id="sinPartidos" class="no-matches hidden">
        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">No tienes partidos asignados</h4>
        <p class="text-muted">Consulta más tarde para ver tus próximos partidos.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elementos del DOM
        const partidosJugados = document.getElementById('partidosJugados');
        const partidosPendientes = document.getElementById('partidosPendientes');
        const sinPartidos = document.getElementById('sinPartidos');

        // Simulación de datos de partidos asignados al árbitro
        // En una implementación real, estos vendrían de la base de datos
        const partidosAsignados = [
            {
                id: 1,
                torneo: "Torneo Verano Valle 2025",
                fecha: "2025-06-10",
                hora: "15:00",
                local: "Tigres del Valle",
                visitante: "Águilas de Bravo",
                cancha: "Estadio Municipal Valle",
                jugado: true,
                resultadoRegistrado: true
            },
            {
                id: 2,
                torneo: "Torneo Verano Valle 2025",
                fecha: "2025-06-11",
                hora: "16:00",
                local: "Leones FC",
                visitante: "Panteras FC",
                cancha: "Cancha Central",
                jugado: true,
                resultadoRegistrado: true
            },
            {
                id: 3,
                torneo: "Torneo Verano Valle 2025",
                fecha: "2025-06-15",
                hora: "15:00",
                local: "Halcones United",
                visitante: "Zorros Rojos",
                cancha: "Estadio Municipal Valle",
                jugado: false,
                resultadoRegistrado: false
            },
            {
                id: 4,
                torneo: "Torneo Verano Valle 2025",
                fecha: "2025-06-18",
                hora: "11:00",
                local: "Coyotes FC",
                visitante: "Dragones Azules",
                cancha: "Cancha Central",
                jugado: false,
                resultadoRegistrado: false
            },
            {
                id: 5,
                torneo: "Torneo Verano Valle 2025",
                fecha: "2025-06-20",
                hora: "17:00",
                local: "Águilas Doradas",
                visitante: "Tiburones FC",
                cancha: "Estadio Municipal Valle",
                jugado: false,
                resultadoRegistrado: false
            }
        ];

        // Cargar partidos en la vista
        function cargarPartidos() {
            // Limpiar contenedores
            partidosJugados.innerHTML = '';
            partidosPendientes.innerHTML = '';

            // Filtrar partidos
            const jugados = partidosAsignados.filter(p => p.jugado);
            const pendientes = partidosAsignados.filter(p => !p.jugado);

            // Mostrar mensaje si no hay partidos
            if (partidosAsignados.length === 0) {
                sinPartidos.classList.remove('hidden');
                return;
            } else {
                sinPartidos.classList.add('hidden');
            }

            // Cargar partidos pendientes
            if (pendientes.length > 0) {
                // Ordenar por fecha (más próximos primero)
                pendientes.sort((a, b) => new Date(a.fecha) - new Date(b.fecha));

                pendientes.forEach(partido => {
                    const card = crearCardPartido(partido, 'pendiente');
                    partidosPendientes.appendChild(card);
                });
            } else {
                partidosPendientes.innerHTML = `
                    <div class="no-matches">
                        <i class="fas fa-calendar-check fa-2x text-muted mb-3"></i>
                        <p class="text-muted">No hay partidos pendientes programados</p>
                    </div>
                `;
            }

            // Cargar partidos jugados
            if (jugados.length > 0) {
                // Ordenar por fecha (más recientes primero)
                jugados.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));

                jugados.forEach(partido => {
                    const card = crearCardPartido(partido, 'jugado');
                    partidosJugados.appendChild(card);
                });
            } else {
                partidosJugados.innerHTML = `
                    <div class="no-matches">
                        <i class="fas fa-history fa-2x text-muted mb-3"></i>
                        <p class="text-muted">Aún no has arbitrado ningún partido</p>
                    </div>
                `;
            }
        }

        // Crear tarjeta de partido
        function crearCardPartido(partido, tipo) {
            const card = document.createElement('div');
            card.className = `match-card ${tipo}`;

            const fechaFormateada = formatearFecha(partido.fecha);

            card.innerHTML = `
                <h4 class="text-warning">${partido.local} vs ${partido.visitante}</h4>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Torneo:</strong> ${partido.torneo}</p>
                        <p><strong>Fecha:</strong> ${fechaFormateada}</p>
                        <p><strong>Hora:</strong> ${partido.hora}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Cancha:</strong> ${partido.cancha}</p>
                        <p><strong>Estado:</strong>
                            <span class="status-badge ${tipo === 'jugado' ? 'status-jugado' : 'status-pendiente'}">
                                ${tipo === 'jugado' ? 'Jugado' : 'Pendiente'}
                            </span>
                        </p>
                    </div>
                </div>
            `;

            return card;
        }

        // Formatear fecha para mostrar
        function formatearFecha(fecha) {
            const opciones = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            const fechaObj = new Date(fecha);
            return fechaObj.toLocaleDateString('es-ES', opciones);
        }

        // Inicializar
        cargarPartidos();
    });
</script>
</body>
</html>
