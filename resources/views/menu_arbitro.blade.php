<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Árbitro FIF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                url('https://images.unsplash.com/photo-1556056504-5c7696c4c28d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat fixed;
            color: var(--blanco);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            padding: 20px;
        }

        .dashboard-container { max-width: 1000px; margin: 0 auto; }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
            background: rgba(30, 39, 46, 0.9);
            border-radius: 15px;
            border: 2px solid var(--verde-principal);
        }

        .header h1 { color: var(--dorado); font-weight: 700; text-transform: uppercase; margin-bottom: 10px; }
        .header p { color: var(--verde-principal); font-size: 1.1rem; }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .card {
            background: rgba(30, 39, 46, 0.95);
            border: 2px solid var(--verde-principal);
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            color: var(--blanco);
            min-height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(46, 204, 113, 0.4); border-color: var(--dorado); }
        .card i { font-size: 4rem; color: var(--dorado); margin-bottom: 25px; }
        .card h3 { color: var(--verde-principal); font-weight: 600; margin-bottom: 20px; font-size: 1.5rem; }
        .card p { color: var(--blanco); opacity: 0.8; line-height: 1.6; margin-bottom: 25px; }

        .btn-dashboard {
            background: linear-gradient(45deg, var(--verde-principal), var(--verde-oscuro));
            border: none;
            border-radius: 25px;
            padding: 15px 35px;
            color: var(--blanco);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            display: inline-block;
        }
        .btn-dashboard:hover {
            background: linear-gradient(45deg, var(--dorado), var(--verde-principal));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(241, 196, 15, 0.4);
            color: var(--gris-oscuro);
        }

        .user-info {
            position: fixed; top: 20px; right: 20px;
            background: rgba(30, 39, 46, 0.9);
            padding: 15px 25px; border-radius: 10px;
            border: 1px solid var(--verde-principal); z-index: 1000;
        }
        .logout-btn {
            background: transparent; border: 1px solid #e74c3c; color: #e74c3c;
            padding: 8px 15px; border-radius: 20px; text-decoration: none; transition: all 0.3s ease;
        }
        .logout-btn:hover { background: #e74c3c; color: white; }

        .arbitro-stats { display: flex; justify-content: center; gap: 30px; margin-top: 20px; flex-wrap: wrap; }
        .stat-item { text-align: center; padding: 15px; }
        .stat-number { font-size: 2rem; font-weight: bold; color: var(--dorado); }
        .stat-label { color: var(--verde-principal); font-size: 0.9rem; }

        .centered-card { grid-column: 1 / -1; justify-self: center; width: 350px; }

        .modal-content {
            background: linear-gradient(145deg, rgba(30,39,46,0.98) 0%, rgba(20,90,50,0.9) 100%);
            border: 2px solid var(--dorado); color: var(--blanco);
        }
        .modal-header { border-bottom: 1px solid var(--dorado); }
        .btn-close { filter: invert(1); }
    </style>
</head>
<body>
<div class="dashboard-container">
    <!-- User Info -->
    <div class="user-info">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <i class="fas fa-whistle text-warning"></i>
                <strong>Árbitro</strong>
            </div>
            <a href="/" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Salir
            </a>
        </div>
        <div class="arbitro-stats">
            <div class="stat-item">
                <div class="stat-number stat-asignados">3</div>
                <div class="stat-label">Partidos Asignados</div>
            </div>
            <div class="stat-item">
                <div class="stat-number stat-arbitrados">15</div>
                <div class="stat-label">Total Arbitrados</div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="header">
        <h1><i class="fas fa-whistle"></i>Federacion internacional de Futbol</h1>
        <p>Sistema de gestión arbitral - Registra resultados y consulta información</p>
    </div>

    <!-- Cards Principales -->
    <div class="cards">
        <!-- Registrar Resultados (lleva a la página standalone) -->
        <div class="card">
            <i class="fas fa-clipboard-check"></i>
            <h3>Registrar Resultados</h3>
            <p>Ingresa los resultados finales de los partidos que has arbitrado.</p>
            <a class="btn-dashboard" href="{{ route('arbitro.resultados.create') }}">
                <i class="fas fa-edit"></i> Registrar Resultados
            </a>
        </div>

        <!-- Mis Partidos Asignados (solo ver, sin editar) -->
        <div class="card">
            <i class="fas fa-calendar-alt"></i>
            <h3>Mis Partidos Asignados</h3>
            <p>Consulta tu calendario de partidos pendientes.</p>
            <button class="btn-dashboard" id="btnVerPartidos">
                <i class="fas fa-list"></i> Ver Partidos
            </button>
        </div>

        <!-- Tabla de Posiciones -->
        <div class="card centered-card">
            <i class="fas fa-table"></i>
            <h3>Tabla de Posiciones</h3>
            <p>Consulta la clasificación actual de los torneos.</p>
            <a href="/tabla_pocisiones" class="btn-dashboard">
                <i class="fas fa-trophy"></i> Ver Tabla
            </a>
        </div>
    </div>

    <!-- Información Rápida -->
    <div class="header mt-5">
        <h3><i class="fas fa-info-circle"></i> Información del Árbitro</h3>
        <div class="row mt-3">
            <div class="col-md-6">
                <p><strong><i class="fas fa-id-card text-warning"></i> Licencia:</strong> LIC12345</p>
                <p><strong><i class="fas fa-star text-warning"></i> Categoría:</strong> FIFA Nivel 2</p>
            </div>
            <div class="col-md-6">
                <p><strong><i class="fas fa-calendar-check text-success"></i> Próximo Partido:</strong> Sábado 15:00</p>
                <p><strong><i class="fas fa-map-marker-alt text-danger"></i> Ubicación:</strong> Estadio Municipal</p>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: Ver Partidos y Histórico -->
<div class="modal fade" id="modalVerPartidos" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-list"></i> Mis Partidos Asignados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive mb-3">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Torneo</th>
                            <th>Cancha</th>
                            <th>Local</th>
                            <th>Visitante</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody id="tbPartidosAsignados"></tbody>
                    </table>
                </div>

                <hr class="border-warning">

                <h6 class="text-warning mb-2">Historial reciente</h6>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Torneo</th>
                            <th>Local</th>
                            <th>Visitante</th>
                            <th>Marcador</th>
                        </tr>
                        </thead>
                        <tbody id="tbPartidosHistorico"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-light" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const Q = ''; // si ocupas ?arbitro_id=1 para pruebas, ponlo aquí

    let modalVerPartidos;

    document.addEventListener('DOMContentLoaded', ()=> {
        modalVerPartidos = new bootstrap.Modal(document.getElementById('modalVerPartidos'));

        document.getElementById('btnVerPartidos').addEventListener('click', abrirVerPartidos);

        pintarStats();
    });

    async function pintarStats(){
        try{
            const res = await fetch(`/arbitro/stats${Q}`);
            const json = await res.json();
            if(!json.ok) throw new Error('no ok');
            document.querySelectorAll('.stat-asignados').forEach(e => e.textContent = json.asignados);
            document.querySelectorAll('.stat-arbitrados').forEach(e => e.textContent = json.arbitrados);
        }catch(e){
            console.warn('No se pudieron cargar stats', e);
        }
    }

    async function abrirVerPartidos(){
        await Promise.all([cargarProximos(), cargarHistorico()]);
        modalVerPartidos.show();
    }

    async function cargarProximos(){
        const tb = document.getElementById('tbPartidosAsignados');
        tb.innerHTML = `<tr><td colspan="7" class="text-center text-muted">Cargando...</td></tr>`;
        try{
            const res = await fetch(`/arbitro/partidos/proximos${Q}`);
            const json = await res.json();
            if(!json.ok) throw new Error('respuesta no ok');
            const data = json.data || [];
            if(data.length === 0){
                tb.innerHTML = `<tr><td colspan="7" class="text-center text-muted">Sin asignaciones próximas</td></tr>`;
                return;
            }
            tb.innerHTML = '';
            data.forEach(p => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${p.fecha ?? '-'}</td>
                    <td>${p.hora ?? '-'}</td>
                    <td>${p.torneo ?? '-'}</td>
                    <td>${p.cancha ?? '-'}</td>
                    <td>${p.local ?? '-'}</td>
                    <td>${p.visitante ?? '-'}</td>
                    <td><span class="badge bg-info text-dark">Pendiente</span></td>
                `;
                tb.appendChild(tr);
            });
        }catch(err){
            tb.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Error al cargar</td></tr>`;
            console.error(err);
        }
    }

    async function cargarHistorico(){
        const tb = document.getElementById('tbPartidosHistorico');
        tb.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Cargando...</td></tr>`;
        try{
            const res = await fetch(`/arbitro/partidos/historico${Q}`);
            const json = await res.json();
            if(!json.ok) throw new Error('respuesta no ok');
            const data = json.data || [];
            if(data.length === 0){
                tb.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Sin historial</td></tr>`;
                return;
            }
            tb.innerHTML = '';
            data.forEach(p => {
                const marcador = `${p.goles_local ?? 0} - ${p.goles_visitante ?? 0}`;
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${p.fecha ?? '-'}</td>
                    <td>${p.hora ?? '-'}</td>
                    <td>${p.torneo ?? '-'}</td>
                    <td>${p.local ?? '-'}</td>
                    <td>${p.visitante ?? '-'}</td>
                    <td><span class="badge bg-warning text-dark">${marcador}</span></td>
                `;
                tb.appendChild(tr);
            });
        }catch(err){
            tb.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Error al cargar</td></tr>`;
            console.error(err);
        }
    }
</script>
</body>
</html>
