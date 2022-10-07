/**
 *
 * @param {string} cep CEP
 * @description Busca endereço relacionado ao cep e inseres no campos indicados
 *  localization
 *  neighborhood
 *  city
 *  uf
 */
function verify_cep_professional(cep) {
    // alert(cep.length)
    if(cep.length == 9){
        // alert('teste');
        //Nova variável "cep" somente com dígitos.
        cep = cep.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep != "") {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;
        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            $("#localization").val("...");
            $("#neighborhood").val("...");
            $("#rua").val("...");
            $("#localization").val("...");
            $("#address").val("...");
            $("#bairro").val("...");
            $("#neighborhood").val("...");
            $("#cidade").val("...");
            $("#city").val("...");
            $("#uf").val("...");

            //Consulta o webservice viacep.com.br/
            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                $('input[name=postal_code]').removeClass("is-invalid");
                $('input[name=postal_code]').removeClass("is-valid");

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    $("#localization").val(dados.logradouro);
                    $("#neighborhood").val(dados.bairro);
                    $("#rua").val(dados.logradouro);
                    $("#localization").val(dados.logradouro);
                    $("#address").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#neighborhood").val(dados.bairro);
                    $("#cidade").val(dados.localidade);
                    $("#city").val(dados.localidade);
                    $("#uf").val(dados.uf);
                    $('input[name=postal_code]').addClass("is-valid");
                } //end if.
                else {
                    //CEP pesquisado não foi encontrado.
                    limpa_formulário_cep();
                    $('input[name=postal_code]').addClass("is-invalid");
                }
            });
        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            $('input[name=postal_code]').addClass("is-invalid");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
        $('input[name=postal_code]').addClass("is-invalid");
    }
    }
}

function limpa_formulário_cep() {
    // Limpa valores do formulário de cep.
    $("#localization").val("");
    $("#neighborhood").val("");
    $("#city").val("");
    $("#uf").val("");
}

/**
 *
 * @param {string} cpf CPF
 * @returns Valida o cpf cadastrado
 */
function validateCPF(cpf) {
    if(cpf.length == 14){

    $('.cpf').removeClass("is-valid");
    $('.cpf').removeClass("is-invalid");
    var strCPF = cpf.replace(/\D/g, '')
        .replace('.', '').replace('-', '');
    var Soma;
    var Resto;
    Soma = 0;
    if (strCPF == "00000000000" ||
        strCPF == "11111111111" ||
        strCPF == "22222222222" ||
        strCPF == "33333333333" ||
        strCPF == "44444444444" ||
        strCPF == "55555555555" ||
        strCPF == "66666666666" ||
        strCPF == "77777777777" ||
        strCPF == "88888888888" ||
        strCPF == "99999999999"){
            $('.cpf').addClass("is-invalid");
            $('.cpf').val('');
            alert("CPF inválido")

        }

    for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10))){
        $('.cpf').addClass("is-invalid");
        $('.cpf').val('');
        // alert("CPF inválido")

    }

    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11))){
        $('.cpf').addClass("is-invalid");
        $('.cpf').val('');
        alert("CPF inválido")

    };

    $('.cpf').addClass("is-valid");

    return true;
    }
}
function validateCPFBlur(cpf) {

    $('.cpf').removeClass("is-valid");
    $('.cpf').removeClass("is-invalid");
    var strCPF = cpf.replace(/\D/g, '')
        .replace('.', '').replace('-', '');
    var Soma;
    var Resto;
    Soma = 0;
    if (strCPF == "00000000000" ||
        strCPF == "11111111111" ||
        strCPF == "22222222222" ||
        strCPF == "33333333333" ||
        strCPF == "44444444444" ||
        strCPF == "55555555555" ||
        strCPF == "66666666666" ||
        strCPF == "77777777777" ||
        strCPF == "88888888888" ||
        strCPF == "99999999999"){
            $('.cpf').addClass("is-invalid");
            $('.cpf').val('');
            alert("CPF inválido")

        }

    for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;

    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11))){
        $('.cpf').addClass("is-invalid");
        $('.cpf').val('');
        alert("CPF inválido")

    };

    $('.cpf').addClass("is-valid");

    return true;
    }
/**
 *
 * @param {string} email email
 * @description Testa se o email já está cadastrado
 */
function searchEmail(email) {
    $.ajax({
        method: 'GET',
        url: '/api/search-user-email/' + email,
        success: function(response) {
            $('#email').removeClass("is-invalid");
            $('#email').removeClass("is-valid");
            if (response == 1) {
                $('#email').addClass("is-invalid");
                $('#email').val('');
                alert('Email já cadastrado');
            } else {
                $('#email').addClass("is-valid");
            }
        },
        error: function(response) {
            console.log("error", response);
        }
    });
}

/**
 * @param password Senha
 * @description \Valida se a senha é valida
 */
function validatePassword(password) {
    $('input[name=password]').removeClass("is-invalid");
    $('input[name=password]').removeClass("is-valid");

    var password = document.getElementById("password").value;

    if (password.length >= 8) {
        $('input[name=password]').addClass("is-valid");
    } else {
        $('input[name=password]').addClass("is-invalid");
    }
}

function validateConfirmPassword() {
    $('input[name=password-confirm]').removeClass("is-invalid");
    $('input[name=password-confirm]').removeClass("is-valid");

    var password = document.getElementById("password").value;
    var confirm = document.getElementById("password-confirm").value;

    if (password == confirm) {
        $('input[name=password-confirm]').addClass("is-valid");
    } else {
        $('input[name=password-confirm]').addClass("is-invalid");
    }
}

function validateCNPJ(cnpj) {
    $('input[id=cnpj]').removeClass("is-invalid");
    $('input[id=cnpj]').removeClass("is-valid");

    cnpj = cnpj.replace(/[^\d]+/g, '');

    if (cnpj == '') {
        //$('#cnpj-input').focus();
        $('input[id=cnpj]').addClass("is-invalid");
    }

    if (cnpj.length != 14) {
        $('#cnpj').val("");
        //$('#cnpj-input').focus();
        $('input[id=cnpj]').addClass("is-invalid");
        alert('CPNJ inválido!');
    }

    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999") {
        $('#cnpj').val("");
        //$('#cnpj-input').focus();
        $('input[id=cnpj]').addClass("is-invalid");
        alert('CPNJ inválido!');
    }

    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0, tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0)) {
        $('#cnpj').val("");
        //$('#cnpj-input').focus();
        $('input[id=cnpj]').addClass("is-invalid");
        alert('CPNJ inválido!');
    }

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1)) {
        $('#cnpj').val("");
        //$('#cnpj-input').focus();
        $('input[id=cnpj]').addClass("is-invalid");
        alert('CPNJ inválido!');
    }

    $('input[id=cnpj]').addClass("is-valid");
}

$('.load').click(function(){
    // alert('teste');
})
