// Función para abrir el modal y cargar la información

function openEditModal(type, user) {
  // Obtén referencias a los campos dentro del modal
  document.getElementById('nombre').value = user[0] || ''; // Agrega un valor por defecto si no hay dato
  document.getElementById('apellidos').value = user[1] || '';
  document.getElementById('email').value = user[2] || '';
  document.getElementById('tipo_cliente').value = user[3] || 0;
  document.getElementById('id_usuario').value = user[4] || '';

  document.getElementById('tipo_ejecucion').value = type; 

  // Inicializa y muestra el modal usando Bootstrap
  const editModal = new bootstrap.Modal(document.getElementById('createUser'));
  editModal.show();
  }
  
  // Función para guardar los cambios (opcional)
  function saveChanges() {
    editModal.hide();
  }