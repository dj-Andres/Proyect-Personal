$(document).ready(function(){
    buscar_presentacion();
    var funcion;
    var editar=false;
    $('#form-crear-presentacion').submit(e=>{
        let nombre_presentacion=$('#nombre-presentacion').val();
        let id_editado=$('#Id_editar_presentacion').val();
        if(editar==false){
            funcion='crear';
        }else{
            funcion='actualizar';
        }
        $.post('../controlador/controlador-presentacion.php',{funcion,id_editado,nombre_presentacion},(response)=>{
            if(response=='crear'){
                $('#crear-presentacion').hide('slow');
                $('#crear-presentacion').show(1000);
                $('#crear-presentacion').hide(2000);
                $('#form-crear-presentacion').trigger('reset');
                buscar_presentacion();
            }
            if(response=='nocrear'){
                $('#nocrear-presentacion').hide('slow');
                $('#nocrear-presentacion').show(1000);
                $('#nocrear-presentacion').hide(2000);
                $('#form-crear-presentacion').trigger('reset');
            }
            if(response=='editado'){
                $('#crear-presentacion-edit').hide('slow');
                $('#crear-presentacion-edit').show(1000);
                $('#crear-presentacion-edit').hide(2000);
                $('#form-crear-presentacion').trigger('reset');
                buscar_presentacion();
            }
            editar==false;
        })
        e.preventDefault();
    })
    function buscar_presentacion(consulta){
        funcion='buscar';
        $.post('../controlador/controlador-presentacion.php',{funcion,consulta},(response)=>{
            const presentaciones=JSON.parse(response);
            let template='';
            presentaciones.forEach(presentacion => {
                template+=`
                    <tr presentacion="${presentacion.Id_presentacion}" presentacionn="${presentacion.nombre}">
                        <td>${presentacion.nombre}</td>
                        <td>
                            <button class="editar-presentacion btn btn-success" title="Editar la presentación" type="button" data-toggle="modal" data-target="#crearpresentacion">
                                <i class="fas fa-pencil-alt"></i>
                            </button>

                            <button class="borrar-presentacion btn btn-danger" title="Eliminar la presentación">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#presentaciones').html(template);
        })
    }
    $(document).on('keyup','#buscar-presentacion',function(){
        let valor=$(this).val();
        if(valor !=''){
            buscar_presentacion(valor);
        }else{
            buscar_presentacion();
        }
    })
    $(document).on('click','.editar-presentacion',(e)=>{
        const elemento=$(this)[0].activeElement.parentElement.parentElement;
        const id=$(elemento).attr('presentacion'); 
        const nombre=$(elemento).attr('presentacionn');
        $('#Id_editar_presentacion').val(id);
        $('#nombre-presentacion').val(nombre);
        editar=true;
    })
    $(document).on('click','.borrar-presentacion',(e)=>{
        funcion="borrar";
        const elemento=$(this)[0].activeElement.parentElement.parentElement;
        const id=$(elemento).attr('presentacion'); 
        const nombre=$(elemento).attr('presentacionn');
        $('#Id_editar_presentacion').val(id);
        $('#nombre-presentacion').val(nombre);

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-1'
            },
            buttonsStyling: false
          })
          
          swalWithBootstrapButtons.fire({
            title: 'Desea eliminar al tipo de producto: '+nombre+'?',
            text: "No se podra revertir la acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, se elimino el registro!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                //eviamos datos mediante ajax//
                $.post('../controlador/controlador-presentacion.php',{id,funcion},(response)=>{
                    //console.log(response);
                    editar==false;
                    if (response=='borrado') {
                            swalWithBootstrapButtons.fire(
                                'Eliminado!',
                                'La presentación :'+nombre+' se ha eliminado',
                                'success'
                            )
                            buscar_presentacion();
                    }else{
                        swalWithBootstrapButtons.fire(
                            'No se pudo el tipo!',
                            'La presentación :'+nombre+' nose ha eliminado porque esta asociado a un producto',
                            'success'
                         )
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                'Cancelar',
                'La presentación :'+nombre+' no se elimino',
                'error'
              )
            }
          })      
    })
})