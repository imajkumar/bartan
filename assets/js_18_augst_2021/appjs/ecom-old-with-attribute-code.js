var max_fields = 50; //maximum input boxes allowed
var wrapper = $(".input_fields_wrap"); //Fields wrapper
var add_button = $(".add_field_button"); //Add button ID

var x = 1; //initlal text box count
$(add_button).click(function(e) { //on add input button click
    e.preventDefault();
    // ajax 
    var formData = {
        'type': 1,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        url: BASE_URL + '/getAjaxAttributes',
        type: 'POST',
        data: formData,
        success: function(res) {
            if (x < max_fields) { //max input box allowed
                x++; //text box increment

                $(wrapper).append(`<div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Attribute</label>
                        <select class="form-control" id="attribute" name="attribute[]" placeholder="Please select attribute">
                            <option value="">-SELECT-</option>
                          ${ res }
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Is required</label>
                        <select class="form-control" id="is_required" name="is_required[]">
                            <option value="">-SELECT-</option>
                            <option value="1">Yes</option>
                            <option value="2">No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Is unique</label>
                        <select class="form-control" id="is_unique" name="is_unique[]">
                            <option value="">-SELECT-</option>
                            <option value="1">Yes</option>
                            <option value="2">No</option>
                        </select>

                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Is comparable</label>
                        <select class="form-control" id="is_comparable" name="is_comparable[]">
                            <option value="">-SELECT-</option>
                            <option value="1">Yes</option>
                            <option value="2">No</option>
                        </select>

                    </div>
                </div>
                <div class="col-md-1">
                                    <div class="form-group">
                                        
                                        <button type="button" style="margin-top: 27px;" id="addCustomerBtn" class="btn btn-sm btn-danger m-r-5 remove_field_icat">X </button>

                                    </div>
                                </div>



            </div>`); //add input box
            }
        }
    });



});

$(wrapper).on("click", ".remove_field_icat", function(e) { //user click on remove text
    e.preventDefault();
    $(this).parent('div').parent('div').parent('div').remove();
    x--;
})


//selectProduct
$("select.selectProductAttribute").change(function() {

    var selectedProductCatID = $(this).children("option:selected").val();
    //ajax
    $('#productAttribute').html("<option value=''>-SELECT-</option>");
    var formData = {
        'selectedProductCatID': selectedProductCatID,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/getAjaxAttriubeByCatID',
        data: formData,
        success: function(res) {
            $('#productAttribute').append(res);
        }
    });
    //ajax

});
//selectProduct

$("select.productAttribute").change(function() {
    var selectAttrID = $(this).children("option:selected").val();
    //alert(selectAttrID);
    //ajax
    //$( '#productAttribute' ).html( "<option value=''>-SELECT-</option>" );
    var formData = {
        'selectAttrID': selectAttrID,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/getAjaxSelectedAttributeValue',
        data: formData,
        success: function(res) {
            $('.appendDataHtml').append(res);



            $('.appendDataHtml').on("click", ".remove_field_Attr", function(e) { //user click on remove text
                e.preventDefault();
                $(this).parent('div').parent('div').parent('div').remove();

            })
            savePAtr();



        }
    });
    //ajax

});



// Dropzone.options.imajkumar = {
//     paramName: "file",
//     maxFiles: 1,
//     maxFilesize: 1000888,
//     addRemoveLinks: !0,
//     //acceptedFiles: "image/*,application/png,.jpg",
//     acceptedFiles: ".pdf,.mkv,.avi",
//     accept: function ( e, o )
//     {
//         "justinbieber.jpg" == e.name ? o( "Naha, you don't." ) : o()
//     },
//     sending: function ( file, xhr, formData )
//     {

//         var publish_on = $( 'input[name="txtPayOrderIDInvAdd"]' ).val();
//         var txtAdminAccountOCInvoice = $( '#txtAdminAccountOCInvoice' ).val();

//         var  _token = $( 'meta[name="csrf-token"]' ).attr( 'content' );
//         formData.append( 'orderid', publish_on );
//         formData.append( 'notes', txtAdminAccountOCInvoice );
//         formData.append( '_token', _token );

//     }
// };


//save 
function savePAtr() {
    $("#ajaxProductAttrSave").validate({
        rules: {
            name: "required",
            email: { email: true, required: true },
            mobile: { required: true, minlength: 10 },

        },

        messages: {
            name: "Please fill name",
            email: {
                email: "Enter Valid Email!",
                required: "Enter Email!"
            },
            mobile: {
                minlength: "Please enter Valid Mobile No.",
                required: "Please enter Mobile No."
            },
        },

        submitHandler: function(form) {

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(res) {
                    if (res.status == 1) {
                        $.gritter.add({
                            title: 'Product Modification',
                            text: res.msg
                        });
                        location.reload(1);
                    }
                },
                dataType: 'json'
            });
        }
    });
}
// save attribute of product 

