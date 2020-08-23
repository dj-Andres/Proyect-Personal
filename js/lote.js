$(document).ready(function(){
    buscar_lote();

    
    function buscar_lote(consulta){
        funcion='buscar';
        $.post('../controlador/controlador-lote.php',{consulta,funcion},(response)=>{
                const lotes=JSON.parse(response);
                let templete='';
                lotes.forEach(lote => {
                    templete+=`
                    <div loteID="${lote.Id_lote}"   loteStock="${lote.stock}"  class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">`;
                    if(lote.estado=='ligth'){
                        templete+=`<div class="card bg-light">`;
                    }
                    if(lote.estado=='warning'){
                        templete+=`<div class="card bg-warning">`;
                    }
                    if(lote.estado=='secondary'){
                        templete+=`<div class="card bg-secondary">`;
                    }
                    templete+=`<div class="card-header  border-bottom-0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                    <h6>Codigo: ${lote.Id_lote}</h6>            
                    <i class="fas fa-lg fa-cubes mr-1"></i>${lote.stock}
                            </font></font></div>
                            <div class="card-body pt-0">
                                <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b>Hola</b></h2>
                                    <ul class="ml-4 mb-0 fa-ul">
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-mortar-pestle "></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Concentración: ${lote.concentracion}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-prescription-bottle-alt"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Adicional:${lote.adicional}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-flask"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Laboratorio:${lote.laboratorio}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-pills"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Presentación:${lote.presentacion}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-times"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Fech Venc:${lote.vencimiento}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-truck"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Proveedor:${lote.proveedor}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-alt"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Mes:${lote.mes}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-day"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Día:${lote.dia}</font></font></li>
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="${lote.avatar}" alt="" class="img-circle img-fluid">
                                </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button class="editar btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#editar-lote">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="borrar btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                    </div>
                </div>
            `;
            })
            $('#lotes').html(templete);
        })
    }
    $(document).on('keyup','#buscar-lote',function(){
        let valor=$(this).val();
        if(valor!=''){
             buscar_lote(valor);
        }else{
             buscar_lote();
        }
    });
    $(document).on('click','.editar',(e)=>{
        const elemento=$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('LoteId');
        const stock=$(elemento).attr('LoteStock');

        $('#id_editar_lote').val(id);
        $('#stock').val(stock);
        $('#codigo_lote').html(id);
    });
    $('#form-editar-lote').submit(e=>{
        let id_lote=$('#id_editar_lote').val();
        let stock=$('#stock').val();
        funcion='editar'
        $.post('../controlador/controlador-lote.php',{funcion,id_lote,stock},(response)=>{
            if (response=='editado') {
                $('#edit-lote').hide('slow');
                $('#edit-lote').show(1000);
                $('#edit-lote').hider(2000);
                $('#form-editar-lote').trigger('reset');
            }
            buscar_lote();
        })
        e.preventDefault();
    })
    $(document).on('click','.borrar',(e)=>{
        funcion='borrar';
        const elemento=$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('LoteId');
        const stock=$(elemento).attr('LoteStock');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-1'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Desea eliminar al lote: '+id+'?',
            text: "No se podra revertir la acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, se elimino el registro!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                //eviamos datos mediante ajax//
                $.post('../controlador/controlador-lote.php',{id,funcion},(response)=>{
                    
                    if (response=='borrado') {
                            swalWithBootstrapButtons.fire(
                                'Eliminado!',
                                'El lote :'+id+' se ha eliminado',
                                'success'
                            )
                            buscar_lote();
                    }else{
                        swalWithBootstrapButtons.fire(
                            'No se pudo Eliminar!',
                            'El lote :'+id+' nose ha eliminado porque esta asociado a un producto',
                            'success'
                          )
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                'Cancelar',
                'El lote :'+id+' no se elimino',
                'error'
              )
            }
        })    
    });
})