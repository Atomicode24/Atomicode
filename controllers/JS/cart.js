document.addEventListener('DOMContentLoaded', () => {
    const cartItemsList = document.getElementById('cart-items');
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    function renderCart() {
        cartItemsList.innerHTML = '';
        if (cart.length === 0) {
            cartItemsList.innerHTML = '<li>No hay productos en tu carrito.</li>';
        } else {
            cart.forEach((item, index) => {
                const listItem = document.createElement('li');
                const itemPrice = item.price ? item.price.toFixed(2) : 'N/A';
                listItem.innerHTML = `
                    <span class="item-details">
                        <h4>${item.name}</h4>
                        <p>Cantidad: ${item.quantity}</p>
                    </span>
                    <span class="item-price">Precio: U$S ${itemPrice}</span>
                    <button class="remove-item" data-index="${index}">Eliminar</button>
                `;
                cartItemsList.appendChild(listItem);
            });
        }
    }

    function removeItem(index) {
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
    }

    cartItemsList.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-item')) {
            const index = event.target.getAttribute('data-index');
            removeItem(index);
        }
    });

    renderCart();
});
