<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="{{ asset('css/CandidatRegister.css') }}">
</head>
<body>
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
            <div class="register-form">
                <h1>Obtén más oportunidades</h1>
                <form method="POST" action="{{ route('candidat.register') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">Nombre</label>
                            <input type="text" name="first_name" id="first_name" placeholder="Ingresa tu nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Apellido</label>
                            <input type="text" name="last_name" id="last_name" placeholder="Ingresa tu apellido" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="position">Cargo actual</label>
                            <input type="text" name="position" id="position" placeholder="Ingresa tu cargo actual" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="email" name="email" id="email" placeholder="Ingresa tu correo electrónico" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" placeholder="Crea una contraseña segura" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirma tu contraseña" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="sector">Sector</label>
                            <input type="text" name="sector" id="sector" placeholder="Ingresa tu sector" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Número de contacto</label>
                            <input type="tel" name="tel" id="phone" placeholder="Ingresa tu número de contacto" required>
                        </div>
                    </div>
                    {{-- <div class="linkedin-import">
                        <img src="https://s3-alpha-sig.figma.com/img/cda2/d4a4/23121f81a9ea958eeed10b3dfb738450?Expires=1733702400&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=ZXm-c~mg5XOjQRwE1Ajo2eKLhdTw-zS4xCqFCNvMuH9bhWAFfwBEq3w7g52cbP9pmMjG9vaReqpRAUI75TsYHRcz8r3lrJy5atujhXTP-HR8g3Jd34Ycn4NqG6-C7Bo09oxHbuBcCrqO-PudjBX0InG1zkVeFwSUg4Scyjg8vRV9OV8G6H5e93a1UuebdgArvmBx1PuRKfle14~k5ZUnFI9yEn1A~l~FX~aBX7eQyDqsulyOIYlzJ4-bYEzrxW0tnAV3LlAzNHaAhstga2f1bB48VWYWO0yEbDDGZ1ZTDIQLyr2GYzRgV5byy-ctfSLhMeO6jxRtKzI~UB~qLOxcAg__" alt="LinkedIn">
                        <span>Importar CV o LinkedIn</span>
                    </div> --}}
                    <button type="submit" class="submit-btn">Continuar</button>
                    <div class="login-link">
                        <span>¿Ya tienes una cuenta? </span>
                        <a href="{{ route('candidat.login') }}">Inicia sesión</a>
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
</body>
</html>