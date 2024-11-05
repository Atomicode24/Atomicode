const btnAddDeseo = document.querySelectorAll(".btnAddDeseo");
const btnDeseo = document.querySelector('#btnCantidadDeseo');
let listaDeseo = JSON.parse(localStorage.getItem('listaDeseo')) || []; // Cargar la lista de deseos del localStorage

document.addEventListener('DOMContentLoaded', function () {
    if (localStorage.getItem('listDeseo') != null) {
        listaDeseo = JSON.parse(localStorage.getItem('listaDeseo'));
    }
    cantidadDeseo();
    for (let i = 0; i < btnAddDeseo.length; i++) {
        const element = btnAddDeseo[i];
    
        element.addEventListener('click', function () {
            let idProducto = element.getAttribute('prod');
            let nombreProducto = element.getAttribute('data-nombre'); // Suponiendo que tienes un atributo data-nombre
            let precioProducto = parseFloat(element.getAttribute('data-precio')); // Y un atributo data-precio
            agregarDeseo(idProducto, nombreProducto, precioProducto); // Llamar a la función
        });
    }
    
    
});

function agregarDeseo(idProducto) {
    // Verificar si el producto ya está en la lista de deseos
    // (Tu lógica existente aquí)

    // Después de agregar el producto a la lista de deseos local
    listaDeseo.push({
        "idProducto": idProducto,
        "cantidad": 1
    });

    // Guardar la lista actualizada en localStorage
    localStorage.setItem('listaDeseo', JSON.stringify(listaDeseo)); 

    // Hacer una solicitud para guardar la lista de deseos en el servidor
    fetch('../PHP/guardar_lista_deseos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(listaDeseo) // Enviando la lista de deseos como JSON
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message); // Manejo de la respuesta
    })
    .catch(error => console.error('Error:', error));

    // Mostrar alerta de éxito
    Swal.fire({
        position: "top-center",
        title: "Producto Agregado a la Lista de Deseos",
        showConfirmButton: false,
        timer: 1500,
        customClass: {
            title: 'custom-swal',
            popup: 'custom-popup'
        }
    });

    cantidadDeseo();
}


    // Agregar el producto con su nombre y precio a la lista de deseos
    listaDeseo.push({
        "idProducto": idProducto,
        "nombre": nombreProducto,
        "precio": precioProducto,
        "cantidad": 1
    });

    localStorage.setItem('listaDeseo', JSON.stringify(listaDeseo)); // Guardar la lista actualizada
    Swal.fire({
        position: "top-center",
        title: "Producto agregado a la lista de deseos",
        showConfirmButton: false,
        timer: 1500,
        customClass: {
            title: 'custom-swal',
            popup: 'custom-popup'
        }
    });
    
    cantidadDeseo();



function cantidadDeseo(){
    let listas = JSON.parse(localStorage.getItem('listaDeseo'));
    if (listas != null) {
        btnDeseo.textContent = listas.length;
    }else {
        btnDeseo.textContent = 0;
    }
    
}

function enviarListaDeseo() {
    const listaDeseo = JSON.parse(localStorage.getItem('listaDeseo')) || []; // Obtener la lista de deseos

    // Enviar la lista de deseos al servidor
    fetch('../../controllers/PHP/guardar_lista_deseos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(listaDeseo), // Convertir la lista a JSON
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al enviar la lista de deseos');
        }
        return response.json();
    })
    .then(data => {
        console.log('Lista de deseos enviada con éxito:', data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}



