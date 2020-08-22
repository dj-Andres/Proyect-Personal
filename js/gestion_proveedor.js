$(document).ready(function(){
    buscar_proveedor();
    var funcion;
    var editar=false;
    $('#form-crear').submit(e=>{
        let id_editado=$('#id_editar_proveedor').val();
        let nombre=$('#nombre').val();
        let telefono=$('#telefono').val();
        let correo=$('#correo').val();
        let direccion=$('#direccion').val();
        if(editar==true){
            funcion='editar';
        }else{
            funcion='crear';
        }
        $.post('../controlador/controlador-proveedor.php',{id_editado,nombre,telefono,correo,direccion,funcion},(response)=>{
            //console.log(response);
            if(response=='crear'){
                $('#crear').hide('slow');
                $('#crear').show(1000);
                $('#crear').hide(2000);
                $('#form-crear').trigger('reset');
                buscar_proveedor();
            }
            if(response=='no-crear'){
                $('#nocrear').hide('slow');
                $('#nocrear').show(1000);
                $('#nocrear').hide(2000);
                $('#form-crear').trigger('reset');
            }
            if(response=='editado'){
                $('#editar').hide('slow');
                $('#editar').show(1000);
                $('#editar').hide(2000);
                $('#form-crear').trigger('reset');
                buscar_proveedor();
            }
            if(response=='no-editado'){
                $('#nocrear').hide('slow');
                $('#nocrear').show(1000);
                $('#nocrear').hide(2000);
                $('#form-crear').trigger('reset');
            }
            editar=false;
        })
        e.preventDefault();
    })
    function buscar_proveedor(consulta){
        funcion='buscar';
        $.post('../controlador/controlador-proveedor.php',{consulta,funcion},(response)=>{
                const proveedores=JSON.parse(response);
                let  template='';
                proveedores.forEach(proveedor => {
                    template+=`
                            <div provID="${proveedor.Id_proveedor}" provNom="${proveedor.nombre}" provTelefono="${proveedor.telefono}" provDireccion="${proveedor.direccion}" provCorreo="${proveedor.correo}" provAvatar="${proveedor.avatar}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                            <div class="card bg-light">
                            <div class="card-header text-muted border-bottom-0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                <h1 class="badge badge-success">Proveedor</h1>
                            </font></font></div>
                            <div class="card-body pt-0">
                                <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b>${proveedor.nombre}</b></h2>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Dirección: ${proveedor.direccion}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Telefono:${proveedor.telefono}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Telefono:${proveedor.correo}</font></font></li>
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="${proveedor.avatar}" alt="" class="img-circle img-fluid">
                                </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button  class="avatar btn btn-sm bg-teal" type="button" data-toggle="modal" data-target="#cambio-logo" title="Editar el logo">
                                        <i class="fas fa-image"></i>
                                    </button>
                                    <button class="editar btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#crear-proveedor" title="Editar el proveedor">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="borrar btn btn-sm btn-danger" title="Eliminar el proveedor">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            </div>
                        </div>
                    `;
                });
                $('#proveedor').html(template);
        })
    }
    $(document).on('keyup','#buscar',function(){
        let valor=$(this).val();
        if(valor!=''){
            buscar_proveedor(valor);
        }else{
            buscar_proveedor();
        }
    })
    $(document).on('click','.editar',(e)=>{
        const elemento=$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('ProvID');
        const nombre=$(elemento).attr('ProvNom');
        const telefono=$(elemento).attr('ProvTelefono');
        const correo=$(elemento).attr('ProvCorreo');
        const direccion=$(elemento).attr('ProvDireccion');
        
        $('#id_editar_proveedor').val(id);
        $('#nombre').val(nombre);
        $('#telefono').val(telefono);
        $('#direccion').val(direccion);
        $('#correo').val(correo);
        
        editar=true;
    });
    $(document).on('click','.avatar',(e)=>{
        funcion='cambiar_avatar';
        const elemento=$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('ProvID');
        const nombre=$(elemento).attr('ProvNom');
        const avatar=$(elemento).attr('provAvatar');

        $('#logo-actual').attr('src',avatar);
        $('#nombre_logo').html(nombre);
        $('#id_logo_prov').val(id);
        $('#funcion').val(funcion);
        $('#avatar').val(avatar);
    });
    $('form-logo').submit(e=>{
        let formData=new FormData($('#form-logo')[0]);
        $.ajax({
            url:'../controlador/controlador-proveedor.php',
            type:'POST',
            data:formData,
            cache:false,
            processData:false,
            comentType:false
        }).done(function(response){
            console.log(response);
        })
        e.preventDefault();
    });
    $(document).on('click','.borrar',(e)=>{
        funcion="borrar";
        const elemento=$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('ProvID');
        const nombre=$(elemento).attr('ProvNom');
        const avatar=$(elemento).attr('provAvatar');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-1'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Desea eliminar el proveedor: '+nombre+'?',
            text: "No se podra revertir la acción!",
            //icon: 'warning',
            // añadimos propiedades para mostrar el avatar del laboratorio//
            imageUrl:''+avatar+'',
            imageWidth:100,
            imageHeigth:100,
            showCancelButton: true,
            confirmButtonText: 'Si, se elimino el registro!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                //eviamos datos mediante ajax//
                $.post('../controlador/controlador-proveedor.php',{id,funcion},(response)=>{
                    //console.log(response);
                    editar==false;
                    if (response=='borrado') {
                            swalWithBootstrapButtons.fire(
                                'Eliminado!',
                                'El proveeedor :'+nombre+' se ha eliminado',
                                'success'
                            )
                            buscar_proveedor();
                    }else{
                        swalWithBootstrapButtons.fire(
                            'No se pudo Eliminar!',
                            'El proveedor :'+nombre+' nose ha eliminado porque esta asociado a un producto',
                            'success'
                          )
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                'Cancelar',
                'El proveedor :'+nombre+' no se elimino',
                'error'
              )
            }
        })

    })

})