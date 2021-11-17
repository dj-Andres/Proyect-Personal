$(document).ready(()=>{
    search();
    $("#form-empresa").submit((e)=>{
        e.preventDefault();
        let funcion = "crear";
        let name = $("#nombre").val();
        let ruc_number = $("#ruc").val();
        let phone = $("#telefono").val();
        let address = $("#direccion").val();
        let email = $("#email").val();

        $.post('../controlador/controlador-empresa.php',{funcion,name,ruc_number,phone,email,address},(response)=>{
            if(response=='crear'){
                $('#nueva-empresa').hide('slow');
                $('#nueva-empresa').show(1000);
                $('#nueva-empresa').hide(2000);
                $('#form-empresa').trigger('reset');
                search();
            }
            if(response=='nocrear'){
                $('#nocrear-empresa').hide('slow');
                $('#nocrear-empresa').show(1000);
                $('#nocrear-empresa').hide(2000);
                $('#form-empresa').trigger('reset');
           }
        });
    });
    function search(){
        let funcion ="search";
        $.post('../controlador/controlador-empresa.php',{funcion},(response)=>{
            const empresa=JSON.parse(response);
            let templete='';
            empresa.forEach(element => {
                templete+=`
                        <div empresaID="${element.id}" empresaNom="${element.nombre}" empresaRuc="${element.ruc}"  empresaTelefono="${element.telefono}"  empresaAvatar="${element.avatar}" empresaEmail="${element.email}" empresaDireccion="${element.direccion}"  class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                        <div class="card bg-light">
                            <div class="card-header text-muted border-bottom-0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                            <div class="card-body pt-0">
                                <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b>${element.nombre}</b></h2>
                                    <h4 class="lead"><b><i class="far fa-lg fa-credit-card mr-1"></i>${element.ruc}</b></h4>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Telefono: ${element.telefono}</font></font></li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope-square"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Email: ${element.email}</font></font></li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-map-marked-alt"></i></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Dirección: ${element.direccion}</font></font></li>
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="${element.avatar}" alt="" class="img-circle img-fluid">
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
                            </div>
                        </div>
                        </div>
                    </div>
                `;
            });
            $("#empresa").html(templete);
        });
    }
});