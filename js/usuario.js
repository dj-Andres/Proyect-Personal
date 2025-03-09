$(document).ready(function(){
    var funcion='';
    var Id_usuario=$('#Id_usuario').val();

    var edit=false;
    buscar_usuario(Id_usuario);
    function buscar_usuario(dato){
        funcion='buscar_usuario';
        $.post('../controlador/usuario-controlador.php',{dato,funcion},(response)=>{
            let nombre='';
            let apellido='';
            let edad='';
            let cedula='';
            let tipo='';
            let telefono='';
            let residencia='';
            let correo='';
            let sexo='';
            let adicional='';
            let avatar='';
            let tipo_usuario='';
            //JSON.parse convierte  el json encode del controlador y convierte a int al string del controlador//
            const usuario=JSON.parse(response);
            
            // recorremos el json//
            nombre+=`${usuario.nombre}`;
            apellido+=`${usuario.apellido}`;
            edad+=`${usuario.edad}`;
            cedula+=`${usuario.cedula}`;
            if(usuario.tipo_usuario=='root'){
             tipo+=`<h1 class="badge badge-danger">${usuario.tipo_usuario}</h1>`;
            }
            if(usuario.tipo_usuario=='tecnico'){
                tipo+=`<h1 class="badge badge-warning">${usuario.tipo_usuario}</h1>`;
            }                            
            if(usuario.tipo_usuario=='admin'){
                  tipo+=`<h1 class="badge badge-info">${usuario.tipo_usuario}</h1>`;
            }
            tipo+=`${usuario.tipo_usuario}`;                                          
            telefono+=`${usuario.telefono}`;
            residencia+=`${usuario.residencia}`;
            correo+=`${usuario.correo}`;
            sexo+=`${usuario.sexo}`;
            adicional+=`${usuario.adicional}`;
            avatar+=`${usuario.avatar}`;
            // se pasara los datos a la plantilla//
            $('#nombre').html(nombre);
            $('#apellido').html(apellido);
            $('#cedula').html(cedula);
            $('#edad').html(edad);
            $('#us_tipo').html(tipo);
            $('#telefono').html(telefono);
            $('#sexo').html(sexo);
            $('#correo').html(correo);
            $('#residencia').html(residencia);
            $('#avatar1').attr('src',usuario.avatar);
            $('#avatar2').attr('src',usuario.avatar);
            $('#avatar3').attr('src',usuario.avatar);
            $('#avatar4').attr('src',usuario.avatar);
            $('#adicioanl-use').html(adicional);
        })
    }
    $(document).on('click','.edit',(e)=>{
        funcion='capturar_datos';
        edit=true;
        $.post('../controlador/usuario-controlador.php',{funcion,Id_usuario},(response)=>{
            //para prueba de mostrar en la consola del navegador que datos nos muestra en el boton de edicion//
            //console.log(response);
            //funcion para devolver los datos a los imputs en la plantilla de eidicion de datos response"es la el json decodificado del controlador es decir los datos obtenidos de la consulta"//
            const usuario=JSON.parse(response);
            $('#telefono1').val(usuario.telefono);
            $('#recidencia').val(usuario.residencia);
            $('#email1').val(usuario.correo);
            $('#sexo1').val(usuario.sexo);
            $('#adicional1').val(usuario.adicional);
        })
    });
    $('#form-usuario').submit(e=>{
        if(edit==true){
            let telefono=$('#telefono1').val();
            let residencia=$('#recidencia').val();
            let correo=$('#email1').val();
            let sexo=$('#sexo1').val();
            let adicional=$('#adicional1').val();
            funcion='editar_usuario';
            $.post('../controlador/usuario-controlador.php',{Id_usuario,funcion,telefono,residencia,correo,sexo,adicional},(response)=>{
                    console.log(response);
                if(response=='edicion'){
                    $('#editado').hide('slow');
                    $('#editado').show(1000);
                    $('#editado').hide(2000);
                    // limpiamos la caja de texto despues que se ejecuto la actualizacion//
                    $('#form-usuario').trigger('reset');
                }
                    edit=false;
                    buscar_usuario(Id_usuario);
            })
        }else{
            $('#no-editado').hide('slow');
            $('#no-editado').show(1000);
            $('#no-editado').hide(2000);
            $('#form-usuario').trigger('reset');
        }
        e.preventDefault();
    });
    $('#form-clave').submit(e=>{
        let vieja_clave=$('#clave-vieja').val();
        let nueva_clave=$('#clave-nueva').val();

        funcion='cambiar_clave';
        $.post('../controlador/usuario-controlador.php',{funcion,Id_usuario,vieja_clave,nueva_clave},(response)=>{
            //console.log(response);
            if(response=='update'){
                $('#actualizado').hide('slow');
                $('#actualizado').show(1000);
                $('#actualizado').hide(2000);
                $('#form-clave').trigger('reset');
            }else{
                $('#no-actualizado').hide('slow');
                $('#no-actualizado').show(1000);
                $('#no-actualizado').hide(2000);
                $('#form-clave').trigger('reset');
            }
        })
        e.preventDefault();
    });
    $('#form-foto').submit(e=>{
        let formData=new FormData($('#form-foto')[0]);
        $.ajax({
            url:'../controlador/usuario-controlador.php',
            type:'POST',
            data:formData,
            cache:false,
            processData:false,
            contentType:false
        }).done(function(response){
            //console.log(response);
            const json=JSON.parse(response);
            if (json.alert=='editado') {
                $('#avatar1').attr('src',json.ruta);
                $('#update').hide('slow');
                $('#update').show(1000);
                $('#update').hide(2000);
                $('#form-foto').trigger('reset');
                buscar_usuario(Id_usuario);    
            }else{
              $('#no-update').hide('slow');
              $('#no-update').show(1000);
              $('#no-update').hide(2000);
              $('#form-foto').trigger('reset');    
            }
            
        });
        e.preventDefault();
    })
})