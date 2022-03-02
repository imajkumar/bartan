// save attribute of product 


$("#ajaxProductAttrSaveEditNeeraj").validate({
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




var handleJstreeCheckable = function() {
    var formData = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'action': 1

    };
    $.ajax({
        url: BASE_URL + '/getTreeView',
        type: 'POST',
        data: formData,
        success: function(res) {
            // tree
            $('#jstree-checkable').jstree({
                'plugins': ['types', 'wholerow'],
                'core': {
                    "themes": {
                        "responsive": false
                    },
                    'data': res
                },
                "types": {
                    "default": {
                        "icon": "fa fa-d text-primary fa-lg"
                    },
                    "file": {
                        "icon": "fa fa-file text-success fa-lg"
                    }
                }
            });
            // tree
        },
        dataType: "json"
    });



};


// $('#jstree-checkable').on('select_node.jstree', function(e, data) {
//     var link = $('#' + data.selected).find('a');


// });



// $("#searchText").keyup(function() {
//     var text = $(this).val();
//     search(text)

// });

// function search(text) {
//     $('#jstree-checkable').jstree(true).search(text);
// }

var handleJstreeCheckableGroup = function() {
    var itemId = $('#item_id').val();
    var formData = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'action': 1,
        'itemId': itemId,

    };
    $.ajax({
        url: BASE_URL + '/getTreeViewFrEdit',
        type: 'POST',
        data: formData,
        success: function(res) {
            // tree
            $('#jstree-checkable-group').jstree({
                'plugins': ["wholerow", "checkbox", "types"],
                'core': {
                    "themes": {
                        "responsive": false
                    },
                    'data': res
                },
                "types": {
                    "default": {
                        "icon": "fa fa-d text-primary fa-lg"
                    },
                    "file": {
                        "icon": "fa fa-file text-success fa-lg"
                    }
                }
            });
            // tree
        },
        dataType: "json"
    });



};


var Dashboard = function() {
    "use strict";
    return {
        //main function
        init: function() {
            handleJstreeCheckable();
            handleJstreeCheckableGroup();


        }
    };
}();

