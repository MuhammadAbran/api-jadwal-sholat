@extends('layouts.app')
@section('title', 'Jadwal Sholat')
@section('user-name', 'Jadwal Sholat KEMENAG')
@section('user-avatar', 'data:image/jpeg;base64,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')
@section('user-text', 'Indonesia')
@push('head')
<link rel="stylesheet" href="{{ asset('/css/select2.css') }}">
<link rel="icon" href="data:image/jpeg;base64,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">
@endpush
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2 animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-title"><h5>Jadwal Sholat <span class="text-navy" id="kota">Kota Yogyakarta</span> </h5>
              <div class="ibox-tools"> <span class="label label-primary pull-right">By API Fathimah</span></div>
            </div>

            <div class="ibox-content">
               <div class="row">
                  <form id="form" method="post" action="">
                     <div class="col-md-2"></div>
                     <div class="col-md-4">
                        <label for="kota">Pilih Kota</label>
                        <select class="select2_demo_3 form-control wow">
                            <option value="777">Kota Yogyakarta</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Bahrain">Bahrain</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                        </select>
                     </div>
                     <div class="col-md-4">
                        <label for="kota">Pilih Tanggal</label>
                        <div class="input-group date" id="data_1">
                        <span class="input-group-addon" style="border-radius: 5px 0 0 5px"><i class="fa fa-calendar"></i></span><input type="date" class="form-control" value="{{date('d/m/Y')}}" style="border-radius: 0 5px 5px 0">
                        </div>
                     </div>
                     <div class="col-md-2"></div>
                  </form>
               </div>
               <div class="row">
                  <div class="col-md-3"></div>
                  <div class="col-md-6">
                     <strong>Timeline activity</strong>
                      <div id="vertical-timeline" class="vertical-container dark-timeline">
                          <div class="vertical-timeline-block">
                              <div class="vertical-timeline-icon navy-bg">
                                  <i class="fa fa-clock-o"></i>
                              </div>
                              <div class="vertical-timeline-content">
                                    <h4>Shubuh <span class="text-navy">15:00 WIB</span></h4>
                              </div>
                          </div>
                          <div class="vertical-timeline-block">
                              <div class="vertical-timeline-icon red-bg">
                                  <i class="fa fa-sun-o"></i>
                              </div>
                              <div class="vertical-timeline-content">
                                    <h4>Terbit <span class="text-danger">15:00 WIB</span></h4>
                              </div>
                          </div>
                          <div class="vertical-timeline-block">
                              <div class="vertical-timeline-icon navy-bg">
                                  <i class="fa fa-sun-o"></i>
                              </div>
                              <div class="vertical-timeline-content">
                                    <h4>Dzuhur <span class="text-navy">15:00 WIB</span></h4>
                              </div>
                          </div>
                          <div class="vertical-timeline-block">
                              <div class="vertical-timeline-icon navy-bg">
                                  <i class="fa fa-clock-o"></i>
                              </div>
                              <div class="vertical-timeline-content">
                                    <h4>Ashar <span class="text-navy">15:00 WIB</span></h4>
                              </div>
                          </div>
                          <div class="vertical-timeline-block">
                              <div class="vertical-timeline-icon navy-bg">
                                  <i class="fa fa-clock-o"></i>
                              </div>
                              <div class="vertical-timeline-content">
                                    <h4>Maghrib <span class="text-navy">15:00 WIB</span></h4>
                              </div>
                          </div>
                          <div class="vertical-timeline-block">
                              <div class="vertical-timeline-icon navy-bg">
                                  <i class="fa fa-moon-o"></i>
                              </div>
                              <div class="vertical-timeline-content">
                                    <h4>Isya <span class="text-navy">15:00 WIB</span></h4>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-3"></div>
               </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('body')
   <script src="{{ asset('/js/select2.js') }}" charset="utf-8"></script>
   <script src="{{ asset('/js/date.js') }}" charset="utf-8"></script>
   <script type="text/javascript">
      $(".select2_demo_3").select2();

   </script>
    <script>
        var url = "https://api.banghasan.com/sholat/format/json/kota";
        var id, name;
        var xhr;

        if(window.XMLHttpRequest){
            xhr = new XMLHttpRequest();
        }else{
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xhr.onread
    </script>
@endpush
