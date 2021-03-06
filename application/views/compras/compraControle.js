$(document).ready(function(){

    var urlHost = window.document.referrer.substring(0, window.document.referrer.indexOf("/index.php"));

     $('#recebido').click(function(event) {
        var flag = $(this).is(':checked');
        if(flag == true){
          $('#divRecebimento').show();
        }
        else{
          $('#divRecebimento').hide();
        }
     });

     $(document).on('click', '#btn-faturar', function(event) {
       event.preventDefault();
         valor = $('#total-venda').val();
         valor = valor.replace(',', '' );
         $('#valor').val(valor);
     });

     $("#produto").autocomplete({
            source: urlHost + "/index.php/produtos/autoCompleteProduto",
            minLength: 2,
            select: function( event, ui ) {
                 $("#idProduto").val(ui.item.id);
                 $("#estoque").val(ui.item.estoque);
                 $("#preco").val(ui.item.precoCompra);
                 $("#preco").focus();
            }
      });



      $("#fornecedor").autocomplete({
            source: urlHost + "/index.php/pessoas/autoCompleteFornecedor",
            minLength: 2,
            select: function( event, ui ) {
                 $("#fornecedor_id").val(ui.item.id);
            }
      });

      $("#tecnico").autocomplete({
            source: urlHost + "/index.php/usuarios/autoCompleteUsuario",
            minLength: 2,
            select: function( event, ui ) {
                 $("#usuarios_id").val(ui.item.id);
            }
      });



      $("#formCompras").validate({
          rules:{
             fornecedor: {required:true},
             tecnico: {required:true},
             dataCompra: {required:true}
          },
          messages:{
             fornecedor: {required: 'Campo Requerido.'},
             tecnico: {required: 'Campo Requerido.'},
             dataCompra: {required: 'Campo Requerido.'}
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

      $("#formProdutos").validate({
          rules:{
             quantidade: {required:true}
          },
          messages:{
             quantidade: {required: 'Insira a quantidade'}
          },
          submitHandler: function( form ){
             var quantidade = parseInt($("#quantidade").val());
             var estoque = parseInt($("#estoque").val());
                 var dados = $( form ).serialize();
                $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: urlHost + "/index.php/compras/adicionarProduto",
                  data: dados,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divProdutos" ).load(window.location+" #divProdutos" );
                        $("#quantidade").val('');
                        $("#preco").val('');
                        $("#produto").val('').focus();
                    }
                    else{
                        alert('Ocorreu um erro ao tentar adicionar produto.');
                    }
                  }
                  });

                  return false;

             }

       });

       $("#formParcelas").validate({
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
            },
            submitHandler: function( form ){
              var dados = $( form ).serialize();
              $('#btn-cancelar-faturar').trigger('click');
              $.ajax({
                type: "POST",
                url: urlHost + "/index.php/compras/faturar",
                data: dados,
                dataType: 'json',
                success: function(data)
                {
                  if(data.result == true){

                      window.location.reload(true);
                  }
                  else{
                      alert('Ocorreu um erro ao tentar faturar compra.');
                      $('#progress-fatura').hide();
                  }
                }
                });

                return false;
            }
       });

       $(document).on('click', 'a', function(event) {
            var idProduto = $(this).attr('idAcao');
            var quantidade = $(this).attr('quantAcao');
            var produto = $(this).attr('prodAcao');
            if((idProduto % 1) == 0){
                $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                  type: "POST",
                  url: urlHost + "/index.php/compras/excluirProduto",
                  data: "idProduto="+idProduto+"&quantidade="+quantidade+"&produto="+produto,
                  dataType: 'json',
                  success: function(data)
                  {
                    if(data.result == true){
                        $("#divProdutos" ).load(window.location+" #divProdutos" );
                    }
                    else{
                        alert('Ocorreu um erro ao tentar excluir produto.');
                    }
                  }
                  });
                  return false;
            }

       });

       $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
});
