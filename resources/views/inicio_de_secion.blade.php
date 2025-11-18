<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - FIF Torneos</title>
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
                center/cover no-repeat fixed;
            color: var(--blanco);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            background: rgba(30, 39, 46, 0.95);
            border: 2px solid var(--verde-principal);
            border-radius: 15px;
            padding: 2rem;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 0 20px rgba(46, 204, 113, 0.3);
            backdrop-filter: blur(10px);
        }
        h2 {
            color: var(--dorado);
            text-align: center;
            font-weight: 700;
            text-transform: uppercase;
            border-bottom: 2px solid var(--verde-principal);
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .form-label { color: var(--verde-principal); font-weight: 600; }
        .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--verde-principal);
            color: var(--blanco);
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--dorado);
            box-shadow: 0 0 10px rgba(241, 196, 15, 0.4);
        }
        .btn-primary {
            background: linear-gradient(45deg, var(--verde-principal), var(--verde-oscuro));
            border: none;
            border-radius: 30px;
            padding: 10px 30px;
            font-weight: bold;
            color: var(--blanco);
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, var(--dorado), var(--verde-principal));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(241, 196, 15, 0.4);
        }
        .btn-secondary {
            background: rgba(255,255,255,0.1);
            border: 1px solid var(--verde-principal);
            border-radius: 30px;
            color: var(--blanco);
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-secondary:hover {
            background: var(--verde-principal);
            color: var(--gris-oscuro);
            transform: scale(1.03);
        }
        .card:hover { transform: translateY(-5px); transition: transform 0.3s ease; }
        .icono { color: var(--dorado); margin-right: 8px; }
    </style>
</head>
<body>

<div class="card shadow">
    <h2><i class="fa-solid fa-futbol icono"></i>Iniciar Sesión</h2>

    {{-- Mensajes de estado --}}
    @if (session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- IMPORTANTE: usar la ruta POST correcta y los names que espera el AuthController --}}
    <form action="{{ route('login.attempt') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo"
                   value="{{ old('correo') }}" placeholder="ejemplo@correo.com" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Ingresa tu contraseña" required>
        </div>

        <button type="submit" class="btn btn-primary">Entrar</button>

        <div class="text-center mt-3">
            <a href="{{ route('registro.form') }}" class="btn btn-secondary">Registrar</a>
        </div>

        <div class="text-center mt-2">
            <a href="{{ route('home') }}" class="btn btn-secondary">Volver al inicio</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
