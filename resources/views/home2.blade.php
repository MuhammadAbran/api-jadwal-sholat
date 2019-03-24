@extends('layouts.app')
@section('title', 'Jadwal Sholat')
@section('user-name', 'Jadwal Sholat KEMENAG')
@section('user-text', 'Indonesia')
@section('breadcrumbs', 'Indonesia')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-title"><h5>Dashboard</h5>
              <div class="ibox-tools"> <span class="label label-warning-light pull-right">Welcome</span></div>
            </div>

            <div class="ibox-content">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                Jadwal Sholat
            <select name="" id="">
                <option value=""></option>
            </select>
            
                ISI DISINI
            </div>
        </div>
    </div>
</div>
@endsection
