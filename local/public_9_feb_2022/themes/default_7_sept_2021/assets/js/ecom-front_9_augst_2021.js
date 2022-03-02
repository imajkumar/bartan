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


        }
    });
});


// $('.getItemWithPagination').on('click', function() {

//     paginationCategoy(catId = "", pageNo = "", perPageLimit);
// });

function paginationCategoy(flag = '', catId = "", pageNo, perPageLimit) {

    //alert(pageNo);
    //alert(perPageLimit);
    // alert(pageNo);
    //var catOrBrandId = $(this).attr('id');
    // alert($(this).attr('id'));
    // return false;

    var formData = {
        'flag': flag,
        'catId': catId,
        'pageNo': pageNo,
        'perPageLimit': perPageLimit,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'GET',
        url: BASE_URL + '/getItemsByCatOrBrandIdByAjaxForPagination',
        data: formData,

        success: function(responce) {

                if (responce['success'] == true) {


                    $("#hideWhenClickCat").show();
                    $("#paginateHtmlClickOnCat").hide();
                    $('#itemsByCategory').empty().append(responce['ordeHtml']);
                    $('#paginateHtml').empty().append(responce['paginateHtml']);





                } else {


                    $('#itemsByCategory').empty().append('Items not found.');


                }



            }
            // },
            // error: function(xhr, status, error) {

        //     let errorHtml = '';
        //     $.each(xhr.responseJSON.errors, function(key, item) {
        //         errorHtml += `<strong>${item}</strong></br>`;
        //     });
        //     //alert(errorHtml);
        //     //toastr.error(errorHtml);

        // }
    });



}

function paginationCategoyOnClick(flag = '', catId = "", pageNo, perPageLimit) {

    //alert(pageNo);
    //alert(perPageLimit);
    // alert(pageNo);
    //var catOrBrandId = $(this).attr('id');
    // alert($(this).attr('id'));
    // return false;

    var formData = {
        'flag': flag,
        'catId': catId,
        'pageNo': pageNo,
        'perPageLimit': perPageLimit,
        '_token': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        type: 'GET',
        url: BASE_URL + '/getItemsByCatOrBrandIdByAjaxForPaginationOnClickCat',
        data: formData,

        success: function(responce) {

            if (responce['success'] == true) {


                $("#hideWhenClickCat").hide();
                $("#paginateHtmlClickOnCat").show();
                $('#itemsByCategory').empty().append(responce['ordeHtml']);
                $('#paginateHtmlClickOnCat').empty().append(responce['paginateHtml']);





            } else {


                $('#itemsByCategory').empty().append('Items not found.');


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



}



// Loop through the NodeList object.


// var catOrBrandIdPageUrls = $(this).attr('href');
// $('.page-link').attr('href', 'javascript:void()');

//alert();
// var allLinks = $('.page-item').attr('href');
//console.log($('.page-link').attr('href'));

// $.each(allLinks, function(key, linkU) {
//     linkUrls.push(linkU);
//     $('.page-link').attr('href', 'javascript:void()');
// });

// $('.page-link').on('click', function() {
// $('.page-item').on('click', function() {
//     alert();

// });



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
            if (responce['status'] == '1') {
                // console.log(responce['ordeHtml']);
                //return false;
                //window.location.replace(BASE_URL +'');
                $('#filterWithPagination').empty().append(responce['ordeHtml']);


            } else {

                $('#filterWithPagination').empty().append(responce['msg']);

            }
            // if (responce['status'] == 'success') {

            //     $('#itemsByCategory').find('.item-row').remove().end().append(responce['itemHtml']);


            // } else {

            //     $('#itemsByCategory').find('.item-row').remove().end().append(responce['msg']);

            // }
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
        url: BASE_URL + '/filterByAjaxBrand',
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

$('#filterLeftSideSearchPageAjax').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/filterLeftSideSearchPageAjax',
        data: $(this).serialize(),

        success: function(responce) {
            if (responce['status'] == '1') {

                $('#searchFilterDiv').empty().append(responce['ordeHtml']);
                // $('#itemsByBrand').find('.item-row').remove().end().append(responce['itemHtml']);


            } else {

                $('#searchFilterDiv').empty().append(responce['msg']);
                // $('#itemsByBrand').find('.item-row').remove().end().append(responce['msg']);

            }
            // if (responce['status'] == 'success') {

            //     $('#itemsByBrand').find('.item-row').remove().end().append(responce['itemHtml']);


            // } else {

            //     $('#itemsByBrand').find('.item-row').remove().end().append(responce['msg']);

            // }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${item}</strong></br>`;
            });


        }

    })

});

