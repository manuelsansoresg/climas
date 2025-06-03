document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('add-to-cart-btn');
    if (!btn) return;

    btn.addEventListener('click', function() {
        const productId = btn.getAttribute('data-product-id');
        const url = btn.getAttribute('data-url');
        const csrfToken = btn.getAttribute('data-csrf');

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            alert(data.message);
        })
        .catch(error => {
            if (error.message) {
                alert('Error: ' + error.message);
            } else {
                alert('Error al agregar al carrito');
            }
            console.error(error);
        });
    });
});