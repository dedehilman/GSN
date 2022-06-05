<div class="row">
    <div class="col-md-12">
        <form id="formSelectSearch">
        </form>
        <table id="datatable-select" class="table table-bordered">
            <thead>
                <tr>
                    <th>@if(($select ?? 'single') == 'multiple')<input type='checkbox' name="select-all"/>@endif</th>
                    <th>{{ __("Period") }}</th>
                    <th>{{ __("Medicine") }}</th>
                    <th>{{ __("Clinic") }}</th>
                    <th>{{ __("Quantity") }}</th>
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
                url: "{{route('stock.datatable.select')}}",
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
                    data: 'period.name',
                    name: 'period_id',
                    defaultContent: '',
                }, {
                    data: 'medicine.name',
                    name: 'medicine_id',
                    defaultContent: '',
                }, {
                    data: 'clinic.name',
                    name: 'clinic_id',
                    defaultContent: '',
                }, {
                    data: 'qty',
                    name: 'qty',
                    defaultContent: '',
                }
            ],
        });
    });
</script>