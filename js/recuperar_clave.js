$(document).ready(function(){
    $('#aviso1').hide();
    $('#aviso2').hide();
    $('#form-recuperar-clave').submit(e=>{
        mostrarLoader('recuperar_clave');

        let cedula =$('#cedula').val();
        let correo =$('#correo').val();

        if(cedula=='' || correo==''){
            $('#aviso2').show();
            $('#aviso2').text('Llenar todos los campos solicitados');
            cerrarLoader('');
        }else{
            $('#aviso2').hide();
            let funcion="recuperar_clave";
            $.post('../controlador/controlador-recuperar.php',{funcion,cedula,correo},(response)=>{
                console.log(response);
                if(response=='encontrado'){
                    let funcion="generar";
                    $('#aviso2').hide();
                    $.post('../controlador/controlador-recuperar.php',{funcion,cedula,correo},(response2)=>{
                        console.log(response2);
                        $('#aviso1').hide();
                        $('#aviso2').hide();
                        if(response2=='reemplazado'){
                            cerrarLoader('exito_envio');        
                            $('#aviso1').show();
                            $('#aviso1').text('Se establecio correctamente la contraseña');
                            $('##form-recuperar-clave').trigger('reset');
                        }else{
                            cerrarLoader('error_envio');
                            $('#aviso2').show();
                            $('#aviso2').text('No se pudo reestablecer la contraseña');
                            $('##form-recuperar-clave').trigger('reset');
                        }
                    });
                }else{
                    cerrarLoader('error_usuario');
                    $('#aviso1').hide();
                    $('#aviso2').hide();
                    $('#aviso2').show();
                    $('#aviso2').text('La cedula o el correo no se encuentran asociados al sistema');
                }
            });
        }

        e.preventDefault();
    });
    function mostrarLoader(mensaje){
        var texto=null;
        var mostrar=false;

        switch (mensaje) {
            case 'recuperar_clave':
                texto='Se esta enviando el correo por favor espere...';
                mostrar=true;
                break;
        }
        if(mostrar){
            Swal.fire({
                title: 'Enviando correo',
                text: texto,
                showConfirmation:false
            })
        }
    }
    function cerrarLoader(mensaje){
        var tipo=null;
        var texto=null;
        var mostrar=false;

        switch (mensaje) {
            case 'exito_envio':
                tipo='success';
                texto='El correo fue enviado correctamente!';
                mostrar=true;
            break;

            case 'error_envio':
                tipo='error';
                texto='El correo no pudo enviarse Intente nuevamente!';
                mostrar=true;
            break;

            case 'error_usuario':
                tipo='error';
                texto='El usuario pertenenciente sus datos no fueron encontraron';
                mostrar=true;
            break;

            default:
                Swal.close();    
            break;
        }

        if(mostrar){
            Swal.fire({
                position:'center',
                icon: tipo,
                text: texto,
                showConfirmation:false
            })
        }
    }
});
    
