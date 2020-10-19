$(document).ready(function(){
    $('#form-recuperar-clave').submit(e=>{
        let funcion='recuperar_clave';
        let cedula=$('#cedula').val();
        let correo=$('#correo').val();
        $.post('../controlador/usuario-controlador.php',{funcion,cedula,correo},(response)=>{
            console.log(response);
        })
        e.preventDefault();
    })
})
    