$(document).ready(function() {
    body = $("body");
    Dashboard.init();

    //save attribur group

    $("#frmSaveGroupAttr").submit(function(event) {
        event.preventDefault(); //prevent default action 
        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = $(this).serialize(); //Encode form elements for submission

        $.ajax({
            url: post_url,
            type: request_method,
            data: form_data
        }).done(function(response) { //
            alert('Save Attribute');
        });
    });


    //save attribur group

    $("select.primaryGroup").change(function() {
        var selectedprimaryGroup = $(this).children("option:selected").val();

        if (selectedprimaryGroup == 1) {

            $('#UnderGroup').prop('disabled', false);

        } else {
            $('#UnderGroup').prop('disabled', true);

        }

    });
    $('#btnGroup').click(function() {
        //ajax
        var formData = {
            'group_name': $('#group_name').val(),
            'alias_name': $('#alias_name').val(),
            'primaryGroup': $("#primaryGroup option:selected").val(),
            'UnderGroup': $("#UnderGroup option:selected").val(),
            'taxCategory': $("#taxCategory option:selected").val(),
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'action': 1

        };
        $.ajax({
                url: BASE_URL + '/saveMasterGroup',
                type: 'POST',
                data: formData,
                success: function(res) {
                    $.gritter.add({
                        title: 'Group',
                        text: 'Group save successfull.'
                    });
                    location.reload();
                }
            })
            //ajax
    });



    $('#updateGroup').click(function() {
        //ajax
        if ($('#edit_group_name').val() == '') {
            $('#edit_group_name').css('border-color', 'red');
            return false;
        } else {
            $('#edit_group_name').css('border-color', '');
        }



        var formData = {
            'group_id': $('#group_id').val(),
            'group_name': $('#edit_group_name').val(),
            'alias_name': $('#edit_alias_name').val(),
            'primaryGroup': $("#primaryGroup_edit option:selected").val(),
            'UnderGroup': $("#Edit_UnderGroup option:selected").val(),
            'taxCategory': $("#taxCategory option:selected").val(),
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'action': 1

        };
        $.ajax({
                url: BASE_URL + '/updateMasterGroup',
                type: 'POST',
                data: formData,
                success: function(res) {
                    $.gritter.add({
                        title: 'Group',
                        text: 'Group updated successfully.'
                    });
                    location.reload(1);
                }
            })
            //ajax
    });









    // $('#addImageModelAjax').click(function() {
    //     alert();
    //     $("#addItemImageByModel").show("slow");

    // });

    $(document).ready(function() {


        $('#saveItemMaster').on('submit', function(e) {
            e.preventDefault();

            $('#errorMsg').html('');
            $.ajax({
                    type: 'POST',
                    url: BASE_URL + '/saveItem',
                    data: $('#saveItemMaster').serialize(),

                    success: function(responce) {

                        if (responce['status'] == 'success') {

                            toastr.success(responce['msg']);
                            window.location.replace(responce['url']);
                            // $('#saveItemMaster')[0].reset();
                            // $('#errorMsg').css("display", "block");
                            // $('#errorMsg').removeClass('alert-warning');
                            // $('#errorMsg').addClass('alert-success');
                            // $('#errorMsg').html(`<strong>${responce['msg']}</strong>`);
                            // $('html,body').animate({
                            //     scrollTop: $("#content").offset().top
                            // }, 100);
                            // setInterval(function() {
                            //     $('#errorMsg').css("display", "none");

                            //     $('#errorMsg').html('');

                            // }, 10000);

                            // $.ajax({
                            //     type: 'GET',
                            //     url: BASE_URL + '/getItembyAjax',
                            //     success: function(res) {
                            //         //console.log(res);
                            //         $('#itemDataAppend').empty();
                            //         let html = '';
                            //         $.each(res['dataForTable'], function(ind, itemData) {
                            //             // console.log(itemData['item_name']);
                            //             html += `<tr class="odd gradeX">
                            //                     <td width="1%" class="f-s-600 text-inverse">${ind+1}</td>
                            //                     <td>
                            //                     <img src="${(itemData['img_name'] && itemData['default']==1) ? BASE_URL+'/gallery/'+itemData['img_name']: BASE_URL+'/assets/img/product/default.jpg'}" width="50px" height="50px"/>

                            //                     <a href="${BASE_URL+'/add-gallery-image/'+itemData['item_id']}">Add image</a></td>
                            //                     <td>${itemData['item_name']}</td>
                            //                     <td>${itemData['g_name']}</td>
                            //                     <td>${itemData['open_qty']}</td>
                            //                     <td>${itemData['min_qty']}</td>
                            //                 </tr>`;
                            //             $('#itemId').val(itemData['item_id']);
                            //         });


                            //         $('#itemDataAppend').append(html);
                            //     }
                            // });


                        } else {

                            toastr.warning(responce['msg']);
                            // $('#errorMsg').css("display", "block");
                            // $('#errorMsg').removeClass('alert-success');
                            // $('#errorMsg').addClass('alert-warning');
                            // $('#errorMsg').html(`<strong>${responce['msg']}</strong>`);
                            // $('html,body').animate({
                            //     scrollTop: $("#content").offset().top
                            // }, 100);
                            // setInterval(function() {
                            //     $('#errorMsg').css("display", "none");

                            //     $('#errorMsg').html('');
                            // }, 10000);


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
                        // $('#errorMsg').css("display", "block");
                        // $('#errorMsg').removeClass('alert-success');
                        // $('#errorMsg').addClass('alert-warning');
                        // $('#errorMsg').html(errorHtml);
                        // $('html,body').animate({
                        //     scrollTop: $("#content").offset().top
                        // }, 100);
                        // setInterval(function() {
                        //     $('#errorMsg').css("display", "none");
                        //     $('#errorMsg').html('');
                        // }, 10000);
                        // $('#errorMsg').css("display", "block");
                        // $('#errorMsg').addClass('alert-warning');
                        // $('#errorMsg').append(errorHtml);
                    }

                })
                //alert('submitBtn');
        });

        $('#addCustomer').on('submit', function(e) {
            e.preventDefault();

            $('#errorMsg').html('');
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/add-new-customer',
                data: $('#addCustomer').serialize(),

                success: function(responce) {

                    if (responce['status'] == 'success') {

                        toastr.success(responce['msg']);
                        window.location.replace(responce['url']);

                    } else {

                        toastr.warning(responce['msg']);

                    }
                },
                error: function(xhr, status, error) {

                    let errorHtml = '';
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        errorHtml += `<strong>${ item }</strong></br>`;
                    });
                    toastr.error(errorHtml);

                }

            })

        });

        $('#updateCustomer').on('submit', function(e) {
            e.preventDefault();

            $('#errorMsg').html('');
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/update-customer',
                data: $('#updateCustomer').serialize(),

                success: function(responce) {

                    if (responce['status'] == 'success') {

                        toastr.success(responce['msg']);
                        window.location.replace(responce['url']);

                    } else {

                        toastr.warning(responce['msg']);

                    }
                },
                error: function(xhr, status, error) {

                    let errorHtml = '';
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        errorHtml += `<strong>${ item }</strong></br>`;
                    });
                    toastr.error(errorHtml);

                }

            })

        });

        $('#addAttribute').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/addAttribute',
                data: $(this).serialize(),

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

            })

        });

        $('#updateAttributeFamily').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: BASE_URL + '/updateAttributeFamily',
                data: $(this).serialize(),

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

            })

        });

        // $('#addSlaesPersion').on('submit', function(e) {
        // e.preventDefault();
        $("#addSlaesPersion").validate({
            rules: {
                seller_name: "required",
                //seller_email: { email: true, required: true },
                seller_phone: { required: true, minlength: 10 },

            },

            messages: {
                seller_name: "Please fill name",
                seller_email: {
                    email: "Enter Valid Email!",
                    required: "Enter Email!"
                },
                seller_phone: {
                    minlength: "Please enter Valid Mobile No.",
                    required: "Please enter Mobile No."
                },
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: BASE_URL + '/new-sales-person',
                    data: $(form).serialize(),

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

                })
            }

        });

        $('#UpdateSalesPersion').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: BASE_URL + '/update-sales-person',
                data: $(this).serialize(),

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

            })

        });

        $('#updateAttribute').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: BASE_URL + '/updateAttribute',
                data: $(this).serialize(),

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

            })

        });

        $('#addAttributeFamily').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: BASE_URL + '/addAttributeFamily',
                data: $(this).serialize(),

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

            })

        });

        $('#addAddress').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: BASE_URL + '/addAddress',
                data: $(this).serialize(),

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

            })

        });

        $('#updateAddress').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: BASE_URL + '/updateAddress',
                data: $(this).serialize(),

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

            })

        });

        $('#deleteCustomer').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: BASE_URL + '/delete-customer',
                data: $(this).serialize(),

                success: function(responce) {

                    if (responce['status'] == 'success') {

                        toastr.success(responce['msg']);
                        //window.location.replace(responce['url']);

                    } else {

                        toastr.warning(responce['msg']);

                    }
                },
                error: function(xhr, status, error) {

                    let errorHtml = '';
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        errorHtml += `<strong>${ item }</strong></br>`;
                    });
                    toastr.error(errorHtml);

                }

            })

        });



        $('#editItemMasterForm').on('submit', function(e) {
            e.preventDefault();
            var selectedElmsIds = $('#jstree-checkable-group').jstree("get_selected");

            // var attr = $.map($('.attributeList :selected'), function(c) {
            //     return c.value;
            // });
            // var option = $.map($('.attrOption :selected'), function(c) { return c.value; });
            // console.log(attr);
            // console.log(option);
            var formData = new FormData(this);
            // formData.append('attributes', attr);
            // formData.append('options', option);
            formData.append('categorys', JSON.stringify(selectedElmsIds));

            var item_id = $('#edit_item_id').val();
            $('#errorMsg').html('');
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/update-item/' + item_id,
                data: formData,
                processData: false,
                contentType: false,
                //dataType: 'text',
                //data: $('#editItemMasterForm').serialize(),

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

            })

        });

    });

    $('#saveAttribute').click(function() {

        $('#errorModelMsg').html('');
        $.ajax({
                type: 'POST',
                url: BASE_URL + '/saveAttribute',
                data: $('#formAttribute').serialize(),

                success: function(responce) {
                    //console.log(responce);
                    // return false;
                    if (responce['status'] == 'success') {
                        $('#formAttribute')[0].reset();
                        $('#errorModelMsg').css("display", "block");
                        $('#errorModelMsg').removeClass('alert-warning');
                        $('#errorModelMsg').addClass('alert-success');
                        $('#errorModelMsg').html(`<strong>${ responce[ 'msg' ] }</strong>`);

                        setInterval(function() {
                            $('#errorModelMsg').css("display", "none");
                            $('#errorModelMsg').html('');

                        }, 10000);

                    } else {

                        $('#errorModelMsg').css("display", "block");
                        $('#errorModelMsg').removeClass('alert-success');
                        $('#errorModelMsg').addClass('alert-warning');
                        $('#errorModelMsg').html(`<strong>${ responce[ 'msg' ] }</strong>`);
                        setInterval(function() {
                            $('#errorModelMsg').css("display", "none");

                            $('#errorModelMsg').html('');
                        }, 10000);

                    }
                },
                error: function(xhr, status, error) {
                    //let errorMsg = '';
                    //alert('empty');
                    let errorHtml = '';
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        errorHtml += `<strong>${ item }</strong></br>`;
                    });
                    $('#errorModelMsg').css("display", "block");
                    $('#errorModelMsg').removeClass('alert-success');
                    $('#errorModelMsg').addClass('alert-warning');
                    $('#errorModelMsg').html(errorHtml);

                    setInterval(function() {
                        $('#errorModelMsg').css("display", "none");
                        $('#errorModelMsg').html('');
                    }, 10000);
                    // $('#errorMsg').css("display", "block");
                    // $('#errorMsg').addClass('alert-warning');
                    // $('#errorMsg').append(errorHtml);
                }

            })
            //alert('submitBtn');
            // $('#exampleModal').on('hidden.bs.modal', function() {
            //     alert();
            //     document.location.reload();
            //     //location.reload();
            // });
    });

    $('.deleteItemImgBtn').click(function() {
        // let city= $('input[name="city"]').val();
        let del = $(this).attr('value');
        let delItem = del.split('_');
        let itemId = delItem['0'];
        let imgId = delItem['1'];
        if (!confirm('Are you sure you want to delete this image?')) {
            return false;
        }
        //return false;
        $.ajax({
            type: 'POST',
            url: BASE_URL + '/deleteItemImgByAjax',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'itemId': itemId,
                'imgId': imgId,
            },
            success: function(responce) {
                //console.log(responce);
                // return false;
                if (responce['status'] == 'success') {
                    $('#errorModelMsg').css("display", "block");
                    $('#errorModelMsg').removeClass('alert-warning');
                    $('#errorModelMsg').addClass('alert-success');
                    $('#errorModelMsg').html(`<strong>${ responce[ 'msg' ] }</strong>`);
                    $('html,body').animate({
                        scrollTop: $("#content").offset().top
                    }, 100);
                    setInterval(function() {
                        $('#errorModelMsg').css("display", "none");
                        $('#errorModelMsg').html('');

                    }, 10000);
                    document.location.reload();

                } else {
                    $('#errorModelMsg').css("display", "block");
                    $('#errorModelMsg').removeClass('alert-success');
                    $('#errorModelMsg').addClass('alert-warning');
                    $('#errorModelMsg').html(`<strong>${ responce[ 'msg' ] }</strong>`);
                    $('html,body').animate({
                        scrollTop: $("#content").offset().top
                    }, 100);
                    setInterval(function() {
                        $('#errorModelMsg').css("display", "none");

                        $('#errorModelMsg').html('');
                    }, 10000);

                }
            },
            error: function(xhr, status, error) {
                let errorHtml = '';
                $.each(xhr.responseJSON.errors, function(key, item) {
                    errorHtml += `<strong>${ item }</strong></br>`;
                });
                $('#errorModelMsg').css("display", "block");
                $('#errorModelMsg').removeClass('alert-success');
                $('#errorModelMsg').addClass('alert-warning');
                $('#errorModelMsg').html(errorHtml);
                $('html,body').animate({
                    scrollTop: $("#content").offset().top
                }, 100);
                setInterval(function() {
                    $('#errorModelMsg').css("display", "none");
                    $('#errorModelMsg').html('');
                }, 10000);

            }

        })

    });

    $('.defaultImg').change(function() {
        let del = $(this).attr('value');
        let delItem = del.split('_');
        itemId = delItem['0'];
        imgId = delItem['1'];
        if (!confirm('Are you sure you want to make primary this image?')) {
            return false;
        }
        if ($(this).prop('checked')) {


            //return false;

            $.ajax({
                type: 'POST',
                url: BASE_URL + '/addPrimaryImgByAjax',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'itemId': itemId,
                    'imgId': imgId,
                    'defaultVal': 1,
                },
                success: function(responce) {
                    //console.log(responce);
                    // return false;
                    if (responce['status'] == 'success') {
                        $('#errorModelMsg').css("display", "block");
                        $('#errorModelMsg').removeClass('alert-warning');
                        $('#errorModelMsg').addClass('alert-success');
                        $('#errorModelMsg').html(`<strong>${ responce[ 'msg' ] }</strong>`);
                        $('html,body').animate({
                            scrollTop: $("#content").offset().top
                        }, 100);
                        setInterval(function() {
                            $('#errorModelMsg').css("display", "none");
                            $('#errorModelMsg').html('');

                        }, 10000);
                        document.location.reload();

                    } else {
                        $('#errorModelMsg').css("display", "block");
                        $('#errorModelMsg').removeClass('alert-success');
                        $('#errorModelMsg').addClass('alert-warning');
                        $('#errorModelMsg').html(`<strong>${ responce[ 'msg' ] }</strong>`);
                        $('html,body').animate({
                            scrollTop: $("#content").offset().top
                        }, 100);
                        setInterval(function() {
                            $('#errorModelMsg').css("display", "none");

                            $('#errorModelMsg').html('');
                        }, 10000);

                    }
                },
                error: function(xhr, status, error) {
                    let errorHtml = '';
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        errorHtml += `<strong>${ item }</strong></br>`;
                    });
                    $('#errorModelMsg').css("display", "block");
                    $('#errorModelMsg').removeClass('alert-success');
                    $('#errorModelMsg').addClass('alert-warning');
                    $('#errorModelMsg').html(errorHtml);
                    $('html,body').animate({
                        scrollTop: $("#content").offset().top
                    }, 100);
                    setInterval(function() {
                        $('#errorModelMsg').css("display", "none");
                        $('#errorModelMsg').html('');
                    }, 10000);

                }

            });

        } else {
            if (!confirm('Are you sure you want to remove primary this image?')) {
                return false;
                // $(this).prop("checked", "true")
            }

            $.ajax({
                type: 'POST',
                url: BASE_URL + '/addPrimaryImgByAjax',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'itemId': itemId,
                    'imgId': imgId,
                    'defaultVal': 0,
                },
                success: function(responce) {
                    //console.log(responce);
                    // return false;
                    if (responce['status'] == 'success') {
                        $('#errorModelMsg').css("display", "block");
                        $('#errorModelMsg').removeClass('alert-warning');
                        $('#errorModelMsg').addClass('alert-success');
                        $('#errorModelMsg').html(`<strong>${ responce[ 'msg' ] }</strong>`);
                        $('html,body').animate({
                            scrollTop: $("#content").offset().top
                        }, 100);
                        setInterval(function() {
                            $('#errorModelMsg').css("display", "none");
                            $('#errorModelMsg').html('');

                        }, 10000);
                        document.location.reload();

                    } else {
                        $('#errorModelMsg').css("display", "block");
                        $('#errorModelMsg').removeClass('alert-success');
                        $('#errorModelMsg').addClass('alert-warning');
                        $('#errorModelMsg').html(`<strong>${ responce[ 'msg' ] }</strong>`);
                        $('html,body').animate({
                            scrollTop: $("#content").offset().top
                        }, 100);
                        setInterval(function() {
                            $('#errorModelMsg').css("display", "none");

                            $('#errorModelMsg').html('');
                        }, 10000);

                    }
                },
                error: function(xhr, status, error) {
                    let errorHtml = '';
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        errorHtml += `<strong>${ item }</strong></br>`;
                    });
                    $('#errorModelMsg').css("display", "block");
                    $('#errorModelMsg').removeClass('alert-success');
                    $('#errorModelMsg').addClass('alert-warning');
                    $('#errorModelMsg').html(errorHtml);
                    $('html,body').animate({
                        scrollTop: $("#content").offset().top
                    }, 100);
                    setInterval(function() {
                        $('#errorModelMsg').css("display", "none");
                        $('#errorModelMsg').html('');
                    }, 10000);

                }

            });
        }
    });

    // $('#attrOption').hide();
    $('#type').change(function() {
        var typeVal = $(this).val();
        if (typeVal == 'select' || typeVal == 'checkbox' || typeVal == 'multiselect') {
            $('#attrOption').show();
            $('#option').attr('data-parsley-required', 'true');
        } else {
            $('#attrOption').hide();
            $('#option').attr('data-parsley-required', 'falsea');
        }
    });

});




