<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Selectalent - Connexion</title>
    <link rel="stylesheet" href="{{ asset('css/Admin/login.css') }}">
</head>
<body>
    <div class="container">
        <div class="login-card">
            <div class="logo">
                <div class="logo">
                    <img src="{{ asset('images/logo/logo2.png') }}" alt="Selectalent" class="logo-img">
                </div>                

            </div>
            <h1>Acceso</h1>
            <form id="loginForm" class="login-form" method="POST" action="{{route('administration.login')}}">
                @csrf
                <div class="form-group">
                    <input type="email" id="email" name="email" required>
                    <label for="email">Correo electrónico</label>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Contraseña</label>
                </div>
                <button type="submit" class="login-button">Acceso</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/Admin/profile.js') }}"></script>
</body>
</html>