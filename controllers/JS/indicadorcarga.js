// Esperamos a que la página cargue
window.addEventListener('load', function() {
    // Ocultamos el loader una vez cargada la página
    const contenedorCarga = document.getElementById('contenedor__carga');
    contenedorCarga.style.opacity = '0';  // Suavizar la salida
    setTimeout(() => {
        contenedorCarga.style.display = 'none';  // Después de 1s lo ocultamos completamente
    }, 1000);
});

// Mostrar el loader cuando navegamos fuera de la página
window.addEventListener('beforeunload', function() {
    const contenedorCarga = document.getElementById('contenedor__carga');
    contenedorCarga.style.display = 'block';
    contenedorCarga.style.opacity = '1';  // Volvemos a mostrarlo
});
