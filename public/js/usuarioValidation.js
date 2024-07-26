$(document).ready(function () {
    $("#userForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            },
            nome:{
                required: true,
            },
            access_level:{
                required: true,
            }
        },
        messages: {
            email: {
                required: "Por favor, insira seu email",
                email: "Por favor, insira um endereço de email válido"
            },
            password: {
                required: "Por favor, insira sua senha",
                minlength: "Sua senha deve ter pelo menos 5 caracteres"
            }
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element); 
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
