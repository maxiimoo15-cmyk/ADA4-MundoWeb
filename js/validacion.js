
const formulario = document.getElementById("formulario-contacto");

if (formulario) {
    formulario.addEventListener("submit", function (evento) {

        const nombre = document.getElementById("nombre");
        const correo = document.getElementById("correo");
        const tema = document.getElementById("tema");
        const mensaje = document.getElementById("mensaje");
        const acepto = document.getElementById("acepto");
        const resultado = document.getElementById("resultado-formulario");

        const recomendacion = document.querySelector(
            'input[name="recomendacion"]:checked'
        );

        const errores = {
            nombre: document.getElementById("error-nombre"),
            correo: document.getElementById("error-correo"),
            tema: document.getElementById("error-tema"),
            mensaje: document.getElementById("error-mensaje"),
            recomendacion: document.getElementById("error-recomendacion"),
            acepto: document.getElementById("error-acepto")
        };

        // Limpiar mensajes anteriores.
        Object.values(errores).forEach(function (elemento) {
            elemento.textContent = "";
        });

        resultado.textContent = "";
        resultado.className = "";

        let formularioValido = true;

        // Validar nombre.
        if (nombre.value.trim().length < 3) {
            errores.nombre.textContent =
                "Escribe un nombre de al menos 3 caracteres.";
            formularioValido = false;
        }

        // Validar correo.
        if (!correo.validity.valid || correo.value.trim() === "") {
            errores.correo.textContent =
                "Escribe un correo electrónico válido.";
            formularioValido = false;
        }

        // Validar tema.
        if (tema.value === "") {
            errores.tema.textContent =
                "Selecciona un tema de interés.";
            formularioValido = false;
        }

        // Validar comentario.
        if (mensaje.value.trim().length < 10) {
            errores.mensaje.textContent =
                "El comentario debe tener al menos 10 caracteres.";
            formularioValido = false;
        }

        // Validar recomendación.
        if (!recomendacion) {
            errores.recomendacion.textContent =
                "Selecciona Sí o No.";
            formularioValido = false;
        }

        // Validar confirmación.
        if (!acepto.checked) {
            errores.acepto.textContent =
                "Debes marcar la casilla de confirmación.";
            formularioValido = false;
        }

        // Mostrar resultado.
        if (!formularioValido) {
            evento.preventDefault();

            resultado.textContent =
                "Revisa los campos marcados antes de continuar.";
            resultado.className = "mensaje-error";

        } else {
            resultado.textContent =
                "Datos correctos. Enviando información al servidor...";
            resultado.className = "mensaje-exito";

            // El formulario se enviará normalmente a PHP.
            // No utilizar formulario.reset() aquí.
        }
    });
}
