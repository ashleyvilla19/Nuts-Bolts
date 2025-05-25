// Código para el popup de registro
document.addEventListener('DOMContentLoaded', function() {

});

// Precios de los productos
const PRODUCT_PRICES = {
    'tornillo': 1000,
    'soldador': 450000,
    'drywall': 35000
};

// Descuentos por tipo de cliente
const CUSTOMER_DISCOUNTS = {
    'permanente': 0.10,
    'periodico': 0.05,
    'casual': 0.02,
    'nuevo': 0
};

// Manejo del sistema de cotizaciones
document.addEventListener('DOMContentLoaded', function() {
    const addProductBtn = document.getElementById('add-product');
    const productsContainer = document.getElementById('products-container');
    const quoteForm = document.getElementById('quote-form');

    // Añadir nuevo producto
    if (addProductBtn) {
        addProductBtn.addEventListener('click', function() {
            const productEntry = document.createElement('div');
            productEntry.className = 'product-entry';
            productEntry.innerHTML = `
                <select class="product-select" required>
                    <option value="">Seleccione un producto</option>
                    <option value="tornillo">Tornillos de Acero Inoxidable - 1,000 COP</option>
                    <option value="soldador">Soldador Eléctrico - 450,000 COP</option>
                    <option value="drywall">Láminas de Drywall - 35,000 COP</option>
                </select>
                <input type="number" class="product-quantity" min="1" value="1" required>
                <button type="button" class="remove-product">Eliminar</button>
            `;
            productsContainer.appendChild(productEntry);
            
            // Agregar event listeners a los nuevos elementos
            const newSelect = productEntry.querySelector('.product-select');
            const newQuantity = productEntry.querySelector('.product-quantity');
            
            newSelect.addEventListener('change', updateQuote);
            newQuantity.addEventListener('change', updateQuote);
            newQuantity.addEventListener('input', updateQuote);
            
            updateQuote();
        });
    }

    // Eliminar producto
    if (productsContainer) {
        productsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.parentElement.remove();
                updateQuote();
            }
        });
    }

    // Función para calcular y actualizar la cotización
    function updateQuote() {
        let subtotal = 0;
        const products = document.querySelectorAll('.product-entry');
        
        products.forEach(product => {
            const selectedProduct = product.querySelector('.product-select').value;
            const quantity = parseInt(product.querySelector('.product-quantity').value) || 0;
            
            if (selectedProduct && PRODUCT_PRICES[selectedProduct]) {
                subtotal += PRODUCT_PRICES[selectedProduct] * quantity;
            }
        });

        // Obtener tipo de cliente
        const customerType = document.getElementById('customerType')?.value || 'nuevo';
        let discountPercentage = CUSTOMER_DISCOUNTS[customerType];

        // Descuento adicional por compra mayor a $100,000
        if (subtotal > 100000) {
            discountPercentage += 0.05; // 5% adicional
        }

        const discountAmount = subtotal * discountPercentage;
        const total = subtotal - discountAmount;

        // Actualizar resumen
        const subtotalElement = document.getElementById('subtotal');
        const discountElement = document.getElementById('discount');
        const totalElement = document.getElementById('total');

        if (subtotalElement) subtotalElement.textContent = `${subtotal.toLocaleString()} COP`;
        if (discountElement) discountElement.textContent = `${discountAmount.toLocaleString()} COP`;
        if (totalElement) totalElement.textContent = `${total.toLocaleString()} COP`;
    }

});
