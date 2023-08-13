var onSelectHandler, selectedIds = [];
$(function() {

    $(document).on('click', "#datatable-select input[type='checkbox'][name='select-all']", function(){
        var isChecked = $(this).prop('checked');
        var datatable = $('#datatable-select').DataTable();
        if(isChecked) {
            datatable.rows().select();
        } else {
            datatable.deselect();
        }
    });

    //select option data relations modal
    $(document).on('click', '.show-modal-select', function(){
        setSelectedIds($(this));
        onSelectHandler = $(this).attr('data-handler');
        $('#modal-select .modal-title').html($(this).attr('data-title'));
        $.ajax
        ({
            type: "GET",
            url: $(this).attr('data-url'),
            cache: false,
            beforeSend: function() {
                $('#loader').modal('show');
            },
            success: function (data) {
                $('#modal-select .modal-body').html(data);
                $('#modal-select').modal('show');
            },
            complete: function() {
                $('#loader').modal('hide');
            },
        });
    })

    $(document).on('click', '.show-modal-form', function(){
        $.ajax
        ({
            type: "GET",
            url: $(this).attr('data-url'),
            cache: false,
            beforeSend: function() {
                $('#loader').modal('show');
            },
            success: function (data) {
                $('#modal-form-container').html(data);
                if($(this).attr('data-title')) {
                    $('#modal-form .modal-title').html($(this).attr('data-title'));
                }
                $('#modal-form').modal('show');
            },
            complete: function() {
                $('#loader').modal('hide');
            },
        });
    })

    $('#btn-select').on('click', function(){
        $('#modal-select').modal('hide');
        var datatable = $('#datatable-select').DataTable();
        var data = datatable.rows({selected:true}).data();
        if(onSelectHandler != undefined) {
            window[onSelectHandler](data);
        }
    });
})

function getDatatableSelectParameter(data) {
    var obj = {};
    var objExtra = {};
    $('#formSelectSearch input:not([type="checkbox"]):not([type="radio"])').each(function(){
        if($(this).attr('name')) {
            if($(this).attr('parameter-type') == 'extra') {
                objExtra[$(this).attr('name')] = $(this).val()
            } else {
                obj[$(this).attr('name')] = $(this).val()
            }
        }
    })
    $('#formSelectSearch input[type="checkbox"]').each(function(){
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
    $('#formSelectSearch input[type="radio"]').each(function(){
        if($(this).attr('name') && $(this).prop("checked") == true){
            if($(this).attr('parameter-type') == 'extra') {
                objExtra[$(this).attr('name')] = $(this).val();
            } else {
                obj[$(this).attr('name')] = $(this).val();
            }
        }
    })
    $('#formSelectSearch select').each(function(){
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

function setSelectedIds() {
    selectedIds = [];
}