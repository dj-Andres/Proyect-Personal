$(document).ready(function(){
    calcular_total();
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
        contar_productos();
        calcular_total();
    })
    $(document).on('click','#vaciar-carrito',(e)=>{
        $('#lista').empty();
        eliminarLS();
        contar_productos();
    })
    $(document).on('click','#procesar_pedido',(e)=>{
        procesar_pedido();
    })
    $(document).on('click','#procesar-compra',(e)=>{
        procesar_compra();
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
        let productos,id_producto;
        productos=recuperarLs();
        funcion='buscar_id';
        productos.forEach(producto => {
            id_producto=producto.id;
            $.post('../controlador/controlador-producto.php',{funcion,id_producto},(response)=>{
                let tempate_carrito='';
                let json=JSON.parse(response);
                tempate_carrito=`
                    <tr prodId="${json.id}">
                        <td>${json.Id}</td>
                        <td>Producto</td>
                        <td>${json.concentracion}</td>
                        <td>${json.adicional}</td>
                        <td>${json.precio}</td>
                        <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
                    </tr>
                `;
                $('#lista').append(tempate_carrito);
            })
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
        let productos,id_producto;
        productos=recuperarLs();
        funcion='buscar_id';
        productos.forEach(producto => {
            id_producto=producto.id;
            $.post('../controlador/controlador-producto.php',{funcion,id_producto},(response)=>{
                let tempate_compra='';
                let json=JSON.parse(response);
                tempate_compra=`
                    <tr prodId="${producto.id}" prodPrecio="${json.precio}">
                        <td>Producto</td>
                        <td>${json.stock}</td>
                        <td class="precio">${json.precio}</td>
                        <td>${json.concentracion}</td>
                        <td>${json.adicional}</td>
                        <td>${json.laboratorio}</td>
                        <td>${json.presentacion}</td>
                        <td>
                            <input type="number" class="form-control producto" min="1" value="${producto.cantidad}">
                        </td>
                        <td class="subtotales">
                            <h5>${json.precio*producto.cantidad}</h5>
                        </td>
                        <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
                    </tr>
                `;
                $('#lista-compra').append(tempate_compra);
            })
        });
    }
    $(document).on('click','#actualizar',(e)=>{
        let productos,precios;
        precios=document.querySelectorAll('.precio');
        productos=recuperarLs();
        productos.forEach( function(producto,indice) {
            producto.precio=precios[indice].textContent;
        });
        localStorage.setItem('productos',JSON.stringify(productos));
        calcular_total();
    })
    $('#cp').keyup((e)=>{
        let id,cantidad,producto,productos,montos,precio;
        producto=$(this)[0].activeElement.parentElement.parentElement
        id=$(producto).attr('prodId');
        precio=$(producto).attr('prodPrecio');
        cantidad=producto.querySelector('input').value;
        montos=document.querySelectorAll('.subtotales');
        productos=recuperarLs();

        productos.forEach(function(prod,indice)  {
            if(prod.id === id){
                prod.cantidad=cantidad;
                prod.precio=precio;
                montos[indice].innerHTML=`<h5>${cantidad*precio}</h5>`;
            }
        });
        localStorage.setItem('productos',JSON.stringify(productos));
        calcular_total();
    })
    function calcular_total(){
        let productos,subtotal,con_iva,total_sin_descuento,pago,vuelto,descuento;
        let total=0,IVA=0.12;
        productos=recuperarLs();
        productos.forEach(producto => {
            let subtotal_producto=Number(producto.precio * producto.cantidad);
            total=total+subtotal_producto;
        });
        pago=$('#pago').val();
        descuento=$('#descuento').val();

        total_sin_descuento=total.toFixed(2);
        con_iva=parseFloat(total*IVA).toFixed(2);
        subtotal=parseFloat(total-con_iva).toFixed(2);
        total=total-descuento;
        vuelto=pago-total;
        $('#subtotal').html(subtotal);
        $('#con_igv').html(con_iva);
        $('#total_sin_descuento').html(total_sin_descuento);
        $('#total').html(total);
        $('#vuelto').html(vuelto);
    }
    //funcion para procesar el pago de producto//
    function procesar_compra(){
        let nombre,cedula;
        nombre=$('#cliente').val();
        cedula=$('#cedula').val();
        total=$("#total").val();

        if(recuperarLs().length==0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No hay producto,Seleccionar alguno!'
            }).then(function(){
                location.href='../vista/adm_catalogo.php';
            })
        }
        else if(nombre==''){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Ingresar el campo del nombre del cliente!'
            })
        }else{
            verificar_Stock().then(error=>{
                if(error==0){
                    registar_compra(nombre,cedula);
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Se realizo la compra',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function(){
                        eliminarLS();
                        Location.href='../vista/adm_catalogo.php';
                    })
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'La cantidad solicitada supera al stock del producto!'
                    })
                }
            });
        }
    }
    async function verificar_Stock(){
        let productos;
        funcion='verificar_stock';
        productos=recuperarLs();

        const response= await fetch('../controlador/controlador-producto.php',{
            method :'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'funcion='+funcion+'&&productos='+JSON.stringify(productos)
        })
        let error=await response.text();
        return error;
    }
    function registar_compra(nombre,cedula){
        funcion='registar_compra';
        let total=$('#total').get(0).textContent;
        let productos=recuperarLs();
        let json=JSON.stringify(productos);


        $.ajax({
            data:{"funcion":funcion,"nombre":nombre,"cedula":cedula,"total":total,"json":json},
            type:"POST",
            dataType:"json",
            url:"../controlador/controlador-compra.php",
        }).done(function(response){
            console.log(response);
        })

    }
})











