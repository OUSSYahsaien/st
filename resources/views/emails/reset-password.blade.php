<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reiniciar contraseña</title>
</head>
<body>
    <p>Hola,</p>
    <p>Cliquez sur le lien suivant pour réinitialiser votre mot de passe : 
        <a href="{{ url('/reset-password/'.$token) }}">Réinitialiser le mot de passe</a>
    </p>
    <p>Ce lien expirera dans 15 minutes.</p>
</body>
</html>