$(document).ready(function() {

    var MaxInputs = 2;
    var InputsWrapper = $("#InputsWrapper");
    var AddButton = $("#AddMoreFileBox");
    var x = InputsWrapper.length;
    var FieldCount = 1;
    $(AddButton).click(function(e) {
        FieldCount++;
        $(InputsWrapper).append(`<div class="row form_group" id="removeBlock_${ FieldCount }">
                        <div class="col-sm-10">
                        <input type="text" name="options[]"  class="form-control" placeholder="Please enter option" data-parsley-required="true"> 
                        <a href="#" class="removeclass">Remove</a>
                        </div>
                    </div>`);
        x++;
        return false;
    });

    $("body").on("click", ".removeclass", function(e) {
        if (x > 1) {
            $(this).parent().parent().remove();

            x--;

            $("#AddMoreFileId").show();

            $("#lineBreak").html("");

            $('AddMoreFileBox').html("Add field");
        }
        return false;
    })

});

//item attr Add more start

$(document).ready(function() {

    var MaxInputs = 2;
    var InputsWrapper = $("#InputsWrapperAttr");
    var AddButton = $("#AddMoreFileBoxAttr");
    var x = InputsWrapper.length;
    var FieldCount = 1;

    $(AddButton).click(function(e) {
        FieldCount++;
        $(InputsWrapper).append(`<div class="row" id="removeBlock_${ FieldCount }">
        <div class="col-md-3">
            <div class="form-group">
                <label class="col-form-label">Attributes :</label>    
                <select class="form-control attributeList" name="attribute" id="attr_${ FieldCount }">
                </select>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
            <label class="col-form-label">Options :</label>
            <select name="option[]" id="attrOptions_attr_${ FieldCount }" class="select2-original attrOption" multiple>
            </select>  
            </div>
        </div>
        <a href="#" class="removeclass">Remove</a>
        </div>
    </div>`);


        $.ajax({
            url: BASE_URL + '/get_attributes',
            type: 'GET',
            success: function(res) {
                $('#attr_' + FieldCount).find('option')
                    .remove()
                    .end()
                    .append(res);

            },
        });

        attrOptions();
        $('.select2-original').select2({
            placeholder: "Choose elements",
            width: "100%"
        })

        x++;
        return false;
    });

    $("body").on("click", ".removeclass", function(e) {
        if (x > 1) {
            $(this).parent().remove();

            x--;

        }
        return false;
    })

    attrOptions();

    function attrOptions() {
        $('.attributeList').on('change', function() {

            var id = $(this).attr('id');
            var formData = {
                'attr_id': this.value,
                '_token': $('meta[name="csrf-token"]').attr('content')
            };
            $.ajax({
                url: BASE_URL + '/getAttributeOptions',
                type: 'POST',
                data: formData,
                success: function(res) {
                    $('#attrOptions_' + id)
                        .find('option')
                        .remove()
                        .end()
                        .append(res);

                }
            });

        });
    }




    //item attr add more  end
    // $("#wizard").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {

    //     if (currentStepIndex == 2 && nextStepIndex == 'forward') {


    //         var gst_certificate_old = $("#gst_certificate_old").val();

    //         var checkValidationCert = false;
    //         $('#sgst_certificate_errorMsg').remove();

    //         if (checkValidationCert) {


    //             $('#wizard').data('smartWizard')._showStep(3);

    //             return false;
    //         } else {



    //             $('#sgst_certificate_errorMsg').html(' ');

    //             $('.sw-btn-next').removeClass('disabled');
    //             $('.sw-btn-next').attr('disabled', false);

    //         }

    //         $(".sw-btn-next").hide();

    //     } else {
    //         $(".sw-btn-next").show();
    //     }



    //     $("#saveCustomerProfileDetails").validate({
    //         rules: {
    //             store_name: "required",
    //             customer_type: "required",
    //             business_street_address: "required",
    //             business_country: "required",
    //             business_state: "required",
    //             business_city: "required",
    //             business_postal_code: "required",
    //             document_option: {
    //                 required: true,



    //             },
    //             business_gst_number: { required: true, minlength: 15 },
    //             pan_number: "required",
    //             dl_number: "required",
    //             cancel_check: "required",


    //         },

    //         messages: {
    //             store_name: "Please fill your Store Name.",
    //             customer_type: "Please select Customer Type.",
    //             business_street_address: "Please fill your Address.",
    //             business_country: "Please select your Country",
    //             business_state: "Please select your State",
    //             business_city: "Please select your City",
    //             business_postal_code: "Please fill your Postal Code",
    //             document_option: {
    //                 required: "Please select any two option",
    //             },

    //             business_gst_number: {
    //                 required: "Please fill GSTIN",
    //                 minlength: 'Please fill GSTIN Valid GSTNO.'
    //             },
    //             pan_number: "Please fill your PAN Number",
    //             dl_number: "Please fill your Driving License",
    //             cancel_check: "Please fill your Cancel Check Number",

    //         },
    //     });
    //     if (currentStepIndex == 1 && nextStepIndex == 'forward') {




    //         var checkValidation = false;


    //         $('#document_option_errorMsg').remove();
    //         if ($("#saveCustomerProfileDetails").valid() == false) {

    //             checkValidation = false;
    //             return false
    //         } else if ($("#checkNum").val() >= 2) {
    //             checkValidation = true;
    //             $('#wizard').data('smartWizard')._showStep(1);
    //         } else {
    //             $('#document_option').after('<div id="document_option_errorMsg" class="error">Please select any two option.</div>');
    //             return false;
    //         }



    //     }

    // });
    // $(function() {
    //     $(".sw-btn-next").click(function() { // when the button is clicked...
    //         alert($('#wizard').smartWizard("getStepIndex"));
    //         //alert($('#wizard').data('smartWizard')._showStep(3));
    //         //console.log($("#wizard").smartWizard("getCurrentStep"));
    //         var wizard = $("#saveCustomerProfileDetails"); // cache the form element selector
    //         if (!wizard.validate().element("#cutomer_fname")) { // validate the input field
    //             alert(22);
    //             //wizard.validate().focusInvalid(); // focus it if it was invalid
    //         }

    //     })
    // })
    $('#saveCustomerProfileDetails').on('submit', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $.ajax({
            type: 'POST',
            url: BASE_URL + '/saveCustomerProfileDetails',
            //data: $(this).serialize(),
            data: new FormData(this),
            //dataType: 'json',
            contentType: false,
            //cache: false,
            processData: false,
            beforeSend: function() { body.addClass("loading"); },
            complete: function() { body.removeClass("loading"); },

            success: function(responce) {

                if (responce['status'] == 'success') {

                    toastr.success(responce['msg']);
                    window.location.replace(responce['url']);

                } else {

                    toastr.warning(responce['msg']);

                }
            },
            error: function(xhr, status, error) {

                let errorHtml = '';
                $.each(xhr.responseJSON.errors, function(key, item) {
                    errorHtml += `<strong>${ item }</strong></br>`;
                });
                toastr.error(errorHtml);

            }

        })

    });


    $('#updateCustomerProfileDetails').on('submit', function(e) {
        e.preventDefault();


        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $.ajax({
            type: 'POST',
            url: BASE_URL + '/updateCustomerProfileDetails',
            data: new FormData(this),
            contentType: false,
            processData: false,
            // beforeSend: function() { body.addClass("loading"); },
            // complete: function() { body.removeClass("loading"); },
            beforeSend: function() { body.addClass("loading"); },
            complete: function() { body.removeClass("loading"); },

            success: function(responce) {

                if (responce['status'] == 'success') {

                    toastr.success(responce['msg']);
                    window.location.replace(responce['url']);

                } else {

                    toastr.warning(responce['msg']);

                }
            },
            error: function(xhr, status, error) {

                let errorHtml = '';
                $.each(xhr.responseJSON.errors, function(key, item) {
                    errorHtml += `<strong>${ item }</strong></br>`;
                });
                toastr.error(errorHtml);

            }

        })

    });

    $('#saveCustomerApproval').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: BASE_URL + '/saveCustomerApproval',
            data: $(this).serialize(),
            beforeSend: function() { body.addClass("loading"); },
            complete: function() { body.removeClass("loading"); },

            success: function(responce) {

                if (responce['status'] == 'success') {

                    toastr.success(responce['msg']);
                    window.location.replace(responce['url']);

                } else {

                    toastr.warning(responce['msg']);

                }
            },
            error: function(xhr, status, error) {

                let errorHtml = '';
                $.each(xhr.responseJSON.errors, function(key, item) {
                    errorHtml += `<strong>${ item }</strong></br>`;
                });
                toastr.error(errorHtml);

            }

        })

    });

    $('.output').click(function() {

        $('#customerPic').trigger('click');
    })

    loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementsByClassName('outputPic');
            output.src = reader.result;

            $('#saveProfilePic').submit();

        };
        reader.readAsDataURL(event.target.files[0]);
    };

    $('#saveProfilePic').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: BASE_URL + '/saveProfilePic',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(responce) {

                if (responce['status'] == 'success') {

                    $('.outputPic').attr('src', responce['picPath']);
                    toastr.success(responce['msg']);


                } else {

                    toastr.warning(responce['msg']);

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
    });



    // e.preventDefault();
    // $.ajax({
    //     type: 'POST',
    //     url: BASE_URL + '/saveCustomerApproval',
    //     data: new FormData(this),
    //     contentType: false,
    //     cache: false,
    //     processData: false,
    //     success: function(responce) {

    //         if (responce['status'] == 'success') {

    //             toastr.success(responce['msg']);


    //         } else {

    //             toastr.warning(responce['msg']);

    //         }
    //     },
    //     error: function(xhr, status, error) {

    //         let errorHtml = '';
    //         $.each(xhr.responseJSON.errors, function(key, item) {
    //             errorHtml += `<strong>${ item }</strong></br>`;
    //         });
    //         toastr.error(errorHtml);

    //     }
    // });
});


