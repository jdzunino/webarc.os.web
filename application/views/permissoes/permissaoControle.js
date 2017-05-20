$(document).ready(function(){

$("#marcarTodos").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});


$("#formPermissao").validate({
    rules :{
        nome: {required: true}
    },
    messages:{
        nome: {required: 'Campo obrigatório'}
    }
});

});
