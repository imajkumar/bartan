BASE_URL = $('meta[name="BASE_URL"]').attr('content');



//cart system 
// add to cart

//1.add to cart 
//2.update cart notification
//3.update cart list 
//4.show notification added in cart 

// $("#attrSelectionItemDescription").validate({
//     rules: {
//         attrSelect_1: {
//             required: true,

//         },
//         attrSelect_2: {
//             required: true,

//         },

//     },
//     // Specify validation error messages

//     messages: {
//         //attrSelect: "Please specify your name",
//         // email: {
//         //   required: "We need your email address to contact you",
//         //   email: "Your email address must be in the format of name@domain.com"
//         // }
//     }
// });

function attrValidationAndAddToCart(errorCount, itemID) {
    //alert(errorCount);
    // if ($("#attrSelectionItemDescription").valid()) {
    //     add_to_cart(itemID);
    // }
    var cart = [];
    for (var n = 1; n <= errorCount; n++) {
        var attrSelect = $('#attrSelect_' + n).val();

        if (attrSelect == "") {
            $('#attrSelectError_' + n).html('<span class="required-star">This field is required.</span>');

        } else {

            $('#attrSelectError_' + n).html('');
            cart.push(n);

        }
    }

    if (cart.length == errorCount) {
        add_to_cart(itemID);
    }






}

function add_to_cart(itemID) {

    var formData = {
        'itemID': itemID,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/setAddToCart',
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
// add to cart 

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
//removeItemFromCart

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
//decreaseQTY

//cart system

$('.getItem').on('click', function() {
    var catOrBrandId = $(this).attr('id');

    var formData = {
        'catOrBrandId': catOrBrandId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/getItemsByCatOrBrandIdByAjax',
        data: formData,

        success: function(responce) {
            if (responce['status'] == 'success') {

                $('#itemsByCategory').find('.item-row').remove().end().append(responce['itemHtml']);


            } else {

                $('#itemsByCategory').find('.item-row').remove().end().append(responce['msg']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${item}</strong></br>`;
            });
            //alert(errorHtml);
            //toastr.error(errorHtml);

        }
    });
});


$('.getItemTest').on('click', function() {
    var catOrBrandId = $(this).attr('id');

    var formData = {
        'catOrBrandId': catOrBrandId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'GET',
        url: BASE_URL + '/getItemsByCatOrBrandIdByAjaxForPagination',
        data: formData,

        success: function(responce) {
            if (responce['success'] == true) {

                alert();
                $('#itemsByCategory').find('.item-row').remove().end().append(responce['ordeHtml']);


            } else {


                $('#itemsByCategory').find('.item-row').remove().end().append('Items not found.');


            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${item}</strong></br>`;
            });
            //alert(errorHtml);
            //toastr.error(errorHtml);

        }
    });
});


$('.getItemByBrand').on('click', function() {
    var catOrBrandId = $(this).attr('id');

    var formData = {
        'catOrBrandId': catOrBrandId,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/getItemsByCatOrBrandIdByAjax',
        data: formData,

        success: function(responce) {
            if (responce['status'] == 'success') {

                $('#itemsByBrand').find('.item-row').remove().end().append(responce['itemHtml']);


            } else {

                $('#itemsByBrand').find('.item-row').remove().end().append(responce['msg']);

            }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${item}</strong></br>`;
            });


        }
    });
});

$('#filterByAjax').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/filterByAjax',
        data: $(this).serialize(),

        success: function(responce) {
            if (responce['status'] == 'success') {

                $('#itemsByCategory').find('.item-row').remove().end().append(responce['itemHtml']);


            } else {

                $('#itemsByCategory').find('.item-row').remove().end().append(responce['msg']);

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

// $('#searchForm').on('submit', function(e) {
//     e.preventDefault();

//     $.ajax({
//         type: 'POST',
//         url: BASE_URL + '/searchKeyword',
//         data: $(this).serialize(),

//         success: function(responce) {
//             if (responce['status'] == 'success') {




//             } else {



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

$('#filterByBrandAjax').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/filterByAjax',
        data: $(this).serialize(),

        success: function(responce) {
            if (responce['status'] == 'success') {

                $('#itemsByBrand').find('.item-row').remove().end().append(responce['itemHtml']);


            } else {

                $('#itemsByBrand').find('.item-row').remove().end().append(responce['msg']);

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

$('.getCustomerOrder').on('click', function(e) {
    e.preventDefault();

    let order = $(this).attr('id');

    var formData = {
        'stage': order,
        'customer_id': $('meta[name="UUID"]').attr('content'),
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    //alert(formData);
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/getCustomerOrder',
        data: formData,

        success: function(responce) {
            if (responce['status'] == 'success') {


                $('#appendOrderItemCustomer').empty().append(responce['ordeHtml']);


            } else {

                $('#appendOrderItemCustomer').empty().append(responce['msg']);

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

$('#itemRating').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/itemRating',
        data: $(this).serialize(),

        success: function(responce) {
            if (responce['status'] == 'success') {

                alert('success');
                //$('#itemsByBrand').find('.item-row').remove().end().append(responce['itemHtml']);


            } else {
                alert('fail');
                // $('#itemsByBrand').find('.item-row').remove().end().append(responce['msg']);

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

$("#saveContactUs").validate({
    rules: {
        name: "required",
        email: "required",
        mobile_no: "required",
        subject: "required",
        message: "required",

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
        // for (instance in CKEDITOR.instances) {
        //     CKEDITOR.instances[instance].updateElement();
        // }
        //var formData = $(form).serializeArray();
        //formData.push({ name: "productTag", value: $('#jquery-tagIt-default').tagit() });
        //console.log($(form).serialize());
        $("#contactMsg").html(' ');
        $.ajax({
            url: form.action,
            type: form.method,
            //data: $(form).serialize() + "&productTag=" + $('#jquery-tagIt-default').tagit("assignedTags"),
            data: $(form).serialize(),
            //data: formData,

            success: function(res) {
                if (res.status == 1) {
                    $("#saveContactUs")[0].reset();
                    $("#contactMsg").html(res.msg);

                } else {
                    $("#contactMsg").html(' ');
                }
                setInterval(function() {


                    $('#contactMsg').html('');
                }, 2000);
            },
            dataType: 'json'
        });
    }
});


//Start filter search
$('.itemByBrandfillter').on('change', function(e) {
    e.preventDefault();

    let brandId = $("#brand_id").val();
    let price_by = $("#price_by").val();
    let keyword = $('#keyword').val();
    // let keyword = $('input[name="keyword"]').val();
    //alert(price_by);
    var formData = {
        'brandId': brandId,
        'price_by': price_by,
        'keyword': keyword,

        '_token': $('meta[name="csrf-token"]').attr('content')
    };

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/itemByBrandfillter',

        data: formData,

        success: function(responce) {

            if (responce['status'] == 'success') {

                $('#itemsByBrand').find('.item-row').remove().end().append(responce['itemHtml']);


            } else {

                $('#itemsByBrand').find('.item-row').remove().end().append(responce['msg']);

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