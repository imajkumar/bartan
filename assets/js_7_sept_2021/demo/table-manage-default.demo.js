/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Version: 4.6.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin/admin/
*/

var handleDataTableDefault = function() {
    "use strict";

    if ($('#data-table-default').length !== 0) {
        $('#data-table-default').DataTable({
            responsive: true,
            order: [
                [0, 'desc']
            ]
        });
    }
};
var handleDataTableDefaultByClass = function() {
    "use strict";

    if ($('.data-table-default').length !== 0) {
        $('.data-table-default').DataTable({
            responsive: true

        });
    }
};

var handleDataTableDefaultByClassWithOutRes = function() {
    "use strict";

    if ($('.data-table-without-resp').length !== 0) {
        $('.data-table-without-resp').DataTable({
            //responsive: true

        });
    }
};

var TableManageDefault = function() {
    "use strict";
    return {
        //main function
        init: function() {
            handleDataTableDefault();
            handleDataTableDefaultByClass();
            handleDataTableDefaultByClassWithOutRes();
        }
    };
}();

$(document).ready(function() {
    TableManageDefault.init();
});