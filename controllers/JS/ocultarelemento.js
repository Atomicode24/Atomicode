// Selecciona el contenedor "cuenta"
const contenedorCuenta = document.querySelector('.contenedor__cuenta');

// Selecciona el enlace "Mi Cuenta"
const enlaceCuenta = document.querySelector('.abrir__cuenta');

// Agrega un evento al documento para detectar clics en cualquier parte de la pantalla
document.addEventListener('click', function(event) {
    // Verifica si el clic fue fuera del contenedor "cuenta" y del enlace "Mi Cuenta"
    if (!contenedorCuenta.contains(event.target) && event.target !== enlaceCuenta) {
        contenedorCuenta.style.display = 'none';
    }
});

// Muestra el contenedor "cuenta" cuando se hace clic en el enlace "Mi Cuenta"
enlaceCuenta.addEventListener('click', function(event) {
    // Evita que el clic en el enlace también cierre el contenedor
    event.stopPropagation();
    
    // Muestra el contenedor "cuenta"
    contenedorCuenta.style.display = 'flex';
});
