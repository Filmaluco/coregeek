/* ------------------------------------------------------------------------------
 *
 *  # Basic datatables
 *
 *  Demo JS code for datatable_basic.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------
$(document).ready(function(){



    // Basic initialization
    $var = $('.datatable-button-html5-basic').DataTable({
        autoWidth: false,
        dom: '<"toolbar id=pesquisa">B',
        paging: false,
        ordering: true,
        order: [[0, "asc"]],
        searching: true,
        searchPlaceholder: 'Procure por qualquer campo...',
        buttons: {
            dom: {
                button: {
                    className: 'btn btn-default'
                }
            },
            buttons: [
                {
                    extend: 'copyHtml5',
                    footer: true,
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    footer: true,
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                }
            ]
        }
    });

    $("div.toolbar").html('<form action="#"> <div class="input-group text-left col-md-12">\n' +
        '                        <div class="form-group-feedback form-group-feedback-left float-lg" >\n' +
        '                            <input type="text" id="pesquisa" class="form-control form-control-lg" placeholder="Procure por qualquer campo" >\n' +
        '                            <div class="form-control-feedback form-control-feedback-lg">\n' +
        '                                &nbsp;<i class="icon-search4 text-muted"></i>\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                            <div class="input-group col-md-2"><select id="dynamic_select" class="form-control wmin-200" onchange="this.form.submit()">\n' +
        '                                    <option value="" selected>filtro...</option>\n' +
        '                                    <option value="onGoing">Em Curso</option>\n' +
        '                                    <option value="finished">Finalizados</option>\n' +
        '                                    <option value="all">Todos</option>\n' +
        '                                </optgroup>\n' +
        '                            </select></div></div>\n' +
        '                        </form>');


    $('#pesquisa').keyup(function(){
        $var.search($(this).val()).draw() ;
    });

    $(function(){
        // bind change event to select
        $('#dynamic_select').on('change', function () {
            var url = window.location.origin + "/r/booking/search/" + $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
    });

    // Custom bootbox dialog with form





    $('.stateUpdate').on('click', function() {
        var orID = this.id;
        bootbox.dialog({
            title: "OR " + this.id + " - atualizacao do estado",
            message: '<form action="#" class="modal-body form-inline ">\n' +
                '                        <label>Estado:</label>\n' +
                '\n' +
                '                        <select id="state'+orID+'" class="form-control col-auto  ">\n' +
                '                            <option value="1">Agendado</option>\n' +
                '                            <option value="2">Recebido na Loja </option>\n' +
                '                            <option value="4">Recebido em Laboratorio</option>\n' +
                '                            <option value="7">OR Recusado</option>\n' +
                '                            <option value="8">Aguarda Stock</option>\n' +
                '                            <option value="9">Em Reparação</option>\n' +
                '                            <option value="10">Reparado</option>\n' +
                '                            <option value="15">Entregue (Reparado)</option>\n' +
                '                            <option value="16">Entregue (S/ Reparação)</option>\n' +
                '                            <option value="17">Cancelado</option>\n' +
                '                        </select>\n' +
                '\n' +
                '                        <label> Codigo Funcionario</label>\n' +
                '                        <input id="cod'+orID+'" type="password" placeholder="codigo funcionario" class="form-control mb-2 mr-sm-2 ml-sm-2 mb-sm-0" required>\n' +
                '\n' +
                '                     \n' +
                '                    </form>\n',
            buttons: {
                success: {
                    label: "Update",
                    className: "btn btn-primary btn-block",
                    callback: function () {
                        var state = $('#state'+orID).val();
                        var state_name = $( "#state"+orID+ " option:selected" ).text();
                        var codFunc = $('#cod'+orID).val();
                        var token = $.cookie("SID");

                        var postData =
                            {
                                "token": token,
                                "orID":orID,
                                "stateID":state,
                                "codFunc":codFunc,
                            };


                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: window.location.origin + "/coregeek/API/OR_STATE",
                            data: {data:postData},
                            success: function(data){
                                $("#"+orID+"_state").text(state_name);
                            },
                            error: function(e){
                                alert('Verifique o codigo de funcionario');
                            }
                        });


                    }
                }
            }
        });
    });

});

// Initialize module
// ------------------------------