//saveChangesProductTaxation
$("#saveChangesProductTaxation").submit(function(event) {

    event.preventDefault(); //prevent default action 
    var post_url = $(this).attr("action"); //get form action url
    var request_method = $(this).attr("method"); //get form GET/POST method
    var form_data = $(this).serialize(); //Encode form elements for submission

    $.ajax({
        url: post_url,
        type: request_method,
        data: form_data
    }).done(function(response) { //

        if (response.status == 1) {

            $.gritter.add({
                title: 'Item Category',
                text: response.msg
            });
            location.reload(1);

        }

    });
});

//saveChangesProductTaxation

//saveItemCategoryeditProduct
$("#saveChangesProductRelation").submit(function(event) {

    event.preventDefault(); //prevent default action 
    var post_url = $(this).attr("action"); //get form action url
    var request_method = $(this).attr("method"); //get form GET/POST method
    var form_data = $(this).serialize(); //Encode form elements for submission

    $.ajax({
        url: post_url,
        type: request_method,
        data: form_data
    }).done(function(response) { //

        if (response.status == 1) {

            $.gritter.add({
                title: 'Item Category',
                text: response.msg
            });
            location.reload(1);

        }

    });
});

$("#saveItemCategoryeditProduct").submit(function(event) {

    event.preventDefault(); //prevent default action 
    var post_url = $(this).attr("action"); //get form action url
    var request_method = $(this).attr("method"); //get form GET/POST method
    var form_data = $(this).serialize(); //Encode form elements for submission

    $.ajax({
        url: post_url,
        type: request_method,
        data: form_data
    }).done(function(response) { //

        if (response.status == 1) {

            $.gritter.add({
                title: 'Item Category',
                text: response.msg
            });
            location.reload(1);

        }

    });
});


//saveItemCategoryeditProduct

// process the form
$("#saveItemCategory").submit(function(event) {
    event.preventDefault(); //prevent default action 
    var post_url = $(this).attr("action"); //get form action url
    var request_method = $(this).attr("method"); //get form GET/POST method
    var form_data = $(this).serialize(); //Encode form elements for submission

    $.ajax({
        url: post_url,
        type: request_method,
        data: form_data
    }).done(function(response) { //

        if (response.status == 1) {

            $.gritter.add({
                title: 'Item Category',
                text: response.msg
            });

            window.location.replace(response.url);

        }

    });
});
//itemBarcode
$('#itemBarcode').keyup(function() {
        var barcode = $(this).val();
        if (barcode.length == 13) {

            //ajax
            var formData = {
                'barcode': barcode,
                '_token': $('meta[name="csrf-token"]').attr('content')
            };
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/checkUniBarcode',
                data: formData,

                success: function(responce) {
                    if (responce.status == 1) {
                        $.gritter.add({
                            title: 'Barcode',
                            text: responce.msg
                        });
                        $('#SAVE_CHANGES').prop('disabled', true);
                        $(this).focus();
                    } else {
                        $('#SAVE_CHANGES').prop('disabled', false);
                    }
                },
                dataType: 'json'
            });
            //ajax

        }
    })
    //itemBarcode
$("#saveClassDiscount").submit(function(event) {
    event.preventDefault();

    var post_url = $(this).attr("action");
    var request_method = $(this).attr("method");
    var form_data = $(this).serialize();

    $.ajax({
        url: post_url,
        type: request_method,
        data: form_data,
        success: function(response) {

            if (response.status == 1) {

                $.gritter.add({
                    title: 'Class discount',
                    text: response.msg
                });
                $("#saveClassDiscount")[0].reset();
                $('#appendClassDiscount').empty().append(response.appendDiscount);

            } else if (response.status == 0) {
                $.gritter.add({
                    title: 'Class discount',
                    text: response.msg
                });

            }



        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });

            $.gritter.add({
                title: 'Class discount',
                text: 'Please fill all fields'
            });
            // toastr.error(errorHtml);

        }
    });
});



function updateClassDiscountBtn() {

    var post_url = $("#updateClassDiscount").attr("action");
    var request_method = $("#updateClassDiscount").attr("method");
    var form_data = $("#updateClassDiscount").serialize() + "&_token=" + $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: post_url,
        type: request_method,
        data: form_data,
        success: function(response) {

            if (response.status == 1) {

                $.gritter.add({
                    title: 'Class discount',
                    text: response.msg
                });

                $('#appendClassDiscount').empty().append(response.appendDiscount);
                // $("#updateClassDiscount").reset();
                $("#updateClassDiscount").hide();
                $("#saveClassDiscount").show();

            } else if (response.status == 0) {
                $.gritter.add({
                    title: 'Class discount',
                    text: response.msg
                });

            } else {
                $("#updateClassDiscount").show();
            }



        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });

            $.gritter.add({
                title: 'Class discount',
                text: 'Please fill all fields'
            });
            // toastr.error(errorHtml);

        }

    });
}

