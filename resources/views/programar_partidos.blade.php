<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Programar Partidos - FIF</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

    <style>
        :root{
            --verde-principal:#2ecc71;
            --verde-oscuro:#145a32;
            --dorado:#f1c40f;
            --gris-oscuro:#1e272e;
            --blanco:#ffffff;
        }

        body{
            background:
                linear-gradient(rgba(20,90,50,.85),rgba(20,90,50,.85)),
                url('https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')
                center/cover no-repeat fixed;
            color:var(--blanco);
            font-family:'Poppins',sans-serif;
            min-height:100vh;
            padding:20px;
        }

        .container{max-width:1200px; margin:0 auto;}
        .header{
            text-align:center; margin-bottom:40px; padding:25px;
            background:rgba(30,39,46,.95); border-radius:20px;
            border:3px solid var(--dorado); box-shadow:0 10px 30px rgba(0,0,0,.3);
        }
        .header h1{color:var(--dorado); font-weight:800; text-transform:uppercase; margin-bottom:10px; font-size:2.5rem;}
        .header p{color:var(--verde-principal); font-size:1.2rem; font-weight:600;}

        .card{
            background:linear-gradient(145deg, rgba(30,39,46,.95) 0%, rgba(20,90,50,.7) 100%);
            border:2px solid var(--dorado); border-radius:15px; padding:30px; margin-bottom:30px;
            box-shadow:0 8px 25px rgba(0,0,0,.2);
        }
        .card-header{background:transparent; border-bottom:2px solid var(--dorado); padding:20px 30px;}
        .card-title{color:var(--dorado); font-weight:700; margin:0; font-size:1.5rem;}

        .btn-primary{
            background:linear-gradient(45deg,var(--dorado),var(--verde-principal));
            border:none; border-radius:25px; padding:12px 30px; color:var(--gris-oscuro); font-weight:700; transition:.3s;
        }
        .btn-primary:hover{
            background:linear-gradient(45deg,var(--verde-principal),var(--dorado));
            transform:translateY(-2px); box-shadow:0 5px 15px rgba(46,204,113,.4); color:var(--gris-oscuro);
        }
        .btn-success{background:linear-gradient(45deg,var(--verde-principal),#27ae60); border:none; border-radius:20px; color:white; font-weight:600;}
        .btn-secondary{
            background:linear-gradient(45deg,#7f8c8d,#95a5a6);
            border:none; border-radius:25px; padding:10px 25px; color:white; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:8px;
        }
        .btn-secondary:hover{color:white; transform:translateY(-2px);}

        .form-control,.form-select{
            background:rgba(255,255,255,.1); border:1px solid var(--dorado); color:var(--blanco); border-radius:10px; padding:12px 15px;
        }
        .form-control:focus,.form-select:focus{
            background:rgba(255,255,255,.15); border-color:var(--verde-principal); color:var(--blanco); box-shadow:0 0 0 .2rem rgba(46,204,113,.25);
        }
        .form-label{color:var(--dorado); font-weight:600; margin-bottom:8px;}

        .table-dark{background:rgba(30,39,46,.9); border-radius:10px; overflow:hidden; border:1px solid var(--dorado);}
        .table-dark th{background:var(--verde-oscuro); color:var(--dorado); border-color:var(--dorado); padding:15px; font-weight:700;}
        .table-dark td{border-color:rgba(46,204,113,.3); padding:15px; vertical-align:middle;}

        .badge-success{background:linear-gradient(45deg,var(--verde-principal),#27ae60);}
        .badge-warning{background:linear-gradient(45deg,#f39c12,#e67e22);}
        .badge-secondary{background:linear-gradient(45deg,#7f8c8d,#95a5a6);}

        .back-btn{position:absolute; top:30px; left:30px;}
        .equipo-info{background:rgba(46,204,113,.1); border-radius:10px; padding:15px; margin-bottom:15px; border:1px solid rgba(46,204,113,.3);}
        .arbitro-card{background:rgba(52,152,219,.1); border:1px solid rgba(52,152,219,.3); border-radius:10px; padding:15px; margin-bottom:10px;}
        .cancha-info{background:rgba(155,89,182,.1); border:1px solid rgba(155,89,182,.3); border-radius:10px; padding:15px; margin-bottom:15px;}
        .nueva-cancha-form{background:rgba(241,196,15,.1); border:1px solid rgba(241,196,15,.3); border-radius:10px; padding:15px; margin-top:10px;}
        .alert-warning{background:rgba(241,196,15,.2); border:1px solid var(--dorado); border-radius:10px; padding:15px; margin-bottom:15px;}

        :root{
            color-scheme: dark;
            --select-bg: rgba(16,38,28,.98);
            --select-txt:#FAF3CF;
            --select-border:#f1c40f;
            --select-focus: rgba(46,204,113,.35);
        }
        .form-select{
            color:var(--select-txt);
            background-color:var(--select-bg);
            border-color:var(--select-border);
            appearance:none;
        }
        .form-select option{
            color:#ffffff;
            background-color:#0f221b;
        }
        .form-select:focus{
            color:var(--select-txt);
            background-color:var(--select-bg);
            border-color:var(--select-border);
            box-shadow:0 0 0 .2rem var(--select-focus);
        }
        .form-select:invalid,
        .form-select option[disabled],
        .form-select option[value=""]{
            color:#c8d6c6;
        }
        .form-select::-ms-expand{display:none;}

        @-moz-document url-prefix(){
            .form-select option{
                background-color:#0e1d17 !important;
                color:#fff !important;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <a href="/menu_cordinador" class="btn btn-secondary back-btn">
        <i class="fas fa-arrow-left"></i> Volver al Menu
    </a>

    <div class="header">
        <h1><i class="fas fa-calendar-alt"></i> Programar Partidos</h1>
        <p>Gestiona el calendario y fixture de partidos del sistema FIF</p>
    </div>

    @if (session('ok'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('ok') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Revisa:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-plus-circle"></i> Programar Nuevo Partido</h3>
        </div>
        <div class="card-body">
            <form id="formProgramarPartido" method="POST" action="{{ route('partidos.store') }}">
                @csrf

                {{-- Torneo y Jornada --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 style="color: var(--dorado);"><i class="fas fa-trophy"></i> Información del Torneo</h5>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="torneo" class="form-label">Torneo *</label>
                                <select class="form-select" id="torneo" name="id_torneo" required>
                                    <option value="">Seleccionar torneo</option>
                                    @foreach ($torneos as $t)
                                        <option value="{{ $t->id_torneo }}">{{ $t->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="jornada" class="form-label">Jornada *</label>
                                <input type="number" class="form-control" id="jornada" name="jornada" required min="1" max="38" value="1">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 style="color: var(--dorado);"><i class="fas fa-calendar-day"></i> Fecha y Hora</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fechaPartido" class="form-label">Fecha *</label>
                                <input type="date" class="form-control" id="fechaPartido" name="fecha" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="horaPartido" class="form-label">Hora *</label>
                                <input type="time" class="form-control" id="horaPartido" name="hora" required value="15:00">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Equipos --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 style="color: var(--dorado);"><i class="fas fa-users"></i> Selección de Equipos</h5>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="equipo-info">
                                    <label for="equipoLocal" class="form-label">Equipo Local *</label>
                                    <select class="form-select" id="equipoLocal" name="equipo_local" required>
                                        <option value="">Seleccionar equipo local</option>
                                        @foreach ($equipos as $e)
                                            <option value="{{ $e->id_equipo }}">{{ $e->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div class="mt-2"><small class="text-muted"><i class="fas fa-info-circle"></i> Equipo que juega en casa</small></div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center my-auto">
                                <h4 class="text-warning">VS</h4>
                            </div>
                            <div class="col-md-5">
                                <div class="equipo-info">
                                    <label for="equipoVisitante" class="form-label">Equipo Visitante *</label>
                                    <select class="form-select" id="equipoVisitante" name="equipo_visitante" required>
                                        <option value="">Seleccionar equipo visitante</option>
                                        @foreach ($equipos as $e)
                                            <option value="{{ $e->id_equipo }}">{{ $e->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div class="mt-2"><small class="text-muted"><i class="fas fa-info-circle"></i> Equipo que visita</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cancha --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 style="color: var(--dorado);"><i class="fas fa-map-marker-alt"></i> Ubicación del Partido</h5>
                        <div class="cancha-info">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cancha" class="form-label">Cancha *</label>
                                    <select class="form-select" id="cancha" name="id_cancha" required>
                                        <option value="">Seleccionar cancha</option>
                                        @foreach ($canchas as $c)
                                            <option value="{{ $c->id_cancha }}">{{ $c->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Agregar nueva cancha</label>
                                    <button type="button" class="btn btn-success w-100" onclick="mostrarFormularioNuevaCancha()">
                                        <i class="fas fa-plus"></i> Agregar Nueva Cancha
                                    </button>
                                </div>
                            </div>

                            {{-- Form nueva cancha --}}
                            <div id="formNuevaCancha" class="nueva-cancha-form" style="display:none;">
                                <h6 class="text-warning mb-3"><i class="fas fa-plus-circle"></i> Nueva Cancha</h6>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Nombre *</label>
                                        <input type="text" class="form-control" id="nc_nombre" placeholder="Nombre de la cancha">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Localidad *</label>
                                        <select class="form-select" id="nc_localidad">
                                            <option value="">Seleccionar localidad</option>
                                            @foreach ($localidades as $loc)
                                                <option value="{{ $loc->id_localidad }}">{{ $loc->comunidad }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Dirección *</label>
                                        <input type="text" class="form-control" id="nc_direccion" placeholder="Dirección completa">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Capacidad</label>
                                        <input type="number" class="form-control" id="nc_capacidad" placeholder="Ej: 1000">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Teléfono del Encargado</label>
                                        <input type="tel" class="form-control" id="nc_telefono" placeholder="10 dígitos" maxlength="10">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Condiciones</label>
                                        <input type="text" class="form-control" id="nc_condiciones" placeholder="Ej: Césped natural">
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-secondary me-2" onclick="cancelarNuevaCancha()">
                                        <i class="fas fa-times"></i> Cancelar
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick="agregarNuevaCancha()">
                                        <i class="fas fa-save"></i> Guardar Cancha
                                    </button>
                                </div>
                            </div>

                            {{-- Info cancha seleccionada --}}
                            <div id="infoCancha" style="display:none;">
                                <div class="row mt-3">
                                    <div class="col-md-3"><strong>Dirección:</strong><p id="direccionCancha" class="mb-1">—</p></div>
                                    <div class="col-md-3"><strong>Capacidad:</strong><p id="capacidadCancha" class="mb-1">—</p></div>
                                    <div class="col-md-3"><strong>Condiciones:</strong><p id="condicionesCancha" class="mb-1">—</p></div>
                                    <div class="col-md-3"><strong>Teléfono Encargado:</strong><p id="telefonoCancha" class="mb-1">—</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Árbitro --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 style="color: var(--dorado);"><i class="fas fa-whistle"></i> Asignación de Árbitro</h5>
                        <div class="arbitro-card">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="arbitroPrincipal" class="form-label">Árbitro Principal *</label>
                                    <select class="form-select" id="arbitroPrincipal" name="id_arbitro" required>
                                        <option value="">Seleccionar árbitro principal</option>
                                        @foreach ($arbitros as $a)
                                            <option value="{{ $a->id_arbitro }}">{{ $a->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="arbitroDisponibilidad" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="reset" class="btn btn-secondary me-2">
                        <i class="fas fa-undo"></i> Limpiar Formulario
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-plus"></i> Programar Partido
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const RUTA_CANCHA_SHOW = @json(route('partidos.cancha.show', ['id'=>'__ID__']));
    const RUTA_CANCHA_FAST = @json(route('partidos.cancha.fast'));
    const RUTA_ARB_LIBRES  = @json(route('partidos.arbitros.disponibles'));
    const CSRF = @json(csrf_token());

    document.getElementById('cancha').addEventListener('change', async function(){
        const id = this.value;
        const infoDiv = document.getElementById('infoCancha');
        if(!id){ infoDiv.style.display='none'; return; }
        const url = RUTA_CANCHA_SHOW.replace('__ID__', id);
        const res = await fetch(url);
        if(!res.ok){ infoDiv.style.display='none'; return; }
        const j = await res.json();
        if(!j.ok){ infoDiv.style.display='none'; return; }
        document.getElementById('direccionCancha').textContent  = j.data.direccion ?? '';
        document.getElementById('capacidadCancha').textContent  = j.data.capacidad ?? '';
        document.getElementById('condicionesCancha').textContent= j.data.condiciones ?? '';
        document.getElementById('telefonoCancha').textContent   = j.data.telefono ?? '';
        infoDiv.style.display='block';
    });

    function mostrarFormularioNuevaCancha(){
        document.getElementById('formNuevaCancha').style.display='block';
        document.getElementById('cancha').disabled = true;
    }
    function cancelarNuevaCancha(){
        document.getElementById('formNuevaCancha').style.display='none';
        document.getElementById('cancha').disabled = false;
        ['nc_nombre','nc_localidad','nc_direccion','nc_capacidad','nc_telefono','nc_condiciones']
            .forEach(id=>document.getElementById(id).value='');
    }

    async function agregarNuevaCancha(){
        const payload = {
            nombre:     document.getElementById('nc_nombre').value.trim(),
            localidad:  document.getElementById('nc_localidad').value,
            direccion:  document.getElementById('nc_direccion').value.trim(),
            capacidad:  document.getElementById('nc_capacidad').value,
            telefono:   document.getElementById('nc_telefono').value,
            condiciones:document.getElementById('nc_condiciones').value.trim(),
            _token: CSRF
        };
        if(!payload.nombre || !payload.localidad || !payload.direccion){
            alert('Completa Nombre, Localidad y Dirección'); return;
        }
        const res = await fetch(RUTA_CANCHA_FAST, {
            method:'POST',
            headers:{'Accept':'application/json','Content-Type':'application/json'},
            body: JSON.stringify(payload)
        });
        const j = await res.json();
        if(!j.ok){ alert(j.message ?? 'No se pudo crear la cancha'); return; }

        const sel = document.getElementById('cancha');
        const opt = document.createElement('option');
        opt.value = j.cancha.id; opt.textContent = j.cancha.text; opt.selected = true;
        sel.insertBefore(opt, sel.options[1] || null);
        cancelarNuevaCancha();
        sel.dispatchEvent(new Event('change'));
    }

    async function verificarDisponibilidadArbitroUI(){
        const fecha = document.getElementById('fechaPartido').value;
        const hora  = document.getElementById('horaPartido').value;
        const div   = document.getElementById('arbitroDisponibilidad');

        div.innerHTML = '';
        if(!fecha || !hora) return;

        const url = new URL(RUTA_ARB_LIBRES, window.location.origin);
        url.searchParams.set('fecha', fecha);
        url.searchParams.set('hora',  hora);

        try{
            const res = await fetch(url);
            const j = await res.json();
            if(!j.ok) return;

            const sel = document.getElementById('arbitroPrincipal');
            const actual = sel.value;
            const idsLibres = j.arbitros.map(a=>String(a.id));
            if(actual && !idsLibres.includes(actual)){
                div.innerHTML = `<div class="alert-warning"><i class="fas fa-exclamation-triangle"></i>
          <strong>Conflicto:</strong> el árbitro seleccionado tiene un partido +/- 2h ese día.</div>`;
            }else{
                div.innerHTML = `<div class="alert alert-success"><i class="fas fa-check-circle"></i>
          Árbitro disponible para este horario.</div>`;
            }
        }catch(e){ }
    }
    ['fechaPartido','horaPartido','arbitroPrincipal'].forEach(id=>{
        document.getElementById(id).addEventListener('change', verificarDisponibilidadArbitroUI);
    });

    document.getElementById('formProgramarPartido').addEventListener('submit', function(e){
        const req = ['torneo','jornada','fechaPartido','horaPartido','equipoLocal','equipoVisitante','cancha','arbitroPrincipal'];
        for(const id of req){
            const el = document.getElementById(id);
            if(!el || !String(el.value).trim()){ e.preventDefault(); alert('Completa todos los campos obligatorios'); return; }
        }
        const local = document.getElementById('equipoLocal').value;
        const visit = document.getElementById('equipoVisitante').value;
        if(local === visit){ e.preventDefault(); alert('El equipo local y visitante no pueden ser el mismo'); return; }
    });

    document.getElementById('fechaPartido').min = new Date().toISOString().split('T')[0];
</script>
</body>
</html>
