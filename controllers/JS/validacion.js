// Función para validar el inicio de sesión
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('correo').value;
    const password = document.getElementById('contrasenia').value;

    const storedUser = JSON.parse(localStorage.getItem('user'));
    
    if (storedUser && storedUser.email === email && storedUser.password === password) {
        localStorage.setItem('loggedIn', 'true');
        window.location.href = 'index.html'; // Redirige a la página principal después de iniciar sesión
    } else {
        alert('Email o contraseña incorrectos.');
    }
});
// Función para validar el inicio de sesión
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('correo').value;
    const password = document.getElementById('contrasenia').value;

    const storedUser = JSON.parse(localStorage.getItem('user'));
    
    if (storedUser && storedUser.email === email && storedUser.password === password) {
        localStorage.setItem('loggedIn', 'true');
        window.location.href = 'index.html'; // Redirige a la página principal después de iniciar sesión
    } else {
        alert('Email o contraseña incorrectos.');
    }
});
