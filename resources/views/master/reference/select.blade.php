<div class="row">
    <div class="col-md-12">
        <form id="formSelectSearch">
        </form>
        <table id="datatable-select" class="table table-bordered">
            <thead>
                <tr>
                    <th>@if(($select ?? 'single') == 'multiple')<input type='checkbox' name="select-all"/>@endif</th>
                    <th>{{ __("Code") }}</th>
                    <th>{{ __("Name") }}</th>
                    <th>{{ __("Phone") }}</th>
                    <th>{{ __("Address") }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $('document').ready(function(){
        $('#datatable-select').DataTable({
            ajax:
            {
                url: "{{route('reference.datatable.select')}}",
                type: 'POST',
                data: function(data){
                    getDatatableSelectParameter(data);
                },
                error: function (xhr, error, thrown) {
                    
                }
            },
            searching: true,
            order: [[1, "asc"]],
            select: @if($select == 'multiple') 'multiple' @else 'single' @endif,
            columns: [
                {
                    width: "30px",
                    defaultContent: '',
                    sortable: false,
                    className: 'select-checkbox text-center',
                    render: function(data, type, row)
                    {
                        return '';
                    }
                }, {
                    data: 'code',
                    name: 'code',
                    defaultContent: '',
                }, {
                    data: 'name',
                    name: 'name',
                    defaultContent: '',
                }, {
                    data: 'phone',
                    name: 'phone',
                    defaultContent: '',
                }, {
                    data: 'address',
                    name: 'address',
                    defaultContent: '',
                }
            ],
            rowCallback: function(row, data) {
                if(Array.isArray(selectedIds) && selectedIds.includes(data.id)) {
                    $(row).addClass('selected');
                }
            }
        });

        $('#datatable-select').DataTable().on('select', function ( e, dt, type, indexes ) {
            var data = $('#datatable-select').DataTable().rows(indexes).data();
            if(Array.isArray(selectedIds) && !selectedIds.includes(data[0].id)) {
                selectedIds.push(data[0].id);
            }
        }).on('deselect', function ( e, dt, type, indexes ) {
            var data = $('#datatable-select').DataTable().rows(indexes).data();
            if(Array.isArray(selectedIds) && selectedIds.includes(data[0].id)) {
                var index = selectedIds.indexOf(data[0].id);
                selectedIds.splice(index, 1);
            }
        });
    });
</script>