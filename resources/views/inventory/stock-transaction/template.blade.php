@if ($data->clinic->image)
    <img src="{{ asset($data->clinic->image) }}" height="60" style="position: absolute; left: 0px; left: 0px;">
@else
    <img src="{{ asset('public/img/logo_clinic.jpeg') }}" height="60" style="position: absolute; left: 0px; left: 0px;">
@endif
<table width="100%">
    <tr>
        <td align="center">
            <strong style="font-size: 24px;">{{$data->clinic->name}}</strong><br/>
            {{$data->clinic->address}}<br/>
            Telepon {{$data->clinic->phone}}
        </td>
    </tr>
</table>
<hr/>
<table width="100%">
    <tr>
        <td width="20%">{{__("Transaction No")}}</td>
        <td width="30%">: {{$data->transaction_no}}</td>
        <td width="20%">{{__("Transaction Type")}}</td>
        <td width="30%">: {{$data->transaction_type}}</td>
    </tr>
    <tr>
        <td>{{__("Transaction Date")}}</td>
        <td>: {{\Carbon\Carbon::parse($data->transaction_date)->isoFormat("DD MMMM YYYY")}}</td>
        <td>{{__("Clinic")}}</td>
        <td>: {{$data->clinic->name}}</td>
    </tr>
    <tr>
        <td>{{__("Remark")}}</td>
        <td>: {!!nl2br($data->remark ?? '')!!}</td>
        @if ($data->transaction_type == 'Transfer Out')
            <td>{{__("New Clinic")}}</td>
            <td>: {{$data->newClinic->name ?? ''}}</td>
        @elseif ($data->transaction_type == 'Transfer In')
            <td>{{__("Reference")}}</td>
            <td>: {{$data->reference->transaction_no ?? ''}}</td>
        @endif
    </tr>
</table>
<br>
<br>
<table width="100%" border="1px">
    <thead>
        <tr>
            <th width="5%">{{ __('Number') }}</th>
            <th width="50%">{{ __('Product') }}</th>
            <th width="10%">{{ __('Stock Qty') }}</th>
            <th width="10%">{{ __('Qty') }}</th>
            <th width="25%">{{ __('Remark') }}</th>
        </tr>
    </thead>
</table>