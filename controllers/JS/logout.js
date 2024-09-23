// Función para manejar el cierre de sesión
document.getElementById('logoutButton').addEventListener('click', function() {
    localStorage.removeItem('loggedIn');
    localStorage.removeItem('user');
    window.location.href = 'login.html'; // Redirige a la página de login después del cierre de sesión
});
