<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Coordinador FIF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root{--verde-principal:#2ecc71;--verde-oscuro:#145a32;--dorado:#f1c40f;--gris-oscuro:#1e272e;--blanco:#ffffff;}
        body{
            background:linear-gradient(rgba(20,90,50,.85),rgba(20,90,50,.85)),
            url('https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')
            center/cover no-repeat fixed;
            color:var(--blanco);font-family:'Poppins',sans-serif;min-height:100vh;padding:20px;
        }
        .dashboard-container{max-width:1400px;margin:0 auto;}
        .header{
            text-align:center;margin-bottom:40px;padding:25px;background:rgba(30,39,46,.95);
            border-radius:20px;border:3px solid var(--dorado);box-shadow:0 10px 30px rgba(0,0,0,.3);position:relative;
        }
        .header h1{color:var(--dorado);font-weight:800;text-transform:uppercase;margin-bottom:10px;font-size:2.5rem;}
        .header p{color:var(--verde-principal);font-size:1.2rem;font-weight:600;}

        .user-panel{
            position:absolute;top:20px;right:20px;background:rgba(46,204,113,.1);
            padding:15px;border-radius:15px;border:1px solid var(--dorado);width:280px;
        }
        .user-panel-header{display:flex;align-items:center;gap:10px;margin-bottom:10px;}
        .user-panel-header i{font-size:1.8rem;color:var(--dorado);}
        .user-panel-header h5{color:var(--dorado);margin:0;font-size:1.1rem;}
        .user-panel-name{font-size:.9rem;}
        .user-panel-mail{font-size:.8rem;color:#bdc3c7;}

        .logout-btn{
            background:transparent;border:2px solid #e74c3c;color:#e74c3c;padding:8px 15px;border-radius:25px;
            text-decoration:none;transition:.3s;font-weight:600;display:inline-flex;align-items:center;
            gap:8px;width:100%;justify-content:center;font-size:.9rem;
        }
        .logout-btn:hover{background:#e74c3c;color:#fff;transform:translateY(-2px);}

        .cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:25px;margin-top:30px;}
        .card{
            background:linear-gradient(145deg,rgba(30,39,46,.95) 0%,rgba(20,90,50,.7) 100%);
            border:2px solid var(--dorado);border-radius:15px;padding:30px;text-align:center;transition:.3s;
            color:var(--blanco);min-height:220px;display:flex;flex-direction:column;justify-content:center;align-items:center;
            box-shadow:0 8px 25px rgba(0,0,0,.2);
        }
        .card:hover{transform:translateY(-8px);box-shadow:0 15px 35px rgba(241,196,15,.3);border-color:var(--verde-principal);}
        .card i{
            font-size:3.5rem;background:linear-gradient(135deg,var(--dorado),var(--verde-principal));
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:20px;
        }
        .card h3{color:var(--dorado);font-weight:700;margin-bottom:15px;font-size:1.4rem;}
        .card p{color:var(--blanco);opacity:.9;line-height:1.5;margin-bottom:20px;font-size:.95rem;}
        .btn-dashboard{
            background:linear-gradient(45deg,var(--dorado),var(--verde-principal));border:none;border-radius:25px;
            padding:12px 30px;color:var(--gris-oscuro);font-weight:700;text-decoration:none;transition:.3s;font-size:1rem;
            display:inline-flex;align-items:center;gap:8px;
        }
        .btn-dashboard:hover{
            background:linear-gradient(45deg,var(--verde-principal),var(--dorado));transform:translateY(-2px);
            box-shadow:0 5px 15px rgba(46,204,113,.4);color:var(--gris-oscuro);text-decoration:none;
        }

        .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:30px;}
        .stat-card{
            background:rgba(46,204,113,.1);border-radius:15px;padding:20px;text-align:center;
            border:1px solid rgba(46,204,113,.3);
        }
        .stat-number{font-size:2.5rem;font-weight:bold;color:var(--dorado);margin-bottom:5px;}
        .stat-label{color:var(--verde-principal);font-weight:600;font-size:.9rem;}

        .section-title{
            color:var(--dorado);border-bottom:2px solid var(--verde-principal);
            padding-bottom:10px;margin:40px 0 20px 0;font-weight:700;
        }

        .modal-content{
            background:linear-gradient(145deg,rgba(30,39,46,.98) 0%,rgba(20,90,50,.9) 100%);
            border:2px solid var(--dorado);border-radius:15px;color:var(--blanco);
        }
        .modal-header{border-bottom:1px solid var(--dorado);}
        .modal-title{color:var(--dorado);font-weight:700;}
        .btn-close{filter:invert(1);}
        .table-dark{background:rgba(30,39,46,.9);border-radius:10px;overflow:hidden;}
        .table-dark th{background:var(--verde-oscuro);color:var(--dorado);border-color:var(--dorado);}
        .table-dark td{border-color:rgba(46,204,113,.3);}
        .badge-light{background:#f8f9fa;color:#212529;}

        @media (max-width:768px){
            .user-panel{position:static;width:100%;margin-bottom:20px}
            .header{padding-bottom:180px}
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="dashboard-container">
    <div class="header">
        <h1><i class="fas fa-user-tie"></i> Menu Coordinador</h1>
        <p>Control total del sistema FIF - Gestión de torneos y asignaciones</p>

        {{-- PANEL DEL USUARIO (SIN SELECTOR DE TORNEO) --}}
        <div class="user-panel">
            <div class="user-panel-header">
                <i class="fas fa-user-shield"></i>
                <div>
                    <h5>Coordinador General</h5>
                    @if($coordNombre)
                        <div class="user-panel-name">{{ $coordNombre }}</div>
                    @endif
                    @if($coordCorreo)
                        <div class="user-panel-mail">{{ $coordCorreo }}</div>
                    @endif
                </div>
            </div>
            <a href="/" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </div>

    {{-- ESTADÍSTICAS (DATOS REALES DEL CONTROLADOR) --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $totalEquipos }}</div>
            <div class="stat-label">Equipos Registrados</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $totalArbitros }}</div>
            <div class="stat-label">Árbitros Activos</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $torneosActivos }}</div>
            <div class="stat-label">Torneos Registrados</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $partidosProgramados }}</div>
            <div class="stat-label">Partidos Programados (≥ hoy)</div>
        </div>
    </div>

    <h3 class="section-title"><i class="fas fa-trophy"></i> Gestión de Torneos</h3>
    <div class="cards">
        <div class="card">
            <i class="fas fa-edit"></i>
            <h3>Gestionar Torneos</h3>
            <p>Modifica torneos existentes y configuración</p>
            <a href="/gestionar_torneos" class="btn-dashboard">
                <i class="fas fa-edit"></i> Gestionar
            </a>
        </div>
        <div class="card">
            <i class="fas fa-calendar-alt"></i>
            <h3>Programar Partidos</h3>
            <p>Gestiona el calendario y fixture de partidos</p>
            <a href="/programar_partidos" class="btn-dashboard">
                <i class="fas fa-calendar-plus"></i> Programar
            </a>
        </div>
    </div>

    <h3 class="section-title"><i class="fas fa-users"></i> Gestión de Equipos</h3>
    <div class="cards">
        <div class="card">
            <i class="fas fa-list"></i>
            <h3>Gestionar Equipos</h3>
            <p>Administra equipos existentes y sus datos</p>
            <a href="/gestionar_equipos" class="btn-dashboard">
                <i class="fas fa-cog"></i> Gestionar
            </a>
        </div>
        <div class="card">
            <i class="fas fa-eye"></i>
            <h3>Ver Jugadores</h3>
            <p>Solicitudes y jugadores activos</p>
            <button class="btn-dashboard" onclick="abrirModalJugadores()">
                <i class="fas fa-list"></i> Ver Jugadores
            </button>
        </div>
    </div>

    <h3 class="section-title"><i class="fas fa-whistle"></i> Gestión de Árbitros</h3>
    <div class="cards">
        <div class="card">
            <i class="fas fa-eye"></i>
            <h3>Ver Árbitros</h3>
            <p>Consulta, edita y elimina árbitros</p>
            <button class="btn-dashboard" onclick="abrirVerArbitros()">
                <i class="fas fa-list"></i> Ver Árbitros
            </button>
        </div>
    </div>
