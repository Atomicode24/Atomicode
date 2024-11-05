

// Obtén los elementos
const modal = document.querySelector('.modal');
const btnEliminar = modal.querySelector('#btn-elimina');
const abrirModalButtons = document.querySelectorAll('.abrir-alerta');

// Agrega el evento click a los botones que abren el modal
abrirModalButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
        const id = this.getAttribute('data-id'); // Obtén el ID del atributo data-id
        btnEliminar.setAttribute('value', id); // Establece el valor en el botón de eliminar
        modal.style.display = 'block'; // Muestra el modal
    });
});

// Agrega el evento click al botón de cerrar
const cerrarBoton = modal.querySelector('.cerrar-alerta');
cerrarBoton.addEventListener('click', function() {
    modal.style.display = 'none'; // Oculta el modal
});


function actualizaCantidad(cantidad, id){
    let url = '../../model/clases/actualizar_carrito.php';
    let formData = new FormData();
    formData.append('action', 'agregar');
    formData.append('id', id);
    formData.append('cantidad', cantidad);

    fetch(url, {
       method: 'POST',
       body: formData,
       mode: 'cors'
    }).then(Response => Response.json())
    .then(data => {
       if(data.ok){
            let divsubtotal = document.getElementById('subtotal_' + id);
            divsubtotal.innerHTML = data.subtotal;

            let total = 0.00;
            let list = document.getElementsByName('subtotal[]');

            for(let i = 0; i < list.length; i++){
                total  += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''));
            }

            total = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2
            }).format(total)
            document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total;
       }
    })
}

function eliminar(){

    let botonElimina = document.getElementById("btn-elimina");
    let id = botonElimina.value;

    let url = '../../model/clases/actualizar_carrito.php';
    let formData = new FormData();
    formData.append('action', 'eliminar');
    formData.append('id', id);

    fetch(url, {
       method: 'POST',
       body: formData,
       mode: 'cors'
    }).then(Response => Response.json())
    .then(data => {
       if(data.ok){
        location.reload();
       }
    })
}