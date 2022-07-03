@if ($clinic->image)
    <img src="{{ asset($clinic->image) }}" width="50" height="50" style="position: absolute; left: 0px; left: 0px;">
@else
    <img src="{{ asset('public/img/logo.png') }}" width="50" height="50" style="position: absolute; left: 0px; left: 0px;">
@endif
<table width="400px">
    <tr>
        <td align="center">
            <strong style="font-size: 20px;">{{$clinic->name}}</strong><br/>
            {{$clinic->address}}<br/>
            Telepon {{$clinic->phone}}
        </td>
    </tr>
</table>
<br/>
<br/>
<table width="400px">
    <tr>
        <td>
            {{$data->code}}<br/>
            {{$data->name}}<br/>
            {{$data->address}}
        </td>
        <td align="right">
            <img src="data:image/png;base64, {!! $qrcode !!}">
        </td>
    </tr>
    <tr>
        <td></td>
        <td align="right">
            Kartu Pasien / <i>Patien Card</i>
        </td>
    </tr>
    <tr>
        <td>
            **Bila berobat harap dibawa
        </td>
        <td align="right">
            Reg. {{Carbon\Carbon::parse($data->created_at)->isoFormat("YYYY/MM/DD")}}
        </td>
    </tr>
</table>