</div>

{{-- ================= MODAL JUGADORES ================= --}}
<div class="modal fade" id="modalJugadores" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-users"></i> Gestión de Jugadores</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <ul class="nav nav-tabs" id="tabJugadores" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-solicitudes"
                                data-bs-toggle="tab" data-bs-target="#pane-solicitudes" type="button" role="tab">
                            Solicitudes Pendientes
                            <span class="badge bg-warning text-dark" id="badgePendientes">0</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-activos"
                                data-bs-toggle="tab" data-bs-target="#pane-activos" type="button" role="tab">
                            Jugadores Activos
                        </button>
                    </li>
                </ul>

                <div class="tab-content pt-3">
                    {{-- Solicitudes --}}
                    <div class="tab-pane fade show active" id="pane-solicitudes" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle">
                                <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>CURP</th>
                                    <th>Nacimiento</th>
                                    <th>Localidad</th>
                                    <th>Dorsal</th>
                                    <th>Posición</th>
                                    <th style="width:230px">Acciones</th>
                                </tr>
                                </thead>
                                <tbody id="tbodySolicitudes"></tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Activos --}}
                    <div class="tab-pane fade" id="pane-activos" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle">
                                <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Equipo</th>
                                    <th>Dorsal</th>
                                    <th>Posición</th>
                                    <th>Correo</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyActivos"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div> <!-- body -->
        </div>
    </div>
