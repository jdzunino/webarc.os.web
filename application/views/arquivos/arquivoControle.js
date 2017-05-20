$(document).ready(function(){

     $('#formArquivo').validate({
       rules :{
             nome:{ required: true},
             userfile:{ required: true}
       },
       messages:{
             nome :{ required: 'Campo Requerido.'},
             userfile :{ required: 'Campo Requerido.'}
       },

      errorClass: "help-inline",
      errorElement: "span",
      highlight:function(element, errorClass, validClass) {
          $(element).parents('.control-group').addClass('error');
          $(element).parents('.control-group').removeClass('success');
      },
      unhighlight: function(element, errorClass, validClass) {
          $(element).parents('.control-group').removeClass('error');
          $(element).parents('.control-group').addClass('success');
      }
     });


     $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
});
