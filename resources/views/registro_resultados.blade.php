<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Resultados - Árbitro FIF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root{
            --verde-principal:#2ecc71;
            --verde-oscuro:#145a32;
            --dorado:#f1c40f;
            --gris-oscuro:#1e272e;
            --blanco:#ffffff;
        }
        body{
            background:linear-gradient(135deg,var(--verde-oscuro) 0%,var(--gris-oscuro) 100%);
            color:var(--blanco);
            font-family:'Poppins',sans-serif;
            min-height:100vh;
            padding:20px;
        }
        .form-container{
            max-width:800px;
            margin:0 auto;
            background:rgba(30,39,46,.95);
            border-radius:20px;
            border:3px solid var(--dorado);
            padding:30px;
            box-shadow:0 15px 35px rgba(0,0,0,.3)
        }
        .header{
            text-align:center;
            margin-bottom:30px;
            padding-bottom:20px;
            border-bottom:2px solid var(--verde-principal)
        }
        .header h1{
            color:var(--dorado);
            font-weight:700;
            margin-bottom:10px
        }
        .match-info{
            background:rgba(46,204,113,.1);
            border-radius:15px;
            padding:20px;
            margin-bottom:25px;
            border-left:4px solid var(--dorado)
        }
        .team-section{
            background:rgba(255,255,255,.05);
            border-radius:15px;
            padding:25px;
            margin-bottom:20px;
            border:1px solid rgba(255,255,255,.1)
        }
        .form-label{
            color:var(--verde-principal);
            font-weight:600;
            margin-bottom:8px
        }
        .form-control,.form-select{
            background:rgba(255,255,255,.08);
            border:1px solid var(--verde-principal);
            color:var(--blanco);
            border-radius:10px;
            padding:12px 15px;
            transition:.3s
        }
        .form-control:focus,.form-select:focus{
            background:rgba(255,255,255,.15);
            border-color:var(--dorado);
            box-shadow:0 0 10px rgba(241,196,15,.3);
            color:var(--blanco)
        }
        .btn-submit{
            background:linear-gradient(45deg,var(--verde-principal),var(--verde-oscuro));
            border:none;
            border-radius:25px;
            padding:15px 40px;
            color:var(--blanco);
            font-weight:600;
            font-size:1.1rem;
            transition:.3s;
            width:100%;
            margin-top:20px
        }
        .btn-submit:hover:not(:disabled){
            background:linear-gradient(45deg,var(--dorado),var(--verde-principal));
            transform:translateY(-2px);
            box-shadow:0 8px 25px rgba(241,196,15,.4)
        }
        .btn-submit:disabled{
            background:#6c757d;
            cursor:not-allowed;
            transform:none;
            box-shadow:none;
            opacity:.6
        }
        .btn-back{
            background:transparent;
            border:2px solid #e74c3c;
            color:#e74c3c;
            border-radius:25px;
            padding:10px 25px;
            text-decoration:none;
            transition:.3s;
            display:inline-flex;
            align-items:center;
            gap:8px;
            margin-bottom:20px
        }
        .btn-back:hover{
            background:#e74c3c;
            color:#fff
        }
        .score-input{
            font-size:2rem;
            font-weight:bold;
            text-align:center;
            max-width:100px;
            margin:0 auto
        }
        .vs-text{
            color:var(--dorado);
            font-size:1.5rem;
            font-weight:bold;
            text-align:center;
            margin:20px 0
        }
        .points-display{
            background:rgba(241,196,15,.1);
            border-radius:10px;
            padding:15px;
            margin-top:15px;
            text-align:center;
            border:1px dashed var(--dorado)
        }
        .points-value{
            font-size:1.5rem;
            font-weight:bold;
            color:var(--dorado)
        }
        .team-name{
            font-weight:bold;
            margin-bottom:10px
        }
        .alert-result{
            background:rgba(46,204,113,.2);
            border:1px solid var(--verde-principal);
            border-radius:10px;
            padding:15px;
            margin-top:20px;
            text-align:center
        }
        .hidden{display:none}

        /* Fuerza el texto de las opciones a negro */
        select.form-select option {
            color: black !important;
            background-color: white !important;
        }

        /* Cuando se despliega, también forzar estilo */
        select.form-select:focus option {
            color: black !important;
            background-color: white !important;
        }

    </style>
