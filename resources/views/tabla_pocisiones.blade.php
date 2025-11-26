<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de Posiciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{
            --verde-principal:#2ecc71;
            --verde-oscuro:#145a32;
            --dorado:#f1c40f;
            --gris-oscuro:#1e272e;
            --blanco:#ffffff;
        }
        body{
            background:linear-gradient(rgba(20,90,50,.85),rgba(20,90,50,.85)),
            url('https://images.unsplash.com/photo-1518091043644-c1fdb84f7aa5?auto=format&fit=crop&w=1600&q=80')
            center/cover no-repeat fixed;
            color:var(--blanco);
            font-family:'Poppins',sans-serif;
            min-height:100vh;
            padding:20px;
        }
        .container-main{max-width:1100px;margin:0 auto;}
        .header{
            text-align:center;
            margin-bottom:30px;
            padding:20px;
            background:rgba(30,39,46,.95);
            border-radius:15px;
            border:2px solid var(--dorado);
        }
        .header h1{color:var(--dorado);font-weight:800;text-transform:uppercase;margin-bottom:10px;}
        .header p{color:var(--verde-principal);font-weight:600;}
        .card{
            background:rgba(30,39,46,.95);
            border-radius:15px;
            border:2px solid var(--verde-principal);
            padding:20px;
        }
        .form-select, .form-control{
            background:rgba(0,0,0,.3);
            color:#fff;
            border:1px solid var(--dorado);
        }
        .form-select:focus, .form-control:focus{
            border-color:var(--verde-principal);
            box-shadow:0 0 0 .2rem rgba(46,204,113,.25);
        }
        .table-dark{
            background:rgba(30,39,46,.95);
            border-radius:10px;
            overflow:hidden;
        }
        .table-dark th{
            background:var(--verde-oscuro);
            color:var(--dorado);
            border-color:var(--dorado);
            text-align:center;
        }
        .table-dark td{
            border-color:rgba(46,204,113,.3);
            text-align:center;
            vertical-align:middle;
        }
        .pos-1{background:rgba(241,196,15,.15);}
        .pos-2{background:rgba(189,195,199,.15);}
        .pos-3{background:rgba(205,127,50,.15);}
    </style>
</head>
<body>
<div class="container-main">
    <div class="header">
        <h1>Tabla de Posiciones</h1>
        <p>Consulta la clasificación por torneo</p>
    </div>

    <div class="card mb-3">
        <form method="GET" action="{{ route('posiciones.index') }}" class="row g-3 align-items-end">
            <div class="col-md-8">
                <label class="form-label text-warning">Seleccionar torneo</label>
                <select name="torneo" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Selecciona un torneo --</option>
                    @foreach($torneos as $t)
                        <option
                            value="{{ $t->id_torneo }}"
                            {{ (int)$torneoSeleccionado === (int)$t->id_torneo ? 'selected' : '' }}
                        >
                            {{ $t->nombre }}
                            @if(isset($t->temporada) && $t->temporada)
                                ({{ $t->temporada }})
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 text-end">
                @php
                    $torneoObj = $torneos->firstWhere('id_torneo', (int)$torneoSeleccionado);
                @endphp
                @if($torneoObj)
                    <p class="mb-0">
                        <strong>Torneo seleccionado:</strong><br>
                        {{ $torneoObj->nombre }}
                        @if(isset($torneoObj->temporada) && $torneoObj->temporada)
                            - {{ $torneoObj->temporada }}
                        @endif
                    </p>
                @else
                    <p class="text-muted mb-0">
                        Selecciona un torneo para ver la tabla.
                    </p>
                @endif
            </div>
        </form>
    </div>

    <div class="card">
        @if($clasificacion->isEmpty())
            <p class="text-center text-muted mb-0">
                No hay datos de clasificación para el torneo seleccionado.
            </p>
        @else
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Equipo</th>
                        <th>PJ</th>
                        <th>GF</th>
                        <th>GC</th>
                        <th>DG</th>
                        <th>Puntos</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clasificacion as $idx => $fila)
                        @php
                            $pos = $idx + 1;
                            $rowClass =
                                $pos === 1 ? 'pos-1' :
                                ($pos === 2 ? 'pos-2' :
                                ($pos === 3 ? 'pos-3' : ''));
                        @endphp
                        <tr class="{{ $rowClass }}">
                            <td>{{ $pos }}</td>
                            <td class="text-start">{{ $fila->equipo }}</td>
                            <td>{{ $fila->pj }}</td>
                            <td>{{ $fila->gf }}</td>
                            <td>{{ $fila->gc }}</td>
                            <td>{{ $fila->dg }}</td>
                            <td><strong>{{ $fila->puntos }}</strong></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
</body>
</html>