$('#filterLeftSideCategoryPageAjax').on('submit', function(e) {
    e.preventDefault();

    $("#brand_id").prop("selectedIndex", 0);
    $("#price_by").prop("selectedIndex", 0);
    $.ajax({
        type: 'POST',
        url: BASE_URL + '/filterLeftSideCategoryPageAjax',
        data: $(this).serialize(),

        success: function(responce) {
            if (responce['status'] == '1') {

                $('#filterWithPagination').empty().append(responce['ordeHtml']);
                // $('#itemsByBrand').find('.item-row').remove().end().append(responce['itemHtml']);


            } else {

                $('#filterWithPagination').empty().append(responce['msg']);
                // $('#itemsByBrand').find('.item-row').remove().end().append(responce['msg']);

            }
            // if (responce['status'] == 'success') {

            //     $('#itemsByBrand').find('.item-row').remove().end().append(responce['itemHtml']);


            // } else {

            //     $('#itemsByBrand').find('.item-row').remove().end().append(responce['msg']);

            // }
        },
        error: function(xhr, status, error) {

            let errorHtml = '';
            $.each(xhr.responseJSON.errors, function(key, item) {
                errorHtml += `<strong>${item}</strong></br>`;
            });


        }

    })

});

$('#filterLeftSideBrandPageAjax').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/filterLeftSideBrandPageAjax',
        data: $(this).serialize(),

        success: function(responce) {
            if (responce['status'] == '1') {

                //$('#itemsByBrand').find('.item-row').remove().end().append(responce['ordeHtml']);
                $('#filterWithPagination').empty().append(responce['ordeHtml']);
                // $('#itemsByBrand').find('.item-row').remove().end().append(responce['itemHtml']);


            } else {

                //$('#itemsByBrand').find('.item-row').remove().end().append(responce['msg']);
                $('#filterWithPagination').empty().append(responce['msg']);
                // $('#itemsByBrand').find('.item-row').remove().end().append(responce['msg']);

            }
            // if (responce['status'] == 'success') {

            //     $('#itemsByBrand').find('.item-row').remove().end().append(responce['itemHtml']);


            // } else {

            //     $('#itemsByBrand').find('.item-row').remove().end().append(responce['msg']);

            // }
            // if (responce['status'] == 'success') {

            //     $('#itemsByBrand').find('.item-row').remove().end().append(responce['itemHtml']);


            // } else {

            //     $('#itemsByBrand').find('.item-row').remove().end().append(responce['msg']);

            // }
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

            if (responce['status'] == '1') {

                $('#searchFilterDiv').empty().append(responce['ordeHtml']);
                // $('#itemsByBrand').find('.item-row').remove().end().append(responce['itemHtml']);


            } else {

                $('#searchFilterDiv').empty().append(responce['msg']);
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

$('.itemByCategoryfillter').on('change', function(e) {
    e.preventDefault();

    let brandId = $("#brand_id").val();
    let price_by = $("#price_by").val();
    let catId = $("#catId").val();

    let priceFromCat = $("#priceFrom").val();
    let priceToCat = $("#priceTo").val();
    let keywordCat = $("#keyword").val();


    // keyword = $('#keyword').val();
    // let keyword = $('input[name="keyword"]').val();
    //alert(price_by);
    var formData = {
        'brandId': brandId,
        'price_by': price_by,
        'catId': catId,

        'priceFromCat': priceFromCat,
        'priceToCat': priceToCat,
        'keywordCat': keywordCat,

        '_token': $('meta[name="csrf-token"]').attr('content')
    };

    $.ajax({
        type: 'POST',
        url: BASE_URL + '/itemByCategoryfillter',
        //url: BASE_URL + '/itemByCategoryfillter/brand=' + brandId + 'price=' + price_by,


        data: formData,

        success: function(responce) {

            if (responce['status'] == '1') {
                // console.log(responce['ordeHtml']);
                //return false;
                //window.location.replace(BASE_URL +'');
                $('#filterWithPagination').empty().append(responce['ordeHtml']);


            } else {

                $('#filterWithPagination').empty().append(responce['msg']);

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

function checkPrice() {
    if ($(".checckPrice").val() == 0 && $(".checckPrice").val() != "") {
        $("#priceFrom").val(1);
    }
}