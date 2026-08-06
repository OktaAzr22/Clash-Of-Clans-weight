<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<style>

body{

    font-family: DejaVu Sans;

    font-size:12px;

}

table{

    width:100%;

    border-collapse:collapse;

    margin-bottom:25px;

}

th,td{

    border:1px solid #000;

    padding:6px;

}

th{

    background:#efefef;

}

.title{

    text-align:center;

    font-size:20px;

    margin-bottom:20px;

}

.player{

    margin-top:20px;

    margin-bottom:10px;

    font-weight:bold;

}

</style>

</head>

<body>

<div class="title">

LIST AKUN YANG MASIH PERLU UPGRADE

</div>

<p>

Tanggal Cetak :
{{ now()->format('d-m-Y H:i') }}

</p>

@foreach($players as $data)

<div class="player">

{{ $data['player']->name }}

|
TH {{ $data['player']->town_hall }}

@if($data['player']->template)

|
Template :
{{ $data['player']->template->name }}

@endif

</div>

<table>

<thead>

<tr>

<th>Bangunan</th>

<th>Slot</th>

<th>Lv Sekarang</th>

<th>Lv Target</th>

<th>Kurang</th>

</tr>

</thead>

<tbody>

@foreach($data['upgrades'] as $upgrade)

<tr>

<td>

{{ $upgrade['building'] }}

</td>

<td align="center">

{{ $upgrade['slot'] }}

</td>

<td align="center">

{{ $upgrade['current'] }}

</td>

<td align="center">

{{ $upgrade['target'] }}

</td>

<td align="center">

{{ $upgrade['difference'] }}

</td>

</tr>

@endforeach

</tbody>

</table>

@endforeach

</body>

</html>