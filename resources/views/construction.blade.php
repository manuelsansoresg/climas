<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio en Construcción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Arial', sans-serif;
        }
        .construction-container {
            text-align: center;
            color: white;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .construction-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-30px);
            }
            60% {
                transform: translateY(-15px);
            }
        }
        .construction-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .construction-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        .contact-info {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
        }
        .contact-item {
            margin: 0.5rem 0;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="construction-container">
        <div class="construction-icon">
            <i class="fas fa-hard-hat"></i>
        </div>
        <h1 class="construction-title">Sitio en Construcción</h1>
        <p class="construction-subtitle">
            Estamos trabajando duro para traerte una experiencia increíble.<br>
            ¡Pronto estaremos de vuelta!
        </p>
        
        @if($config)
            <div class="contact-info">
                <h5 class="mb-3">Contáctanos mientras tanto:</h5>
                @if($config->email)
                    <div class="contact-item">
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:{{ $config->email }}" class="text-white text-decoration-none">{{ $config->email }}</a>
                    </div>
                @endif
                @if($config->phone)
                    <div class="contact-item">
                        <i class="fas fa-phone me-2"></i>
                        <a href="tel:{{ $config->phone }}" class="text-white text-decoration-none">{{ $config->phone }}</a>
                    </div>
                @endif
                
                @if($config->fb || $config->instagram || $config->x)
                    <div class="mt-3">
                        <h6>Síguenos en:</h6>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            @if($config->fb)
                                <a href="{{ $config->fb }}" class="text-white" target="_blank">
                                    <i class="fab fa-facebook fa-2x"></i>
                                </a>
                            @endif
                            @if($config->instagram)
                                <a href="{{ $config->instagram }}" class="text-white" target="_blank">
                                    <i class="fab fa-instagram fa-2x"></i>
                                </a>
                            @endif
                            @if($config->x)
                                <a href="{{ $config->x }}" class="text-white" target="_blank">
                                    <i class="fab fa-twitter fa-2x"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</body>
</html>