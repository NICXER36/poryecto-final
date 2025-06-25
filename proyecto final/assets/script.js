document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const feedback = document.createElement('div');
    feedback.className = 'form-feedback';
    form.appendChild(feedback);

    // Expresión regular que solo permite letras (incluyendo acentos y ñ)
    const soloLetras = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let errores = [];

        // Validación del nombre
        const nombre = document.getElementById('fname').value.trim();
        if (!soloLetras.test(nombre)) {
            errores.push('El nombre solo puede contener letras');
        }

        // Validación del apellido
        const apellido = document.getElementById('lname').value.trim();
        if (!soloLetras.test(apellido)) {
            errores.push('El apellido solo puede contener letras');
        }

        // Validación del email
        const email = document.getElementById('email').value.trim();
        if (!email.includes('@') || !email.includes('.')) {
            errores.push('Ingresa un email válido');
        }

        // Validación del mensaje
        const mensaje = document.getElementById('subject').value.trim();
        if (mensaje.length < 10) {
            errores.push('El mensaje debe tener al menos 10 caracteres');
        }

        if (errores.length === 0) {
            feedback.textContent = '¡Mensaje enviado con éxito!';
            feedback.className = 'form-feedback success';
            form.reset();
            
            setTimeout(() => {
                feedback.textContent = '';
                feedback.className = 'form-feedback';
            }, 3000);
        } else {
            feedback.textContent = errores.join('\n');
            feedback.className = 'form-feedback error';
        }
    });

    // Validación en tiempo real para nombre y apellido
    const nombreInput = document.getElementById('fname');
    const apellidoInput = document.getElementById('lname');

    function validarLetras(input) {
        input.value = input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
    }

    nombreInput.addEventListener('input', function() {
        validarLetras(this);
    });

    apellidoInput.addEventListener('input', function() {
        validarLetras(this);
    });
}); 