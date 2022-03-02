//Start Sales item
$('#saveItemMasterSales').on('submit', function(e) {
    e.preventDefault();

    $('#errorMsg').html('');
    $.ajax({
            type: 'POST',
            url: BASE_URL + '/saveItemSales',
            data: $('#saveItemMasterSales').serialize(),

            success: function(responce) {

                if (responce['status'] == 'success') {

                    toastr.success(responce['msg']);
                    window.location.replace(responce['url']);

                } else {

                    toastr.warning(responce['msg']);


                }
            },
            error: function(xhr, status, error) {
                //let errorMsg = '';
                //alert('empty');
                let errorHtml = '';
                $.each(xhr.responseJSON.errors, function(key, item) {
                    errorHtml += `<strong>${ item }</strong></br>`;
                });
                toastr.error(errorHtml);

            }

        })
        //alert('submitBtn');
});

$("#ajaxProductAttrSaveEditNeerajSales").validate({
    rules: {
        item_name: "required",

        //email: { email: true, required: true },
        //mobile: { required: true, minlength: 10 },

    },

    messages: {
        // name: "Please fill name",
        // email: {
        //     email: "Enter Valid Email!",
        //     required: "Enter Email!"
        // },
        // mobile: {
        //     minlength: "Please enter Valid Mobile No.",
        //     required: "Please enter Mobile No."
        // },
    },

    submitHandler: function(form) {

        //alert($('#jquery-tagIt-default').tagit("assignedTags"));
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        var formData = $(form).serializeArray();
        formData.push({ name: "productTag", value: $('#jquery-tagIt-default').tagit() });
        //console.log($(form).serialize());

        $.ajax({
            url: form.action,
            type: form.method,
            //data: $(form).serialize() + "&productTag=" + $('#jquery-tagIt-default').tagit("assignedTags"),
            data: $(form).serialize(),
            //data: formData,

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

$("select.selectProductAttributeSales").change(function() {

    var selectedProductCatID = $(this).children("option:selected").val();
    //ajax
    $('#productAttributeSales').html("<option value=''>-SELECT-</option>");
    var formData = {
        'selectedProductCatID': selectedProductCatID,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/getAjaxAttriubeByCatIDSales',
        data: formData,
        success: function(res) {
            $('#productAttributeSales').append(res);
        }
    });
    //ajax

});

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
        url: BASE_URL + '/getAjaxSelectedAttributeValueSales',
        data: formData,
        success: function(res) {

            if (res.type == 'text') {

                $('.appendDataHtml').append(res.HTML);
            } else {

                $('.appendDataHtml').empty().append(res.HTML);
            }




            $('.appendDataHtml').on("click", ".remove_field_Attr", function(e) { //user click on remove text
                e.preventDefault();
                $(this).parent('div').parent('div').parent('div').remove();

            })
            savePAtr();



        }
    });
    //ajax

});

