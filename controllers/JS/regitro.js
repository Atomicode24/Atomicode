// Función para registrar un nuevo usuario
document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('regEmail').value;
    const password = document.getElementById('regPassword').value;

    // Validar correo electrónico
    if (!validateEmail(email)) {
        alert('Correo electrónico inválido.');
        return;
    }

    // Validar contraseña
    if (password.length < 6) {
        alert('La contraseña debe tener al menos 6 caracteres.');
        return;
    }

    // Guardar en localStorage
    localStorage.setItem('user', JSON.stringify({ name, email, password }));
    localStorage.setItem('loggedIn', 'true');
    alert('Registro exitoso.');
    window.location.href = 'index.html'; // Redirige a la página de inicio después del registro
});

// Función para validar el correo electrónico
function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
