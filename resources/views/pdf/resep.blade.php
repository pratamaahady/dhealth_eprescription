@extends('layouts.pdf')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th class="text-center">No.</th>
            <th>Nama Obat</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
        @foreach($data->obatalkes as $obatalkes)
        <tr>
            <td class="text-center">{{ $i }}</td>
            <td>{{ $obatalkes->obatalkes_nama }}</td>
            <td>{{ $obatalkes->pivot->quantity }}</td>
        </tr>
        <?php $i++; ?>
        @endforeach
        @foreach($data->obatalkes_racikan as $obatalkesRacikan)
        <tr>
            <td class="text-center">{{ $i }}</td>
            <td>{{ $obatalkesRacikan->obatalkes_racikan_nama }}</td>
            <td>{{ $obatalkesRacikan->pivot->quantity }}</td>
        </tr>
        <?php $i++; ?>
        @endforeach
    </tbody>
</table>
@stop