</div>

{{-- SUBMODAL APROBAR JUGADOR --}}
<div class="modal fade" id="modalAprobar" tabindex="-1">
    <div class="modal-dialog">
        <form id="formAprobar" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-check"></i> Aprobar y asignar equipo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="aprobarIdJugador">
                <div class="mb-3">
                    <label class="form-label">Equipo *</label>
                    <select class="form-select" id="aprobarEquipo" required></select>
                </div>
                <small class="text-muted">
                    Al confirmar, el jugador pasará a estado
                    <span class="badge bg-success">Activo</span>.
                </small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-check"></i> Aprobar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL ÁRBITROS --}}
<div class="modal fade" id="modalVerArbitros" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="background:linear-gradient(145deg, rgba(30,39,46,.98), rgba(20,90,50,.9)); border:2px solid #f1c40f; color:#fff;">
            <div class="modal-header" style="border-bottom:1px solid #f1c40f;">
                <h5 class="modal-title"><i class="fas fa-whistle"></i> Árbitros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
            </div>

            <div class="modal-body">
                {{-- Formulario crear/editar árbitro --}}
                <form id="frmArbitro" class="mb-4">
                    <input type="hidden" id="arb_id" value="">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-warning">Nombre completo *</label>
                            <input type="text" class="form-control" id="arb_nombre" placeholder="Ej. Luis Pérez Gómez">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-warning">Licencia *</label>
                            <input type="text" class="form-control" id="arb_licencia" placeholder="LIC12345">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-warning">Años experiencia *</label>
                            <input type="number" class="form-control" id="arb_exp" min="0" max="50" placeholder="5">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label text-warning">Vigencia *</label>
                            <input type="date" class="form-control" id="arb_vigencia">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-warning">Estado</label>
                            <input type="text" class="form-control" id="arb_estado" placeholder="Se calcula automáticamente" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-warning">Correo</label>
                            <input type="email" class="form-control" id="arb_correo" placeholder="correo@dominio.com">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-warning">Teléfono</label>
                            <input type="text" class="form-control" id="arb_tel" placeholder="10 dígitos" maxlength="10">
                        </div>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <button type="button" class="btn btn-success" id="btnGuardarArb">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <button type="button" class="btn btn-secondary" id="btnLimpiarArb">
                            <i class="fas fa-broom"></i> Limpiar
                        </button>
                    </div>
                </form>

                {{-- Tabla árbitros --}}
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Licencia</th>
                            <th>Experiencia</th>
                            <th>Vigencia</th>
                            <th>Estado</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th style="width:120px">Acciones</th>
                        </tr>
                        </thead>
                        <tbody id="tbArbitros"></tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer" style="border-top:1px solid #f1c40f;">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    /* ===== ÁRBITROS ===== */
    function abrirVerArbitros(){
        const m = new bootstrap.Modal(document.getElementById('modalVerArbitros'));
        m.show();
        cargarArbitros();
    }

    async function cargarArbitros(){
        const tb = document.getElementById('tbArbitros');
        tb.innerHTML = `<tr><td colspan="8" class="text-center text-muted">Cargando...</td></tr>`;
        try{
            const res  = await fetch('/arbitros', { headers: {'X-Requested-With':'XMLHttpRequest'} });
            const json = await res.json();
            if(!json.ok){ throw new Error('Respuesta inválida'); }

            const data = json.arbitros || [];
            if(data.length === 0){
                tb.innerHTML = `<tr><td colspan="8" class="text-center text-muted">Sin árbitros registrados</td></tr>`;
                return;
            }

            tb.innerHTML = '';
            data.forEach(a=>{
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${a.nombre ?? '(sin nombre)'}</td>
                    <td>${a.licencia ?? ''}</td>
                    <td>${a.anios_experiencia ?? 0} años</td>
                    <td>${a.vigencia_licencia ?? ''}</td>
                    <td><span class="badge ${a.estado==='Activo'?'bg-success':'bg-secondary'}">${a.estado ?? ''}</span></td>
                    <td>${a.correo ?? ''}</td>
                    <td>${a.telefono ?? ''}</td>
                    <td>
                      <button class="btn btn-sm btn-warning me-1" title="Editar" onclick='editarArb(${JSON.stringify(a)})'>
                        <i class="fas fa-pen"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Eliminar" onclick="eliminarArb(${a.id_arbitro})">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                `;
                tb.appendChild(tr);
            });
        }catch(e){
            tb.innerHTML = `<tr><td colspan="8" class="text-center text-danger">Error al cargar</td></tr>`;
        }
    }

    function estadoDesdeVigencia(v){
        if(!v) return '';
        const hoy = new Date(); hoy.setHours(0,0,0,0);
        const fv  = new Date(v); fv.setHours(0,0,0,0);
        return fv >= hoy ? 'Activo' : 'Inactivo';
    }

    document.getElementById('btnGuardarArb').addEventListener('click', async ()=>{
        const id  = document.getElementById('arb_id').value || null;
        const body = {
            nombre_full: (document.getElementById('arb_nombre').value || '').trim(),
            licencia:    (document.getElementById('arb_licencia').value || '').trim(),
            anios_experiencia: parseInt(document.getElementById('arb_exp').value || '0'),
            vigencia_licencia: document.getElementById('arb_vigencia').value || null,
            correo:      (document.getElementById('arb_correo').value || '').trim(),
            telefono:    (document.getElementById('arb_tel').value || '').trim(),
            estado:      estadoDesdeVigencia(document.getElementById('arb_vigencia').value)
        };

        if(!body.nombre_full || !body.licencia){
            alert('Nombre y licencia son obligatorios.');
            return;
        }

        const url  = id ? `/arbitros/${id}` : `/arbitros`;
        const meth = id ? 'PUT' : 'POST';

        try{
            const res = await fetch(url, {
                method: meth,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': CSRF
                },
                body: JSON.stringify(body)
            });
            const json = await res.json();
            if(!json.ok){
                alert(json.message || 'No se pudo guardar');
                return;
            }
            limpiarFormArb();
            cargarArbitros();
        }catch(e){
            alert('Error de red');
        }
    });

    function editarArb(a){
        document.getElementById('arb_id').value       = a.id_arbitro;
        document.getElementById('arb_nombre').value   = a.nombre || '';
        document.getElementById('arb_licencia').value = a.licencia || '';
        document.getElementById('arb_exp').value      = a.anios_experiencia || 0;
        document.getElementById('arb_vigencia').value = a.vigencia_licencia || '';
        document.getElementById('arb_estado').value   = a.estado || '';
        document.getElementById('arb_correo').value   = a.correo || '';
        document.getElementById('arb_tel').value      = a.telefono || '';
    }

    async function eliminarArb(id){
        if(!confirm('¿Eliminar árbitro?')) return;
        try{
            const res = await fetch(`/arbitros/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': CSRF
                }
            });
            const json = await res.json();
            if(!json.ok){
                alert(json.message || 'No se pudo eliminar');
                return;
            }
            cargarArbitros();
        }catch(e){
            alert('Error de red');
        }
    }

    document.getElementById('btnLimpiarArb').addEventListener('click', limpiarFormArb);
    document.getElementById('arb_vigencia').addEventListener('input', e=>{
        document.getElementById('arb_estado').value = estadoDesdeVigencia(e.target.value);
    });

    function limpiarFormArb(){
        document.getElementById('arb_id').value = '';
        document.getElementById('frmArbitro').reset();
        document.getElementById('arb_estado').value = '';
    }

    /* ===== JUGADORES ===== */
    let modalJugadores, modalAprobar;

    document.addEventListener('DOMContentLoaded', ()=>{
        modalJugadores = new bootstrap.Modal(document.getElementById('modalJugadores'));
        modalAprobar   = new bootstrap.Modal(document.getElementById('modalAprobar'));

        cargarEquiposSelect();
        document.getElementById('formAprobar').addEventListener('submit', submitAprobar);
    });

    function abrirModalJugadores(){
        modalJugadores.show();
        cargarSolicitudes();
        cargarActivos();
    }

    async function cargarEquiposSelect(){
        const sel = document.getElementById('aprobarEquipo');
        sel.innerHTML = '<option value="">Cargando...</option>';
        try{
            const res = await fetch('/api/equipos');
            const json = await res.json();
            sel.innerHTML = '<option value="">-- Seleccionar equipo --</option>';
            (json || []).forEach(e=>{
                const opt = document.createElement('option');
                opt.value = e.id;
                opt.textContent = e.nombre;
                sel.appendChild(opt);
            });
        }catch(e){
            sel.innerHTML = '<option value="">Error al cargar</option>';
        }
    }

    async function cargarSolicitudes(){
        const tbody = document.getElementById('tbodySolicitudes');
        tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Cargando...</td></tr>';
        try{
            const res = await fetch('/api/jugadores/pendientes');
            const json = await res.json();
            if(!json.ok){ throw new Error('Error'); }
            const data = json.data || [];
            document.getElementById('badgePendientes').textContent = data.length;

            if(data.length === 0){
                tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">No hay solicitudes pendientes</td></tr>';
                return;
            }

            tbody.innerHTML = '';
            data.forEach(j=>{
                const nombre = [j.apaterno, j.amaterno, j.nombre].filter(Boolean).join(' ');
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><strong>${nombre}</strong></td>
                    <td>${j.correo ?? '-'}</td>
                    <td><span class="badge bg-light text-dark">${j.curp ?? '-'}</span></td>
                    <td>${j.fecha_de_nacimiento ?? '-'}</td>
                    <td>${j.localidad ?? '-'}</td>
                    <td>${j.dorsal ?? '-'}</td>
                    <td>${j.posicion ?? '-'}</td>
                    <td>
                      <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-success" onclick="abrirAprobar(${j.id_jugador})">
                          <i class="fas fa-check"></i> Aprobar
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="rechazar(${j.id_jugador})">
                          <i class="fas fa-times"></i> Rechazar
                        </button>
                      </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });

        }catch(e){
            tbody.innerHTML = '<tr><td colspan="8" class="text-center text-danger">Error al cargar solicitudes</td></tr>';
        }
    }

    async function cargarActivos(){
        const tbody = document.getElementById('tbodyActivos');
        tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Cargando...</td></tr>';
        try{
            const res = await fetch('/api/jugadores/activos');
            const json = await res.json();
            if(!json.ok){ throw new Error('Error'); }
            const data = json.data || [];
            if(data.length === 0){
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No hay jugadores activos</td></tr>';
                return;
            }
            tbody.innerHTML = '';
            data.forEach(j=>{
                const nombre = [j.apaterno, j.amaterno, j.nombre].filter(Boolean).join(' ');
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><strong>${nombre}</strong></td>
                    <td>${j.equipo ?? '-'}</td>
                    <td>${j.dorsal ?? '-'}</td>
                    <td>${j.posicion ?? '-'}</td>
                    <td>${j.correo ?? '-'}</td>
                `;
                tbody.appendChild(tr);
            });
        }catch(e){
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error al cargar</td></tr>';
        }
    }

    function abrirAprobar(idJugador){
        document.getElementById('aprobarIdJugador').value = idJugador;
        document.getElementById('aprobarEquipo').value = '';
        modalAprobar.show();
    }

    async function submitAprobar(ev){
        ev.preventDefault();
        const id = document.getElementById('aprobarIdJugador').value;
        const equipo = document.getElementById('aprobarEquipo').value;

        if(!equipo){ alert('Selecciona un equipo.'); return; }

        try{
            const res = await fetch(`/api/jugadores/${id}/aprobar`, {
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
                body: JSON.stringify({equipo:Number(equipo)})
            });
            const json = await res.json();
            if(!json.ok){
                alert(json.message || 'No se pudo aprobar');
                return;
            }
            modalAprobar.hide();
            cargarSolicitudes();
            cargarActivos();
            alert('Jugador aprobado y asignado correctamente.');
        }catch(e){
            alert('Error de red aprobando jugador.');
        }
    }

    async function rechazar(id){
        if(!confirm('¿Seguro que deseas rechazar esta solicitud?')) return;
        try{
            const res = await fetch(`/api/jugadores/${id}/rechazar`, {
                method:'POST',
                headers:{'X-CSRF-TOKEN':CSRF}
            });
            const json = await res.json();
            if(!json.ok){
                alert(json.message || 'No se pudo rechazar');
                return;
            }
            cargarSolicitudes();
            alert('Solicitud rechazada.');
        }catch(e){
            alert('Error de red.');
        }
    }
</script>
</body>
</html>
