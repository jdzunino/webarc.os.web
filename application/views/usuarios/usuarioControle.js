$(document).ready(function(){

     $('#formUsuario').validate({
      rules : {
            nome:{ required: true},
            rg:{ required: true},
            cpf:{ required: true},
            telefone:{ required: true},
            email:{ required: true},
            senha:{ required: true},
            rua:{ required: true},
            numero:{ required: true},
            bairro:{ required: true},
            cidade:{ required: true},
            estado:{ required: true},
            cep:{ required: true}
      },
      messages: {
            nome :{ required: 'Campo Requerido.'},
            rg:{ required: 'Campo Requerido.'},
            cpf:{ required: 'Campo Requerido.'},
            telefone:{ required: 'Campo Requerido.'},
            email:{ required: 'Campo Requerido.'},
            senha:{ required: 'Campo Requerido.'},
            rua:{ required: 'Campo Requerido.'},
            numero:{ required: 'Campo Requerido.'},
            bairro:{ required: 'Campo Requerido.'},
            cidade:{ required: 'Campo Requerido.'},
            estado:{ required: 'Campo Requerido.'},
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
