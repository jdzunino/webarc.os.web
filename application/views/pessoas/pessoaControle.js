$(document).ready(function() {

  var urlHost = window.document.referrer.substring(0, window.document.referrer.indexOf("/index.php"));

  $("#cidade").autocomplete({
    source: urlHost + "/index.php/cidades/autoCompleteCidade",
    minLength: 1,
    select: function(event, ui) {
      $("#cidade_id").val(ui.item.id);
    }
  });

  $("#cep").focusout(function() {
    //Verifica se o CEP foi informado para não chamar o serviço sem CEP informado
    if (!$("#cep").val()) {
      return;
    }
    var url = "https://viacep.com.br/ws/" + $("#cep").val() + "/json/";
    $.ajax({
      type: "GET",
      url: url,
      dataType: 'text',
      success: function(responseData) {
        var json = JSON.parse(responseData);
        $("#cidade").val(json.localidade);
        $("#bairro").val(json.bairro);
        $("#rua").val(json.logradouro);

        if (!json.localidade) {
          $("#cidade").focus();
        } else if (!json.bairro) {
          $("#bairro").focus();
        } else if (!json.logradouro) {
          $("#rua").focus();
        } else{
          $("#numero").focus();
        }
        //Busca cidade_id, busca pelo código ibge da cidade
        var codigoIbge6Digitos = parseInt(json.ibge / 10);
        url = urlHost + "/index.php/cidades/getByCodigoIbge?codigoIbge=" + codigoIbge6Digitos;
        $.ajax({
          type: "GET",
          url: url,
          dataType: 'text',
          success: function(responseData) {
            var json = JSON.parse(responseData);
            if (json.idCidade) {
              $("#cidade_id").val(json.idCidade);
            } else {}

          },
          error: function(request, status, error) {
            console.log(request.responseText);

          }
        });
      },
      error: function(request, status, error) {
        console.log(request.responseText);

      }
    });
  });

  $('#formCliente').validate({
    rules: {
      nomeCliente: {
        required: true
      },
      documento: {
        required: true
      },
      telefone: {
        required: true
      },
      celular: {},
      email: {
        required: true
      },
      rua: {
        required: true
      },
      numero: {
        required: true
      },
      bairro: {
        required: true
      },
      cidade_id: {
        required: true
      },
      cep: {
        required: true
      }
    },
    messages: {
      nomeCliente: {
        required: 'Campo Requerido.'
      },
      documento: {
        required: 'Campo Requerido.'
      },
      telefone: {
        required: 'Campo Requerido.'
      },
      celular: {},
      email: {
        required: 'Campo Requerido.'
      },
      rua: {
        required: 'Campo Requerido.'
      },
      numero: {
        required: 'Campo Requerido.'
      },
      bairro: {
        required: 'Campo Requerido.'
      },
      cidade_id: {
        required: 'Campo Requerido.'
      },
      cep: {
        required: 'Campo Requerido.'
      }

    },

    errorClass: "help-inline",
    errorElement: "span",
    highlight: function(element, errorClass, validClass) {
      $(element).parents('.control-group').addClass('error');
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).parents('.control-group').removeClass('error');
      $(element).parents('.control-group').addClass('success');
    }
  });
});
