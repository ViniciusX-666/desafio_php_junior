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
    }

    $("input").blur(function () {
        validarCampo($(this));
    });

    

});