$('.hellodel').on('click', function(e) {
    e.preventDefault();
    alert();
    let classDiscountId = $(this).attr('id');
    alert(classDiscountId);

    var formData = {
        'classDiscountId': classDiscountId,

        '_token': $('meta[name="csrf-token"]').attr('content')
    };

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/hello',
        data: formData,
        //dataType: "json",

        success: function(responce) {

            alert(responce);

        },


    })

});

function neerajtest(classDiscountId) {
    //alert(BASE_URL + '/hello');
    alert(classDiscountId);
    var formData = {
        'classDiscountId': classDiscountId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    alert(formData);
    $.ajax({
        type: 'post',
        url: BASE_URL + '/hello',
        data: formData,

        success: function(responce) {

            alert();
        },

    });
}



function deleteCategoryDiscount(categoryDiscountId) {
    alert(BASE_URL + '/deleteCategoryDiscount');
    var formData = {
        'categoryDiscountId': categoryDiscountId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/deleteCategoryDiscount',
        data: formData,

        success: function(responce) {
            console.log(responce);
            alert(responce);
            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                //window.location.replace(responce['url']);

            } else {
                alert(responce);
                toastr.warning(responce['msg']);
                //window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function updateCategoryDiscountBtn() {

    var post_url = $("#updateCategoryDiscount").attr("action");
    var request_method = $("#updateCategoryDiscount").attr("method");
    var form_data = $("#updateCategoryDiscount").serialize() + "&_token=" + $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: post_url,
        type: request_method,
        data: form_data,
        success: function(response) {

            if (response.status == 1) {

                $.gritter.add({
                    title: 'Category discount',
                    text: response.msg
                });

                $('#appendCategoryDiscount').empty().append(response.appendDiscount);
                // $("#updateClassDiscount").reset();
                $("#updateCategoryDiscount").hide();
                $("#saveCategoryDiscount").show();

            } else if (response.status == 0) {
                $.gritter.add({
                    title: 'Category discount',
                    text: response.msg
                });

            } else {
                $("#updateCategoryDiscount").show();
            }



        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });

            $.gritter.add({
                title: 'Class discount',
                text: 'Please fill all fields'
            });
            // toastr.error(errorHtml);

        }


    });
}

$("#saveCategoryDiscount").submit(function(event) {
    event.preventDefault();

    var post_url = $(this).attr("action");
    var request_method = $(this).attr("method");
    var form_data = $(this).serialize();

    $.ajax({
        url: post_url,
        type: request_method,
        data: form_data,
        success: function(response) {

            if (response.status == 1) {

                $.gritter.add({
                    title: 'Category discount',
                    text: response.msg
                });
                $("#saveCategoryDiscount")[0].reset();
                $('#appendCategoryDiscount').empty().append(response.appendDiscount);
                //window.location.replace(response.url);

            } else if (response.status == 0) {
                $.gritter.add({
                    title: 'Category discount',
                    text: response.msg
                });

            }



        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });

            $.gritter.add({
                title: 'Class discount',
                text: 'Please fill all fields'
            });
            // toastr.error(errorHtml);

        }

    });
});



//neeraj start




function editCategoryDiscount(categoryDiscountId) {

    var formData = {
        'categoryDiscountId': categoryDiscountId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/editCategoryDiscount',
        data: formData,

        success: function(responce) {

            if (responce.status == 1) {

                $("#saveCategoryDiscount").hide();
                $("#disountCategoryHtmlEditForm").empty().append(responce.disountClassHtmlEdit);

            } else {

                $("#saveCategoryDiscount").show();

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            // toastr.error(errorHtml);

        }
    });
}

function editClassDiscount(classDiscountId) {

    var formData = {
        'classDiscountId': classDiscountId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/editClassDiscount',
        data: formData,

        success: function(responce) {

            if (responce.status == 1) {

                $("#saveClassDiscount").hide();
                $("#disountClassHtmlEditForm").empty().append(responce.disountClassHtmlEdit);

            } else {

                $("#saveClassDiscount").show();

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            // toastr.error(errorHtml);

        }
    });
}

