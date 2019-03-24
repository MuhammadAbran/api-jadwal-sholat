@extends('layouts.app')
@section('title', 'Jadwal Sholat')
@section('user-name', 'Jadwal Sholat KEMENAG')
@section('user-text', 'Indonesia')
@section('breadcrumbs', 'Indonesia')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-title"><h5>Jadwal Sholat</h5>
              <div class="ibox-tools"> <span class="label label-warning-light pull-right">Welcome</span></div>
            </div>

            <div class="ibox-content">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <label for="">Nama Daerah : </label>
            <select name="kota" class="kota">
                @foreach ($kota as $x)
                    <option value={{$x['id']}}>{{$x['nama']}}</option>
                @endforeach
            </select>
            </div>
        </div>
    </div>
</div>
@endsection
@push('selectcdn')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@endpush
@push('select2script')
<script>
    $(document).ready(function() {
        $('.kota').select2();
    });
</script>
@endpush