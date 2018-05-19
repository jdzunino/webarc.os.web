$(document).ready(function(){
    $(".money").maskMoney();

    $('#formProduto').validate({
        rules :{
              descricao: { required: true},
              unidade: { required: true},
              precoCompra: { required: true},
              precoVenda: { required: true},
              estoque: { required: true},
              estoqueMinimo: { required: true},
              codigoGtin: { required: true}
        },
        messages:{
              descricao: { required: 'Campo Requerido.'},
              unidade: {required: 'Campo Requerido.'},
              precoCompra: { required: 'Campo Requerido.'},
              precoVenda: { required: 'Campo Requerido.'},
              estoque: { required: 'Campo Requerido.'},
              estoqueMinimo: { required: 'Campo Requerido.'},
              codigoGtin: { required: 'Campo Requerido.'}
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
