$(document).ready(function(){
    buscar_proveedor();
    $('#form-crear').submit(e=>{
        let nombre=$('#nombre').val();
        let telefono=$('#telefono').val();
        let correo=$('#correo').val();
        let direccion=$('#direccion').val();

        funcion='crear';

        $.post('../controlador/controlador-proveedor.php',{nombre,telefono,correo,direccion,funcion},(response)=>{
            if(response=='crear'){
                $('#crear').hide('slow');
                $('#crear').show(1000);
                $('#crear').hide(2000);
                $('#form-crear').trigger('reset');
                //buscar_proveedor();
            }
            if(response=='no-crear'){
                $('#nocrear').hide('slow');
                $('#nocrear').show(1000);
                $('#nocrear').hide(2000);
                $('#form-crear').trigger('reset');
            }
        })
        e.preventDefault();
    })
    function buscar_proveedor(consulta){
        funcion='buscar';
        $.post('../controlador/controlador-proveedor.php',{consulta,funcion},(respose)=>{
            console.log(respose);
        })
    }
    $(document).on('keyup','#buscar',function(){
        let valor=$(this).val();
        if(valor!=''){
            buscar_proveedor(valor);
        }else{
            buscar_proveedor();
        }
    })
})