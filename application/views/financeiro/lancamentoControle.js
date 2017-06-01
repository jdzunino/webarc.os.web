jQuery(document).ready(function($) {

  var urlHost = window.document.referrer.substring(0, window.document.referrer.indexOf("/index.php"));

  $(".money").maskMoney();

  $('#pago').click(function(event) {
    var flag = $(this).is(':checked');
    if(flag == true){
      $('#divPagamento').show();
    }
    else{
      $('#divPagamento').hide();
    }
  });


  $('#recebido').click(function(event) {
    var flag = $(this).is(':checked');
    if(flag == true){
      $('#divRecebimento').show();
    }
    else{
      $('#divRecebimento').hide();
    }
  });

  $('#pagoEditar').click(function(event) {
    var flag = $(this).is(':checked');
    if(flag == true){
      $('#divPagamentoEditar').show();
    }
    else{
      $('#divPagamentoEditar').hide();
    }
  });

  $("#cliente").autocomplete({
        source: urlHost + "/index.php/pessoas/autoCompleteCliente",
        minLength: 2,
        select: function( event, ui ) {
             $("#cliente_id").val(ui.item.id);
        }
  });

  $("#fornecedor").autocomplete({
        source: urlHost + "/index.php/pessoas/autoCompleteFornecedor",
        minLength: 2,
        select: function( event, ui ) {
             $("#fornecedor_id").val(ui.item.id);
        }
  });

  $("#formReceita").validate({
        rules:{
           descricao: {required:true},
           cliente: {required:true},
           valor: {required:true},
           vencimento: {required:true}

        },
        messages:{
           descricao: {required: 'Campo Requerido.'},
           cliente: {required: 'Campo Requerido.'},
           valor: {required: 'Campo Requerido.'},
           vencimento: {required: 'Campo Requerido.'}
        }
  });



  $("#formDespesa").validate({
        rules:{
           descricao: {required:true},
           fornecedor: {required:true},
           valor: {required:true},
           vencimento: {required:true}

        },
        messages:{
           descricao: {required: 'Campo Requerido.'},
           fornecedor: {required: 'Campo Requerido.'},
           valor: {required: 'Campo Requerido.'},
           vencimento: {required: 'Campo Requerido.'}
        }
      });


  $(document).on('click', '.excluir', function(event) {
    $("#idExcluir").val($(this).attr('idLancamento'));
  });


  $(document).on('click', '.editar', function(event) {
    $("#idEditar").val($(this).attr('idLancamento'));
    $("#descricaoEditar").val($(this).attr('descricao'));
    $("#fornecedorEditar").val($(this).attr('cliente'));
    $("#valorEditar").val($(this).attr('valor'));
    $("#vencimentoEditar").val($(this).attr('vencimento'));
    $("#pagamentoEditar").val($(this).attr('pagamento'));
    $("#formaPgtoEditar").val($(this).attr('formaPgto'));
    $("#tipoEditar").val($(this).attr('tipo'));
    $("#urlAtualEditar").val($(location).attr('href'));
    var baixado = $(this).attr('baixado');
    if(baixado == 1){
      $("#pagoEditar").attr('checked', true);
      $("#divPagamentoEditar").show();
    }
    else{
      $("#pagoEditar").attr('checked', false);
      $("#divPagamentoEditar").hide();
    }


  });

  $(document).on('click', '#btnExcluir', function(event) {
      var id = $("#idExcluir").val();

      $.ajax({
        type: "POST",
        url: urlHost + "/index.php/financeiro/excluirLancamento",
        data: "id="+id,
        dataType: 'json',
        success: function(data)
        {
          if(data.result == true){
              $("#btnCancelExcluir").trigger('click');
              $("#divLancamentos").html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
              $("#divLancamentos").load( $(location).attr('href')+" #divLancamentos" );

          }
          else{
              $("#btnCancelExcluir").trigger('click');
              alert('Ocorreu um erro ao tentar excluir produto.');
          }
        }
      });
      return false;
  });

  $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });

});
