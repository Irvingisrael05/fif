<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Equipos - FIF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root{
            --verde-principal:#2ecc71;
            --verde-oscuro:#145a32;
            --dorado:#f1c40f;
            --gris-oscuro:#1e272e;
            --blanco:#fff;
        }

        body{
            background:
                linear-gradient(rgba(20,90,50,.85),rgba(20,90,50,.85)),
                url('https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=1920&q=80') center/cover fixed;
            color:var(--blanco);
            font-family:'Poppins',sans-serif;
            min-height:100vh;
            padding:20px;
        }

        .container{max-width:1200px;margin:0 auto;}
        .header{text-align:center;margin-bottom:40px;padding:25px;background:rgba(30,39,46,.95);
            border-radius:20px;border:3px solid var(--dorado);box-shadow:0 10px 30px rgba(0,0,0,.3);}
        .header h1{color:var(--dorado);font-weight:800;text-transform:uppercase;margin-bottom:10px;font-size:2.3rem;}
        .header p{color:var(--verde-principal);font-weight:600;font-size:1.1rem;}
        .btn-secondary{
            background:linear-gradient(45deg,#7f8c8d,#95a5a6);
            border:none;border-radius:25px;padding:10px 25px;
            color:#fff;font-weight:600;text-decoration:none;
            display:inline-flex;align-items:center;gap:8px;
        }
        .btn-secondary:hover{color:#fff;transform:translateY(-2px);}
        .btn-primary{
            background:linear-gradient(45deg,var(--dorado),var(--verde-principal));
            border:none;border-radius:25px;padding:12px 28px;
            color:#1e272e;font-weight:700;
        }
        .btn-primary:hover{background:linear-gradient(45deg,var(--verde-principal),var(--dorado));}
        .btn-warning{background:linear-gradient(45deg,#f39c12,#e67e22);border:none;}
        .btn-danger{background:linear-gradient(45deg,#e74c3c,#c0392b);border:none;}

        .form-label{color:var(--dorado);font-weight:600;}
        .form-control{background:rgba(255,255,255,.08);border:1px solid var(--dorado);color:#fff;border-radius:10px;}
        .form-control:focus{border-color:var(--verde-principal);box-shadow:0 0 0 .2rem rgba(46,204,113,.25);}

        .card{
            background:linear-gradient(145deg,rgba(30,39,46,.95) 0%,rgba(20,90,50,.7) 100%);
            border:2px solid var(--dorado);
            border-radius:15px;
            padding:30px;
            margin-bottom:30px;
            box-shadow:0 8px 25px rgba(0,0,0,.2);
        }
        .card-header{background:transparent;border-bottom:2px solid var(--dorado);}
        .card-title{color:var(--dorado);font-weight:700;}

        .table-dark{background:rgba(30,39,46,.9);border:1px solid var(--dorado);border-radius:10px;}
        .table-dark th{background:var(--verde-oscuro);color:var(--dorado);}
        .table-dark td{border-color:rgba(46,204,113,.3);vertical-align:middle;padding:12px;}
        .estado-activo{color:var(--verde-principal);font-weight:700;}
        .estado-inactivo{color:#e74c3c;font-weight:700;}
        .chip{background:rgba(241,196,15,.15);border:1px solid rgba(241,196,15,.6);border-radius:999px;padding:5px 10px;}

        .action-buttons{display:flex;gap:8px;}
        .equipo-info{background:rgba(46,204,113,.1);border:1px solid rgba(46,204,113,.3);border-radius:10px;padding:15px;}

        /* === SELECT personalizado (verde-dorado) === */
        .fancy-select {
            background: rgba(255,255,255,0.08);
            color: var(--blanco);
            border: 1px solid var(--dorado);
            border-radius: 12px;
            padding: 12px 14px;
            font-weight: 600;
            outline: none;
            transition: box-shadow .2s, border-color .2s, background .2s;
            appearance: none;
        }
        .fancy-select:focus {
            background: rgba(255,255,255,0.12);
            border-color: var(--verde-principal);
            box-shadow: 0 0 0 .2rem rgba(46,204,113,.25);
        }
        .fancy-select option {
            background: #13251c;
            color: #ffffff;
        }
        .fancy-select option:hover,
        .fancy-select option:focus,
        .fancy-select option:checked {
            background: #145a32 !important;
            color: #f1c40f !important;
        }
        .fancy-select option[disabled] {
            color: #a5c9b3;
        }
    </style>
</head>

<body>
<div class="container">
    <a href="/menu_cordinador" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i> Volver al menú</a>

    <div class="header">
        <h1><i class="fas fa-users"></i> Gestionar Equipos</h1>
        <p>Administra los equipos registrados en el sistema FIF</p>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title" id="formTitle"><i class="fas fa-plus-circle"></i> Registrar Nuevo Equipo</h3>
        </div>
        <div class="card-body">
            <form id="formEquipo">
                @csrf
                <input type="hidden" id="equipoId">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre del Equipo *</label>
                        <input type="text" id="nombre" class="form-control" placeholder="Ej: Tigres del Valle" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Año de Fundación *</label>
                        <input type="number" id="anio" class="form-control" min="1900" max="2100" placeholder="Ej: 2015" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Localidad *</label>
                        <select id="localidad" class="form-select fancy-select" required>
                            <option value="">Seleccionar localidad</option>
                            @foreach ($localidades as $loc)
                                <option value="{{ $loc->id_localidad }}">{{ $loc->comunidad }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Colores de Equipación *</label>
                        <input type="text" id="colores" class="form-control" placeholder="Ej: Amarillo y azul" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">URL del Logo *</label>
                        <input type="url" id="logoUrl" class="form-control" placeholder="https://ejemplo.com/logo_equipo.jpg" required>
                    </div>
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" id="estado" checked>
                    <label class="form-check-label" for="estado"><span id="estadoTxt" class="estado-activo">Activo</span></label>
                </div>

                <div class="text-end">
                    <button type="button" id="btnCancelar" class="btn btn-secondary me-2"><i class="fas fa-times"></i> Cancelar</button>
                    <button type="submit" id="btnSubmit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar Equipo</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-list"></i> Equipos Registrados</h3></div>
        <div class="card-body">
            <table class="table table-dark table-hover">
                <thead>
                <tr>
                    <th>Equipo</th>
                    <th>Localidad</th>
                    <th>Año</th>
                    <th>Colores</th>
                    <th>Logo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody id="tbodyEquipos"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal eliminar -->
<div class="modal fade" id="modalDel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background:rgba(30,39,46,.95);color:#fff;border:2px solid var(--dorado);">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-trash"></i> Eliminar equipo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                ¿Seguro que deseas eliminar <strong id="delNombre"></strong>?
                <div class="text-warning mt-2"><i class="fas fa-exclamation-triangle"></i> Esta acción no se puede deshacer.</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-danger" id="btnDelConfirm"><i class="fas fa-trash"></i> Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (() => {
        const EQUIPOS = @json($equipos);
        const CSRF = @json(csrf_token());
        const R_STORE = @json(route('equipos.store'));
        const R_UPDATE = @json(route('equipos.update', ['id' => '__ID__']));
        const R_DESTROY = @json(route('equipos.destroy', ['id' => '__ID__']));

        const tbody = document.getElementById('tbodyEquipos');
        const form = document.getElementById('formEquipo');
        const elId = document.getElementById('equipoId');
        const elNom = document.getElementById('nombre');
        const elAnio = document.getElementById('anio');
        const elLoc = document.getElementById('localidad');
        const elCols = document.getElementById('colores');
        const elLogo = document.getElementById('logoUrl');
        const elEst = document.getElementById('estado');
        const elEstTxt = document.getElementById('estadoTxt');
        const btnSubmit = document.getElementById('btnSubmit');
        const btnCancelar = document.getElementById('btnCancelar');
        const formTitle = document.getElementById('formTitle');

        const delModal = new bootstrap.Modal(document.getElementById('modalDel'));
        const delName = document.getElementById('delNombre');
        const btnDelConfirm = document.getElementById('btnDelConfirm');
        let pendingDeleteId = null;

        elEst.addEventListener('change', () => {
            elEstTxt.textContent = elEst.checked ? 'Activo' : 'Inactivo';
            elEstTxt.className = elEst.checked ? 'estado-activo' : 'estado-inactivo';
        });

        function renderTabla() {
            tbody.innerHTML = '';
            EQUIPOS.forEach(e => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                <td><strong>${e.nombre}</strong></td>
                <td>${e.nombre_localidad ?? '—'}</td>
                <td>${e.anio_fundacion ?? '—'}</td>
                <td><span class="chip">${e.colores_de_equipacion ?? '—'}</span></td>
                <td>${e.url_logo ? `<a href="${e.url_logo}" target="_blank">Ver logo</a>` : '—'}</td>
                <td><span class="${(e.estado||'Activo')==='Activo'?'estado-activo':'estado-inactivo'}">${e.estado||'Activo'}</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-warning btn-sm" onclick="editarEquipo(${e.id_equipo})"><i class="fas fa-pen"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="confirmarEliminar(${e.id_equipo})"><i class="fas fa-trash"></i></button>
                    </div>
                </td>`;
                tbody.appendChild(tr);
            });
        }
        renderTabla();

        window.editarEquipo = id => {
            const e = EQUIPOS.find(x => x.id_equipo === id);
            if (!e) return;
            elId.value = e.id_equipo;
            elNom.value = e.nombre;
            elAnio.value = e.anio_fundacion;
            elLoc.value = e.localidad;
            elCols.value = e.colores_de_equipacion;
            elLogo.value = e.url_logo;
            elEst.checked = (e.estado || 'Activo') === 'Activo';
            elEst.dispatchEvent(new Event('change'));
            formTitle.innerHTML = `<i class="fas fa-edit"></i> Editar Equipo`;
            btnSubmit.innerHTML = `<i class="fas fa-save"></i> Actualizar`;
        };

        window.confirmarEliminar = id => {
            const e = EQUIPOS.find(x => x.id_equipo === id);
            if (!e) return;
            pendingDeleteId = id;
            delName.textContent = e.nombre;
            delModal.show();
        };

        btnDelConfirm.addEventListener('click', async () => {
            if (!pendingDeleteId) return;
            const url = R_DESTROY.replace('__ID__', pendingDeleteId);
            const res = await fetch(url, {method:'DELETE', headers:{'X-CSRF-TOKEN':CSRF}});
            const j = await res.json();
            if (j.ok) {
                const ix = EQUIPOS.findIndex(x=>x.id_equipo===pendingDeleteId);
                if (ix>-1) EQUIPOS.splice(ix,1);
                renderTabla();
                delModal.hide();
            } else alert('Error eliminando equipo');
            pendingDeleteId = null;
        });

        form.addEventListener('submit', async e => {
            e.preventDefault();
            const isEdit = !!elId.value;
            const url = isEdit ? R_UPDATE.replace('__ID__', elId.value) : R_STORE;
            const method = isEdit ? 'PUT' : 'POST';
            const payload = {
                nombre: elNom.value.trim(),
                localidad: parseInt(elLoc.value),
                anio_fundacion: parseInt(elAnio.value),
                colores_de_equipacion: elCols.value.trim(),
                logo_url: elLogo.value.trim(),
                estado: elEst.checked ? 'Activo' : 'Inactivo'
            };
            const res = await fetch(url,{
                method,
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
                body:JSON.stringify(payload)
            });
            const j = await res.json();
            if(j.ok){
                if(isEdit){
                    const ix = EQUIPOS.findIndex(x=>x.id_equipo===j.equipo.id_equipo);
                    if(ix>-1) EQUIPOS[ix]=j.equipo;
                } else EQUIPOS.push(j.equipo);
                renderTabla();
                form.reset();
                elId.value='';
                elEst.checked=true; elEstTxt.textContent='Activo';
            }else alert('Error al guardar');
        });

        btnCancelar.addEventListener('click',()=>{
            form.reset(); elId.value=''; elEst.checked=true; elEstTxt.textContent='Activo';
            formTitle.innerHTML=`<i class="fas fa-plus-circle"></i> Registrar Nuevo Equipo`;
            btnSubmit.innerHTML=`<i class="fas fa-save"></i> Registrar Equipo`;
        });
    })();
</script>
</body>
</html>
