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
            warnAfter: 600000,
            redirAfter: 650000,
            keepBtnText: 'Continuar ligado',
            keepAliveUrl: '/',
            redirUrl: 'http://127.0.0.1/coregeek/r/profile/lockout',
            logoutUrl: 'http://127.0.0.1/coregeek/login'
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