$(document).ready(function(){
    recuperarLS_carrito();
    contar_productos();
    recuperarLS_carrito_compra();
    $(document).on('click','.agregar-carrito',(e)=>{
        const elemento=$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('prodID');
        //const nombre=$(elemento).attr('prodNom');
        const concentracion=$(elemento).attr('prodConcentracion');
        const adicional=$(elemento).attr('prodAdicional');
        const precio=$(elemento).attr('prodPrecio');
        const laboratorio=$(elemento).attr('prodLaboratorio');
        const tipo=$(elemento).attr('prodTipo');
        const presentacion=$(elemento).attr('prodPresentacion');
        const avatar=$(elemento).attr('prodAvatar');
        const stock=$(elemento).attr('prodStock');

        const producto={
            id:id,
            //nombre:nombre,
            concentracion:concentracion,
            adicional:adicional,
            precio:precio,
            laboratorio:laboratorio,
            tipo:tipo,
            presentacion:presentacion,
            avatar:avatar,
            stock:stock,
            cantidad:1
        }
        let id_producto;
        let productos;
        productos=recuperarLs();
        productos.forEach(prod => {
            if(prod.id===producto.id){
                id_producto=prod.id;
            }
        });
        if(id_producto === producto.id){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'El producto ya se añadio!'
            })
        }else{
            template=`
                <tr prodId="${producto.id}">
                    <td>${producto.id}</td>
                    <td>Producto</td>
                    <td>${producto.concentracion}</td>
                    <td>${producto.adicional}</td>
                    <td>${producto.precio}</td>
                    <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
                </tr>
                `;
                $('#lista').append(template);
                AgregarLs(producto);
                contar_productos();
                
        }
    })
    $(document).on('click','.borrar-producto',(e)=>{
        const elemento=$(this)[0].activeElement.parentElement.parentElement;
        const id=$(elemento).attr('prodId');
        eliminar_producto_LS(id);
        elemento.remove();
        contador=contar_productos();
        
    })
    $(document).on('click','#vaciar-carrito',(e)=>{
        // vacia todo los elementos de una fila//
        $('#lista').empty();
        eliminarLS();
        contar_productos();
        
    })
    $(document).on('click','#procesar_pedido',(e)=>{
        procesar_pedido();
    })
    function recuperarLs(){
        let productos;
        if(localStorage.getItem('productos')===null){
            productos=[];
        }else{
            productos=JSON.parse(localStorage.getItem('productos'))
        }
        return productos
    }
    function AgregarLs(producto){
        let productos;
        productos=recuperarLs();
        productos.push(producto);
        localStorage.setItem('productos',JSON.stringify(productos));
    }
    //mostar los productos guardados en el localStorage
    function recuperarLS_carrito(){
        let productos;
        productos=recuperarLs();
        productos.forEach(producto => {
            template=`
            <tr prodId="${producto.id}">
                <td>${producto.id}</td>
                <td>Producto</td>
                <td>${producto.concentracion}</td>
                <td>${producto.adicional}</td>
                <td>${producto.precio}</td>
                <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
            </tr>
            `;
            $('#lista').append(template);          
        });
    }
    function eliminar_producto_LS(id){
        let productos;
        productos=recuperarLs();
        productos.forEach(function(producto,indice) {
            if(producto.id===id){
                productos.splice(indice,1);
            }
        });      
        localStorage.setItem('productos',JSON.stringify(productos));
    }
    function eliminarLS(){
        localStorage.clear();
    }
    function contar_productos(){
        let productos;
        let contador=0;
        productos=recuperarLs();
        productos.forEach(producto => {
            contador++;
        });
        $('#contador').html(contador);
    }
    function procesar_pedido(){
        let productos;
        productos=recuperarLs();
        if(productos.length===0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'El carrito esta vacio!'
            })
        }else{
            location.href='../vista/adm_compra.php';
        }
    }
    //mostrar los productos añadidos en el carrito de compras para el proceso de compras
    function recuperarLS_carrito_compra(){
        let productos;
        productos=recuperarLs();
        productos.forEach(producto => {
            template=`
            <tr prodId="${producto.id}">
                <td>Producto</td>
                <td>${producto.stock}</td>
                <td>${producto.precio}</td>
                <td>${producto.concentracion}</td>
                <td>${producto.adicional}</td>
                <td>${producto.laboratorio}</td>
                <td>${producto.presentacion}</td>
                <td>
                    <input type="number" class="form-control producto" min="1" value="${producto.cantidad}">
                </td>
                <td class="subtotales">
                    <h5>${producto.precio*producto.cantidad}</h5>
                </td>
                <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
            </tr>
            `;
            $('#lista-compra').append(template);          
        });
    }
   // $('#cp').keyup(e=>{
        //let id,cantidad,producto,productos,montos;
        //producto=$(this)[0].activeElement.parentElement.parentElement;
        //id=$(producto).attr('prodId');
        //cantidad=producto.querySelector('input').value;
        //montos=document.querySelectorAll('.subtotales');
        //productos=recuperarLs();

        //productos.forEach(function(prod,indice)  {
         //   if(prod.id===id){
           //     prod.cantidad=cantidad;
            //    montos[indice].innerHTML=`<h5>${cantidad*productos[indice].precio}</h5>`;
           // }
        //});
        //localStorage.setItem('productos',JSON.stringify(producto));
   // })
})