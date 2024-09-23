document.addEventListener('DOMContentLoaded', () => {
    // Inicializa el contador del carrito en la carga de la página
window.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
});
    // Obtén el carrito desde localStorage
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    
    // Obtén el elemento del contador
    const contadorElement = document.getElementById('cart-count');
    
    // Verifica si el elemento existe antes de intentar actualizarlo
    if (contadorElement) {
        contadorElement.textContent = carrito.length;
    } else {
        console.error('Elemento con ID "cart-count" no encontrado.');
    }
});
