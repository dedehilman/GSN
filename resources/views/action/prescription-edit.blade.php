@php
    $prescriptions = \App\Models\Prescription::where('model_type', get_class($data))
            ->where('model_id', $data->id)
            ->get();
@endphp
<button class="btn btn-default">{{__("Generate")}}</button>
<table class="table table-bordered mt-2" id="table-prescription-medicine">
    <thead>
        <tr>
            <th width="10px" class="text-center">
                <span class='btn btn-primary btn-sm' id="btn-add-medicine" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
            </th>
            <th>{{__('Product')}}</th>
            <th>{{__('Rule')}}</th>
            <th>{{__('Stock Qty')}}</th>
            <th>{{__('Qty')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($prescriptions as $index => $prescription)
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" placeholder="" value="{{$index}}">
                    <input type="hidden" name="prescription_id[]" id="prescription_id{{$index}}" placeholder="" value="{{$prescription->id}}">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" id="prescription_medicine_name{{$index}}" class="form-control " value="{{$prescription->medicine->name}}" readonly>
                        <input type="hidden" name="prescription_medicine_id[]" id="prescription_medicine_id{{$index}}" value="{{$prescription->medicine->id}}">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select" data-title="{{__('Product List')}}" data-url="{{route('medicine.select')}}" data-handler="onSelectedPrescriptionMedicine"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" id="prescription_medicine_rule_name{{$index}}" class="form-control " value="{{$prescription->medicineRule->name}}" readonly>
                        <input type="hidden" name="prescription_medicine_rule_id[]" id="prescription_medicine_rule_id{{$index}}" value="{{$prescription->medicineRule->id}}">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select" data-title="{{__('Medicine Rule List')}}" data-url="{{route('medicine-rule.select')}}" data-handler="onSelectedPrescriptionMedicineRule"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
                <td>
                    <input type="number" class="form-control " name="prescription_stock_qty[]" id="prescription_stock_qty{{$index}}" value="{{$prescription->stock_qty ?? '0.00'}}" readonly>
                </td>
                <td>
                    <input type="number" class="form-control " name="prescription_qty[]" id="prescription_qty{{$index}}" value="{{$prescription->qty}}">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<table class="d-none" id="table-prescription-medicine-tmp">
    <tbody>
        <tr>
            <td style="vertical-align: middle; text-align: center;">
                <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                <input type="hidden" placeholder="">
                <input type="hidden" placeholder="">
            </td>
            <td>
                <div class="input-group">
                    <input type="text" class="form-control " readonly>
                    <input type="hidden">
                    <div class="input-group-append">
                        <span class="input-group-text show-modal-select" data-title="{{__('Product List')}}" data-url="{{route('medicine.select')}}" data-handler="onSelectedPrescriptionMedicine"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </td>
            <td>
                <div class="input-group">
                    <input type="text" class="form-control " readonly>
                    <input type="hidden">
                    <div class="input-group-append">
                        <span class="input-group-text show-modal-select" data-title="{{__('Medicine Rule List')}}" data-url="{{route('medicine-rule.select')}}" data-handler="onSelectedPrescriptionMedicineRule"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </td>
            <td>
                <input type="number" class="form-control " readonly>
            </td>
            <td>
                <input type="number" class="form-control ">
            </td>
        </tr>
    </tbody>
</table>

@section('scriptPresciption')
    <script>
        function onSelectedPrescriptionMedicine(data) {
            $('#prescription_medicine_id'+seqId).val(data[0].id);
            $('#prescription_medicine_name'+seqId).val(data[0].name);
        }

        function onSelectedPrescriptionMedicineRule(data) {
            $('#prescription_medicine_rule_id'+seqId).val(data[0].id);
            $('#prescription_medicine_rule_name'+seqId).val(data[0].name);
        }

        $(function(){
            $('#btn-add-medicine').on('click', function(){
                var clonedRow = $('#table-prescription-medicine-tmp tbody tr:last').clone();
                $('#table-prescription-medicine tbody').append(clonedRow);
                var textInput = clonedRow.find('input');
                
                var i = 0;
                for(var i=1; $('#prescription_id'+i).length;i++){}

                textInput.eq(1).attr('id', 'prescription_id' + i);
                textInput.eq(2).attr('id', 'prescription_medicine_name' + i);
                textInput.eq(3).attr('id', 'prescription_medicine_id' + i);
                textInput.eq(4).attr('id', 'prescription_medicine_rule_name' + i);
                textInput.eq(5).attr('id', 'prescription_medicine_rule_id' + i);
                textInput.eq(1).attr('name', 'prescription_id[]');
                textInput.eq(3).attr('name', 'prescription_medicine_id[]');
                textInput.eq(5).attr('name', 'prescription_medicine_rule_id[]');
                textInput.eq(6).attr('id', 'prescription_stock_qty[]');
                textInput.eq(6).attr('name', 'prescription_stock_qty[]');
                textInput.eq(7).attr('name', 'prescription_qty[]');
                textInput.val('');
                textInput.eq(0).val(i);
                textInput.eq(6).val('0.00');
                textInput.eq(7).val('0.00');
            });

            $(document).on('click', '.show-modal-select', function(){
                seqId = $(this).closest('tr').find('input:first').val();
            });
        })

        function removeRow(element)
        {
            var tableId = $(element).closest('table').attr("id");
            $(element).closest('tr').remove();
        }
    </script>
@endsection