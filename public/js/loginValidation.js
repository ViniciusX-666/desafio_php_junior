$(document).ready(function () {
    function validarCampo(campo) {
        if (campo.val() === '') {
            campo.css('outline', '2px solid red');
            campo.siblings('.error-message').remove(); 
            campo.after('<span class="error-message" style="color: red; font-size: 0.875em;">Campo obrigatório</span>');
        } else {
            campo.css('outline', 'none');
            campo.siblings('.error-message').remove();
        }
        validarTodosCampos();
    }

    function validarTodosCampos() {
        let camposValidos = true;
        $("input").each(function() {
            if ($(this).val() === '') {
                camposValidos = false;
                return false;
            }
        });
        $("#submit").prop('disabled', !camposValidos);
    }

    $("input").blur(function () {
        validarCampo($(this));
    });

    
});