// Start code for item category----------------------------------------

//var MaxInputs = 2;
var InputsCategoryWrapper = $("#categoryAttrWrapper");
var AddButtonCategory = $("#AddMoreAttrInCategory");
var x = InputsCategoryWrapper.length;
var FieldCount = 1;

$(AddButtonCategory).click(function(e) {
    FieldCount++;

    $(InputsCategoryWrapper).append(`<div class="row form-layout">
                <div class="form-group">
                    <div class="m-b-3">
                        <label class="" for="attribute">Attribute</label>
                        <div class="">
                            <select class="form-control" id="attribute" name="attribute[]" placeholder="Please select attribute">
                                <option value="">Please select Attribute</option>
                                
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="m-b-3">
                        <label class="" for="is_required">Is required</label>
                        <div class="">
                            <select class="form-control" id="is_required" name="is_required[]">
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="m-b-3">
                        <label class="" for="is_unique">Is unique</label>
                        <div class="">
                            <select class="form-control" id="is_unique" name="is_unique[]">
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="m-b-3">
                        <label class="" for="is_comparable">Attribute to comparable</label>
                        <div class="">
                            <select class="form-control" id="is_comparable" name="is_comparable[]">
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="m-b-3">
                        <label class="" for="sku_count">SKU Count</label>
                        <div class="">
                            <input class="form-control" type="text" id="sku_count" name="sku_count[]" placeholder="Please enter sku count">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="m-b-3">
                        <label class="" for="priority">Priority</label>
                        <div class="">
                            <input class="form-control" type="text" id="priority" name="priority[]" placeholder="Please enter priority">
                        </div>
                    </div>
                </div>
                <a href="#" class="removeCategoryclass">Remove</a>
            </div>`);
    x++;
    return false;
});
$("body").on("click", ".removeCategoryclass", function(e) {
    if (x > 1) {
        $(this).parent().remove();

        x--;

    }
    return false;
})