function deleteItemAttrOption(attrOptionId) {

    var formData = {
        'attrOptionId': attrOptionId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/deleteItemAttrOption',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                //window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function customerDeactive(customerId) {

    var formData = {
        'customerId': customerId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/customerDeactive',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function activeHsn(hsnId) {

    var formData = {
        'hsnId': hsnId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/activeHsn',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function activeClass(id) {

    var formData = {
        'id': id,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/activeClass',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function activeCustomerCategory(id) {

    var formData = {
        'id': id,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/activeCustomerCategory',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function deactiveClass(id) {

    var formData = {
        'id': id,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/deactiveClass',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function deactiveCustomerCategory(id) {

    var formData = {
        'id': id,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/deactiveCustomerCategory',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function deactiveHsn(hsnId) {

    var formData = {
        'hsnId': hsnId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/deactiveHsn',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function bannerDeactive(bannerId) {

    var formData = {
        'bannerId': bannerId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/bannerDeactive',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function bannerActive(bannerId) {

    var formData = {
        'bannerId': bannerId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/bannerActive',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function sellerDeactive(customerId) {

    var formData = {
        'customerId': customerId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/sellerDeactive',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function itemActive(itemId) {
    var formData = {
        'itemId': itemId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/itemActive',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function itemDeactive(itemId) {
    var formData = {
        'itemId': itemId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/itemDeactive',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function customerActive(customerId) {
    var formData = {
        'customerId': customerId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/customerActive',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function sellerActive(customerId) {
    var formData = {
        'customerId': customerId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/sellerActive',
        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                toastr.success(responce['msg']);
                window.location.replace(responce['url']);

            } else {

                toastr.warning(responce['msg']);
                window.location.replace(responce['url']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${ item }</strong></br>`;
            });
            toastr.error(errorHtml);

        }
    });
}

function updateOrderStage(itemOrderIdAndStage) {

    var orderIdAndStageFelter = itemOrderIdAndStage.split('_');
    var itemOrderId = orderIdAndStageFelter[0];
    var stage = orderIdAndStageFelter[1];

    $('#itemOrderId').val(itemOrderId);
    //$("#gender").val("Male").attr("selected","selected");
    $('#stage').val(stage).attr("selected", "selected");
}

function updateOrderStageAdminByItem(itemOrderIdAndStage) {

    var orderIdAndStageFelter = itemOrderIdAndStage.split('_');
    var itemOrderId = orderIdAndStageFelter[0];
    var stage = orderIdAndStageFelter[1];

    $('#itemOrderIdByItem').val(itemOrderId);
    //$("#gender").val("Male").attr("selected","selected");
    $('#stageByItem').val(stage).attr("selected", "selected");
}

function updateCustomerDiscount(customerId) {

    var customerId = customerId;
    $('#customerId').val(customerId);

}

function updateHsn(hsnData) {
    var hsnDataEx = hsnData.split('_');
    var hsnId = hsnDataEx[0];
    var hsnName = hsnDataEx[1];

    $('#hsnId').val(hsnId);
    $('#hsnName').val(hsnName);

}

function updateCustomerCategory(customerCategoryData) {

    var categoryData = customerCategoryData.split('_');
    var customerCategoryId = categoryData[0];
    var custCategoryName = categoryData[1];

    $('#customerCategoryId').val(customerCategoryId);
    $('#custCategoryName').val(custCategoryName);

}

function updateCustomerClass(customerClassData) {

    var classData = customerClassData.split('_');
    var custClassId = classData[0];
    var custClassName = classData[1];

    $('#customerClassId').val(custClassId);
    $('#custClassName').val(custClassName);

}



$('.country').change(function() {
    var country = $(this).val();
    var formData = {
        'country': country,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        url: BASE_URL + '/statesByCountry',
        type: 'POST',
        data: formData,
        success: function(res) {
            $('.state').find('option').remove().end().append(res);
        }
    });
});

$('.state').change(function() {
    var state_id = $(this).val();

    var formData = {
        'state_id': state_id,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        url: BASE_URL + '/cityByState',
        type: 'POST',
        data: formData,
        success: function(res) {
            $('.city').find('option').remove().end().append(res);
        }
    });
});


$('.modal').on('hidden.bs.modal', function() {
    // alert(14234);
    location.reload(1);
})


$('.getAdminOrder').on('click', function(e) {
    e.preventDefault();

    let order = $(this).attr('id');

    var formData = {
        'stage': order,

        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    //alert(formData);
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/getAdminOrder',
        data: formData,
        //dataType: "json",

        success: function(responce) {

            //alert(responce);
            if (responce['success'] == true) {
                //console.log(responce['ordeHtml']);
                //alert(responce['ordeHtml']);
                //$('#appendOrderItemAdmin').empty().append(responce['ordeHtml']);

                $('#appendOrderItemAdmin').empty().append(responce['ordeHtml']);


            } else {

                $('#appendOrderItemAdmin').empty().append('Recourd not found.');

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${item}</strong></br>`;
            });


        }

    })

});


//neeraj end