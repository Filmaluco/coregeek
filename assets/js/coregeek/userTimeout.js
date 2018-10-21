/* ------------------------------------------------------------------------------
 *
 *  # Idle timeout
 *
 *  Demo JS code for extra_idle_timeout.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var IdleTimeout = function() {


    //
    // Setup module components
    //

    // Idle timeout
    var _componentIdleTimeout = function() {
        if (!$.sessionTimeout) {
            console.warn('Warning - session_timeout.min.js is not loaded.');
            return;
        }

        // Idle timeout
        $.sessionTimeout({
            heading: 'h5',
            title: 'Inatividade',
            message: 'Vai ser disconectado se continuar inativo, pretentende continuar ligado?',
            warnAfter: 900000,
            redirAfter: 950000,
            keepBtnText: 'Continuar ligado',
            keepAliveUrl: '/',
            redirUrl: 'userprofile/lockout',
            logoutUrl: '../login'
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentIdleTimeout();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    IdleTimeout.init();
});