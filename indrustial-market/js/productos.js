document.addEventListener('DOMContentLoaded', function() {

    //Listar productos
    let productos = [];

    fetch('http://localhost/indrustial-market/data/product.json')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log(data); // Aquí tendrás acceso a tu array de productos
        productos = data;
        const productosContAll = document.getElementById('pill-all-product');
    const productosContNew = document.getElementById('pill-new-product');
    const productosContShopping = document.getElementById('pill-shopping-product');
    const productosContDiscounts = document.getElementById('pill-discounts-product');

    // Filtrar productos según tipo (opcional)
    const productosTodos = productos.filter(p => p);
    const productosNuevos = productos.filter(p => p.calificacion <= 4);
    const productosEnCarrito = productos.filter(p => p.calificacion == 5);
    const productosConDescuento = productos.filter(p => p.descuento);

    const agregarProducto = (producto, contenedor) => {
        const tarjetaProducto = document.createElement('div');
        tarjetaProducto.classList.add('col-auto', 'px-0');

        // Calcular el precio con descuento si aplica
        const precioFinal = producto.descuento 
            ? producto.valor_producto * (1 - producto.valor_descuento / 100) 
            : producto.valor_producto;

        // Crear contenido HTML
        tarjetaProducto.innerHTML = `
            <div class="tarjeta-producto">
                <div class="imagen-producto">
                    <img src="${producto.imagen}" alt="${producto.nombre}">
                    ${producto.descuento ? `<span class="descuento">-${producto.valor_descuento}%</span>` : ''}
                </div>
                <div class="info-producto">
                    <h3>${producto.nombre}</h3>
                    <p class="precio">$${precioFinal.toFixed(2)} COP</p>
                    <div class="calificacion">
                        ${'<i class="fas fa-star"></i>'.repeat(producto.calificacion)}
                        ${'<i class="far fa-star"></i>'.repeat(5 - producto.calificacion)}
                    </div>
                    <button type="button" class="btn btn-dark mt-3 px-4">Cotizar</button>
                </div>
            </div>
        `;

        // Agregar la tarjeta al contenedor especificado
        contenedor.appendChild(tarjetaProducto);
    };

    // Agregar productos a cada contenedor
    productosTodos.forEach(producto => agregarProducto(producto, productosContAll));
    productosNuevos.forEach(producto => agregarProducto(producto, productosContNew));
    productosEnCarrito.forEach(producto => agregarProducto(producto, productosContShopping));
    productosConDescuento.forEach(producto => agregarProducto(producto, productosContDiscounts));
    })
    .catch(error => console.error('Hubo un problema con la petición Fetch:', error));

});
