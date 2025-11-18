<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Torneos - FIF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root{
            --verde-principal:#2ecc71; --verde-oscuro:#145a32; --dorado:#f1c40f; --gris-oscuro:#1e272e; --blanco:#ffffff;
        }
        body{
            background:
                linear-gradient(rgba(20,90,50,.85),rgba(20,90,50,.85)),
                url('https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat fixed;
            color:var(--blanco); font-family:'Poppins',sans-serif; min-height:100vh; padding:20px;
        }
        .container{max-width:1200px; margin:0 auto;}
        .header{ text-align:center; margin-bottom:40px; padding:25px; background:rgba(30,39,46,.95);
            border-radius:20px; border:3px solid var(--dorado); box-shadow:0 10px 30px rgba(0,0,0,.3);}
        .header h1{color:var(--dorado); font-weight:800; text-transform:uppercase; margin-bottom:10px; font-size:2.5rem;}
        .header p{color:var(--verde-principal); font-size:1.2rem; font-weight:600;}

        .card{ background:linear-gradient(145deg, rgba(30,39,46,.95) 0%, rgba(20,90,50,.7) 100%);
            border:2px solid var(--dorado); border-radius:15px; padding:30px; margin-bottom:30px;
            box-shadow:0 8px 25px rgba(0,0,0,.2);}
        .card-header{ background:transparent; border-bottom:2px solid var(--dorado); padding:20px 30px;}
        .card-title{ color:var(--dorado); font-weight:700; margin:0; font-size:1.5rem;}

        .btn-primary{ background:linear-gradient(45deg,var(--dorado),var(--verde-principal)); border:none; border-radius:25px;
            padding:12px 30px; color:var(--gris-oscuro); font-weight:700; transition:.3s;}
        .btn-primary:hover{ background:linear-gradient(45deg,var(--verde-principal),var(--dorado)); transform:translateY(-2px);
            box-shadow:0 5px 15px rgba(46,204,113,.4); color:var(--gris-oscuro);}
        .btn-info{ background:linear-gradient(45deg,#3498db,#2980b9); border:none; border-radius:20px; color:#fff; font-weight:600;}
        .btn-warning{ background:linear-gradient(45deg,#f39c12,var(--dorado)); border:none; border-radius:20px; color:var(--gris-oscuro); font-weight:600;}
        .btn-danger{ background:linear-gradient(45deg,#e74c3c,#c0392b); border:none; border-radius:20px; color:#fff; font-weight:600;}
        .btn-secondary{ background:linear-gradient(45deg,#7f8c8d,#95a5a6); border:none; border-radius:25px; padding:10px 25px;
            color:#fff; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:8px;}
        .btn-secondary:hover{ color:#fff; transform:translateY(-2px);}

        .form-control,.form-select{ background:rgba(255,255,255,.1); border:1px solid var(--dorado); color:var(--blanco);
            border-radius:10px; padding:12px 15px;}
        .form-control:focus,.form-select:focus{ background:rgba(255,255,255,.15); border-color:var(--verde-principal);
            color:var(--blanco); box-shadow:0 0 0 .2rem rgba(46,204,113,.25);}
        .form-select option{ background:var(--gris-oscuro); color:var(--blanco);}
        .form-label{ color:var(--dorado); font-weight:600; margin-bottom:8px;}

        .table-dark{ background:rgba(30,39,46,.9); border-radius:10px; overflow:hidden; border:1px solid var(--dorado);}
        .table-dark th{ background:var(--verde-oscuro); color:var(--dorado); border-color:var(--dorado); padding:15px; font-weight:700;}
        .table-dark td{ border-color:rgba(46,204,113,.3); padding:15px; vertical-align:middle;}

        .nav-tabs{ border-bottom:2px solid var(--dorado); margin-bottom:30px;}
        .nav-tabs .nav-link{ color:var(--blanco); border:2px solid transparent; border-radius:10px 10px 0 0;
            padding:12px 25px; font-weight:600; margin-right:5px;}
        .nav-tabs .nav-link.active{ background:rgba(46,204,113,.2); border-color:var(--dorado) var(--dorado) transparent; color:var(--dorado);}
        .nav-tabs .nav-link:hover{ border-color:var(--verde-principal); color:var(--verde-principal);}

        .action-buttons{ display:flex; gap:8px; justify-content:center;}
        .back-btn{ position:absolute; top:30px; left:30px;}
        textarea.form-control{ min-height:120px; resize:vertical;}

        /* Panel de detalles: texto claro y legible */
        .detalles-torneo{ display:none; margin-top:20px; padding:20px; background:rgba(30,39,46,.88); border-radius:10px; border:1px solid var(--dorado);}
        .detalles-torneo, .detalles-torneo *{ color:#E6F1F7 !important; } /* azul muy claro para contraste */
        .detalles-torneo h4{ color:var(--dorado) !important; }
    </style>
</head>
<body>
@php
    // Mantener la pestaña "gestionar" activa cuando venís del filtro
    $tab = request('tab', request()->has('estado') ? 'gestionar' : 'crear');
@endphp

<div class="container">
    <a href="/menu_cordinador" class="btn btn-secondary back-btn">
        <i class="fas fa-arrow-left"></i> Volver al Menu
    </a>

    <div class="header">
        <h1><i class="fas fa-trophy"></i> Gestión de Torneos</h1>
        <p>Administra y configura todos los torneos del sistema FIF</p>
    </div>

    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups…</strong> corrige estos campos:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <ul class="nav nav-tabs" id="torneoTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $tab==='crear' ? 'active' : '' }}" id="crear-tab" data-bs-toggle="tab" data-bs-target="#crear" type="button" role="tab">
                <i class="fas fa-plus-circle"></i> Crear Nuevo Torneo
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $tab==='gestionar' ? 'active' : '' }}" id="gestionar-tab" data-bs-toggle="tab" data-bs-target="#gestionar" type="button" role="tab">
                <i class="fas fa-edit"></i> Gestionar Torneos Existentes
            </button>
        </li>
    </ul>

    <div class="tab-content" id="torneoTabsContent">
        {{-- ===================== CREAR ===================== --}}
        <div class="tab-pane fade {{ $tab==='crear' ? 'show active' : '' }}" id="crear" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-plus-circle"></i> Formulario de Creación de Torneo</h3>
                </div>
                <div class="card-body">
                    <form id="formCrearTorneo" method="POST" action="{{ route('torneos.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombreTorneo" class="form-label">Nombre del Torneo *</label>
                                <input type="text" class="form-control" id="nombreTorneo" name="nombre" required
                                       placeholder="Ej: Torneo Verano Valle 2025" maxlength="100" value="{{ old('nombre') }}">
                                <small class="form-text text-muted">Máximo 100 caracteres</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="temporada" class="form-label">Temporada *</label>
                                <input type="number" class="form-control" id="temporada" name="temporada" required
                                       min="2000" max="2100" value="{{ old('temporada', now()->year) }}" placeholder="2025">
                                <small class="form-text text-muted">Año de la temporada (YYYY)</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fechaInicio" class="form-label">Fecha de Inicio *</label>
                                <input type="date" class="form-control" id="fechaInicio" name="fecha_inicio" required
                                       value="{{ old('fecha_inicio') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fechaFin" class="form-label">Fecha de Fin *</label>
                                <input type="date" class="form-control" id="fechaFin" name="fecha_fin" required
                                       value="{{ old('fecha_fin') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="localidad" class="form-label">Localidad *</label>
                                <select class="form-select" id="localidad" name="localidad" required>
                                    <option value="">Seleccionar localidad</option>
                                    @foreach ($localidades as $loc)
                                        <option value="{{ $loc->id_localidad }}" {{ old('localidad')==$loc->id_localidad ? 'selected' : '' }}>
                                            {{ $loc->comunidad }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Localidad donde se desarrolla el torneo</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="descripcion" class="form-label">Descripción *</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required
                                          placeholder="Descripción detallada del torneo, observaciones...">{{ old('descripcion') }}</textarea>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="reset" class="btn btn-secondary me-2">
                                <i class="fas fa-undo"></i> Limpiar Formulario
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Crear Torneo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ===================== GESTIONAR ===================== --}}
        <div class="tab-pane fade {{ $tab==='gestionar' ? 'show active' : '' }}" id="gestionar" role="tabpanel">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><i class="fas fa-list"></i> Torneos Existentes</h3>

                    <!-- Mantenerse en esta pestaña al filtrar -->
                    <form method="GET" action="{{ route('torneos.index') }}" style="width:300px;">
                        <input type="hidden" name="tab" value="gestionar">
                        <select class="form-select" id="filtroEstado" name="estado" onchange="this.form.submit()">
                            <option value="todos"        {{ ($estado ?? 'todos') === 'todos' ? 'selected' : '' }}>Todos los torneos</option>
                            <option value="activos"      {{ ($estado ?? '') === 'activos' ? 'selected' : '' }}>Activos</option>
                            <option value="finalizados"  {{ ($estado ?? '') === 'finalizados' ? 'selected' : '' }}>Finalizados</option>
                            <option value="planificados" {{ ($estado ?? '') === 'planificados' ? 'selected' : '' }}>Planificados</option>
                        </select>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Temporada</th>
                                <th>Fechas</th>
                                <th>Localidad</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($torneos as $t)
                                <tr>
                                    <td>{{ $t->nombre }}</td>
                                    <td>{{ $t->temporada }}</td>
                                    <td>{{ \Carbon\Carbon::parse($t->fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($t->fecha_fin)->format('d/m/Y') }}</td>
                                    <td>{{ optional($t->localidadRel)->comunidad ?? '—' }}</td>
                                    <td>
                                        @php
                                            $badge = match($t->estado){
                                                'Activo'=>'success','Finalizado'=>'secondary','Planificado'=>'warning', default=>'secondary',
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badge }}">{{ $t->estado }}</span>
                                    </td>
                                    <td class="action-buttons">
                                        <button class="btn btn-info btn-sm" onclick="verDetalles({{ $t->id_torneo }}, '{{ e($t->nombre) }}')">
                                            <i class="fas fa-eye"></i> Detalles
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">No hay torneos para el filtro seleccionado.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Panel de detalles -->
                    <div id="detallesTorneo" class="detalles-torneo">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0"><i class="fas fa-info-circle"></i> <span id="tituloDetalle">Detalles del Torneo</span></h4>
                            <button class="btn btn-sm btn-secondary" onclick="cerrarDetalles()">
                                <i class="fas fa-times"></i> Cerrar
                            </button>
                        </div>
                        <div id="detallesContenido">
                            Selecciona “Detalles” en la tabla para mostrar información aquí.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /tab-content -->
</div> <!-- /container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Validación en creación
    document.getElementById('formCrearTorneo')?.addEventListener('submit', function(e){
        const fi=document.getElementById('fechaInicio').value;
        const ff=document.getElementById('fechaFin').value;
        if(fi && ff && (new Date(ff)<=new Date(fi))){
            e.preventDefault();
            alert('La fecha de fin debe ser posterior a la fecha de inicio');
        }
    });

    // Detalles visibles con buen contraste
    function verDetalles(id, nombre){
        const panel=document.getElementById('detallesTorneo');
        document.getElementById('tituloDetalle').textContent = `Detalles del Torneo: ${nombre}`;
        document.getElementById('detallesContenido').innerHTML = `
            <p class="mb-1">ID Torneo: <strong>${id}</strong></p>
            <p class="mb-0">Aquí puedes renderizar detalles completos del torneo (cargar por AJAX o incluir datos en la fila).</p>
        `;
        panel.style.display='block';
        panel.scrollIntoView({behavior:'smooth'});
    }
    function cerrarDetalles(){
        const panel=document.getElementById('detallesTorneo');
        document.getElementById('detallesContenido').textContent =
            'Selecciona “Detalles” en la tabla para mostrar información aquí.';
        panel.style.display='none';
    }
</script>
</body>
</html>
