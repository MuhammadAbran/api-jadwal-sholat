@extends('layouts.app')
@section('title', 'Jadwal Sholat')
@section('user-name', 'Jadwal Sholat KEMENAG')
@section('user-text', 'Indonesia')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2 animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-title"><h5>Jadwal Sholat <span class="text-navy" id="kota">Kota Yogyakarta</span> </h5>
              <div class="ibox-tools"> <span class="label label-primary pull-right">By API Fathimah</span></div>
            </div>

            <div class="ibox-content">
               <div class="row">
                  <form id="form" method="post">
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
    <script>
        $(document).ready(function(){
            var url = "https://api.banghasan.com/sholat/format/json/kota";
            var city_opt = '';
            var city = [];

            $.get(url, function(data){
                $.each(data, function(key, items){
                    kota = items.kota.nama;
                    id = items.kota.id;

                    if($.inArray(gend,gender) === -1){
                        city.push(kota);
                        city_opt += '<option value="'+id+'">'+kota+'</option>'
                    }
                });
            
                $('.wow').html('')
            });
        });
    </script>
@endpush
