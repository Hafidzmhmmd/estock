@extends('_layouts.admin')

@section('content')
    <div class="row clearfix">
        <div class="col-12">
            <div class="card top_report">
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="fa fa-2x fa-bookmark text-col-blue"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>Pengajuan Bulan Ini</h6>
                                    <span class="font700">{{$pengjuanBulan}}</span>
                                </div>
                            </div>
                            <div class="progress progress-xs progress-transparent custom-color-blue mb-0 mt-3">
                                <div class="progress-bar" data-transitiongoal="87"></div>
                            </div>
                            <small class="text-muted">Total Pengajuan {{$totalPengajuan}}</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="fa fa-2x fa-bar-chart-o text-col-green"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>Pengajuan Dalam Proses</h6>
                                    <span class="font700">{{$proses}}</span>
                                </div>
                            </div>
                            <div class="progress progress-xs progress-transparent custom-color-green mb-0 mt-3">
                                <div class="progress-bar" data-transitiongoal="28"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="fa fa-2x fa-thumbs-up text-col-yellow"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>Pengajuan Disetujui</h6>
                                    <span class="font700">{{$disetujui}}</span>
                                </div>
                            </div>
                            <div class="progress progress-xs progress-transparent custom-color-yellow mb-0 mt-3">
                                <div class="progress-bar" data-transitiongoal="75"></div>
                            </div>
                            @php
                                $percent = 0;
                                if((int)$totalPengajuan > 0){
                                    $percent = (intval($disetujui)/intval($totalPengajuan))*100;
                                }
                            @endphp
                            <small class="text-muted">Persentase Persetujuan : {{$percent}}%</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="fa fa-2x fa-shopping-cart text-col-red"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>Pembelian Barang bulan ini</h6>
                                    <span class="font700">215</span>
                                </div>
                            </div>
                            <div class="progress progress-xs progress-transparent custom-color-red mb-0 mt-3">
                                <div class="progress-bar" data-transitiongoal="41"></div>
                            </div>
                            <small class="text-muted">Total Barang yang dibeli</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            @include('modules.pengajuan.tabelpengajuan', ['slevel' => 2])
        </div>
    </div>
@endsection
