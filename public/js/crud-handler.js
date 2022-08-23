$(function() {

    $(document).on('click', "#datatable input[type='checkbox'][name='select-all']", function(){
        var isChecked = $(this).prop('checked');
        var datatable = $('#datatable').DataTable();
        if(isChecked) {
            datatable.rows().select();
        } else {
            datatable.rows().deselect();
        }
    });
    
    $(document).on('click' , '#datatable tbody td', function() {
        var index = $(this).index();
        var datatable = $('#datatable').DataTable();
        var id = datatable.row(this).data().id;
        
        if($(this).closest('td').hasClass('select-checkbox')) {
            index = 0;
        }
        else if($(this).closest('td').find('.fa-trash').length > 0) {
            index = 1;
        }
        else if($(this).closest('td').find('.fa-edit').length > 0) {
            if($(this).closest('td').find('.fa-edit').hasClass('d-none')) {
                return;
            }
            index = 2;
        } else {
            index = 3;
        }

        if(index == 0) {
            if(datatable.rows({selected: true}).count() == datatable.rows().count()) {
                $("#datatable input[type='checkbox'][name='select-all']").prop('checked', true);
            } else {
                $("#datatable input[type='checkbox'][name='select-all']").prop('checked', false);
            }
        }
        else if(index == 1) {
            datatable.rows().deselect();
            Swal.fire({
                icon: "warning",
                title: $messages[4],
                text: $messages[5],
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                showCancelButton: true,
                confirmButtonText: $messages[2],
                cancelButtonText: $messages[3],
            }).then((result) => {
                if (!result.value) return;
                
                var url = window.location + "/" + id;
                $.ajax
                ({
                    type: "DELETE",
                    url: url,
                    cache: false,
                    beforeSend: function() {
                        $('#loader').modal('show');
                    },
                    success: function (data) {
                        showNotification(data.status, data.message);
                        if(data.status == '200') {
                            datatable.ajax.reload();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        showNotification(500, xhr.responseJSON.message);
                    },
                    complete: function() {
                        $('#loader').modal('hide');
                    },
                });
            })
        }
        else if(index == 2) {
            datatable.rows().deselect();
            var url = window.location.toString();
            window.location.href = url.replace(window.location.search, "").replace("/index", "") + "/" + id + "/edit";
        }
        else if(index > 2) {
            datatable.rows().deselect();
            var url = window.location.toString();
            window.location.href = url.replace(window.location.search, "").replace("/index", "") + "/" + id;
        }
    });

    $("#btn-clear").on("click", function(){
        $(this).closest('form').find("input[type='text'],input[type='hidden'],textarea").val("");
        $(this).closest('form').find("input[type='checkbox'],input[type='radio']").prop('checked', false);
        $(this).closest('form').find("select").val("").removeAttr('selected');
    });

    $("#btn-search").on("click", function(){
        $('#datatable').DataTable().ajax.reload();
    });

    $("#btn-store").on("click", function(){
        ajaxPost($(this));
    });

    $("#btn-store-multipart").on("click", function(){
        ajaxMultipartPost($(this));
    });

    $("#btn-update").on("click", function(){
        ajaxPut($(this));
    });

    $("#btn-update-multipart").on("click", function(){
        ajaxMultipartPut($(this));
    });

    $(".btn-export").on("click", function(){
        $(".dt-buttons .buttons-" + $(this).data('type')).trigger('click');
    });
})

function getDatatableParameter(data) {
    var obj = {};
    var objExtra = {};
    $('#formSearch input:not([type="checkbox"]):not([type="radio"])').each(function(){
        if($(this).attr('name')) {
            if($(this).attr('parameter-type') == 'extra') {
                objExtra[$(this).attr('name')] = $(this).val()
            } else {
                obj[$(this).attr('name')] = $(this).val()
            }
        }
    })
    $('#formSearch input[type="checkbox"]').each(function(){
        if($(this).attr('name') && $(this).prop("checked") == true){
            if($('input[type="checkbox"][name="'+$(this).attr('name')+'"]').length > 1) {
                var arr = [];
                if($(this).attr('name') in obj) {
                    arr = obj[$(this).attr('name')];
                }
    
                arr.push($(this).val());
    
                if($(this).attr('parameter-type') == 'extra') {
                    objExtra[$(this).attr('name')] = arr;
                } else {
                    obj[$(this).attr('name')] = arr;
                }    
            } else {
                if($(this).attr('parameter-type') == 'extra') {
                    objExtra[$(this).attr('name')] = $(this).val()
                } else {
                    obj[$(this).attr('name')] = $(this).val()
                }
            }
        }
    })
    $('#formSearch input[type="radio"]').each(function(){
        if($(this).attr('name') && $(this).prop("checked") == true){
            if($(this).attr('parameter-type') == 'extra') {
                objExtra[$(this).attr('name')] = $(this).val();
            } else {
                obj[$(this).attr('name')] = $(this).val();
            }
        }
    })
    $('#formSearch select').each(function(){
        if($(this).attr('name')){
            if($(this).attr('parameter-type') == 'extra') {
                objExtra[$(this).attr('name')] = $(this).val()
            } else {
                obj[$(this).attr('name')] = $(this).val()
            }
        }
    })

    data.parameters = obj;
    data.extraParameters = objExtra;
}

function ajaxPost(element) {
    if(validateForm(element)) {
        var form = element.closest('form')[0];
        var data = $(form).serialize();
        $.ajax
        ({
            type: "POST",
            url: form.action,
            data: data,
            cache: false,
            beforeSend: function() {
                $('#loader').modal('show');
            },
            success: function (data) {
                showNotification(data.status, data.message);
                if(data.status == '200') {
					if(data.redirect != null && data.redirect != undefined && data.redirect != "") {
						window.location.href = data.redirect;
					}
					
                    setTimeout(function(){
                        window.location.href = window.location.toString().replace('/create', '');
                    }, 1000)
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                showNotification(500, xhr.responseJSON.message);
            },
            complete: function() {
                $('#loader').modal('hide');
            },
        });   
    }
}

function ajaxPut(element) {
    if(validateForm(element)) {
        var form = element.closest('form')[0];
        var data = $(form).serialize();
        $.ajax
        ({
            type: "PUT",
            url: form.action,
            data: data,
            cache: false,
            beforeSend: function() {
                $('#loader').modal('show');
            },
            success: function (data) {
                showNotification(data.status, data.message);
                if(data.status == '200') {
                    setTimeout(function(){
                        location.reload();
                    }, 1000)
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                showNotification(500, xhr.responseJSON.message);
            },
            complete: function() {
                $('#loader').modal('hide');
            },
        });
    }
}

function ajaxMultipartPost(element) {
    if(validateForm(element)) {
        var form = element.closest('form')[0];
        var data = new FormData(form);
        $.ajax
        ({
            type: "POST",
            url: form.action,
            data: data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('#loader').modal('show');
            },
            success: function (data) {
                showNotification(data.status, data.message);
                if(data.status == '200') {
                    setTimeout(function(){
                        window.location.href = window.location.toString().replace('/create', '');
                    }, 1000)
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                showNotification(500, xhr.responseJSON.message);
            },
            complete: function() {
                $('#loader').modal('hide');
            },
        });
    }
}

function ajaxMultipartPut(element) {
    if(validateForm(element)) {
        var form = element.closest('form')[0];
        var data = new FormData(form);
        $.ajax
        ({
            type: "POST",
            url: form.action,
            data: data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('#loader').modal('show');
            },
            success: function (data) {
                showNotification(data.status, data.message);
                if(data.status == '200') {
                    setTimeout(function(){
                        location.reload();
                    }, 1000)
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                showNotification(500, xhr.responseJSON.message);
            },
            complete: function() {
                $('#loader').modal('hide');
            },
        });
    }
}

function validateForm(element) {
    var validator = $(element).closest('form').validate({
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            if(element.closest('.form-group').hasClass('row')) {
                element.closest('.form-group').find('div:first').append(error);
            } else {
                element.closest('.form-group').append(error);
            }
        },
        highlight: function (element, errorClass, validClass) {
            if(element.classList.contains('form-check-input')) {

            } else {
                $(element).addClass('is-invalid');
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    $(element).closest('form').find('input.required').each(function() {
        $(this).rules("add", {
            required: true,
            messages: {
                required: $messages[1]
            }
        })
    });

    if(validator.form()) {
        return true;
    }

    return false;
}