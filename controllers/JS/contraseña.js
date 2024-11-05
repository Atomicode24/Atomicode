// Selecciona los elementos necesarios
const togglePassword1 = document.querySelector('.campo__contraseña + .eye-icon');
const passwordInput1 = document.querySelector('.campo__contraseña');

const togglePassword2 = document.querySelector('.campo__contraseña2 + .eye-icon');
const passwordInput2 = document.querySelector('.campo__contraseña2');

// Función para alternar el tipo de campo y el icono
function togglePasswordVisibility(passwordInput, toggleIcon) {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    // Cambia el ícono del ojo
    toggleIcon.querySelector('i').classList.toggle('fa-eye');
    toggleIcon.querySelector('i').classList.toggle('fa-eye-slash');
}

// Asignar el evento al primer campo de contraseña
togglePassword1.addEventListener('click', function () {
    togglePasswordVisibility(passwordInput1, this);
});

// Asignar el evento al segundo campo de contraseña
togglePassword2.addEventListener('click', function () {
    togglePasswordVisibility(passwordInput2, this);
});
