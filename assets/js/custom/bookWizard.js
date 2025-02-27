//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------

/* ------------------------------------------------------------------------------
 *
 *  Input Masks */

// Setup module
// ------------------------------




// Setup module
// ------------------------------

function cod_func(){
    if(!form.checkValidity()){return;}

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
                        url:  base_url + "API/OR_BOOK",
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

var FormWizard = function() {


    //
    // Setup module components
    //

    // Wizard
    var _componentWizard = function() {
        if (!$().steps) {
            console.warn('Warning - steps.min.js is not loaded.');
            return;
        }


        //
        // Wizard with validation
        //

        // Stop function if validation is missing
        if (!$().validate) {
            console.warn('Warning - validate.min.js is not loaded.');
            return;
        }

        // Show form
        var form = $('.steps-validation').show();


        // Initialize wizard
        $('.steps-validation').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: '<i class="icon-arrow-left13 mr-2" /> Passo Anterior',
                next: 'Seguinte <i class="icon-arrow-right14 ml-2" />',
                finish: 'Agendar booking <i class="icon-arrow-right14 ml-2" />'
            },
            transitionEffect: 'fade',
            autoFocus: true,
            onStepChanging: function (event, currentIndex, newIndex) {

                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex) {
                    return true;
                }

                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex) {

                    // To remove error styles
                    form.find('.body:eq(' + newIndex + ') label.error').remove();
                    form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
                }

                form.validate().settings.ignore = ':disabled,:hidden';
                return form.valid();
            },
            onFinishing: function (event, currentIndex) {
                form.validate().settings.ignore = ':disabled';
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                cod_func();
            }
        });


        // Initialize validation
        $('.steps-validation').validate({
            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
            errorClass: 'validation-invalid-label',
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },

            // Different components require proper error label placement
            errorPlacement: function(error, element) {

                // Unstyled checkboxes, radios
                if (element.parents().hasClass('form-check')) {
                    error.appendTo( element.parents('.form-check').parent() );
                }

                // Input with icons and Select2
                else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
                    error.appendTo( element.parent() );
                }

                // Input group, styled file input
                else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
                    error.appendTo( element.parent().parent() );
                }

                // Other elements
                else {
                    error.insertAfter(element);
                }
            },
            rules: {
                email: {
                    email: true
                }
            }
        });
    };

    // Uniform
    var _componentUniform = function() {
        if (!$().uniform) {
            console.warn('Warning - uniform.min.js is not loaded.');
            return;
        }

        // Initialize
        $('.form-input-styled').uniform({
            fileButtonClass: 'action btn bg-blue'
        });
    };

    // Select2 select
    var _componentSelect2 = function() {
        if (!$().select2) {
            console.warn('Warning - select2.min.js is not loaded.');
            return;
        }

        // Initialize
        var $select = $('.form-control-select2').select2({
            minimumResultsForSearch: Infinity,
            width: '100%'
        });

        // Trigger value change when selection is made
        $select.on('change', function() {
            $(this).trigger('blur');
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentWizard();
            _componentUniform();
            _componentSelect2();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FormWizard.init();



});



//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------

/* ------------------------------------------------------------------------------
 *
 *  # Date and time pickers
 *
 *  Demo JS code for picker_date.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var DateTimePickers = function() {


    //
    // Setup module components
    //


    // Pickadate picker
    var _componentPickadate = function() {
        if (!$().pickadate) {
            console.warn('Warning - picker.js and/or picker.date.js is not loaded.');
            return;
        }

        var yesterday = new Date((new Date()).valueOf()-1000*60*60*24);


        $('.pickadate').pickadate({
            // Disable date range
            disable: [
                { from: [0,0,0], to: yesterday }
            ],
            orientation: "top"
        });


    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentPickadate();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DateTimePickers.init();
});

