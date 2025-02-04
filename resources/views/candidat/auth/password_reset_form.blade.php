<form action="{{ route('password.update') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">
    <label for="password">Nouveau mot de passe</label>
    <input type="password" name="password" required>
    <label for="password_confirmation">Confirmer le mot de passe</label>
    <input type="password" name="password_confirmation" required>
    <button type="submit">Réinitialiser le mot de passe</button>
</form>
