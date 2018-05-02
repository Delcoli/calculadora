/***********************************************************************
 Gravar Usuário
 **********************************************************************/
$('#gravar-usuario').click(function () {

    function habilitarErro(erro) {
        $('#erro').show(500);
        $('#erro').delay(4000);
        $('#erro').animate({
            height: 'toggle'
        }, 500, function () {
        });

        $('#erro').text(erro);
    }

    function habilitarSucesso(erro) {
        $('#sucesso').show(500);
        $('#sucesso').delay(4000);
        $('#sucesso').animate({
            height: 'toggle'
        }, 500, function () {
            // Animation complete.
        });
        $('#sucesso').text(erro);
    }

    var compararEmail = /^([a-z0-9_.-]+)@([0-9a-z.-]+).([a-z.]{2,6})$/; // Syntax para comparar email

    var email = $('#email').val().toLowerCase(); // valor do campo de email
    var senha = $('#senha').val().toLowerCase(); // valor do campo de senha
    var nome = $('#nome').val().toLowerCase(); // valor do campo de nome

    if (email == "" || email == " " || !compararEmail.test(email)) {
        habilitarErro('Email informado está inválido');
        return false;
    }

    if (senha == "" || senha == " ") {
        habilitarErro('Senha informada está inválida');
        return false;
    }

    if (nome == "" || nome == " ") {
        nome = email;
    }

    $.ajax({
        type: 'POST',
        url: '/api/usuario/salvar',

        data: {
            nome: nome,
            email: email,
            senha: senha
        },
        error: function (request, erro) {
            if (request.status == 403) {
                habilitarErro(request.responseText);
            } else {
                habilitarErro();
            }
        },
        success: function (response) {
            habilitarSucesso();
            email = $('#email').val(''); // limpar o campo de email
            senha = $('#senha').val(''); // limpar o campo de senha
            nome = $('#nome').val(''); // limpar o campo de nome

        }
    });

    return false;
});

/***********************************************************************
 Realizar login
 **********************************************************************/
$('#logar').click(function () {

    function habilitarErro(erro) {
        $('#erro').show(500);
        $('#erro').delay(4000);
        $('#erro').animate({
            height: 'toggle'
        }, 500, function () {
        });

        $('#erro').text(erro);
    }

    var compararEmail = /^([a-z0-9_.-]+)@([0-9a-z.-]+).([a-z.]{2,6})$/; // Syntax para comparar email

    var email = $('#email').val().toLowerCase(); // valor do campo de email
    var senha = $('#senha').val().toLowerCase(); // valor do campo de senha

    if (email == "" || email == " " || !compararEmail.test(email)) {
        habilitarErro('Email informado está inválido');
        return false;
    }

    if (senha == "" || senha == " ") {
        habilitarErro('Senha informada está inválida');
        return false;
    }

    $.ajax({
        type: 'POST',
        url: '/api/usuario/logar',

        data: {
            email: email,
            senha: senha
        },
        error: function (request, erro) {
            if (request.status == 403) {
                habilitarErro(request.responseText);
            } else {
                habilitarErro();
            }
        },
        success: function (response) {
            document.cookie = "logado=" + email;
            window.location = "calculadora.html";
        }
    });

    return false;
});

/***********************************************************************
 funcoes botão calculadora
 **********************************************************************/
function atribuirValor(atribuir) {
    var valor = $('#expressao').val().toLowerCase();
    valor = valor + atribuir;
    $('#expressao').val(valor);
}

$('#zero').click(function () {
    atribuirValor('0');
});
$('#um').click(function () {
    atribuirValor('1');
});
$('#dois').click(function () {
    atribuirValor('2');
});
$('#tres').click(function () {
    atribuirValor('3');
});
$('#quatro').click(function () {
    atribuirValor('4');
});
$('#cinco').click(function () {
    atribuirValor('5');
});
$('#seis').click(function () {
    atribuirValor('6');
});
$('#sete').click(function () {
    atribuirValor('7');
});
$('#oito').click(function () {
    atribuirValor('8');
});
$('#nove').click(function () {
    atribuirValor('9');
});
$('#ponto').click(function () {
    atribuirValor('.');
});
$('#percentual').click(function () {
    atribuirValor('%');
});
$('#soma').click(function () {
    atribuirValor('+');
});
$('#menos').click(function () {
    atribuirValor('-');
});
$('#multiplicacao').click(function () {
    atribuirValor('*');
});
$('#divisao').click(function () {
    atribuirValor('/');
});
$('#raiz-quadrada').click(function () {
    atribuirValor('√¯');
});
$('#parentes-aberto').click(function () {
    atribuirValor('(');
});
$('#parentes-fechado').click(function () {
    atribuirValor(')');
});
$('#limpar').click(function () {
    $('#expressao').val('');
    $('#resultado').val('');
});
$('#remover').click(function () {
    var valor = $('#expressao').val();
    valor = valor.substr(0, valor.length - 1);
    $('#expressao').val(valor);
});

function getCookie(id) {
    var listaCookie = document.cookie.split(';');
    var cookie = null;

    for (var i = 0; i < listaCookie.length; i++) {
        cookie = listaCookie[i].split('=');
        if (cookie[0] == id) {
            return cookie[1];
        }
        ;
    }

    return null;
}

$('#igual').click(function () {
    var expressao = $('#expressao').val().toLowerCase(); // valor da expressao

    if (expressao == "" || expressao == " ") {
        $('#resultado').val('Expressão não informada');
        return false;
    }

    expressao = expressao.replace('√¯', '@');
    var email = getCookie('logado');

    $.ajax({
        type: 'POST',
        url: '/api/calculadora/calcular',

        data: {
            expressao: expressao,
            email: email
        },
        error: function (request, erro) {
            if (request.status == 403) {
                $('#resultado').val(request.responseText);
            } else {
                $('#resultado').val('Erro ao calcular');
            }
        },
        success: function (response) {
            $('#resultado').val(response);
        }
    });

    return false;
});

$('#filtrar-operacoes').click(function () {
    function habilitarErro(erro) {
        $('#erro').show(500);
        $('#erro').delay(4000);
        $('#erro').animate({
            height: 'toggle'
        }, 500, function () {
        });

        $('#erro').text(erro);
    }

    $('#dados').text('');

    var dataInicial = $('#dataInicial').val().toLowerCase(); // valor da data inicial
    var dataFinal = $('#dataFinal').val().toLowerCase(); // valor da data inicial
    if (dataInicial != '' || dataFinal != '') {
        if (dataInicial == '') {
            habilitarErro('Informe a data inicial ou limpe a data final');
            return false;
        }

        if (dataFinal == '') {
            habilitarErro('Informe a data final ou limpe a data inicial');
            return false;
        }

        if (dataInicial > dataFinal) {
            habilitarErro('A data inicial não pode ser maior que a data final');
            return false;
        }
    }


    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/api/relatorio/lista',
        data: {
            dataInicial: dataInicial,
            dataFinal: dataFinal
        },
        error: function (request, erro) {
            if (request.status == 403) {
                habilitarErro(request.responseText)
            } else {
                habilitarErro('Erro ao listar dados');
            }
        },
        success: function (response) {
            for (var i = 0; response.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#dados').append('<tr>' +
                    '<td class="coluna-operacao">' + response[i].dataFormatada + '</td>' +
                    '<td>' + response[i].operacao + '</td>' +
                    '<td class="coluna-resultado">' + response[i].resultado + '</td>' +
                    '<td>' + response[i].usuario.nome + '</td>' +
                    '</tr>');
            }
        }
    });

    return false;
})
;
