<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Company/auth/companyRegister.css') }}">
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
                <a href="{{ route('candidat.login') }}">
                    <button class="tab">Talento</button>
                </a>
                {{-- <a href="CompanyLogin.html"> --}}
                    <button class="tab active">Empresa</button>
                {{-- </a> --}}
            </div>
            <div class="register-form">
                <h1>Encuentra el talento</h1>
                <form method="POST" action="{{ route('company.register') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fullname">Nombre completo</label>
                            <input type="text" id="fullname" name="fullname" placeholder="Ingresa la contraseña" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="company">Empresa</label>
                            <input type="text" id="company" name="company" placeholder="Ingresa la contraseña" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email" placeholder="Ingresa la contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Numero de contacto</label>
                            <input type="tel" id="phone" name="phone" placeholder="Ingresa la contraseña" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" id="password" name="password" placeholder="Ingresa la contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="position">Confirmar Contraseña</label>
                            <input type="text" id="password_confirmation" name="password_confirmation" placeholder="Ingresa la contraseña" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="position">Cargo</label>
                            <input type="text" id="position" name="position" placeholder="Ingresa la contraseña" required>
                        </div>
                    </div>
                    <button type="submit" class="submit-btn">Continuar</button>
                    <div class="login-link">
                        <span>¿Ya tienes una cuenta? </span>
                        <a href="{{ route('company.login') }}">Inicia sesión</a>
                    </div>
                    <div class="terms">
                        <p>Al hacer clic en Continuar, reconoces que has leído y aceptado los 
                            <a href="#">Términos de Servicio</a> y la 
                            <a href="#">Política de Privacidad</a>.
                        </p>
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