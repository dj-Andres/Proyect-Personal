$(document).ready(function(){
    $('#cat-carrito').show();
    buscar_producto();
    mostrar_lote();
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
                                <h2 class="lead"><b>Codigo ${producto.Id_producto}</b></h2>
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
                                 
                                 <button class="agregar-carrito btn btn-sm btn-primary">
                                     <i class="fas fa-plus mr-2">Agregar al carrito</i>
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
     function mostrar_lote() {
        funcion="buscar";
        $.post('../controlador/controlador-lote.php',{funcion},(response)=>{
            const lotes=JSON.parse(response);
            let templete='';
            lotes.forEach(lote => {
                if(lote.estado=='warning'){
                    templete+=`
                    <tr class="table-warning">
                        <td>${lote.Id_lote}</td>
                        <td>Producto</td>
                        <td>${lote.stock}</td>
                        <td>${lote.laboratorio}</td>
                        <td>${lote.presentacion}</td>
                        <td>${lote.proveedor}</td>
                        <td>${lote.mes}</td>
                        <td>${lote.dia}</td>
                    </tr>
                `;
                }
                if(lote.estado=='secondary'){
                    templete+=`
                    <tr class="table-danger">
                        <td>${lote.Id_lote}</td>
                        <td>Producto</td>
                        <td>${lote.stock}</td>
                        <td>${lote.laboratorio}</td>
                        <td>${lote.presentacion}</td>
                        <td>${lote.proveedor}</td>
                        <td>${lote.mes}</td>
                        <td>${lote.dia}</td>
                    </tr>
                `;
                }
            });
            $('#lotes').html(templete);
        })
    }
})