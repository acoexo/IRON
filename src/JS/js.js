
const formulario = document.getElementById('login');
formulario.addEventListener('click', function() {
  comprobarDatos();
});

function comprobarDatos() {
  const nombre = document.getElementById('username').value;
  const contraseña = document.getElementById('password').value;
  console.log('Nombre:', nombre);
  console.log('Contraseña:', contraseña);
  



}
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const toggleButton = document.querySelector('.toggle-password-button img');

    if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    toggleButton.src = '../../src/img/invisible.png';
    toggleButton.alt = 'Ocultar contraseña';
    } else {
    passwordInput.type = 'password';
    toggleButton.src = '../../src/img/ojo.png';
    toggleButton.alt = 'Mostrar contraseña';
    }
}


