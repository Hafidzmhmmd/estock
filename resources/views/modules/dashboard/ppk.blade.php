@extends('_layouts.admin')

@push('css_vendor')
    <link rel="stylesheet" href="{{ asset('/vendor/morrisjs/morris.css') }}" />
@endpush
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
        <div class="card mx-3">
            <div class="header">
                <h2>Site Chart</h2>
                <ul class="header-dropdown dropdown dropdown-animated scale-left">
                    <li> <a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="pulse"><i class="icon-refresh"></i></a></li>
                    <li><a href="javascript:void(0);" class="full-screen"><i class="icon-size-fullscreen"></i></a></li>
                    {{-- <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another Action</a></li>
                            <li><a href="javascript:void(0);">Something else</a></li>
                        </ul>
                    </li> --}}
                </ul>
            </div>
            <div class="body">
                <div id="m_area_chart2"></div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            @include('modules.pengajuan.tabelpengajuan', ['slevel' => 2])
        </div>
    </div>
@endsection

@push('js_vendor')
<script src="{{ asset('/bundles/morrisscripts.bundle.js') }}"></script>
@endpush
@push('js')
    <script>

        $(document).ready(function(){
            getDataGrafik()
        })

        var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "Desember"];
        function getDataGrafik(){
            $.get('{{route('data.grafikDashboard')}}', function(rsp){

                let data = [];
                rsp.in.forEach(e => {
                    data.push({
                        m: `${e.year}-${e.month - 1}`,
                        a: e.pengajuan,
                        b: 0,
                    })
                });
                createGraph(data)

            })
        }

        function createGraph(dt){
            Morris.Area({
                element: 'm_area_chart2',
                data: dt,
                xkey: 'm',
                ykeys: ['a', 'b'],
                labels: ['Pengangaran', 'Terpakai'],
                xLabelFormat: function (x) {
                    console.log(x)
                    let strlabel = x.src.m;
                    let parts = strlabel.split('-')
                    console.log(parts)
                    var month = months[parseInt(parts[1])];
                    return `${month} ${parts[0]}`;
                },
                pointSize: 0,
                fillOpacity: 0.8,
                pointStrokeColors: ['#242a2b', '#5dd0fc'],
                behaveLikeLine: true,
                gridLineColor: '#eeeeee',
                lineWidth: 0,
                smooth: false,
                hideHover: 'auto',
                lineColors: ['#242a2b', '#5dd0fc'],
                resize: true,
                parseTime:false,
            });
        }


    </script>
@endpush
