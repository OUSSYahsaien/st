<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="{{ asset('css/CandidatLogin.css') }}">
</head>
<body>

    @if($errors->any())
        <div class="alert-container">
            @foreach($errors->all() as $error)
                <div class="alert alert-error">
                    <div class="alert-content">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $error }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="alert-close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endforeach
        </div>
    @endif
    
    <div class="container">
        <div class="left-section">
            <div class="stats">
                <h2>100+</h2>
                <p>Oportunidades</p>
            </div>
            <div class="image-container">
                <img draggable="false" src="{{ asset('images/businessman.png') }}" alt="Professional businessman">
            </div>
        </div>
        <div class="right-section">
            <div class="tabs">
                <button class="tab active">Talento</button>
                <a href="{{ route('company.login') }}">
                    <button class="tab">Empresa</button>
                </a>
            </div>
            <div class="login-form">
                <h1>Bienvenido/a de nuevo</h1>
                <form  action="{{ route('candidat.login') }}" method="POST" >
                    @csrf
                    <div class="form-group">
                        <label for="email">Dirección de correo electrónico</label>
                        <input name="email" type="email" id="email" placeholder="Ingresa la dirección de correo electrónico" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input name="password" type="password" id="password" placeholder="Ingresa la contraseña" required>
                    </div>
                    <div class="form-group checkbox">
                        <input type="checkbox" id="remember">
                        <label for="remember">mantener sesion iniciada</label>
                    </div>
                    <button type="submit" class="submit-btn">Continuar</button>
                    <div class="forgot-password">
                        <span>¿Olvidaste tu contraseña? </span>
                        <a href="#">Resablecer</a>
                    </div>
                    <div class="registration">
                        <span>¿No tienes una cuenta?  </span>
                        <a href="{{route('candidat.register')}}">Crea una</a>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sélectionner toutes les alertes
            const alerts = document.querySelectorAll('.alert');
            
            // Pour chaque alerte
            alerts.forEach(alert => {
                // Ajouter une classe pour l'animation de sortie après 5 secondes
                setTimeout(() => {
                    alert.style.animation = 'slideOut 0.4s ease-in-out forwards';
                    // Supprimer l'élément après l'animation
                    setTimeout(() => {
                        alert.remove();
                    }, 400);
                }, 5000);
            });
        });
    </script>
    
</body>
</html>