var handleBootstrapWizards = function() {
    "use strict";
    $('#wizard').smartWizard({
        selected: 0,
        theme: 'default',
        transitionEffect: '',
        transitionSpeed: 0,
        useURLhash: false,
        showStepURLhash: false,
        toolbarSettings: {
            toolbarPosition: 'bottom'

        },




    });

};

var FormWizard = function() {

    "use strict";
    return {
        //main function
        init: function() {
            handleBootstrapWizards();

        }



    };

}();

$(document).ready(function() {


    FormWizard.init();

});