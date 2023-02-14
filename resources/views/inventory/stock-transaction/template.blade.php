@if ($data->clinic->image)
    <img src="{{ asset($data->clinic->image) }}" height="60" style="position: absolute; left: 0px; left: 0px;">
@else
    <img src="{{ asset('public/img/logo_clinic.jpeg') }}" height="60" style="position: absolute; left: 0px; left: 0px;">
@endif
<style>
    #tableDetail, #tableDetail th, #tableDetail td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
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
        <td valign="top">{{__("Remark")}}</td>
        <td valign="top">: {!!nl2br($data->remark ?? '')!!}</td>
        @if ($data->transaction_type == 'Transfer Out')
            <td valign="top">{{__("New Clinic")}}</td>
            <td valign="top">: {{$data->newClinic->name ?? ''}}</td>
        @elseif ($data->transaction_type == 'Transfer In')
            <td valign="top">{{__("Reference")}}</td>
            <td valign="top">: {{$data->reference->transaction_no ?? ''}}</td>
        @endif
    </tr>
</table>
<br>
<table id="tableDetail" width="100%" cellpadding="3px">
    <thead>
        <tr>
            <th width="5%">{{ __('Number') }}</th>
            <th width="50%">{{ __('Product') }}</th>
            <th width="10%">{{ __('Stock Qty') }}</th>
            <th width="10%">{{ __('Qty') }}</th>
            <th width="25%">{{ __('Remark') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data->details ?? [] as $index => $detail)
            <tr>
                <td align="right">{{$index+1}}</td>
                <td>{{$detail->medicine->name}}</td>
                <td align="right">{{$detail->stock_qty}}</td>
                <td align="right">{{$detail->qty}}</td>
                <td>{{$detail->remark}}</td>
            </tr>
        @endforeach
    </tbody>
</table>