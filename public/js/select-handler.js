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

    $(document).on('click', '.show-modal-select', function(){
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
    $('#formSelectSearch input:not([type="checkbox"])').each(function(){
        obj[$(this).attr('name')] = $(this).val()
    })
    $('#formSelectSearch input[type="checkbox"]').each(function(){
        if($(this).prop("checked") == true){
            var arr = [];
            if($(this).attr('name') in obj) {
                arr = obj[$(this).attr('name')];
            }

            arr.push($(this).val());
            obj[$(this).attr('name')] = arr;
        }
    })
    $('#formSelectSearch select').each(function(){
        obj[$(this).attr('name')] = $(this).val()
    })

    data.parameters = obj;
}