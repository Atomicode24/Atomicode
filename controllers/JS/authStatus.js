// Función para verificar el estado de autenticación del usuario
function checkLoginStatus() {
    const loggedIn = localStorage.getItem('loggedIn');
    const headerStatus = document.getElementById('headerStatus');
    const logoutButton = document.getElementById('logoutButton');

    if (loggedIn === 'true') {
        headerStatus.textContent = 'Estás logueado';
        logoutButton.style.display = 'inline'; // Mostrar el botón de cerrar sesión
    } else {
        headerStatus.textContent = 'No estás logueado';
        logoutButton.style.display = 'none'; // Ocultar el botón de cerrar sesión
    }
}

// Llama a la función al cargar la página
window.onload = checkLoginStatus;
