<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Jugador FIF</title>
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
            background:
                linear-gradient(rgba(20, 90, 50, 0.85), rgba(20, 90, 50, 0.85)),
                url('https://images.unsplash.com/photo-1575361204480-aadea25e6e68?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat fixed;
            color: var(--blanco);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
            background: rgba(30, 39, 46, 0.9);
            border-radius: 15px;
            border: 2px solid var(--verde-principal);
        }

        .header h1 {
            color: var(--dorado);
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .header p {
            color: var(--verde-principal);
            font-size: 1.1rem;
        }

        .section-title {
            color: var(--dorado);
            border-bottom: 2px solid var(--verde-principal);
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .card-custom {
            background: rgba(30, 39, 46, 0.95);
            border: 2px solid var(--verde-principal);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(46, 204, 113, 0.3);
        }

        .match-card {
            background: rgba(46, 204, 113, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid var(--dorado);
        }

        .match-date {
            background: var(--dorado);
            color: var(--gris-oscuro);
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 10px;
        }

        .team-badge {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
        }

        .team-local {
            border: 1px solid var(--verde-principal);
        }

        .team-visitor {
            border: 1px solid var(--dorado);
        }

        .vs-text {
            color: var(--dorado);
            font-weight: bold;
            margin: 0 15px;
        }

        .match-info {
            background: rgba(30, 39, 46, 0.8);
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
        }

        .table-custom {
            background: rgba(30, 39, 46, 0.8);
            color: var(--blanco);
            border-radius: 10px;
            overflow: hidden;
        }

        .table-custom th {
            background: var(--verde-oscuro);
            color: var(--dorado);
            border: none;
            padding: 15px;
            text-align: center;
        }

        .table-custom td {
            border-color: rgba(46, 204, 113, 0.2);
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }

        .position-1 {
            background: linear-gradient(45deg, rgba(255, 215, 0, 0.2), transparent);
            font-weight: bold;
        }

        .position-2 {
            background: linear-gradient(45deg, rgba(192, 192, 192, 0.2), transparent);
        }

        .position-3 {
            background: linear-gradient(45deg, rgba(205, 127, 50, 0.2), transparent);
        }

        .user-info {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(30, 39, 46, 0.9);
            padding: 15px 25px;
            border-radius: 10px;
            border: 1px solid var(--verde-principal);
            z-index: 1000;
        }

        .logout-btn {
            background: transparent;
            border: 1px solid #e74c3c;
            color: #e74c3c;
            padding: 8px 15px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            background: #e74c3c;
            color: white;
        }

        .badge-status {
            padding: 5px 12px;
            border-radius: 15px;
            font-weight: 600;
        }

        .status-pending {
            background: rgba(241, 196, 15, 0.2);
            color: var(--dorado);
            border: 1px solid var(--dorado);
        }

        .status-playing {
            background: rgba(46, 204, 113, 0.2);
            color: var(--verde-principal);
            border: 1px solid var(--verde-principal);
        }

        .status-finished {
            background: rgba(149, 165, 166, 0.2);
            color: #bdc3c7;
            border: 1px solid #bdc3c7;
        }

        .stats-card {
            text-align: center;
            padding: 20px;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--dorado);
        }

        .stats-label {
            color: var(--verde-principal);
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <!-- User Info -->
    <div class="user-info">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <i class="fas fa-futbol text-warning"></i>
                <strong>Jugador</strong>
            </div>
            <a href="/" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Salir
            </a>
        </div>
        <div class="mt-2 small">
            <i class="fas fa-tshirt text-warning"></i> Dorsal: #9
        </div>
    </div>

    <!-- Header -->
    <div class="header">
        <h1><i class="fas fa-user"></i> Federacion internacional de Futbol</h1>
        <p>Bienvenido al sistema de gestión de partidos FIF - Tigres del Valle</p>
    </div>

    <!-- Player Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card-custom stats-card">
                <div class="stats-number">12</div>
                <div class="stats-label">Partidos Jugados</div>
                <i class="fas fa-futbol mt-2 text-warning"></i>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card-custom stats-card">
                <div class="stats-number">8</div>
                <div class="stats-label">Goles Anotados</div>
                <i class="fas fa-bullseye mt-2 text-success"></i>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card-custom stats-card">
                <div class="stats-number">5</div>
                <div class="stats-label">Asistencias</div>
                <i class="fas fa-assistive-listening-systems mt-2 text-info"></i>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card-custom stats-card">
                <div class="stats-number">3°</div>
                <div class="stats-label">Posición Equipo</div>
                <i class="fas fa-trophy mt-2 text-warning"></i>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Próximos Partidos -->
        <div class="col-lg-6 mb-4">
            <div class="card-custom">
                <h3 class="section-title">
                    <i class="fas fa-calendar-alt"></i> Mis Próximos Partidos
                </h3>

                <!-- Partido 1 -->
                <div class="match-card">
                    <div class="match-date">
                        <i class="fas fa-calendar"></i> SÁB 15 JUN - 15:00
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="team-badge team-local">
                            <i class="fas fa-home text-success"></i> Tigres del Valle
                        </div>
                        <div class="vs-text">VS</div>
                        <div class="team-badge team-visitor">
                            Águilas de Bravo <i class="fas fa-plane text-warning"></i>
                        </div>
                    </div>

                    <div class="match-info">
                        <div class="row">
                            <div class="col-6">
                                <strong><i class="fas fa-map-marker-alt text-danger"></i> Cancha:</strong><br>
                                Estadio Municipal Valle
                            </div>
                            <div class="col-6">
                                <strong><i class="fas fa-location-arrow text-info"></i> Dirección:</strong><br>
                                Av. del Lago #100, Valle de Bravo
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <strong><i class="fas fa-trophy text-warning"></i> Torneo:</strong>
                                Torneo Verano Valle 2025 - Jornada 1
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                            <span class="badge-status status-pending">
                                <i class="fas fa-clock"></i> Por Jugar
                            </span>
                    </div>
                </div>

                <!-- Partido 2 -->
                <div class="match-card">
                    <div class="match-date">
                        <i class="fas fa-calendar"></i> DOM 18 JUN - 11:00
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="team-badge team-visitor">
                            <i class="fas fa-plane text-warning"></i> Leones FC
                        </div>
                        <div class="vs-text">VS</div>
                        <div class="team-badge team-local">
                            Tigres del Valle <i class="fas fa-home text-success"></i>
                        </div>
                    </div>

                    <div class="match-info">
                        <div class="row">
                            <div class="col-6">
                                <strong><i class="fas fa-map-marker-alt text-danger"></i> Cancha:</strong><br>
                                Cancha Central
                            </div>
                            <div class="col-6">
                                <strong><i class="fas fa-location-arrow text-info"></i> Dirección:</strong><br>
                                Calle Principal #234, Centro
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <strong><i class="fas fa-trophy text-warning"></i> Torneo:</strong>
                                Torneo Verano Valle 2025 - Jornada 2
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                            <span class="badge-status status-pending">
                                <i class="fas fa-clock"></i> Por Jugar
                            </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Posiciones -->
        <div class="col-lg-6 mb-4">
            <div class="card-custom">
                <h3 class="section-title">
                    <i class="fas fa-table"></i> Tabla de Posiciones - Torneo Verano 2025
                </h3>

                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                        <tr>
                            <th>Pos</th>
                            <th>Equipo</th>
                            <th>PJ</th>
                            <th>GF</th>
                            <th>GC</th>
                            <th>DG</th>
                            <th>Pts</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="position-1">
                            <td><strong>1°</strong></td>
                            <td>
                                <i class="fas fa-crown text-warning"></i>
                                <strong>Leones FC</strong>
                            </td>
                            <td>3</td>
                            <td>8</td>
                            <td>2</td>
                            <td>+6</td>
                            <td><strong>9</strong></td>
                        </tr>
                        <tr class="position-2">
                            <td><strong>2°</strong></td>
                            <td>
                                <i class="fas fa-medal text-light"></i>
                                <strong>Halcones United</strong>
                            </td>
                            <td>3</td>
                            <td>6</td>
                            <td>3</td>
                            <td>+3</td>
                            <td><strong>7</strong></td>
                        </tr>
                        <tr class="position-3">
                            <td><strong>3°</strong></td>
                            <td>
                                <i class="fas fa-medal text-warning"></i>
                                <strong>Tigres del Valle</strong>
                                <span class="badge bg-warning ms-1">TU EQUIPO</span>
                            </td>
                            <td>2</td>
                            <td>5</td>
                            <td>3</td>
                            <td>+2</td>
                            <td><strong>6</strong></td>
                        </tr>
                        <tr>
                            <td>4°</td>
                            <td>Águilas de Bravo</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>-1</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>5°</td>
                            <td>Panteras FC</td>
                            <td>2</td>
                            <td>2</td>
                            <td>5</td>
                            <td>-3</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>6°</td>
                            <td>Zorros Rojos</td>
                            <td>2</td>
                            <td>1</td>
                            <td>6</td>
                            <td>-5</td>
                            <td>0</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Leyenda -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <strong>Leyenda:</strong><br>
                            PJ: Partidos Jugados, GF: Goles a Favor<br>
                            GC: Goles en Contra, DG: Diferencia de Goles
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="badge-status status-playing">
                            <i class="fas fa-sync-alt"></i> Actualizado: 19-OCT-2025
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Partidos Recientes -->
    <div class="row">
        <div class="col-12">
            <div class="card-custom">
                <h3 class="section-title">
                    <i class="fas fa-history"></i> Mis Partidos Recientes
                </h3>

                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Partido</th>
                            <th>Resultado</th>
                            <th>Cancha</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>12 OCT 2025</td>
                            <td>Tigres del Valle vs Panteras FC</td>
                            <td><strong class="text-success">3 - 1</strong></td>
                            <td>Estadio Municipal</td>
                            <td><span class="badge-status status-finished">Finalizado</span></td>
                        </tr>
                        <tr>
                            <td>05 OCT 2025</td>
                            <td>Halcones United vs Tigres del Valle</td>
                            <td><strong class="text-warning">2 - 2</strong></td>
                            <td>Cancha Central</td>
                            <td><span class="badge-status status-finished">Finalizado</span></td>
                        </tr>
                        <tr>
                            <td>28 SEP 2025</td>
                            <td>Tigres del Valle vs Zorros Rojos</td>
                            <td><strong class="text-success">2 - 0</strong></td>
                            <td>Estadio Municipal</td>
                            <td><span class="badge-status status-finished">Finalizado</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