// End code for item category------------------------------------------

$('#status').on('change', function() {

    var statusVal = $(this).val();

    if (statusVal == 2) {
        $('#remarkField').show();
    } else {
        $('#remarkField').hide();
    }


});


// Start code for Team----------------------------------------

//var MaxInputs = 2;
var TeamWrapper = $("#teamWrapper");
var AddMoreTeam = $("#AddMoreTeam");
var x = TeamWrapper.length;
var FieldCount = 1;

$(AddMoreTeam).click(function(e) {
    FieldCount++;

    $(TeamWrapper).append(`<div id="removeTeamParent">
                    <div class="form-group row m-b-10">
                            <label class="col-lg-3 text-lg-right col-form-label">Name</label>
                            <div class="col-lg-9 col-xl-6">
                            <input type="text" name="team_name[]" placeholder="Please enter name"/>
                        </div>
                    </div>

                    <div class="form-group row m-b-10">
                        <label class="col-lg-3 text-lg-right col-form-label">Mobile number</label>
                        <div class="col-lg-9 col-xl-6">
                        <input type="text" name="team_mobile[]" placeholder="Please enter mobile number"/>
                        </div>
                    </div>

                    <div class="form-group row m-b-10">
                        <label class="col-lg-3 text-lg-right col-form-label">Email id</label>
                        <div class="col-lg-9 col-xl-6">
                            <input type="text" name="team_email[]" placeholder="Please enter email id"/>
                        </div>
                    </div>
                    <a href="#" class="removeTeamClass">Remove</a>
               </div>`);
    x++;
    return false;
});
$("body").on("click", ".removeTeamClass", function(e) {
    if (x > 1) {
        $(this).parent().remove();

        x--;

    }
    return false;
})

