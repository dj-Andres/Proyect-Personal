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
        funcion='crear';

        let nombre=$('#nombre_producto').val();
        let concentracion=$('#concentracion').val();
        let adicional=$('#adicional').val();
        let precio=$('#precio').val();
        let laboratorio=$('#laboratorio').val();
        let tipo=$('#tipo_producto').val();
        let presentacion=$('#presentacion').val();
        
        $.post('../controlador/controlador-producto.php',{funcion,nombre,concentracion,adicional,precio,laboratorio,tipo,presentacion},(response)=>{
            if(response=='crear'){
                $('#crear').hide('slow');
                $('#crear').show(1000);
                $('#crear').hide(2000);
                $('#form-crear-prodcuto').trigger('reset');
                //buscar_producto();
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
        $.post('../controlador/controlador-producto.php',{consulta,funcion},(response)=>{
            console.log(response);
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