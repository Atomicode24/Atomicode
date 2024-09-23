document.addEventListener('DOMContentLoaded', function () {
    const formEstado = document.getElementById('estado-pedido');
    const tablaPedidos = document.getElementById('tabla-pedidos').getElementsByTagName('tbody')[0];

    formEstado.addEventListener('submit', function (e) {
        e.preventDefault();

        const estado = document.getElementById('estado').value;

        // Crear nueva fila en la tabla
        const fila = tablaPedidos.insertRow();
        fila.insertCell(0).textContent = '12345'; // ID del pedido (ejemplo)
        fila.insertCell(1).textContent = 'Cliente Ejemplo';
        fila.insertCell(2).textContent = estado;
        
        const estadoCell = fila.cells[2];
        const estadoTexto = {
            pendiente: 'Pendiente',
            'en-proceso': 'En Proceso',
            enviado: 'Enviado',
            entregado: 'Entregado',
            cancelado: 'Cancelado'
        };
        estadoCell.innerHTML = `<span class="${estado}">${estadoTexto[estado]}</span>`;

        fila.insertCell(3).textContent = new Date().toLocaleDateString();
    });
});
