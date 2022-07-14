<div class="row">
    <div class="col-md-12">
        <form id="formSelectSearch">
            @foreach ($parameters as $key => $value)
                <input type="hidden" name="{{$key}}" value="{{$value}}">
            @endforeach
        </form>
        <table id="datatable-select" class="table table-bordered">
            <thead>
                <tr>
                    <th>@if(($select ?? 'single') == 'multiple')<input type='checkbox' name="select-all"/>@endif</th>
                    <th>{{ __("Code") }}</th>
                    <th>{{ __("Name") }}</th>
                    <th>{{ __("Percentage") }}</th>
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
                url: "{{route('diagnosis.datatable.calculate')}}",
                type: 'POST',
                data: function(data){
                    getDatatableSelectParameter(data);
                },
                error: function (xhr, error, thrown) {
                    
                }
            },
            serverSide: false,
            searching: true,
            order: [[3, "desc"]],
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
                    data: 'matchCount',
                    defaultContent: '0',
                    className: 'text-center',
                    render: function(data, type, row)
                    {
                        if(row.totalCount > 0) {
                            return '<span class="badge bg-success">'+(data/row.totalCount * 100).toFixed(2)+' %</span>';
                        }
                        return '<span class="badge bg-success">100.00 %</span>';
                    }
                }
            ],
        });
    });
</script>