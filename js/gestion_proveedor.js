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
            console.log(response);
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
})