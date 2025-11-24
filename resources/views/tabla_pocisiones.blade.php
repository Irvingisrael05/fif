<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de Posiciones - FIF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
                url('https://images.unsplash.com/photo-1598986646512-9330bcc4c0f4?auto=format&fit=crop&w=1920&q=80')
                center/cover no-repeat fixed;
            color: var(--blanco);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            padding: 20px;
        }

        .main-container{
            max-width: 1100px;
            margin: 0 auto;
        }

        /* Tarjeta principal */
        .tabla-card{
            background: rgba(30,39,46,0.95);
            border-radius: 20px;
            border: 2px solid var(--verde-principal);
            padding: 25px 25px 15px;
            box-shadow: 0 15px 30px rgba(0,0,0,.4);
            position: relative;
            overflow: hidden;
        }

        /* Borde amarillo lateral como en tu diseño */
        .tabla-card::before,
        .tabla-card::after{
            content:'';
            position:absolute;
            top:70px;
            bottom:15px;
            width:4px;
            background: var(--dorado);
        }
        .tabla-card::before{ left:25px; }
        .tabla-card::after{ right:25px; }

        .titulo-seccion{
            font-size: 2.1rem;
            font-weight: 700;
            color: var(--blanco);
            display:flex;
            align-items:center;
            gap:10px;
            margin-bottom:20px;
        }

        .titulo-seccion i{
            color: var(--dorado);
            font-size:1.8rem;
        }

        .subrayado{
            height:3px;
            background: var(--verde-principal);
            margin:5px 0 25px;
        }

        .tabla-wrapper{
            margin:0 15px 10px;
        }

        .table-custom{
            background: transparent;
            color: var(--blanco);
            margin-bottom:0;
        }

        .table-custom thead th{
            background: var(--verde-oscuro);
            color: var(--dorado);
            border:none;
            text-align:center;
            padding:14px;
            font-size:0.95rem;
        }

        .table-custom tbody tr{
            background: rgba(0,0,0,0.35);
        }

        .table-custom tbody tr:nth-child(even){
            background: rgba(0,0,0,0.5);
        }

        .table-custom td{
            border-color: rgba(46,204,113,0.25);
            text-align:center;
            padding:10px 8px;
            vertical-align:middle;
            font-size:0.95rem;
        }

        .pos-col{
            font-weight:bold;
            color: var(--dorado);
        }

        .equipo-col{
            text-align:left;
            padding-left:18px;
        }

        .equipo-col .badge-tuyo{
            background: var(--dorado);
            color: var(--gris-oscuro);
            font-size:0.7rem;
            margin-left:4px;
        }

        .pj-col, .gf-col, .gc-col, .dg-col, .pts-col{
            font-weight:600;
        }

        .pts-col{
            font-size:1.1rem;
            color: var(--dorado);
        }

        /* Resaltar top 3 */
        tbody tr:nth-child(1) { background: linear-gradient(90deg, rgba(255,215,0,0.18), rgba(0,0,0,0.6)); }
        tbody tr:nth-child(2) { background: linear-gradient(90deg, rgba(192,192,192,0.18), rgba(0,0,0,0.6)); }
        tbody tr:nth-child(3) { background: linear-gradient(90deg, rgba(205,127,50,0.18), rgba(0,0,0,0.6)); }

        .footer-info{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin:15px 15px 5px;
            gap:10px;
            flex-wrap:wrap;
        }

        .legend{
            font-size:0.8rem;
            color:#bdc3c7;
        }

        .badge-live{
            border-radius:999px;
            padding:8px 20px;
            border:2px solid var(--verde-principal);
            background: rgba(0,0,0,0.4);
            font-weight:600;
            display:inline-flex;
            align-items:center;
            gap:8px;
            font-size:0.9rem;
            color:var(--verde-principal);
        }

        .badge-live i{
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse{
            0%{ transform:scale(1); opacity:1; }
            50%{ transform:scale(1.2); opacity:.4;}
            100%{ transform:scale(1); opacity:1; }
        }
    </style>
</head>
<body>
<div class="main-container mt-3">
    <div class="tabla-card">
        <div class="titulo-seccion">
            <i class="fas fa-table"></i>
            <span>Tabla de Posiciones</span>
        </div>
        <div class="subrayado"></div>

        <div class="tabla-wrapper">
            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                    <tr>
                        <th>Pos</th>
                        <th>Torneo</th>
                        <th>Equipo</th>
                        <th>PJ</th>
                        <th>GF</th>
                        <th>GC</th>
                        <th>DG</th>
                        <th>Pts</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tabla as $index => $row)
                        <tr>
                            <td class="pos-col">{{ $index + 1 }}</td>
                            <td>{{ $row->torneo ?? '-' }}</td>
                            <td class="equipo-col">
                                {{ $row->equipo ?? $row->nombre_equipo ?? 'N/D' }}
                                {{-- Si quieres marcar el equipo del jugador, aquí podrías
                                     comparar con el id_equipo de la sesión y poner la badge --}}
                            </td>
                            <td class="pj-col">{{ $row->partidos_jugados ?? $row->pj ?? 0 }}</td>
                            <td class="gf-col">{{ $row->goles_favor ?? $row->gf ?? 0 }}</td>
                            <td class="gc-col">{{ $row->goles_contra ?? $row->gc ?? 0 }}</td>
                            <td class="dg-col">
                                {{ ($row->goles_favor ?? $row->gf ?? 0) - ($row->goles_contra ?? $row->gc ?? 0) }}
                            </td>
                            <td class="pts-col">{{ $row->puntos ?? $row->pts ?? 0 }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No hay datos de posiciones registrados aún.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="footer-info">
            <div class="legend">
                <strong>Leyenda:</strong> PJ: Partidos jugados, GF: Goles a favor,
                GC: Goles en contra, DG: Diferencia de goles, Pts: Puntos.
            </div>
            <div class="badge-live">
                <i class="fas fa-signal"></i>
                Tabla en tiempo real (se actualiza al registrar resultados)
            </div>
        </div>
    </div>
</div>

</body>
</html>
