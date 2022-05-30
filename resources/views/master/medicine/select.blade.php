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
                    <th>{{ __("Unit") }}</th>
                    <th>{{ __("Medicine Type") }}</th>
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
                url: "{{route('medicine.datatable.select')}}",
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
                    data: 'unit.name',
                    name: 'unit_id',
                    defaultContent: '',
                }
                }, {
                    data: 'medicine_type.name',
                    name: 'medicine_type_id',
                    defaultContent: '',
                }
            ],
        });
    });
</script>