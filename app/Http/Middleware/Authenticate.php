protected function redirectTo($request)
{
    if (!$request->expectsJson()) {
        return route('candidat.login'); // Remplacez 'login' par 'candidat.login'
    }
}
