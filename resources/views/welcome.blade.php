<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FIF Torneos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
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
                url('https://images.unsplash.com/photo-1556056504-5c7696c4c28d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat fixed;
            color: var(--blanco);
            margin: 0;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .hero-section {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .hero-section h1 {
            font-size: 4rem;
            font-weight: 800;
            color: var(--dorado);
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .hero-section p {
            color: var(--verde-principal);
            font-size: 1.5rem;
            margin-bottom: 30px;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
            font-weight: 600;
        }

        .btn-custom {
            margin: 10px;
            font-size: 1.2rem;
            padding: 15px 35px;
            border-radius: 30px;
            font-weight: 700;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
        }

        .btn-registro {
            background: linear-gradient(45deg, var(--verde-principal), var(--verde-oscuro));
            color: var(--blanco);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }

        .btn-registro:hover {
            background: linear-gradient(45deg, var(--dorado), var(--verde-principal));
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(241, 196, 15, 0.4);
            color: var(--gris-oscuro);
        }

        .btn-login {
            background: rgba(30, 39, 46, 0.9);
            color: var(--dorado);
            border: 2px solid var(--dorado);
            box-shadow: 0 5px 15px rgba(241, 196, 15, 0.2);
        }

        .btn-login:hover {
            background: var(--dorado);
            color: var(--gris-oscuro);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(241, 196, 15, 0.4);
        }

        section {
            padding: 80px 0;
        }

        .section-container {
            background: rgba(30, 39, 46, 0.9);
            border-radius: 20px;
            padding: 50px 30px;
            border: 2px solid var(--verde-principal);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            margin: 20px;
        }

        .section-title {
            color: var(--dorado);
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2.5rem;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
        }

        .section-text {
            color: var(--blanco);
            font-size: 1.2rem;
            line-height: 1.8;
            text-align: center;
            opacity: 0.9;
        }

        .btn-email {
            background: linear-gradient(45deg, var(--dorado), var(--verde-principal));
            color: var(--gris-oscuro);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-email:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(241, 196, 15, 0.4);
            color: var(--gris-oscuro);
        }

        footer {
            background: rgba(30, 39, 46, 0.95);
            color: var(--blanco);
            padding: 30px 0;
            border-top: 2px solid var(--verde-principal);
            text-align: center;
        }

        .footer-text {
            color: var(--verde-principal);
            font-weight: 600;
            margin: 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .feature-card {
            background: rgba(46, 204, 113, 0.1);
            border-radius: 15px;
            padding: 30px 20px;
            text-align: center;
            border: 1px solid rgba(46, 204, 113, 0.3);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(46, 204, 113, 0.2);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--dorado);
            margin-bottom: 20px;
        }

        .feature-title {
            color: var(--verde-principal);
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .feature-text {
            color: var(--blanco);
            opacity: 0.8;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero-section">
    <h1><i class="fas fa-futbol"></i> FIF Torneos</h1>
    <p>Vive la pasión del fútbol en Valle de Bravo</p>
    <div>
        <a href="{{ url('/registro') }}" class="btn-custom btn-registro">
            <i class="fas fa-user-plus"></i> Registrarse
        </a>
        <a href="{{ url('/inicio_de_secion') }}" class="btn-custom btn-login">
            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
        </a>
    </div>
</section>

<!-- Sobre nosotros -->
<section id="sobre">
    <div class="container">
        <div class="section-container">
            <h2 class="section-title">Sobre FIF Torneos</h2>
            <p class="section-text">
                La plataforma oficial de torneos de fútbol en Valle de Bravo. Conectamos jugadores,
                equipos y árbitros en un sistema integral de gestión deportiva.
                ¡Donde la pasión por el fútbol se encuentra con la tecnología!
            </p>

            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-trophy feature-icon"></i>
                    <h4 class="feature-title">Torneos Organizados</h4>
                    <p class="feature-text">Participa en los mejores torneos de la región con sistema profesional</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-chart-line feature-icon"></i>
                    <h4 class="feature-title">Estadísticas en Tiempo Real</h4>
                    <p class="feature-text">Sigue tu rendimiento y el de tu equipo con estadísticas detalladas</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-whistle feature-icon"></i>
                    <h4 class="feature-title">Árbitros Certificados</h4>
                    <p class="feature-text">Contamos con el mejor cuerpo arbitral de la zona</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-users feature-icon"></i>
                    <h4 class="feature-title">Comunidad Activa</h4>
                    <p class="feature-text">Únete a la comunidad futbolística más grande de Valle de Bravo</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contactos -->
<section id="contactos">
    <div class="container">
        <div class="section-container">
            <h2 class="section-title">Contáctanos</h2>
            <p class="section-text">
                ¿Tienes preguntas, sugerencias o quieres organizar un torneo?
                Estamos aquí para ayudarte. ¡Escríbenos!
            </p>
            <a href="mailto:contacto@fiftorneos.com" class="btn-email">
                <i class="fas fa-envelope"></i> contacto@fiftorneos.com
            </a>
        </div>
    </div>
</section>

<!-- Pie de página -->
<footer>
    <div class="container">
        <p class="footer-text">
            <i class="fas fa-copyright"></i> 2025 FIF Torneos | Todos los derechos reservados
        </p>
        <p class="footer-text">
            Valle de Bravo, Estado de México
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
