<table>
    <tr>
        <td colspan="10" align="center">LAPORAN STOK PENERIMAAN / PENGELUARAN OBAT DAN ALKES</td>
    </tr>
    <tr>
        <td colspan="10" align="center">{{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="10" align="center">PERIODE : {{$reportModel->start_date}} - {{$reportModel->end_date}}</td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th>{{__("Transaction No")}}</th>
            <th>{{__("Transaction Date")}}</th>
            <th>{{__("Transaction Type")}}</th>
            <th>{{__("From / To Clinic")}}</th>
            <th>{{__("Reference")}}</th>
            <th>{{__("Remark")}}</th>
            <th>{{__("Product")}}</th>
            <th>{{__("Stock Qty")}}</th>
            <th>{{__("Qty")}}</th>
            <th>{{__("Remark")}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $data)
            @if (count($data->details ?? []) > 0)
                @foreach ($data->details as $detail)
                    <tr>
                        <td>{{$data->transaction_no}}</td>
                        <td>{{$data->transaction_date}}</td>
                        <td>{{$data->transaction_type}}</td>
                        <td>{{$data->transaction_type == "Transfer Out" ? $data->newClinic->name : ($data->transaction_type == "Transfer In" ? $data->reference->clinic->name ?? "" : "")}}</td>
                        <td>{{$data->reference->transaction_no ?? ""}}</td>
                        <td>{{$data->remark}}</td>
                        <td>{{$detail->medicine->name}}</td>
                        <td>{{$detail->stock_qty}}</td>
                        <td>{{$detail->qty}}</td>
                        <td>{{$detail->remark}}</td>
                    </tr>
                @endforeach                
            @else
                <tr>
                    <td>{{$data->transaction_no}}</td>
                    <td>{{$data->transaction_date}}</td>
                    <td>{{$data->transaction_type}}</td>
                    <td>{{$data->transaction_type == "Transfer Out" ? $data->newClinic->name : ($data->transaction_type == "Transfer In" ? $data->reference->clinic->name ?? "" : "")}}</td>
                    <td>{{$data->reference->transaction_no ?? ""}}</td>
                    <td>{{$data->remark}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>