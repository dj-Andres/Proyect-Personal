$(document).ready(function(){
    buscar_lote();
    
    
    function buscar_lote(consulta){
        funcion='buscar';
        $.post('../controlador/controlador-lote.php',{consulta,funcion},(response)=>{
                const lotes=JSON.parse(response);
                let templete='';
                lotes.forEach(lote => {
                    templete+=`
                    <div prodID="${lote.Id_lote}"  prodPrecio="${lote.precio}"  prodConcentracion="${lote.concentracion}" prodAdicional="${lote.adicional}" prodAvatar="${lote.avatar}" prodTipo="${lote.Id_tipo}" prodPresentacion="${lote.Id_presentacion}" prodLaboratorio="${lote.Id_laboratorio}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                        <div class="card bg-light">
                            <div class="card-header text-muted border-bottom-0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                <i class="fas fa-lg fa-cubes mr-1"></i>${lote.stock}
                            </font></font></div>
                            <div class="card-body pt-0">
                                <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b>Hola</b></h2>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-mortar-pestle "></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Concentración: ${lote.concentracion}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-prescription-bottle-alt"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Adicional:${lote.adicional}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-flask"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Laboratorio:${lote.laboratorio}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-pills"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Presentación:${lote.presentacion}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-times"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Fech Venc:${lote.vencimiento}</font></font></li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-truck"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Proveedor:${lote.proveedor}</font></font></li>
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="${lote.avatar}" alt="" class="img-circle img-fluid">
                                </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button  class="logo btn btn-sm bg-teal" type="button" data-toggle="modal" data-target="#cambio-logo">
                                        <i class="fas fa-image"></i>
                                    </button>
                                    <button class="editar btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#crear-lote">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="lote btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#crear-lotes">
                                        <i class="fas fa-plus"></i>
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

})