// End code for team------------------------------------------


$(".docsValidation").on("click", function() {
    $(this).attr('accept', '.xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf');
});

// $("#galleryTab").on("click", function() {
//     //alert();
//     $('#default-tab-3').addClass('active show');
// });



function getPaymentStatusPayByLink() {
    //ajax
    $.ajax({
        type: 'GET',
        url: BASE_URL + '/api/afterPaymentByLinkCron',
        success: function(responce) {
            $.gritter.add({
                title: 'Payment',
                text: 'Payment status updated'
            });
            location.reload(1);
        }
    });
    //ajax

}

function showGroupEdit(rowID) {


    //ajax
    var formData = {
        'group_id': rowID,
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'action': 1

    };
    $.ajax({
            url: BASE_URL + '/editMasterGroup',
            type: 'GET',
            data: formData,
            success: function(res) {

                if (res.status == 1) {

                    $('#groupEditFormAppend').empty().append(res.groupEditHtml);
                    $("select.primaryGroup").change(function() {
                        var selectedprimaryGroup = $(this).children("option:selected").val();

                        if (selectedprimaryGroup == 1) {


                            $('#Edit_UnderGroup').prop('disabled', false);
                        } else {

                            $('#Edit_UnderGroup').prop('disabled', true);
                        }

                    });

                    $('#edit_group_name').keyup(function() {

                        if ($('#edit_group_name').val() == '') {
                            $('#edit_group_name').css('border-color', 'red');
                            return false;
                        } else {
                            $('#edit_group_name').css('border-color', '');
                        }
                    });
                }
                $('#groupEditModal').modal("show");
            }
        })
        //ajax


}

function groupDelete(rowID) {



    //ajax
    if (!confirm('Are you sure you want to delete this?')) {
        return false;
    }
    var formData = {
        'group_id': rowID,
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'action': 1

    };
    $.ajax({
            url: BASE_URL + '/deleteMasterGroup',
            type: 'POST',
            data: formData,
            success: function(res) {
                if (res.status == 1) {
                    $.gritter.add({
                        title: 'Group',
                        text: res.msg
                    });
                    location.reload(1);
                }
            }
        })
        //ajax



}