document.addEventListener('DOMContentLoaded', function() {

// Single picker
    $('.daterange-single').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD/MM/YYYY'
        }
    });

});

function cod_func(){
    bootbox.dialog({
        title: "Novo booking",
        message: '<div class="row">\n' +
            '                <div class="col-md-12">\n' +
            '                    <form action="#" class="modal-body form-inline justify-content-center">\n' +
            '                        <label class="ml-sm-2">Codigo Funcionario</label>\n' +
            '                        <input id="cod" type="password" placeholder="codigo funcionario" class="form-control mb-2 mr-sm-2 ml-sm-2 mb-sm-0" required>\n' +
            '\n' +
            '                     \n' +
            '                    </form>\n' +
            '                    </div>\n' +
            '                </div>',
        buttons: {
            success: {
                label: "book",
                className: "btn btn-primary btn-block",
                callback: function () {
                    var codFunc = $('#cod').val();
                    var token = $.cookie("SID");

                    var postData =
                        {
                            "token": token,
                            "codFunc":codFunc,
                        };


                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: base_url + "/API/OR_BOOK",
                        data: {data:postData},
                        success: function(data){
                            $('#cod_func').val(codFunc);
                            form.submit();
                        },
                        error: function(e){
                            alert('Verifique o codigo de funcionario');
                        }
                    });


                }
            }
        }
    });
};

document.addEventListener('DOMContentLoaded', function() {

    $(document).on('click', '#submit_btn', function(){cod_func()});


});