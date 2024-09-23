document.addEventListener('DOMContentLoaded', () => {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productNameElement = document.querySelector('.titulo__producto_buscar');
            if (!productNameElement) {
                console.error('Elemento con clase "titulo__producto_buscar" no encontrado.');
                return;
            }
            const productName = productNameElement.innerText;

            const quantityInput = document.querySelector('.producto__cantidad input');
            if (!quantityInput) {
                console.error('Elemento de cantidad no encontrado.');
                return;
            }
            const quantity = parseInt(quantityInput.value, 10);

            if (isNaN(quantity) || quantity <= 0) {
                alert('Cantidad inválida.');
                return;
            }

            const productPriceElement = document.querySelector('.precio__dolar.precio__modificado-main');
            if (!productPriceElement) {
                console.error('Elemento de precio no encontrado.');
                return;
            }
            const productPrice = parseFloat(productPriceElement.textContent.replace('U$S ', '').replace(',', '.'));

            const product = {
                name: productName,
                quantity: quantity,
                price: productPrice
            };

            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push(product);
            localStorage.setItem('cart', JSON.stringify(cart));

            alert('Producto agregado al carrito!');
        });
    });
// Función para actualizar el contador del carrito en la página de productos
function updateCartCount() {
    let cartCountElement = document.getElementById('cart-count');
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cartCountElement.textContent = cart.length;
}

// Función para agregar un producto al carrito
function addToCart(product) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push(product);
    localStorage.setItem('cart', JSON.stringify(cart));
    // Recarga la página para actualizar la vista
    location.reload();
}

// Evento para el botón de compra
document.addEventListener('DOMContentLoaded', () => {
    let addToCartButton = document.querySelector('.add-to-cart');
    if (addToCartButton) {
        addToCartButton.addEventListener('click', () => {
            let product = {
                id: 'product-id', // Debes reemplazar esto con el ID real del producto
                name: 'Botella Stanley Classic',
                price: 22.94
            };
            addToCart(product);
        });
    }
});

// Inicializa el contador si la página está cargada
updateCartCount();

});
