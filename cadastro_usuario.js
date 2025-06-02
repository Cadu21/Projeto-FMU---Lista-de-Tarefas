
$(document).ready(function () {
  function mostrarErro(idCampo, mensagem) {
    $('#erro-' + idCampo).text(mensagem);
  }

  function limparErro(idCampo) {
    $('#erro-' + idCampo).text('');
  }

  function validarCampo(idCampo, validacao, mensagem) {
    const valor = $('#' + idCampo).val();
    if (!validacao(valor)) {
      mostrarErro(idCampo, mensagem);
      return false;
    } else {
      limparErro(idCampo);
      return true;
    }
  }

  $('#senha').on('focus', function () {
    $('.regras-senha').slideDown();
  });

  $('#senha').on('blur', function () {
    $('.regras-senha').slideUp();
  });

  $('#cpf').on('input', function () {
    const cpf = $(this).val().replace(/\D/g, '');
    validarCampo('cpf', v => v.length === 11, 'CPF inválido. Deve conter 11 dígitos.');
  });

  $('#cns').on('input', function () {
    const cns = $(this).val().replace(/\D/g, '');
    validarCampo('cns', v => v.length === 15, 'CNS inválido. Deve conter 15 dígitos.');
  });

  $('#senha').on('input', function () {
    const senha = $(this).val();
    const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/;
    validarCampo('senha', v => regex.test(v), 'A senha deve ter entre 8 e 20 caracteres, com pelo menos 1 letra maiúscula, 1 número e 1 caractere especial.');
  });

  $('#confirmar-senha').on('input', function () {
    const senha = $('#senha').val();
    const confirmacao = $(this).val();
    validarCampo('confirmar-senha', v => v === senha, 'As senhas não coincidem.');
  });

  $('#cadastro-form').on('submit', function (e) {
    //e.preventDefault();
    let valido = true;

    const cpf = $('#cpf').val().replace(/\D/g, '');
    const cns = $('#cns').val().replace(/\D/g, '');
    const senha = $('#senha').val();
    const confirmarSenha = $('#confirmar-senha').val();
    const regexSenha = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/;

    if (cpf.length !== 11) {
      mostrarErro('cpf', 'CPF inválido. Deve conter 11 dígitos.');
      valido = false;
    }

    if (cns.length !== 15) {
      mostrarErro('cns', 'CNS inválido. Deve conter 15 dígitos.');
      valido = false;
    }

    if (!regexSenha.test(senha)) {
      mostrarErro('senha', 'A senha deve ter entre 8 e 20 caracteres, com pelo menos 1 letra maiúscula, 1 número e 1 caractere especial.');
      valido = false;
    }

    if (senha !== confirmarSenha) {
      mostrarErro('confirmar-senha', 'As senhas não coincidem.');
      valido = false;
    }

  });

  $('#cep').on('blur', function () {
    const cep = $(this).val().replace(/\D/g, '');
    if (cep.length !== 8) {
      mostrarErro('cep', 'CEP inválido. Deve conter 8 dígitos.');
      return;
    }

    $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function (dados) {
      if (dados.erro) {
        mostrarErro('cep', 'CEP não encontrado.');
      } else {
        $('#logradouro').val(dados.logradouro);
        $('#bairro').val(dados.bairro);
        $('#cidade').val(dados.localidade);
        $('#estado').val(dados.uf);
        $('#complemento-container').slideDown();
        limparErro('cep');
      }
    }).fail(function () {
      mostrarErro('cep', 'Erro ao consultar o CEP.');
    });
  });
});
