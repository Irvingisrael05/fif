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

        .dashboard-container { max-width: 1400px; margin: 0 auto; }

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
        .header p { color: var(--verde-principal); font-size: 1.1rem; }

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
        .card-custom:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(46, 204, 113, 0.3); }

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
        .team-local { border: 1px solid var(--verde-principal); }
        .team-visitor { border: 1px solid var(--dorado); }

        .vs-text { color: var(--dorado); font-weight: bold; margin: 0 15px; }

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
        .logout-btn:hover { background: #e74c3c; color: white; }

        .badge-status {
            padding: 5px 12px;
            border-radius: 15px;
            font-weight: 600;
        }
        .status-pending  { background: rgba(241, 196, 15, 0.2); color: var(--dorado); border: 1px solid var(--dorado); }
        .status-playing  { background: rgba(46, 204, 113, 0.2); color: var(--verde-principal); border: 1px solid var(--verde-principal); }
        .status-finished { background: rgba(149, 165, 166, 0.2); color: #bdc3c7; border: 1px solid #bdc3c7; }

        .stats-card  { text-align: center; padding: 20px; }
        .stats-number{ font-size: 2.5rem; font-weight: bold; color: var(--dorado); }
        .stats-label { color: var(--verde-principal); font-weight: 600; }
    </style>
</head>
<body>
<div class="dashboard-container">
    {{-- User Info --}}
    <div class="user-info">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <div>
                    <i class="fas fa-futbol text-warning"></i>
                    <strong>{{ $jugadorNombre ?? 'Jugador' }}</strong>
                </div>

                @if($equipoNombre)
                    <div class="mt-1 small">
                        <i class="fas fa-users text-success"></i>
                        {{ $equipoNombre }}
                    </div>
                @endif

                @if(!is_null($dorsal))
                    <div class="mt-1 small">
                        <i class="fas fa-tshirt text-warning"></i>
                        Dorsal: #{{ $dorsal }}
                    </div>
                @endif
            </div>

            <a href="/" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Salir
            </a>
        </div>
    </div>

    {{-- Header --}}
    <div class="header">
        <h1><i class="fas fa-user"></i> Federacion internacional de Futbol</h1>
        <p>
            Bienvenido al sistema de gestión de partidos FIF
            @if($equipoNombre)
                - {{ $equipoNombre }}
            @endif
        </p>
    </div>

    {{-- Stats del equipo --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card-custom stats-card">
                <div class="stats-number">{{ $stats['jugados'] }}</div>
                <div class="stats-label">Partidos Jugados</div>
                <i class="fas fa-futbol mt-2 text-warning"></i>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card-custom stats-card">
                <div class="stats-number">{{ $stats['goles_favor'] }}</div>
                <div class="stats-label">Goles a Favor (Equipo)</div>
                <i class="fas fa-bullseye mt-2 text-success"></i>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card-custom stats-card">
                <div class="stats-number">{{ $stats['goles_contra'] }}</div>
                <div class="stats-label">Goles en Contra</div>
                <i class="fas fa-shield-alt mt-2 text-info"></i>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card-custom stats-card">
                <div class="stats-number">
                    @if($stats['posicion'])
                        {{ $stats['posicion'] }}°
                    @else
                        -
                    @endif
                </div>
                <div class="stats-label">Posición del Equipo</div>
                <i class="fas fa-trophy mt-2 text-warning"></i>
            </div>
        </div>
    </div>

    {{-- (A partir de aquí TODO IGUAL que ya tenías) --}}
    <div class="row">
        {{-- Próximos partidos --}}
        <div class="col-lg-6 mb-4">
            <div class="card-custom">
                <h3 class="section-title">
                    <i class="fas fa-calendar-alt"></i> Mis Próximos Partidos
                </h3>

                @forelse($proximos as $p)
                    @php
                        $fechaHora = \Carbon\Carbon::parse($p->fecha . ' ' . ($p->hora ?? '00:00:00'));
                        $soyLocal = ($equipoId && $p->equipo_local == $equipoId);
                    @endphp

                    <div class="match-card">
                        <div class="match-date">
                            <i class="fas fa-calendar"></i>
                            {{ mb_strtoupper($fechaHora->isoFormat('ddd DD MMM - HH:mm'), 'UTF-8') }}
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="team-badge {{ $soyLocal ? 'team-local' : 'team-visitor' }}">
                                @if($soyLocal)
                                    <i class="fas fa-home text-success"></i>
                                @else
                                    <i class="fas fa-plane text-warning"></i>
                                @endif
                                {{ $p->local }}
                                @if($soyLocal)
                                    <span class="badge bg-warning text-dark ms-1">TU EQUIPO</span>
                                @endif
                            </div>

                            <div class="vs-text">VS</div>

                            @php $soyVisitante = ($equipoId && $p->equipo_visitante == $equipoId); @endphp
                            <div class="team-badge {{ $soyVisitante ? 'team-local' : 'team-visitor' }}">
                                @if($soyVisitante)
                                    <i class="fas fa-home text-success"></i>
                                @else
                                    <i class="fas fa-plane text-warning"></i>
                                @endif
                                {{ $p->visitante }}
                                @if($soyVisitante)
                                    <span class="badge bg-warning text-dark ms-1">TU EQUIPO</span>
                                @endif
                            </div>
                        </div>

                        <div class="match-info">
                            <div class="row">
                                <div class="col-6">
                                    <strong><i class="fas fa-map-marker-alt text-danger"></i> Cancha:</strong><br>
                                    {{ $p->cancha ?? 'Por definir' }}
                                </div>
                                <div class="col-6">
                                    <strong><i class="fas fa-location-arrow text-info"></i> Dirección:</strong><br>
                                    {{ $p->direccion ?? '—' }}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <strong><i class="fas fa-trophy text-warning"></i> Torneo:</strong>
                                    {{ $p->torneo ?? '—' }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <span class="badge-status status-pending">
                                <i class="fas fa-clock"></i> Por Jugar
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No tienes próximos partidos programados.</p>
                @endforelse
            </div>
        </div>

        {{-- Tabla de posiciones (solo vista, sin editar) --}}
        <div class="col-lg-6 mb-4">
            <div class="card-custom">
                <h3 class="section-title">
                    <i class="fas fa-table"></i> Tabla de Posiciones
                </h3>

                <div class="ratio ratio-4x3">
                    <iframe
                        src="{{ url('/tabla_pocisiones') }}"
                        style="border:none; border-radius:10px; background:transparent;"
                    ></iframe>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <strong>Leyenda:</strong><br>
                            Solo lectura. Los datos se actualizan al registrar resultados.
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="badge-status status-playing">
                            <i class="fas fa-sync-alt"></i> Tabla en tiempo real
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Partidos recientes del equipo --}}
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
                        @forelse($recientes as $r)
                            @php
                                $fecha = \Carbon\Carbon::parse($r->fecha)->format('DD MMM YYYY');
                                $soyLocal = ($equipoNombre && $r->local === $equipoNombre);
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($r->fecha)->format('d M Y') }}</td>
                                <td>
                                    {{ $r->local }} vs {{ $r->visitante }}
                                    @if($equipoNombre && ($r->local === $equipoNombre || $r->visitante === $equipoNombre))
                                        <span class="badge bg-warning text-dark ms-1">TU EQUIPO</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $marcador = $r->goles_local . ' - ' . $r->goles_visitante;
                                        $esVictoria = ($soyLocal && $r->goles_local > $r->goles_visitante)
                                                      || (!$soyLocal && $r->goles_visitante > $r->goles_local);
                                        $esEmpate = ($r->goles_local == $r->goles_visitante);
                                    @endphp

                                    @if($esEmpate)
                                        <strong class="text-warning">{{ $marcador }}</strong>
                                    @elseif($esVictoria)
                                        <strong class="text-success">{{ $marcador }}</strong>
                                    @else
                                        <strong class="text-danger">{{ $marcador }}</strong>
                                    @endif
                                </td>
                                <td>{{ $r->cancha ?? '—' }}</td>
                                <td><span class="badge-status status-finished">Finalizado</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted">
                                    Aún no hay partidos con resultado registrado para tu equipo.
                                </td>
                            </tr>
                        @endforelse
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
