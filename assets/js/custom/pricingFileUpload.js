/* ------------------------------------------------------------------------------
 *
 *  # Bootstrap multiple file uploader
 *
 *  Demo JS code for uploader_bootstrap.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var FileUpload = function() {


    //
    // Setup module components
    //

    // Bootstrap file upload
    var _componentFileUpload = function() {
        if (!$().fileinput) {
            console.warn('Warning - fileinput.min.js is not loaded.');
            return;
        }

        //
        // Define variables
        //

        //
        // AJAX upload
        //

        var $el1 = $(".file-input-ajax");
        $el1.fileinput({
            browseLabel: 'Browse',
            browseIcon: '<i class="icon-file-plus mr-2"></i>',
            uploadIcon: '<i class="icon-file-upload2 mr-2"></i>',
            removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
            allowedFileExtensions: ['xlsx'],
            uploadUrl: base_url + "/v1/pricing/upload",
            overwriteInitial: false,
            maxFilesNum: 1,
            preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
            previewFileIconSettings: { // configure your icon file extensions
                'xlsx': '<i class="fas fa-file-excel text-success"></i>',
            },
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });

    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentFileUpload();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FileUpload.init();
});
