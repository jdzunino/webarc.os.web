$(document).ready(function(){

  $("#cidade").autocomplete({
    source: window.document.referrer+"/autoCompleteCidade",
    minLength: 1,
    select: function( event, ui ) {
      $("#cidade_id").val(ui.item.id);
    }
  });

  $("#cep").focusout(function(){
    if(!$("#cep").val()){
      return;
    }
    var url = "https://viacep.com.br/ws/"+$("#cep").val()+"/json/";
    $.ajax({
      type: "GET",
      url: url,
      dataType: 'text',
      success: function (responseData) {
        var json = JSON.parse(responseData);
        $("#rua").val(json.logradouro);
        $("#bairro").val(json.bairro);

        $("#cidade").val(json.localidade);

        //Busca cidade_id, busca pelo código ibge da cidade
        var codigoIbge6Digitos = parseInt(json.ibge / 10);
        $("#cidade").focus();

        var url_atual = window.document.referrer;
        url = url_atual + "/../cidades/getByCodigoIbge?codigoIbge="+codigoIbge6Digitos;
        $.ajax({
          type: "GET",
          url: url,
          dataType: 'text',
          success: function (responseData) {
            var json = JSON.parse(responseData);

            $("#cidade_id").val(json.idCidade);
            $("#numero").focus();
          },
          error: function (request, status, error) {
            console.log(request.responseText);

          }
        });
      },
      error: function (request, status, error) {
        console.log(request.responseText);

      }
    });
  });

  $('#formCliente').validate({
    rules :{
      nomeCliente:{ required: true},
      documento:{ required: true},
      telefone:{ required: true},
      celular:{},
      email:{ required: true},
      rua:{ required: true},
      numero:{ required: true},
      bairro:{ required: true},
      cidade_id:{ required: true},
      cep:{ required: true}
    },
    messages:{
      nomeCliente :{ required: 'Campo Requerido.'},
      documento :{ required: 'Campo Requerido.'},
      telefone:{ required: 'Campo Requerido.'},
      celular:{},
      email:{ required: 'Campo Requerido.'},
      rua:{ required: 'Campo Requerido.'},
      numero:{ required: 'Campo Requerido.'},
      bairro:{ required: 'Campo Requerido.'},
      cidade_id:{ required: 'Campo Requerido.'},
      cep:{ required: 'Campo Requerido.'}

    },

    errorClass: "help-inline",
    errorElement: "span",
    highlight:function(element, errorClass, validClass) {
      $(element).parents('.control-group').addClass('error');
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).parents('.control-group').removeClass('error');
      $(element).parents('.control-group').addClass('success');
    }
  });
});
