$(document).ready(function(){
    $('#aviso1').hide();
    $('#aviso2').hide();
    $('#form-recuperar-clave').submit(e=>{
        
        let cedula =$('#cedula').val();
        let correo =$('#correo').val();

        if(cedula=='' || correo==''){
            $('#aviso2').show();
            $('#aviso2').text('Llenar todos los campos solicitados');
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
                            $('#aviso1').show();
                            $('#aviso1').text('Se establecio correctamente la contraseña');
                            $('##form-recuperar-clave').trigger('reset');
                        }else{
                            $('#aviso2').show();
                            $('#aviso2').text('No se pudo reestablecer la contraseña');
                            $('##form-recuperar-clave').trigger('reset');
                        }
                    });
                }else{
                    $('#aviso1').hide();
                    $('#aviso2').hide();
                    $('#aviso2').show();
                    $('#aviso2').text('La cedula o el correo no se encuentran asociados al sistema');
                }
            });
        }

        e.preventDefault();
    });
});
    
