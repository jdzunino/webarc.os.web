$(document).ready(function(){
    $(".money").maskMoney();
     $('#formServico').validate({
      rules :{
            nome:{ required: true},
            preco:{ required: true}
      },
      messages:{
            nome :{ required: 'Campo Requerido.'},
            preco :{ required: 'Campo Requerido.'}
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