</head>
<body>
<div class="form-container">
    <a href="{{ route('arbitro.menu') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Volver al Menú
    </a>

    <div class="header">
        <h1><i class="fas fa-clipboard-check"></i> Registrar Resultados del Partido</h1>
        <p class="text-muted">Completa la información del partido arbitrado</p>
    </div>

    <form id="resultForm">
        @csrf
        <div class="match-info">
            <h4 class="text-warning mb-3"><i class="fas fa-info-circle"></i> Información del Partido</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Seleccionar Partido</label>
                    <select class="form-select" id="partidoSelect" required>
                        <option value="" selected disabled>-- Seleccione un partido --</option>
                    </select>
                    <div class="form-text text-info">
                        Solo se muestran partidos jugados sin resultados registrados
                    </div>
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

        <div class="team-section">
            <h4 class="text-warning mb-4"><i class="fas fa-futbol"></i> Marcador Final</h4>
            <div class="row align-items-center">
                <div class="col-md-5 text-center">
                    <div class="team-name text-success" id="localTeamName">Equipo Local</div>
                    <input type="number" class="form-control score-input" id="golesLocal" value="0" min="0" max="20" required>
                    <div class="points-display">
                        <div>Puntos:</div><div class="points-value" id="puntosLocal">0</div>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <div class="vs-text">VS</div>
                </div>
                <div class="col-md-5 text-center">
                    <div class="team-name text-warning" id="visitanteTeamName">Equipo Visitante</div>
                    <input type="number" class="form-control score-input" id="golesVisitante" value="0" min="0" max="20" required>
                    <div class="points-display">
                        <div>Puntos:</div><div class="points-value" id="puntosVisitante">0</div>
                    </div>
                </div>
            </div>
        </div>

        <div id="resultAlert" class="alert-result hidden">
            <h5 class="text-warning"><i class="fas fa-trophy"></i> Resumen del Resultado</h5>
            <p id="resultText">El equipo local ganó y recibe 3 puntos</p>
        </div>

        <button type="submit" class="btn-submit" id="submitButton" disabled>
            <i class="fas fa-save"></i> Registrar Resultado
        </button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const partidoSelect      = document.getElementById('partidoSelect');
        const torneoInput        = document.getElementById('torneoInput');
        const fechaInput         = document.getElementById('fechaInput');
        const horaInput          = document.getElementById('horaInput');
        const localTeamName      = document.getElementById('localTeamName');
        const visitanteTeamName  = document.getElementById('visitanteTeamName');
        const golesLocal         = document.getElementById('golesLocal');
        const golesVisitante     = document.getElementById('golesVisitante');
        const puntosLocal        = document.getElementById('puntosLocal');
        const puntosVisitante    = document.getElementById('puntosVisitante');
        const resultAlert        = document.getElementById('resultAlert');
        const resultText         = document.getElementById('resultText');
        const submitButton       = document.getElementById('submitButton');
        const resultForm         = document.getElementById('resultForm');

        function formatearFecha(f){
            const d   = new Date(f);
            const opt = { day:'2-digit', month:'2-digit', year:'numeric' };
            return isNaN(d) ? f : d.toLocaleDateString('es-MX', opt);
        }

        async function cargarPartidos() {
            partidoSelect.innerHTML = '<option value="" selected disabled>-- Seleccione un partido --</option>';
            partidoSelect.disabled = true;

            try{
                const res  = await fetch('{{ route('arbitro.partidos.jugados_sin_resultado') }}');
                const json = await res.json();
                if(!json.ok) throw new Error();

                const data = json.data || [];
                if (data.length === 0) {
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = 'No hay partidos pendientes de registro';
                    partidoSelect.appendChild(opt);
                    return;
                }

                data.forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = p.id;
                    opt.textContent = `${p.local} vs ${p.visitante} - ${formatearFecha(p.fecha)} ${p.hora ?? ''}`;
                    opt.dataset.partido = JSON.stringify(p);
                    partidoSelect.appendChild(opt);
                });

                partidoSelect.disabled = false;
            }catch(e){
                const opt = document.createElement('option');
                opt.value = '';
                opt.textContent = 'Error al cargar partidos';
                partidoSelect.appendChild(opt);
            }
        }

        function resetearFormulario() {
            torneoInput.value       = '';
            fechaInput.value        = '';
            horaInput.value         = '';
            localTeamName.textContent     = 'Equipo Local';
            visitanteTeamName.textContent = 'Equipo Visitante';
            golesLocal.value        = '0';
            golesVisitante.value    = '0';
            puntosLocal.textContent     = '0';
            puntosVisitante.textContent = '0';
            resultAlert.classList.add('hidden');
            submitButton.disabled = true;
        }

        function actualizarInfoPartido() {
            const opt = partidoSelect.options[partidoSelect.selectedIndex];
            if(!opt || !opt.value){
                resetearFormulario();
                return;
            }

            const p = JSON.parse(opt.dataset.partido);
            torneoInput.value        = p.torneo ?? '';
            fechaInput.value         = formatearFecha(p.fecha);
            horaInput.value          = p.hora ?? '';
            localTeamName.textContent     = p.local ?? 'Equipo Local';
            visitanteTeamName.textContent = p.visitante ?? 'Equipo Visitante';

            calcularPuntos();
        }

        function calcularPuntos() {
            const gl = parseInt(golesLocal.value)      || 0;
            const gv = parseInt(golesVisitante.value)  || 0;

            let pl = 0, pv = 0, msg = '';
            if (gl > gv){
                pl = 3; pv = 0;
                msg = `${localTeamName.textContent} ganó y recibe 3 puntos`;
            } else if(gl < gv){
                pl = 0; pv = 3;
                msg = `${visitanteTeamName.textContent} ganó y recibe 3 puntos`;
            } else {
                pl = 1; pv = 1;
                msg = 'Empate - Ambos equipos reciben 1 punto';
            }

            puntosLocal.textContent     = pl;
            puntosVisitante.textContent = pv;
            resultText.textContent      = msg;
            resultAlert.classList.remove('hidden');

            submitButton.disabled = !partidoSelect.value;
        }

        async function enviarFormulario(ev){
            ev.preventDefault();

            const opt = partidoSelect.options[partidoSelect.selectedIndex];
            if(!opt || !opt.value){
                alert('Selecciona un partido.');
                return;
            }

            const p = JSON.parse(opt.dataset.partido);

            const payload = {
                goles_local:       parseInt(golesLocal.value      || '0'),
                goles_visitante:   parseInt(golesVisitante.value  || '0'),
                amarillas_local:   0,
                amarillas_visitante: 0,
                rojas_local:       0,
                rojas_visitante:   0,
                incidentes:        ''
            };

            try{
                const res  = await fetch(`/arbitro/partidos/${p.id}/resultado`, {
                    method:'POST',
                    headers:{
                        'Content-Type':'application/json',
                        'X-CSRF-TOKEN': CSRF
                    },
                    body: JSON.stringify(payload)
                });
                const json = await res.json();
                if(!json.ok){
                    alert(json.message || 'No se pudo guardar');
                    return;
                }

                alert('¡Resultado registrado exitosamente!');
                await cargarPartidos();
                resetearFormulario();
            }catch(e){
                alert('Error de red.');
            }
        }

        partidoSelect.addEventListener('change', actualizarInfoPartido);
        golesLocal.addEventListener('input',   calcularPuntos);
        golesVisitante.addEventListener('input', calcularPuntos);
        resultForm.addEventListener('submit',  enviarFormulario);

        cargarPartidos();
        resetearFormulario();
    });
</script>
</body>
</html>
