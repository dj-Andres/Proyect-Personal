$(document).ready(()=>{
    $("#form-empresa").submit((e)=>{
        e.preventDefault();
        let funcion = "crear";
        let name = $("#nombre").val();
        let ruc_number = $("#ruc").val();
        let phone = $("#telefono").val();
        let address = $("#direccion").val();
        let email = $("#email").val();

        $.post('../controlador/controlador-empresa.php',{funcion,name,ruc_number,phone,email,address},(response)=>{
            if(response=='crear'){
                $('#nueva-empresa').hide('slow');
                $('#nueva-empresa').show(1000);
                $('#nueva-empresa').hide(2000);
                $('#form-empresa').trigger('reset');
                //buscar_laboratorio();
            }
            if(response=='nocrear'){
                $('#nocrear-empresa').hide('slow');
                $('#nocrear-empresa').show(1000);
                $('#nocrear-empresa').hide(2000);
                $('#form-empresa').trigger('reset');
           }
        });
    });
});