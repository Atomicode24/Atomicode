document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('subir-producto');
    const tablaProductos = document.getElementById('tabla-productos').getElementsByTagName('tbody')[0];
    let productos = JSON.parse(localStorage.getItem('productos')) || [];
    let idsUsadas = JSON.parse(localStorage.getItem('idsUsadas')) || [];
    let idCounter = 1; // Iniciar el contador de IDs desde 1

    // Función para obtener la próxima ID disponible
    function obtenerProximaID() {
        let id = idCounter.toString().padStart(2, '0');
        while (idsUsadas.includes(id)) {
            idCounter++;
            id = idCounter.toString().padStart(2, '0');
        }
        return id;
    }

    // Cargar productos desde localStorage al cargar la página
    productos.forEach(producto => agregarProductoATabla(producto));

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const nombre = document.getElementById('nombre').value;
        const descripcion = document.getElementById('descripcion').value;
        const precio = document.getElementById('precio').value;
        const imagenes = document.getElementById('imagenes').files;
        const categorias = document.getElementById('categorias').value;
        const etiquetas = document.getElementById('etiquetas').value;
        const sku = document.getElementById('sku').value;

        const idAsignada = obtenerProximaID(); // Obtener la próxima ID disponible

        // Convertir las imágenes a base64
        const imagenesBase64 = [];
        if (imagenes.length > 0) {
            Array.from(imagenes).forEach((imgFile) => {
                const reader = new FileReader();
                reader.readAsDataURL(imgFile);
                reader.onload = function () {
                    imagenesBase64.push(reader.result);

                    // Solo guardar el producto una vez que todas las imágenes se hayan convertido
                    if (imagenesBase64.length === imagenes.length) {
                        const nuevoProducto = {
                            id: idAsignada,
                            nombre,
                            descripcion,
                            precio,
                            imagenes: imagenesBase64,
                            categorias,
                            etiquetas,
                            sku
                        };

                        productos.push(nuevoProducto);
                        idsUsadas.push(idAsignada); // Agregar la nueva ID a la lista de usadas
                        localStorage.setItem('productos', JSON.stringify(productos));
                        localStorage.setItem('idsUsadas', JSON.stringify(idsUsadas));
                        agregarProductoATabla(nuevoProducto);

                        form.reset();
                    }
                };
            });
        } else {
            const nuevoProducto = {
                id: idAsignada,
                nombre,
                descripcion,
                precio,
                imagenes: imagenesBase64,
                categorias,
                etiquetas,
                sku
            };

            productos.push(nuevoProducto);
            idsUsadas.push(idAsignada); // Agregar la nueva ID a la lista de usadas
            localStorage.setItem('productos', JSON.stringify(productos));
            localStorage.setItem('idsUsadas', JSON.stringify(idsUsadas));
            agregarProductoATabla(nuevoProducto);

            form.reset();
        }
    });

    function agregarProductoATabla(producto) {
        const fila = tablaProductos.insertRow();
        fila.setAttribute('data-id', producto.id);
        fila.insertCell(0).textContent = producto.id;
        fila.insertCell(1).textContent = producto.nombre;
        fila.insertCell(2).textContent = producto.descripcion;
        fila.insertCell(3).textContent = producto.precio;

        const imagenesCell = fila.insertCell(4);
        if (producto.imagenes.length > 0) {
            producto.imagenes.forEach((imgBase64) => {
                const img = document.createElement('img');
                img.src = imgBase64;
                img.className = 'table-img';
                imagenesCell.appendChild(img);
            });
        }

        const acciones = fila.insertCell(5);
        const btnEliminar = document.createElement('button');
        btnEliminar.textContent = 'Eliminar';
        btnEliminar.className = 'eliminar';
        btnEliminar.addEventListener('click', function () {
            const confirmacion = window.confirm('¿Está seguro de que desea eliminar este producto?');
            if (confirmacion) {
                const id = producto.id;
                productos = productos.filter(p => p.id !== id);
                localStorage.setItem('productos', JSON.stringify(productos));
                tablaProductos.removeChild(fila);
            }
        });
        acciones.appendChild(btnEliminar);

        const btnEditar = document.createElement('button');
        btnEditar.textContent = 'Editar';
        btnEditar.className = 'editar';
        // Aquí puedes agregar la funcionalidad de edición
        acciones.appendChild(btnEditar);
    }
});
