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

});

// Initialize module
// ------------------------------

