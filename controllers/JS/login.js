// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar el formulario de inicio de sesión
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar el envío del formulario

        // Obtener los datos ingresados por el usuario
        const email = document.getElementById('correo').value;
        const password = document.getElementById('contrasenia').value;

        // Obtener los datos del usuario almacenados en localStorage
        const user = JSON.parse(localStorage.getItem('user'));

        if (user) {
            // Verificar si el correo electrónico y la contraseña coinciden
            if (email === user.email && password === user.password) {
                // Guardar el estado de inicio de sesión en localStorage
                localStorage.setItem('loggedIn', 'true');
                // Redirigir al usuario a la página principal
                window.location.href = 'index.html';
            } else {
                // Mostrar un mensaje de error si las credenciales no coinciden
                alert('Correo electrónico o contraseña incorrectos.');
            }
        } else {
            // Mostrar un mensaje si no hay ningún usuario registrado
            alert('No hay ningún usuario registrado.');
        }
    });
});
