const itemHead = document.querySelector('.itemhead--cuenta');
const submenu = itemHead.querySelector('.submenu__cuenta');

// Mostrar el submenú al pasar el mouse sobre el <li>
itemHead.addEventListener('mouseenter', () => {
    submenu.style.display = 'block'; // Mostrar
    setTimeout(() => {
        submenu.style.opacity = '1'; // Transición
        submenu.style.transform = 'translateX(-50%) translateY(0)'; // Ajuste de posición
    }, 10); // Retardo para que la transición funcione
});

// Ocultar el submenú cuando el mouse sale
itemHead.addEventListener('mouseleave', () => {
    submenu.style.opacity = '0'; // Desvanecer
    submenu.style.transform = 'translateX(-50%) translateY(-10px)'; // Ajuste de posición
    setTimeout(() => {
        submenu.style.display = 'none'; // Ocultar después de la transición
    }, 300); // Coincidir con duración de transición
});
