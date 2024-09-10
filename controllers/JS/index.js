document.addEventListener('DOMContentLoaded', function() {
    const isLoggedIn = localStorage.getItem('loggedIn') === 'true';

    if (isLoggedIn) {
        // Aplicar la clase 'authenticated' al body
        document.body.classList.add('authenticated');

        // Mostrar el mensaje de bienvenida
        document.querySelector('.welcome-message').style.display = 'block';
    } else {
        // Ocultar el mensaje de bienvenida si no está autenticado
        document.querySelector('.welcome-message').style.display = 'none';
    }
});
