$(document).ready(function(){
    var tipo_usuario=$('#tipo_usuario').val();
    //console.log(tipo_usuario);
    if(tipo_usuario==2){
        $('#boton-crear').hide();
    }
    buscar_datos();
    var funcion;
    function buscar_datos(consulta){
        funcion='buscar_usuarios_adm';
        $.post('../controlador/usuario-controlador.php',{funcion,consulta},(response)=>{
            const usuarios=JSON.parse(response);
            let templete='';
            usuarios.forEach(usuario => {
                templete+=`
                <div usuarioid="${usuario.cedula}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">`;
                    if(usuario.tipo_usuario==3){
                        templete+=`<h1 class="badge badge-danger">${usuario.tipo}</h1>`;
                    }
                    if(usuario.tipo_usuario==2){
                        templete+=`<h1 class="badge badge-info">${usuario.tipo}</h1>`;
                    }
                    if(usuario.tipo_usuario==1){
                        templete+=`<h1 class="badge badge-success">${usuario.tipo}</h1>`;
                    }
                templete+=`</font></font></div>
                        <div class="card-body pt-0">
                            <div class="row">
                            <div class="col-7">
                                <h2 class="lead"><b><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">${usuario.nombre} ${usuario.apellido}</font></font></b></h2>
                                <p class="text-muted text-sm"><b><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Acerca de:</font></font></b><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> ${usuario.adicional}</font></font></p>
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-id-card"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Cedula: ${usuario.cedula}</font></font></li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-birthday-cake"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Edad: ${usuario.edad}</font></font></li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Correo: ${usuario.correo}</font></font></li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Dirección: ${usuario.residencia}</font></font></li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Teléfono: ${usuario.telefono}</font></font></li>
                                </ul>
                            </div>
                            <div class="col-5 text-center">
                                <img src="${usuario.avatar}" alt="" class="img-circle img-fluid">
                            </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">`;
                            if(tipo_usuario==3){
                                if(usuario.tipo_usuario!=3){
                                    templete+=`
                                        <button class="borrar-usuario btn btn-danger ml-1" type="button" data-toggle="modal" data-target="#confirmar">
                                            <i class="far fa-window-close mr-1"></i>Eliminar
                                        </button>       
                                    `;
                                }
                                if(usuario.tipo_usuario==2){
                                    templete+=`
                                        <button class="ascender btn btn-success ml-1" type="button" data-toggle="modal" data-target="#confirmar">
                                            <i class="fas fa-angle-double-up mr-1"></i>Ascender
                                        </button>
                                    `;
                                }
                                if(usuario.tipo_usuario==1){
                                    templete+=`
                                        <button class="descender btn btn-warning ml-1" data-toggle="modal" data-target="#confirmar">
                                            <i class="fas fa-angle-double-down mr-1"></i>Descender
                                        </button>
                                    `;
                                }
                            }
                            else{
                                if(tipo_usuario==1 && usuario.tipo_usuario!=1 && usuario.tipo_usuario!=3){
                                    templete+=`
                                        <button class="borrar-usuario btn btn-danger ml-1" type="button" data-toggle="modal" data-target="#confirmar">
                                            <i class="far fa-window-close mr-1"></i>Eliminar
                                        </button>       
                                    `;         
                                }
                            }
                            templete+=`
                        </div>
                    </div>
                    </div>
                </div>
                `;
            });
            $('#usuarios').html(templete);
        })
    }
    $(document).on('keyup','#buscar',function(){
        let valor=$(this).val();
        if(valor !=""){
            buscar_datos(valor);
        }else{
            buscar_datos();
        }
    })
    $('#form-crear').submit(e=>{
        let nombre=$('#nombre').val();
        let apellido=$('#apellido').val();
        let nacimiento=$('#nacimiento').val();
        let cedula=$('#cedula').val();
        let clave=$('#clave').val();
        //console.log(nombre + apellido  + cedula + clave);
        funcion='crear_usuario';
        $.post('../controlador/usuario-controlador.php',{nombre,apellido,nacimiento,cedula,clave,funcion},(response)=>{
            console.log(response);
            if(response=='crear'){
               $('#crear').hide('slow');
                $('#crear').show(1000);
                $('#crear').hide(2000);
                $('#form-crear').trigger('reset');
                buscar_datos();
            }else{
                $('#nocrear').hide('slow');
                $('#nocrear').show(1000);
                $('#nocrear').hide(2000);
                $('#form-crear').trigger('reset');
            }
        });
        e.preventDefault();
    });
    $(document).on('click','.ascender',(e)=>{
        const elemento=$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        //console.log(elemento);
        const id=$(elemento).attr('usuarioid');
        console.log(id);
        funcion='ascender';
        $('#Id_usuario').val(id);
        $('#funcion').val(funcion);
    });
    $(document).on('click','.descender',(e)=>{
        const elemento=$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        //console.log(elemento);
        const id=$(elemento).attr('usuarioid');
        console.log(id);
        funcion='descender';
        $('#Id_usuario').val(id);
        $('#funcion').val(funcion);
    });
    $(document).on('click','borrar-usuario',(e)=>{
        const elemento=$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        //console.log(elemento);
        const id=$(elemento).attr('usuarioid');
        console.log(id);
        funcion='borrar_usuario';
        $('#Id_usuario').val(id);
        $('#funcion').val(funcion);
    });
    $('#form-confirmar').submit(e=>{
        let clave=$('#clave-vieja').val();
        let Id_usuario=$('#Id_usuario').val();
        funcion=$('#funcion').val();
        $.post('../controlador/usuario-controlador.php',{clave,Id_usuario,funcion},(response)=>{
            //console.log(response);
            if(response=='ascendido' || response=='descendido' || response=='borrado'){
                $('#confirmado').hide('slow');
                $('#confirmado').show(1000);
                $('#confirmado').hide(2000);
                $('#form-confirmar').trigger('reset');
           }else{
                $('#rechazado').hide('slow');
                $('#rechazado').show(1000);
                $('#rechazado').hide(2000);
                $('#form-confirmar').trigger('reset');
           }
            buscar_datos();
        });
        e.preventDefault();
    }); 
})