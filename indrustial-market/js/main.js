
// main.js

document.addEventListener('DOMContentLoaded', function() {

    pashInit();

    // Cargar el header y el footer
    loadComponent('../shared/components/header.php', 'header');
    loadComponent('../shared/components/footer.html', 'footer');
    loadComponent('../shared/modals/modal-registro.html', 'modaRegistro');
    
    setTimeout(() => {
        const registerLink = document.querySelector('.login');
        console.log('registerLink: ', registerLink);
        const popup = document.getElementById('registerPopup');
        const closeButton = document.querySelector('.popup-close');
        const registerForm = document.getElementById('registerForm');
        
        if (registerLink) {
            console.log('Botón de registro encontrado');
            registerLink.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Clic en registro detectado');
                if (popup) {
                    popup.style.display = 'block';
                }
            });
        }
        
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                popup.style.display = 'none';
            });
        }
        
        if (popup) {
            popup.addEventListener('click', function(e) {
                if (e.target === popup) {
                    popup.style.display = 'none';
                }
            });
        }
        
        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('¡Registro exitoso!');
                popup.style.display = 'none';
            });
        }
    }, 500);
    
});


  function pashInit() {
    // Obtén la ruta actual
    const rutaActual = window.location.pathname.toLowerCase();
  
    // Obtén el nombre de la carpeta del proyecto dinámicamente
    const projectFolder = `/${rutaActual.split('/')[1]}`;
  
    // Verifica si estás en la raíz o en "index.html"
    const esIndex = rutaActual === projectFolder + "/" || rutaActual.endsWith("/index.html");
    const yaEsHome = rutaActual.includes("/view/home.html");
  
    if (esIndex && !yaEsHome) {
      // Redirige a la vista de "home"
      window.location.href = `${location.origin}${projectFolder}/view/home.html`;
    }
  }
 

// Función para cargar componentes desde un archivo
function loadComponent(component, elementId) {
    fetch(component)
        .then(response => response.text())
        .then(data => {
            document.getElementById(elementId).innerHTML = data;
        })
        .catch(error => console.error('Error loading component:', error));
}



function changeView(view, id = '', extension="html") {
    // Cambia la ubicación de la ventana incluyendo el fragmento del id
    console.log(`${view}.${extension}${id ? `#${id}` : ''}`);
    
    window.location.href = `${view}.${extension}${id ? `#${id}` : ''}`;

    // Escucha el evento de carga de la ventana
    window.addEventListener("load", () => {
        if (id) {
            // Espera a que el elemento esté en el DOM y desplázate hacia él
            const element = document.getElementById(id);
            console.log('element: ', element);
            
            if (element) {
                element.scrollIntoView({ behavior: "smooth", block: "end"});
            }
        }
    });
}
/* 
// Función para cargar contenido HTML y scripts
function loadHTML(url, elementId, scriptUrl) {
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.text();
        })
        .then(data => {
            // Cargar el HTML en el elemento especificado
            document.getElementById(elementId).innerHTML = data;

            // Cargar el script asociado, si se proporciona
            if (scriptUrl) {
                const script = document.createElement('script');
                script.src = scriptUrl;
                script.type = 'application/javascript';
                script.onload = () => {
                    console.log(`${scriptUrl} cargado`);
                };
                document.body.appendChild(script);
            }
        })
        .catch(error => console.error('Hubo un problema con la petición Fetch:', error));
}


// Función para cambiar la vista y actualizar la URL
function changeView(view) {
    console.log('view: ', view);
    switch (view) {
        case 'home':
            loadHTML('view/home.html', 'main', 'js/home.js');
            // Cambiar la URL sin recargar la página
            history.pushState({ view: 'view/home.html' }, '', 'view/home.html');
            break;
        case 'productos':
            loadHTML('view/productos.html', 'main', 'js/productos.js');
            // Cambiar la URL sin recargar la página
            history.pushState({ view: 'view/productos.html' }, '', 'view/productos.html');
            break;
        default:
            loadHTML('view/home.html', 'main', 'js/home.js');
    }
} 


// Manejar la navegación hacia atrás y adelante
window.addEventListener('popstate', (event) => {
    if (event.state) {
        loadHTML(event.state.view, 'main', null); // Cargar la vista correspondiente
    } else {
        // Cargar la vista inicial si no hay estado
        loadHTML('view/home.html', 'main', 'js/home.js');
    }
});


// Cargar la vista inicial (opcional)
loadHTML('view/home.html', 'main', 'js/home.js');
*/
