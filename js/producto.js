$(document).ready(function(){
    var funcion;
    var editar=false;
    buscar_producto();
    $('.select2').select2();
    rellenar_laboratorios();
    rellenar_tipos();
    rellenar_presentaciones();
    rellenar_proveedor();
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
    function rellenar_proveedor(){
        funcion='rellenar_proveedor';
        $.post('../controlador/controlador-proveedor.php',{funcion},(response)=>{
            const proveedores=JSON.parse(response);
            let template='';
            proveedores.forEach(proveedor => {
                template+=`
                    <option value="${proveedor.Id_proveedor}">${proveedor.nombre}</option>
                `;
            });
            $('#proveedor').html(template);
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
        let id=$('#id_editar_producto').val();
        let nombre=$('#nombre_producto').val();
        let concentracion=$('#concentracion').val();
        let adicional=$('#adicional').val();
        let precio=$('#precio').val();
        let laboratorio=$('#laboratorio').val();
        let tipo=$('#tipo_producto').val();
        let presentacion=$('#presentacion').val();
        if(editar==true){
            funcion='editar';
        }else{
            funcion='crear';
        }
        $.post('../controlador/controlador-producto.php',{funcion,nombre,concentracion,adicional,precio,laboratorio,tipo,presentacion,id},(response)=>{
            console.log(response);
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
            if(response=='editado'){
                $('#editar').hide('slow');
                $('#editar').show(1000);
                $('#editar').hide(2000);
                $('#form-crear-prodcuto').trigger('reset');
                buscar_producto();
            }
            if(response=='noeditado'){
                $('#nocrear').hide('slow');
                $('#nocrear').show(1000);
                $('#nocrear').hide(2000);
                $('#form-crear-prodcuto').trigger('reset');
            }
            editar=false;
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
                                <li class="small"><span class="fa-li"><i class="far fa-copyright"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Tipo:${producto.tipo}</font></font></li>
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
                                <button  class="logo btn btn-sm bg-teal" type="button" data-toggle="modal" data-target="#cambio-logo">
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
    $(document).on('click','.logo',(e)=>{
        funcion='cambiar_avatar';
        const elemento=$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('prodID');
        const nombre=$(elemento).attr('prodNom');
        const avatar=$(elemento).attr('prodAvatar');
        $('#funcion').val(funcion);
        $('#id_logo_prod').val(id);
        $('#avatar').val(avatar);

        $('#logo-actual').attr('src',avatar);
        $('#nombre_logo').html(nombre);

    })
    $(document).on('click','.lote',(e)=>{
        const elemento=$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('prodID');
        const nombre=$(elemento).attr('prodNom');
        $('#id_lote_prod').val(id);
        $('#producto-name').html(nombre);

    })
    $('#form-crear-lote').submit(e=>{
        let id_producto=$('#id_lote_prod').val();
        let proveedor=$('#proveedor').val();
        let stock=$('#stock').val();
        let vencimiento=$('#vencimiento').val();
        funcion='crear_stock';

        $.post('../controlador/controlador-lote.php',{funcion,id_producto,proveedor,stock,vencimiento},(response)=>{
            if(response=='crear'){
                $('#add').hide('slow');
                $('#add').show(1000);
                $('#add').hide(2000);
                $('#form-crear-lote').trigger('reset');
                buscar_producto();
            }
        })

        e.preventDefault();
    });
    $('#form-logo').submit(e=>{
        let formData=new FormData($('#form-logo')[0]);

        console.log(formData);
        

        $.ajax({
            url:'../controlador/controlador-producto.php',
            type:'POST',
            data:formData,
            cache:false,
            processData:false,
            comentType:false
        }).done(function(response){
            console.log(response);
            const json=JSON.parse(response);
            
            if (json.alert=='editado') {
                $('#logo-actual').attr('src',json.ruta);
                $('#update').hide('slow');
                $('#update').show(1000);
                $('#update').hide(2000);
                $('#form-logo').trigger('reset');
                buscar_producto();
            }else{
                $('#no-update').hide('slow');
                $('#no-update').show(1000);
                $('#no-update').hide(2000);
                $('#form-logo').trigger('reset');
            }
        })
        e.preventDefault();
    })
    $(document).on('click','.editar',(e)=>{
        const elemento=$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('prodID');
        const nombre=$(elemento).attr('prodNom');
        const concentracion=$(elemento).attr('prodConcentracion');
        const adicioanl=$(elemento).attr('prodAdicional');
        const precio=$(elemento).attr('prodPrecio');
        const laboratorio=$(elemento).attr('prodLaboratorio');
        const tipo=$(elemento).attr('prodTipo');
        const presentacion=$(elemento).attr('prodPresentacion');

        $('#id_editar_producto').val(id);
        $('#nombre_producto').val(nombre);
        $('#concentracion').val(concentracion);
        $('#adicional').val(adicioanl);
        $('#precio').val(precio);
        $('#laboratorio').val(laboratorio).trigger('change');
        $('#tipo_producto').val(tipo).trigger('change');
        $('#presentacion').val(presentacion).trigger('change');
        editar=true;
    })
    $(document).on('click','.borrar',(e)=>{
        funcion="borrar";
        const elemento=$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('prodID');
        const nombre=$(elemento).attr('prodNom');
        const avatar=$(elemento).attr('prodAvatar');


        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-1'
            },
            buttonsStyling: false
          })

          swalWithBootstrapButtons.fire({
            title: 'Desea eliminar el producto? '+nombre+'',
            text: "No se va a poder revertir!",
            imageUrl:''+avatar+'',
            imageWidth:100,
            imageHeigth:100,
            showCancelButton: true,
            confirmButtonText: 'Si, eliminare!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                $.post('../controlador/controlador-producto.php',{id,funcion},(response)=>{
                    editar==false;
                    if(response=='borrado'){
                        swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'El producto :'+nombre+' se ha eliminado',
                            'success'
                        )
                        buscar_producto();
                    }else{
                        swalWithBootstrapButtons.fire(
                            'No se pudo Eliminar!',
                            'El producto :'+nombre+' nose ha eliminado porque esta asociado a un lote',
                            'success'
                          )
                    }
                })

            } else if(result.dismiss === Swal.DismissReason.cancel){
              swalWithBootstrapButtons.fire(
                'No se pudo eliminar',
                'El producto '+nombre+' no fue eliminado',
                'error'
              )
            }
          })
   })
   $(document).on('click','#boton_reporte',(event)=>{
        funcion='reporte';
        mostrarLoader('reporte_pdf');
        $.post('../controlador/controlador-reporte.php',{funcion},(response)=>{
            mostrarLoader('reporte_pdf');
            if (response=="") {
                cerrarLoader('exito_reporte');
                window.open('../pdf/pdf-'+funcion+'.pdf','_blank');
            }else{
               cerrarLoader('error_reporte');
           }
        })

    })
    $(document).on('click','#reporte_excel',(event)=>{
        funcion='reporte_excel';
        $.post('../controlador/controlador-reporte.php',{funcion},(response)=>{
            console.log(response);
             mostrarLoader('reporte_excel');
            if (response== '') {
                cerrarLoader('exito_reporte');
                window.open('../excel/reporte_producto.xlsx','_blank');
            }else{
                cerrarLoader('error_reporte');
            }
        })
    })
    function mostrarLoader(mensaje){
        var texto=null;
        var mostrar=false;

        switch (mensaje) {
            case 'reporte_pdf':
                texto='Se creando el documento PDF por favor espere...';
                mostrar=true;
                break;
            case 'reporte_excel':
                texto='Se esta el reporte EXCEL por favor espere...';
                mostrar=true;
                break;
        }
        if(mostrar){
            Swal.fire({
                title: 'Creando PDF',
                text: texto,
                showConfirmButton:false
            })
        }
    }
    function cerrarLoader(mensaje){
        var tipo=null;
        var texto=null;
        var mostrar=false;

        switch (mensaje) {
            case 'exito_reporte':
                tipo='success';
                texto='El reporte fue generado correctamente!';
                mostrar=true;
            break;

            case 'error_reporte':
                tipo='error';
                texto='El reporte no pudo generarse comunicarse con el departamento de Sistemas!';
                mostrar=true;
            break;

            default:
                Swal.close();
            break;
        }

        if(mostrar){
            Swal.fire({
                position:'center',
                icon: tipo,
                text: texto,
                showConfirmButton:false
            })
        }
    }

})