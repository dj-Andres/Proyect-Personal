$(document).ready(function(){
    //uso de la libreria select2//
    $('.select2').select2();
    rellenar_laboratorios();
    rellenar_tipos();
    rellenar_presentaciones();
    buscar_producto();
    function rellenar_laboratorios(){
        funcion='rellenar_laboratorios';
        $.post('../controlador/controlador-laboratorio.php',{funcion},(response)=>{
            const laboratorios=JSON.parse(response);
            let template='';
            laboratorios.forEach(laboratorio => {
                template+=`
                    <option value="${laboratorio.Id_laboratorio}">${laboratorio.nombre}</option>
                `;
            });
            $('#laboratorio').html(template);
        })
    }
    function rellenar_tipos(){
        funcion='rellenar_tipos';
        $.post('../controlador/controlador-tipo.php',{funcion},(response)=>{
            const tipos=JSON.parse(response);
            let template='';
            tipos.forEach(tipo => {
                template+=`
                    <option value="${tipo.Id_tipo}">${tipo.nombre}</option>
                `;
            });
            $('#tipo_producto').html(template);
        })
    }
    function rellenar_presentaciones(){
        funcion='rellenar_presentaciones';
        $.post('../controlador/controlador-presentacion.php',{funcion},(response)=>{
            const presentaciones=JSON.parse(response);
            let template='';
            presentaciones.forEach(presentacion => {
                template+=`
                    <option value="${presentacion.Id_presentacion}">${presentacion.nombre}</option>
                `;
            });
            $('#presentacion').html(template);
        })
    }
    $('#form-crear-producto').submit(e=>{
        
        let nombre=$('#nombre_producto').val();
        let concentracion=$('#concentracion').val();
        let adicional=$('#adicional').val();
        let precio=$('#precio').val();
        let laboratorio=$('#laboratorio').val();
        let tipo=$('#tipo_producto').val();
        let presentacion=$('#presentacion').val();
    
        funcion='crear';

        $.post('../controlador/controlador-producto.php',{funcion,nombre,concentracion,adicional,precio,laboratorio,tipo,presentacion},(response)=>{
            
            if(response=='crear'){
                $('#crear').hide('slow');
                $('#crear').show(1000);
                $('#crear').hide(2000);
                $('#form-crear-prodcuto').trigger('reset');
                buscar_producto();
            }
            if(response=='nocrear'){
                $('#nocrear').hide('slow');
                $('#nocrear').show(1000);
                $('#nocrear').hide(2000);
                $('#form-crear-prodcuto').trigger('reset');
            }
        })      
        e.preventDefault();
    });
   function buscar_producto(consulta){
       funcion='buscar';
        $.post('../controlador/controlador-producto.php',{funcion,consulta},(response)=>{
            const productos=JSON.parse(response);
            let templete='';
            productos.forEach(producto => {
                templete+=`
                        <div prodID="${producto.Id_producto}" prodNom="${producto.nombre}" prodPrecio="${producto.precio}"  prodConcentracion="${producto.concentracion}" prodAdicional="${producto.adicional}" prodAvatar="${producto.avatar}" prodTipo="${producto.Id_tipo}" prodPresentacion="${producto.Id_presentacion}" prodLaboratorio="${producto.Id_laboratorio}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                        <div class="card bg-light">
                        <div class="card-header text-muted border-bottom-0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                            <i class="fas fa-lg fa-cubes mr-1"></i>${producto.stock}
                        </font></font></div>
                        <div class="card-body pt-0">
                            <div class="row">
                            <div class="col-7">
                                <h2 class="lead"><b>${producto.nombre}</b></h2>
                                <h4 class="lead"><b><i class="fas fa-lg fa-dollar-sign mr-1"></i>${producto.precio}</b></h4>
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-mortar-pestle "></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Concentración: ${producto.concentracion}</font></font></li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-prescription-bottle-alt"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Adicional:${producto.adicional}</font></font></li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-flask"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Laboratorio:${producto.laboratorio}</font></font></li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-copyrigth"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Tipo:${producto.tipo}</font></font></li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-pills"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Presentación:${producto.presentacion}</font></font></li>
                                </ul>
                            </div>
                            <div class="col-5 text-center">
                                <img src="${producto.avatar}" alt="" class="img-circle img-fluid">
                            </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <button  class="avatar btn btn-sm bg-teal" type="button" data-toggle="modal" data-target="#cambio-logo">
                                    <i class="fas fa-image"></i>
                                </button>
                                <button class="editar btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#crear-producto">
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
            });
                $('#productos').html(templete);
        })
    }
    $(document).on('keyup','#buscar-producto',function(){
        let valor=$(this).val();
        if(valor!=''){
            buscar_producto(valor);
        }else{
            buscar_producto();
        }
    })
})