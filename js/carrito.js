$(document).ready(function(){
    template='';
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
        //const stock=$(elemento).attr('prodStock');

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
            //stock:stock,
            cantidad:1
        }
        template+=`
        <tr prodId="${producto.id}">
            <td>${producto.id}</td>
            <td>Producto</td>
            <td>${producto.concentracion}</td>
            <td>${producto.adicional}</td>
            <td>${producto.precio}</td>
            <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
        </tr>
        `;
        $('#lista').html(template);
    })
    $(document).on('click','.borrar-producto',(e)=>{
        const elemento=$(this)[0].activeElement.parentElement.parentElement;
        elemento.remove();
        
    })
})