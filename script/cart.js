function updateQuantity(button, change) {
    const quantityInput = button.parentNode.querySelector('.quantity-input');
    const unitPrice = parseFloat(button.closest('.flex-ticket').querySelector('.unit-price').innerText);
    const totalPriceElement = button.closest('.flex-ticket').querySelector('.total-price');

    // Update the quantity
    let quantity = parseInt(quantityInput.value) + change;
    quantity = Math.max(1, quantity);
    quantityInput.value = quantity;

    // Calculate the total price for this ticket
    totalPriceElement.innerText = (unitPrice * quantity).toFixed(2);

    updateCartTotal();
}

function updateCartTotal() {
    let total = 0;
    document.querySelectorAll('.ticket-price-total').forEach((ticket) => {
        const price = parseFloat(ticket.querySelector('.total-price').textContent);
        total += price;
    });

    // Update the displayed total prices
    document.getElementById('cart-total').textContent = total.toFixed(2);
    document.getElementById('cart-subtotal').textContent = total.toFixed(2);
    document.getElementById('final-cart-total').textContent = (total - 4.00).toFixed(2);
}