$(document).ready(function(){
    mostrar_consultas();
    function mostrar_consultas(){
        let funcion='mostrar_consultas';
        $.post('../controlador/controlador-venta.php',{funcion},(response)=>{
            const vistas=JSON.parse(response);
            $('#venta_dia_vendedor').html(vistas.venta_dia_vendedor);
            $('#venta_diaria').html(vistas.venta_diaria);
            $('#venta_mensual').html(vistas.venta_mensual);
            $('#venta_anual').html(vistas.venta_anual);
        })

    }
     funcion='listar';
    let datatable=$('#tabla_venta').DataTable( {
        "ajax": {
            "url":"../controlador/controlador-venta.php",
            "method":"POST",
            "data":{funcion:funcion}
        },
        "columns": [
            { "data": "id_venta" },
            { "data": "fecha" },
            { "data": "cliente" },
            { "data": "cedula" },
            { "data": "total" },
            { "data": "vendedor" },
            { "defaultContent": `
                <button class="pdf btn btn-secondary"><i class="fas fa-print"></i></button>
                <button class="ver btn btn-success" type="button" data-toggle="modal" data-target="#vista_venta"><i class="fas fa-search"></i></button>
                <button class="btn btn-danger"><i class="fas fa-window-close"></i></button>
            `}
        ],
         "language":espanol
    });
    $('#tabla_venta tbody').on('click','.ver',function(){
        let datos=datatable.row($(this).parents()).data();
        let id=datos.id_venta;
        funcion='ver';
        $('#codigo_venta').html(datos.id_venta);
        $('#Fecha').html(datos.fecha);
        $('#cliente').html(datos.cliente);
        $('#cedula').html(datos.cedula);
        $('#vendedor').html(datos.vendedor);
        $('#total').html(datos.total);

        $.post('../controlador/controlador-venta-producto.php',{funcion,id},(response)=>{
            let registros=JSON.parse(response);
            let template="";
            $('#registros').html(template);
            registros.forEach(registro => {
                template+=`
                    <tr>
                        <td>${registro.cantidad}</td>
                        <td>${registro.precio}</td>
                        <td>${registro.producto}</td>
                        <td>${registro.concentracion}</td>
                        <td>${registro.adicional}</td>
                        <td>${registro.laboratorio}</td>
                        <td>${registro.presentacion}</td>
                        <td>${registro.tipo}</td>
                        <td>${registro.subtotal}</td>
                    </tr>
                `;
            });
            $('#registros').html(template);
        })
    })
    $('#tabla_venta tbody').on('click','.pdf',function(){
        let funcion='reporte-venta';
        let datos=datatable.row($(this).parents()).data();
        let id=datos.id_venta;

        $.post('../controlador/controlador-venta-producto.php',{funcion,id},(response)=>{
            if (response =='') {
                window.open('../pdf/pdf-'+funcion+'.pdf','_blank');
            }
        });

    });

})
let espanol={
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    },
    "buttons": {
        "copy": "Copiar",
        "colvis": "Visibilidad"
    }
};
