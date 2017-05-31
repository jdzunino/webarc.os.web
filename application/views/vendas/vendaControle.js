$(document).ready(function(){

    var urlHost = window.document.referrer.substring(0, window.document.referrer.indexOf("/index.php"));

    $(".money").maskMoney();

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
                $("#preco").val(ui.item.precoVenda);
                $("#preco").focus();
           }
     });



     $("#cliente").autocomplete({
           source: urlHost + "/index.php/pessoas/autoCompleteCliente",
           minLength: 2,
           select: function( event, ui ) {
                $("#clientes_id").val(ui.item.id);
           }
     });

     $("#tecnico").autocomplete({
           source: urlHost + "/index.php/usuarios/autoCompleteUsuario",
           minLength: 2,
           select: function( event, ui ) {
                $("#usuarios_id").val(ui.item.id);
           }
     });

     $("#formVendas").validate({
         rules:{
            cliente: {required:true},
            tecnico: {required:true},
            dataVenda: {required:true}
         },
         messages:{
            cliente: {required: 'Campo Requerido.'},
            tecnico: {required: 'Campo Requerido.'},
            dataVenda: {required: 'Campo Requerido.'}
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
            if(estoque < quantidade){
               alert('Você não possui estoque suficiente.');
            }
            else{
                var dados = $( form ).serialize();
               $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
               $.ajax({
                 type: "POST",
                 url: urlHost + "/index.php/vendas/adicionarProduto",
                 data: dados,
                 dataType: 'json',
                 success: function(data)
                 {
                   if(data.result == true){
                       $("#divProdutos" ).load(window.document.documentURI+" #divProdutos" );
                       $("#preco").val('');
                       $("#quantidade").val('');
                       $("#produto").val('').focus();
                   }
                   else{
                       alert('Ocorreu um erro ao tentar adicionar produto.');
                   }
                 }
                 });

                 return false;
               }

            }

      });

      $("#formFaturar").validate({
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
           },
           submitHandler: function( form ){
             var dados = $( form ).serialize();
             $('#btn-cancelar-faturar').trigger('click');
             $.ajax({
               type: "POST",
               url: urlHost + "/index.php/vendas/faturar",
               data: dados,
               dataType: 'json',
               success: function(data)
               {
                 if(data.result == true){

                     window.location.reload(true);
                 }
                 else{
                     alert('Ocorreu um erro ao tentar faturar venda.');
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
                 url: urlHost + "/index.php/vendas/excluirProduto",
                 data: "idProduto="+idProduto+"&quantidade="+quantidade+"&produto="+produto,
                 dataType: 'json',
                 success: function(data)
                 {
                   if(data.result == true){
                       $( "#divProdutos" ).load(window.document.documentURI+" #divProdutos" );
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