$("#saveItemCategoryeditProductSales").submit(function(event) {

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

$("#saveChangesProductRelationSales").submit(function(event) {

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

$("#saveChangesProductTaxationSales").submit(function(event) {

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

function deleteItemAttrOptionSales(attrOptionId) {


    var formData = {
        'attrOptionId': attrOptionId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/deleteItemAttrOptionSales',
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

function itemActiveSales(itemId) {
    var formData = {
        'itemId': itemId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/itemActiveSales',
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

function itemDeactiveSales(itemId) {
    var formData = {
        'itemId': itemId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/itemDeactiveSales',
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
//End Sales item

function add_to_cart(itemID) {

    var formData = {
        'itemID': itemID,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/setSalesAddToCart',
        data: formData,
        success: function(responce) {

            $('#total').empty().append(responce.totalItem);

            $('#totalWithBag').empty().append(`Shopping Bag (${responce.totalItem})`);

            $('#htmlItemDataAppend').empty().append(responce.htmlItemData);
            // $.gritter.add({
            //     title: 'Cart',
            //     text: 'Successfully Added in cart',
            //     time: 1000,
            //     position: 'center'
            // });
        }
    });



}

//removeItemFromCart
function removeItemFromCart(itemID) {

    //ajax
    var formData = {
        'itemID': itemID,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/removeItemFromCart',
        data: formData,
        success: function(responce) {
            $.gritter.add({
                title: 'Cart',
                text: 'Item remove from cart'
            });
            location.reload(1);
        }
    });
    //ajax



}

function removeItemFromCartSales(itemID) {

    //ajax
    var formData = {
        'itemID': itemID,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/removeItemFromCartSales',
        data: formData,
        success: function(responce) {
            $.gritter.add({
                title: 'Cart',
                text: 'Item remove from cart'
            });
            location.reload(1);
        }
    });
    //ajax



}
//removeItemFromCart


$('#selesCustomer').on('change', function(e) {
    e.preventDefault();

    let customerId = $(this).val();

    var formData = {
        'customerId': customerId,

        '_token': $('meta[name="csrf-token"]').attr('content')
    };

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/getItemsWithCustomerBySeller',
        data: formData,

        success: function(responce) {

            if (responce['success'] == true) {
                $("#filtterItem").show();
                $("#salesItemByBrand").prop("selectedIndex", 0);
                $("#salesItemByCategory").prop("selectedIndex", 0);
                $("#salesItemSeach").val("");

                $('#salesItemByBrand').empty().append(responce['allowBrandOption']);
                $('#salesItemAppend').empty().append(responce['ordeHtml']);


            } else {

                $('#salesItemAppend').empty().append('Recourd not found.');

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


//Start filter search
$('#salesItemByBrand').on('change', function(e) {
    e.preventDefault();

    let brandId = $(this).val();

    var formData = {
        'brandId': brandId,

        '_token': $('meta[name="csrf-token"]').attr('content')
    };

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/salesItemByBrand',
        data: formData,

        success: function(responce) {

            if (responce['success'] == true) {

                $("#salesItemByCategory").prop("selectedIndex", 0);
                $("#salesItemSeach").val("");
                $('#salesItemAppend').empty().append(responce['ordeHtml']);


            } else {

                $('#salesItemAppend').empty().append('Recourd not found.');

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

$('#salesItemByCategory').on('change', function(e) {
    e.preventDefault();

    let catId = $(this).val();

    var formData = {
        'catId': catId,

        '_token': $('meta[name="csrf-token"]').attr('content')
    };

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/salesItemByCategory',
        data: formData,

        success: function(responce) {

            if (responce['success'] == true) {
                $("#salesItemByBrand").prop("selectedIndex", 0);

                $("#salesItemSeach").val("");
                $('#salesItemAppend').empty().append(responce['ordeHtml']);


            } else {

                $('#salesItemAppend').empty().append('Recourd not found.');

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

// $('#salesItemSeach').on('keyup', function(e) {
//     e.preventDefault();

//     let salesItemSeach = $(this).val();

//     var formData = {
//         'salesItemSeach': salesItemSeach,

//         '_token': $('meta[name="csrf-token"]').attr('content')
//     };

//     $.ajax({
//         type: 'POST',
//         url: BASE_URL + '/salesItemSeach',
//         data: formData,

//         success: function(responce) {

//             if (responce['success'] == true) {

//                 $('#salesItemAppend').empty().append(responce['ordeHtml']);


//             } else {

//                 $('#salesItemAppend').empty().append('Recourd not found.');

//             }
//         },
//         error: function(xhr, status, error) {

//             let errorHtml = '';
//             $.each(xhr.responseJSON.errors, function(key, item) {
//                 errorHtml += `<strong>${item}</strong></br>`;
//             });


//         }

//     })

// });


function searchItemBySales() {

    let salesItemSeach = $("#salesItemSeach").val();
    if (salesItemSeach == "") {
        return false;
    }

    var formData = {
        'salesItemSeach': salesItemSeach,

        '_token': $('meta[name="csrf-token"]').attr('content')
    };

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/salesItemSeach',
        data: formData,

        success: function(responce) {

            if (responce['success'] == true) {
                $("#salesItemByBrand").prop("selectedIndex", 0);
                $("#salesItemByCategory").prop("selectedIndex", 0);

                $('#salesItemAppend').empty().append(responce['ordeHtml']);


            } else {

                $('#salesItemAppend').empty().append('Recourd not found.');

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${item}</strong></br>`;
            });


        }

    })
}
//End filter search
//increseQTY




function increseQTY(itemID) {

    var istr = "#qty" + itemID;
    var itemQTY = $(istr).val();
    //ajax
    var formData = {
        'itemID': itemID,
        'itemQTY': itemQTY,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/setIncreseQTY',
        data: formData,
        success: function(responce) {
            $.gritter.add({
                title: 'Cart',
                text: 'Updated Added in cart'
            });
            location.reload(1);
        }
    });
    //ajax



}
//increseQTY

function increseQTYOnKeyPress(itemID) {

    var istr = "#qty" + itemID;
    var itemQTY = $(istr).val();

    //ajax
    var formData = {
        'itemID': itemID,
        'itemQTY': itemQTY,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/increseQTYOnKeyPress',
        data: formData,
        success: function(responce) {
            $.gritter.add({
                title: 'Cart',
                text: 'Updated Added in cart'
            });
            location.reload(1);
        }
    });
    //ajax



}

//decreaseQTY
function decreaseQTY(itemID) {

    var istr = "#qty" + itemID;
    var itemQTY = $(istr).val();
    //ajax
    var formData = {
        'itemID': itemID,
        'itemQTY': itemQTY,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/setDecreaseQTY',
        data: formData,
        success: function(responce) {
            $.gritter.add({
                title: 'Cart',
                text: 'Updated Added in cart'
            });
            location.reload(1);
        }
    });
    //ajax

}

if (performance.navigation.type == 2) {
    location.reload(1);
}


//decreaseQTY



$("#paymentBySales").validate({
    rules: {
        // barcode: "required",
    },

    messages: {

    },

    submitHandler: function(form) {

        $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            beforeSend: function() {
                $("#loadSpin").show();
                $("#processOrder").prop('disabled', true);
            },
            complete: function() {
                $("#loadSpin").hide();
                $("#processOrder").prop('disabled', false);
            },
            success: function(res) {
                if (res.status == 1) {
                    $.gritter.add({
                        title: 'Order',
                        text: res.msg
                    });
                    window.location.replace(res.url);
                } else {
                    $.gritter.add({
                        title: 'Order',
                        text: res.msg
                    });
                    window.location.replace(res.url);
                }
            },
            dataType: 'json'
        });
    }
});
//neeraj end