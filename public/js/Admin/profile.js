document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const inputs = document.querySelectorAll('input');

    // Ajouter un placeholder vide pour activer l'animation du label
    inputs.forEach(input => {
        input.setAttribute('placeholder', ' ');
    });

});