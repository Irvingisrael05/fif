<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Posiciones - Árbitro FIF</title>
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
            background: linear-gradient(135deg, var(--verde-oscuro) 0%, var(--gris-oscuro) 100%);
            color: var(--blanco);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            padding: 20px;
        }

        .container-custom {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(30, 39, 46, 0.95);
            border-radius: 20px;
            border: 3px solid var(--dorado);
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--verde-principal);
        }

        .header h1 {
            color: var(--dorado);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .btn-back {
            background: transparent;
            border: 2px solid #e74c3c;
            color: #e74c3c;
            border-radius: 25px;
            padding: 10px 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .btn-back:hover {
            background: #e74c3c;
            color: white;
        }

        .table-custom {
            background: rgba(30, 39, 46, 0.8);
            color: var(--blanco);
            border-radius: 15px;
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
        }
    </style>
</head>
<body>
<div class="container-custom">
    <!-- Botón Volver -->
    <a href="/menu_arbitro" class="btn-back">
        <i class="fas fa-arrow-left"></i> Volver al Menu
    </a>

    <!-- Header -->
    <div class="header">
        <h1><i class="fas fa-table"></i> Tabla de Posiciones</h1>
        <p class="text-muted">Clasificación actual - Torneo Verano 2025</p>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
            <tr>
                <th>Pos</th>
                <th>Equipo</th>
                <th>PJ</th>
                <th>GF</th>
                <th>GC</th>
                <th>DG</th>
                <th>Pts</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tabla as $row)
                <tr>
                    <td>{{ $row->torneo }}</td>
                    <td>{{ $row->equipo }}</td>
                    <td>{{ $row->partidos_jugados }}</td>
                    <td>{{ $row->goles_favor }}</td>
                    <td>{{ $row->goles_contra }}</td>
                    <td>{{ $row->diferencia_goles }}</td>
                    <td><strong>{{ $row->puntos }}</strong></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
