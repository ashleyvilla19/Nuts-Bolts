// Código para el popup de registro
document.addEventListener('DOMContentLoaded', function() {
    console.log('JavaScript cargado correctamente'); // Para verificar que el archivo se carga
    
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
        const productosContNew = document.getElementById('pill-new-product');
        const productosContShopping = document.getElementById('pill-shopping-product');
        const productosContDiscounts = document.getElementById('pill-discounts-product');

        // Filtrar productos según tipo (opcional)
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
        productosNuevos.forEach(producto => agregarProducto(producto, productosContNew));
        productosEnCarrito.forEach(producto => agregarProducto(producto, productosContShopping));
        productosConDescuento.forEach(producto => agregarProducto(producto, productosContDiscounts));
    })
    .catch(error => console.error('Hubo un problema con la petición Fetch:', error));
});



document.addEventListener('DOMContentLoaded', function() {
    // Obtener todos los enlaces de la barra de navegación
    const navLinks = document.querySelectorAll('.main-nav a');
    
    // Agregar evento click a cada enlace
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
            
            // Obtener el ID del destino desde el href
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                // Calcular la posición de desplazamiento
                const offsetTop = targetElement.offsetTop;
                
                // Realizar el desplazamiento suave
                window.scrollTo({
                    top: offsetTop - 100, // Restamos 100px para dejar un espacio en la parte superior
                    behavior: 'smooth'
                });
            }
        });
    });
});
