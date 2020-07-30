$(document).ready(function(){
    buscar_tipo();
    var funcion;
    var editar=false;
    $('#form-crear-tipo').submit(e=>{
        let nombre_tipo=$('#nombre-tipo').val();
        let id_editado=$('#Id_editar_tipo').val();
        if(editar==false){
            funcion='crear';
        }else{
            funcion='actualizar';
        }
        $.post('../controlador/controlador-tipo.php',{nombre_tipo,id_editado,funcion},(response)=>{
            if(response=='crear'){
                $('#crear-tipo').hide('slow');
                $('#crear-tipo').show(1000);
                $('#crear-tipo').hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_tipo();
            }
            if(response=='nocrear'){
                $('#nocrear-tipo').hide('slow');
                $('#nocrear-tipo').show(1000);
                $('#nocrear-tipo').hide(2000);
                $('#form-crear-tipo').trigger('reset');
            }
            if(response=='editado'){
                $('#crear-tipo-edit').hide('slow');
                $('#crear-tipo-edit').show(1000);
                $('#crear-tipo-edit').hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_tipo();
            }
            editar==false;
        })
        e.preventDefault();
    })
    function buscar_tipo(consulta){
        funcion='buscar';
        $.post('../controlador/controlador-tipo.php',{consulta,funcion},(response)=>{
            const tipos=JSON.parse(response);
            let template='';
            tipos.forEach(tipo => {
                template+=`
                    <tr tipoId="${tipo.Id_tipo}" tipoNom="${tipo.nombre}">
                        <td>${tipo.nombre}</td>
                        <td>
                            <button class="editar-tipo btn btn-success" title="Editar el laboratorio" type="button" data-toggle="modal" data-target="#creartipo">
                                <i class="fas fa-pencil-alt"></i>
                            </button>

                            <button class="borrar-tipo btn btn-danger" title="Eliminar el laboratorio">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
           $('#tipos').html(template);
        })
    }
    $(document).on('keyup','#buscar-tipo',function(){
        let valor=$(this).val();
        if(valor!=''){
            buscar_tipo(valor)
        }else{
            buscar_tipo();
        }      
    })
    $(document).on('click','.editar-tipo',(e)=>{
        const elemento=$(this)[0].activeElement.parentElement.parentElement;
        const id=$(elemento).attr('tipoId'); 
        const nombre=$(elemento).attr('tipoNom');
        $('#Id_editar_tipo').val(id);
        $('#nombre-tipo').val(nombre);
        editar=true;
   })
   $(document).on('click','.borrar-tipo',(e)=>{
        funcion="borrar";
        const elemento=$(this)[0].activeElement.parentElement.parentElement;
        const id=$(elemento).attr('tipoId'); 
        const nombre=$(elemento).attr('tipoNom');
        $('#Id_editar_tipo').val(id);
        $('#nombre-tipo').val(nombre);

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
                $.post('../controlador/controlador-tipo.php',{id,funcion},(response)=>{
                    //console.log(response);
                    editar==false;
                    if (response=='borrado') {
                            swalWithBootstrapButtons.fire(
                                'Eliminado!',
                                'El tipo :'+nombre+' se ha eliminado',
                                'success'
                            )
                            buscar_tipo();
                    }else{
                        swalWithBootstrapButtons.fire(
                            'No se pudo el tipo!',
                            'El tipo :'+nombre+' nose ha eliminado porque esta asociado a un producto',
                            'success'
                         )
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                'Cancelar',
                'El tipo :'+nombre+' no se elimino',
                'error'
              )
            }
          })
        
    })
})