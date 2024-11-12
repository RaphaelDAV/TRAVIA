function updateQuantity(button, change) {
    const quantityInput = button.parentNode.querySelector('.quantity-input');
    const unitPrice = parseFloat(button.closest('.flex-ticket').querySelector('.unit-price').innerText);
    const totalPriceElement = button.closest('.flex-ticket').querySelector('.total-price');

    // Update the quantity
    let quantity = parseInt(quantityInput.value) + change;
    quantity = Math.max(0, quantity);
    quantityInput.value = quantity;

    // Calculate the total price for this ticket
    const totalTicketPrice = unitPrice * quantity;
    totalPriceElement.innerText = totalTicketPrice.toFixed(2);

    // Update the cart total
    updateCartTotal();
}

function updateCartTotal() {
    let total = 0;
    document.querySelectorAll('.ticket-price-total').forEach((ticket) => {
        const price = parseFloat(ticket.querySelector('.total-price').textContent);
        total += price;
    });

    const finalTotal = Math.max(0, total);
    // Update the displayed total prices
    document.getElementById('cart-total').textContent = total.toFixed(2);
    document.getElementById('final-cart-total').textContent = (total).toFixed(2);
}

document.addEventListener("DOMContentLoaded", function() {
    const countdownElements = document.querySelectorAll('.countdown');

    countdownElements.forEach(element => {
        const dateAdded = new Date(element.getAttribute('data-date'));
        const ticketId = element.getAttribute('data-id');
        const expirationTime = new Date(dateAdded.getTime() + 2 * 60 * 1000);

        function updateCountdown() {
            const now = new Date();
            const remainingTime = expirationTime - now;

            if (remainingTime <= 0) {
                element.innerText = 'Expired';
                element.classList.add('expired');
            } else {
                const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
                element.innerText = `${minutes}m ${seconds}s`;
            }
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
});

function deleteToCart() {
    alert("Le ticket a été supprimé du panier !");
}