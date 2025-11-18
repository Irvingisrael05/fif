<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - FIF Torneos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root{
            --verde-principal:#2ecc71;--verde-oscuro:#145a32;--dorado:#f1c40f;--gris-oscuro:#1e272e;--blanco:#ffffff;
        }
        body{
            background:linear-gradient(rgba(20,90,50,.85),rgba(20,90,50,.85)),url('{{ asset('img/campo-futbol.jpg') }}') center/cover no-repeat fixed;
            color:var(--blanco);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:40px 10px;font-family:'Poppins',sans-serif;
        }
        .card{background:rgba(30,39,46,.95);border:2px solid var(--verde-principal);border-radius:15px;padding:2rem;max-width:650px;width:100%;box-shadow:0 0 20px rgba(46,204,113,.3);backdrop-filter:blur(10px)}
        h2{color:var(--dorado);text-align:center;font-weight:700;text-transform:uppercase;border-bottom:2px solid var(--verde-principal);padding-bottom:10px;margin-bottom:25px}
        .form-label{color:var(--verde-principal);font-weight:600}
        .form-control,.form-select{background:rgba(255,255,255,.08);border:1px solid var(--verde-principal);color:var(--blanco);border-radius:10px;transition:all .3s ease}
        .form-control:focus,.form-select:focus{background:rgba(255,255,255,.15);border-color:var(--dorado);box-shadow:0 0 10px rgba(241,196,15,.4)}
        .form-select option{background:var(--gris-oscuro);color:var(--blanco)}
        .btn-primary{background:linear-gradient(45deg,var(--verde-principal),var(--verde-oscuro));border:none;border-radius:30px;padding:10px 30px;font-weight:bold;color:var(--blanco);transition:all .3s ease}
        .btn-primary:hover:not(:disabled){background:linear-gradient(45deg,var(--dorado),var(--verde-principal));transform:translateY(-2px);box-shadow:0 5px 15px rgba(241,196,15,.4)}
        .btn-primary:disabled{background:#6c757d;cursor:not-allowed;transform:none;box-shadow:none;opacity:.6}
        .btn-secondary{background:rgba(255,255,255,.1);border:1px solid var(--verde-principal);border-radius:30px;color:var(--blanco);font-weight:500;transition:all .3s ease}
        .btn-secondary:hover{background:var(--verde-principal);color:var(--gris-oscuro);transform:scale(1.03)}
        .card:hover{transform:translateY(-5px);transition:transform .3s ease}
        #arbitroFields,#jugadorFields,#coordinadorFields{display:none}
        .alert-access{background:rgba(46,204,113,.2);border:1px solid var(--verde-principal);border-radius:10px;padding:15px;margin-bottom:20px}
        .access-granted{background:rgba(46,204,113,.3);border-color:var(--verde-principal);color:var(--blanco)}
        .access-denied{background:rgba(231,76,60,.3);border-color:#e74c3c;color:var(--blanco)}
        .password-match{color:var(--verde-principal);font-size:.875rem;margin-top:5px}
        .password-mismatch{color:#e74c3c;font-size:.875rem;margin-top:5px}
        .field-error{border-color:#e74c3c!important;box-shadow:0 0 5px rgba(231,76,60,.5)!important}
        .field-valid{border-color:var(--verde-principal)!important;box-shadow:0 0 5px rgba(46,204,113,.5)!important}
        .text-uppercase{text-transform:uppercase}
        .estado-arbitro{background:rgba(46,204,113,.1)!important;border:1px dashed var(--verde-principal)!important;color:var(--dorado)!important;font-weight:bold}
    </style>
</head>
<body>

<div class="card shadow">
    <h2>Crear Cuenta</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('registro.store') }}" method="POST" id="registroForm" novalidate>
        @csrf

        <!-- Datos personales -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Nombre *</label>
                <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Apellido Paterno *</label>
                <input type="text" class="form-control" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Apellido Materno *</label>
                <input type="text" class="form-control" name="apellido_materno" value="{{ old('apellido_materno') }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Fecha de Nacimiento *</label>
                <input type="date" class="form-control" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">CURP *</label>
                <input type="text" class="form-control text-uppercase" id="curp" name="curp" maxlength="18" pattern="[A-Z0-9]{18}" value="{{ old('curp') }}" required>
                <div class="form-text text-warning">En mayúsculas (18 caracteres)</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Correo Electrónico *</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Teléfono *</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="10 dígitos" pattern="[0-9]{10}" maxlength="10" value="{{ old('telefono') }}" required>
                <div class="form-text text-warning">Solo números, 10 dígitos</div>
            </div>
        </div>

        <!-- Localidad: SELECT desde BD -->
        <div class="mb-3">
            <label class="form-label">Localidad *</label>
            <select class="form-select" id="localidad_id" name="localidad_id" required>
                <option value="">-- Selecciona tu localidad --</option>
                @foreach($localidades as $loc)
                    <option value="{{ $loc->id_localidad }}" {{ old('localidad_id')==$loc->id_localidad?'selected':'' }}>
                        {{ strtoupper($loc->comunidad) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tipo de usuario -->
        <div class="mb-3">
            <label class="form-label">Tipo de Usuario *</label>
            <select class="form-select" id="tipo_usuario" name="tipo_usuario" required>
                <option value="" disabled {{ old('tipo_usuario')? '' : 'selected' }}>-- SELECCIONA TU TIPO DE USUARIO --</option>
                <option value="jugador"     @selected(old('tipo_usuario')=='jugador')>⚽ Jugador</option>
                <option value="arbitro"     @selected(old('tipo_usuario')=='arbitro')>📣 Árbitro</option>
                <option value="coordinador" @selected(old('tipo_usuario')=='coordinador')>📋 Coordinador</option>
            </select>
        </div>

        <!-- Campos: Árbitro -->
        <div id="arbitroFields" style="{{ old('tipo_usuario')=='arbitro' ? '' : 'display:none' }}">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Licencia *</label>
                    <input type="text" class="form-control" id="licencia" name="licencia" value="{{ old('licencia') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Años de Experiencia *</label>
                    <input type="number" class="form-control" id="anios_experiencia" name="anios_experiencia" min="0" max="50" value="{{ old('anios_experiencia') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Vigencia de Licencia *</label>
                    <input type="date" class="form-control" id="vigencia_licencia" name="vigencia_licencia" value="{{ old('vigencia_licencia') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Estado *</label>
                    <input type="text" class="form-control estado-arbitro" id="estado_arbitro" placeholder="Se calculará automáticamente" readonly>
                    <div class="form-text text-info">Se calcula automáticamente según vigencia</div>
                </div>
            </div>
        </div>

        <!-- Campos: Jugador (sin equipo) -->
        <div id="jugadorFields" style="{{ old('tipo_usuario')=='jugador' ? '' : 'display:none' }}">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dorsal *</label>
                    <input type="number" class="form-control" id="dorsal" name="dorsal" min="1" max="99" value="{{ old('dorsal') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Posición *</label>
                    <select class="form-select" id="posicion" name="posicion">
                        <option value="" disabled {{ old('posicion') ? '' : 'selected' }}>-- Selecciona posición --</option>
                        @foreach(['Delantero','Mediocampista','Defensa','Portero'] as $pos)
                            <option value="{{ $pos }}" @selected(old('posicion')==$pos)>{{ $pos }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- (intencional) SIN select de equipo -->
        </div>

        <!-- Campos: Coordinador -->
        <div id="coordinadorFields" style="{{ old('tipo_usuario')=='coordinador' ? '' : 'display:none' }}">
            <div class="alert-access" id="accessAlert">
                <div class="text-center mb-3">
                    <i class="fas fa-shield-alt fa-2x text-warning"></i>
                    <h5 class="mt-2">Acceso de Coordinador</h5>
                    <p class="mb-3">Necesitas un código de administrador</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">Código de Administrador *</label>
                    <input type="password" class="form-control" id="codigo_admin" name="codigo_admin" value="{{ old('codigo_admin') }}">
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-warning" id="btnVerificarCodigo">
                        <i class="fas fa-key"></i> Verificar Código
                    </button>
                </div>
                <div id="resultadoVerificacion" class="mt-3 text-center"></div>
            </div>
        </div>

        <!-- Password -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Contraseña *</label>
                <input type="password" class="form-control" id="password" name="password" minlength="6" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Confirmar Contraseña *</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                <div id="passwordMatchMessage" class="password-mismatch">Las contraseñas no coinciden</div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ url('/') }}" class="btn btn-secondary">Volver al inicio</a>
            <button type="submit" class="btn btn-primary" id="btnRegistrarse" disabled>
                <i class="fas fa-user-plus"></i> Registrarse
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoUsuario = document.getElementById('tipo_usuario');
        const arbitroFields = document.getElementById('arbitroFields');
        const jugadorFields = document.getElementById('jugadorFields');
        const coordinadorFields = document.getElementById('coordinadorFields');
        const btnRegistrarse = document.getElementById('btnRegistrarse');

        const curpInput = document.getElementById('curp');
        const telefonoInput = document.getElementById('telefono');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const passwordMatchMessage = document.getElementById('passwordMatchMessage');

        const vigenciaLicenciaInput = document.getElementById('vigencia_licencia');
        const estadoArbitroInput   = document.getElementById('estado_arbitro');

        const btnVerificarCodigo  = document.getElementById('btnVerificarCodigo');
        const resultadoVerificacion = document.getElementById('resultadoVerificacion');
        const accessAlert = document.getElementById('accessAlert');
        const codigosValidos = ['fif2004','fif2005'];
        let codigoVerificado = false;

        let passwordsMatch = false, curpValido = false, telefonoValido = false;

        function toUpper(i){ i.value = i.value.toUpperCase(); }
        function validarCURP(){
            const ok = /^[A-Z0-9]{18}$/.test(curpInput.value.trim());
            curpValido = ok;
            curpInput.classList.toggle('field-valid', ok);
            curpInput.classList.toggle('field-error', !ok && curpInput.value!=='');
            actualizarBoton();
        }
        function validarTelefono(){
            telefonoInput.value = telefonoInput.value.replace(/[^0-9]/g,'').slice(0,10);
            const ok = /^[0-9]{10}$/.test(telefonoInput.value);
            telefonoValido = ok;
            telefonoInput.classList.toggle('field-valid', ok);
            telefonoInput.classList.toggle('field-error', !ok && telefonoInput.value!=='');
            actualizarBoton();
        }
        function verificarPasswords(){
            const p = passwordInput.value, c = confirmPasswordInput.value;
            passwordsMatch = (p!=='' && p===c);
            passwordMatchMessage.className = passwordsMatch ? 'password-match' : 'password-mismatch';
            passwordMatchMessage.textContent = passwordsMatch ? '✅ Las contraseñas coinciden' : '❌ Las contraseñas no coinciden';
            confirmPasswordInput.classList.toggle('field-valid', passwordsMatch);
            confirmPasswordInput.classList.toggle('field-error', !passwordsMatch && c!=='');
            actualizarBoton();
        }
        function calcularEstadoArbitro(){
            const v = vigenciaLicenciaInput?.value;
            if(!v){ estadoArbitroInput.value=''; actualizarBoton(); return; }
            const hoy = new Date(), fv = new Date(v);
            estadoArbitroInput.value = fv >= hoy ? 'Activo' : 'Inactivo';
            estadoArbitroInput.classList.toggle('field-valid', fv >= hoy);
            estadoArbitroInput.classList.toggle('field-error', fv < hoy);
            actualizarBoton();
        }

        const arbitroNames = ['licencia','anios_experiencia','vigencia_licencia'];
        const jugadorNames = ['dorsal','posicion']; // SIN equipo
        const coordNames   = ['codigo_admin'];

        function setSection(sectionEl, names, visible){
            sectionEl.style.display = visible ? 'block' : 'none';
            names.forEach(n=>{
                const el = document.getElementById(n) || document.querySelector(`[name="${n}"]`);
                if(!el) return;
                if(visible){ el.disabled=false; el.setAttribute('required','required'); }
                else{
                    el.disabled=true; el.removeAttribute('required');
                    el.classList.remove('field-error','field-valid');
                    if(el.tagName==='SELECT') el.selectedIndex=0; else el.value='';
                    try{ el.setCustomValidity(''); }catch(e){}
                }
            });
        }
        function toggleRoleFields(){
            const v = (tipoUsuario.value || '').toLowerCase();
            setSection(arbitroFields,   arbitroNames, v==='arbitro');
            setSection(jugadorFields,   jugadorNames, v==='jugador');
            setSection(coordinadorFields, coordNames, v==='coordinador');
            actualizarBoton();
        }

        function camposLlenos(ids){
            return ids.every(id=>{
                const el = document.getElementById(id) || document.querySelector(`[name="${id}"]`);
                return el && !el.disabled && el.value && el.value.trim()!=='';
            });
        }
        function actualizarBoton(){
            const base = camposLlenos(['nombre','apellido_paterno','apellido_materno','fecha_nacimiento','curp','email','telefono','localidad_id','tipo_usuario','password','confirm_password']);
            let ok = base && passwordsMatch && curpValido && telefonoValido;

            const v = (tipoUsuario.value || '').toLowerCase();
            if(v === 'arbitro'){
                ok = ok && camposLlenos(arbitroNames) && !!(estadoArbitroInput.value||'');
            }else if(v === 'jugador'){
                ok = ok && camposLlenos(jugadorNames);
            }else if(v === 'coordinador'){
                ok = ok && codigoVerificado;
            }
            btnRegistrarse.disabled = !ok;
        }

        btnVerificarCodigo?.addEventListener('click', ()=>{
            const val = (document.getElementById('codigo_admin')?.value||'').trim().toLowerCase();
            if(!val){
                resultadoVerificacion.innerHTML = '<div class="text-danger"><i class="fas fa-times-circle"></i> Ingresa un código</div>';
                codigoVerificado=false; actualizarBoton(); return;
            }
            if(codigosValidos.includes(val)){
                codigoVerificado=true;
                resultadoVerificacion.innerHTML = '<div class="text-success"><i class="fas fa-check-circle"></i> Acceso concedido</div>';
                accessAlert.classList.add('access-granted'); accessAlert.classList.remove('access-denied');
            }else{
                codigoVerificado=false;
                resultadoVerificacion.innerHTML = '<div class="text-danger"><i class="fas fa-times-circle"></i> Código incorrecto</div>';
                accessAlert.classList.add('access-denied'); accessAlert.classList.remove('access-granted');
            }
            actualizarBoton();
        });

        tipoUsuario.addEventListener('change', toggleRoleFields);
        curpInput.addEventListener('input', ()=>{ toUpper(curpInput); validarCURP(); });
        telefonoInput.addEventListener('input', validarTelefono);
        passwordInput.addEventListener('input', verificarPasswords);
        confirmPasswordInput.addEventListener('input', verificarPasswords);
        vigenciaLicenciaInput?.addEventListener('input', calcularEstadoArbitro);
        vigenciaLicenciaInput?.addEventListener('change', calcularEstadoArbitro);

        // Init
        toggleRoleFields(); validarCURP(); validarTelefono(); verificarPasswords(); calcularEstadoArbitro();
    });
</script>
</body>
</html>
