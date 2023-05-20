@extends('layouts.master')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <i class="fa fa-check-circle"></i> {{session('success')}}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <i class="fa fa-check-circle"></i> {{session('error')}}
                </div>
                @endif
                @if (auth()->user()->role_id == 1)
                <div class="row">
                    <div class="col-md-12">
                            <div class="panel panel-headline">
                            <div class="panel-heading">
                                <h3 class="panel-title">Ringkasan</h3>
                            </div>
                            <div class="panel-body">
                                <!-- OVERVIEW -->
                                <div class="row">
                                    <a href="/request">
                                        <div class="col-md-3">
                                            <div class="metric">
                                                <span class="icon"><i class="fa fa-shopping-cart"></i></span>
                                                <p>
                                                    <span class="number">{{$totalRequest}}</span>
                                                    <span class="title">Pengajuan</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="/problemReport">
                                        <div class="col-md-3">
                                            <div class="metric">
                                                <span class="icon"><i class="fa fa-comment"></i></span>
                                                <p>
                                                    <span class="number">{{$totalProblem}}</span>
                                                    <span class="title">Lapor Gangguan</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="/product">
                                        <div class="col-md-3">
                                            <div class="metric">
                                                <span class="icon"><i class="fa fa-archive"></i></span>
                                                <p>
                                                    <span class="number">{{$totalProduct}}</span>
                                                    <span class="title">Barang</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="/user">
                                        <div class="col-md-3">
                                            <div class="metric">
                                                <span class="icon"><i class="fa fa-user"></i></span>
                                                <p>
                                                    <span class="number">{{$totalUser}}</span>
                                                    <span class="title">User</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="/insurance">
                                        <div class="col-md-3">
                                            <div class="metric">
                                                <span class="icon"><i class="lnr lnr-heart-pulse"></i></span>
                                                <p>
                                                    <span class="number">{{$totalInsurance}}</span>
                                                    <span class="title">Asuransi</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="/rent">
                                        <div class="col-md-3">
                                            <div class="metric">
                                                <span class="icon"><i class="fa fa-handshake-o"></i></span>
                                                <p>
                                                    <span class="number">{{$totalRent}}</span>
                                                    <span class="title">Perjanjian Sewa</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- END OVERVIEW -->
                                <!-- CHART -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <!-- RECENT REQUEST -->
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Pengajuan Pending</h3>
                                                </div>
                                                <div class="panel-body no-padding table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Pemohon</th>
                                                                <th>Diajukan pada</th>
                                                                <th>Tipe Pengajuan</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($requestBarangs as $reqbar)
                                                            <tr>
                                                                <td>{{ $reqbar->user->fullname }}</td>
                                                                <td>{{ Carbon\Carbon::parse($reqbar->date)->format('d M Y') }}</td>
                                                                <td>{{ $reqbar->request_type->request_type }}</td>
                                                                <td><span class="label label-warning">MENUNGGU</span></td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="panel-footer">
                                                    <div class="row">
                                                        <div class="col-md-12 text-right"><a href="/request" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Masuk ke Pengajuan"><span class="lnr lnr-enter"></span></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END RECENT REQUEST -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- RECENT PROBLEM REPORT -->
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Laporan Pending</h3>
                                                    <br>
                                                </div>
                                                <div class="panel-body no-padding table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Pelapor</th>
                                                                <th>Dilaporkan pada</th>
                                                                <th>Kategori</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($problemReport as $problem)
                                                            <tr>
                                                                <td>{{ $problem->user->fullname }}</td>
                                                                <td>{{ Carbon\Carbon::parse($problem->date)->format('d M Y') }}</td>
                                                                <td>{{ $problem->prcategory->problem_report_category }}</td>
                                                                <td><span class="label label-warning">MENUNGGU</span></td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="panel-footer">
                                                    <div class="row">
                                                        <div class="col-md-12 text-right"><a href="/problemReport" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Masuk ke Lapor Gangguan"><span class="lnr lnr-enter"></span></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END RECENT PROBLEM REPORT -->
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <!-- RECENT INSURANCES -->
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Asuransi - Expired terdekat</h3>
                                                    <br>
                                                </div>
                                                <div class="panel-body no-padding table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Detail</th>
                                                                <th>Tgl Berakhir</th>
                                                                <th>Stock</th>
                                                                <th>Bangunan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($insurances as $insurance)
                                                            <tr>
                                                                <td>{{ $insurance->insured_detail }}</td>
                                                                <td>
                                                                    @if ($insurance->insurance_update->isNotEmpty())
                                                                        {{ Carbon\Carbon::parse($insurance->insurance_update->first()->expired_date)->format('d M Y') }}
                                                                    @else
                                                                        {{ Carbon\Carbon::parse($insurance->expired_date)->format('d M Y') }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($insurance->insurance_update->isNotEmpty())
                                                                        {{ $insurance->insurance_update->first()->stock_insurance_provider->insurance_provider ?? '' }}
                                                                    @else
                                                                    {{ $insurance->stock_insurance_provider->insurance_provider ?? ''}}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($insurance->insurance_update->isNotEmpty())
                                                                        {{ $insurance->insurance_update->first()->building_insurance_provider->insurance_provider ?? '' }}
                                                                    @else
                                                                        {{ $insurance->building_insurance_provider->insurance_provider ?? ''}}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="panel-footer">
                                                    <div class="row">
                                                        <div class="col-md-12 text-right"><a href="/insurance" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Masuk ke Asuransi"><span class="lnr lnr-enter"></span></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END RECENT INSURANCES -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- RECENT RENTS -->
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Perjanjian Sewa - Expired terdekat</h3>
                                                    <br>
                                                </div>
                                                <div class="panel-body no-padding table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Detail</th>
                                                                <th>Tgl Berakhir</th>
                                                                <th>Sewa/tahun</th>
                                                                <th>Total Tagihan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($rents as $rent)
                                                            <tr>
                                                                <td>{{ $rent->rented_detail }}</td>
                                                                <td>
                                                                    @if ($rent->rent_update->isNotEmpty())
                                                                        {{ Carbon\Carbon::parse($rent->rent_update->first()->expired_date)->format('d M Y') }}
                                                                    @else
                                                                        {{ Carbon\Carbon::parse($rent->expired_date)->format('d M Y') }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($rent->rent_update->isNotEmpty())
                                                                        Rp {{ number_format($rent->rent_update->first()->rent_per_year, 0, ',', '.') }}
                                                                    @else
                                                                        Rp {{ number_format($rent->rent_per_year, 0, ',', '.') }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($rent->rent_update->isNotEmpty())
                                                                        Rp {{ number_format(
                                                                            Carbon\Carbon::parse($rent->rent_update->first()->expired_date)->diffInDays($rent->rent_update->first()->join_date) / 366 == 1 
                                                                            ? 1 * $rent->rent_update->first()->rent_per_year 
                                                                            : ceil(Carbon\Carbon::parse($rent->rent_update->first()->expired_date)->diffInDays($rent->rent_update->first()->join_date) / 366) * $rent->rent_update->first()->rent_per_year, 0, ',', '.') 
                                                                    }}
                                                                    @else
                                                                        Rp {{ number_format(
                                                                            Carbon\Carbon::parse($rent->expired_date)->diffInDays($rent->join_date) / 366 == 1 
                                                                            ? 1 * $rent->rent_per_year 
                                                                            : ceil(Carbon\Carbon::parse($rent->expired_date)->diffInDays($rent->join_date) / 366) * $rent->rent_per_year, 0, ',', '.')  
                                                                    }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="panel-footer">
                                                    <div class="row">
                                                        <div class="col-md-12 text-right"><a href="/rent" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Masuk ke Perjanjian Sewa"><span class="lnr lnr-enter"></span></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END RECENT RENTS -->
                                        </div>
                                    </div>
                                </div>
                                <!-- END CHART -->
                            </div>
                    </div>
                </div>
                @endif
                @if (auth()->user()->role_id != 1)
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-headline">
                            <!-- <div class="panel-heading">
                                <h3 class="panel-title">Dashboard</h3>
                            </div> -->
                            <div class="panel-body">
                                <!-- JUMBOTRON -->
                                <div class="jumbotron" style="background-color:#2b333e !important;">
                                    <h2 class="display-4" style="color:white">Halo, {{ auth()->user()->fullname }}!</h2>
                                    <hr class="my-4">
                                    <p style="color: white;">{{ $requestSetting->first()->request_detail }} untuk bulan {{ Carbon\Carbon::parse($requestSetting->first()->request_month)->locale('id')->isoFormat('MMMM YYYY'); }} telah dibuka pada tanggal {{ Carbon\Carbon::parse($requestSetting->first()->open_date)->locale('id')->isoFormat('DD MMMM YYYY'); }} - {{ Carbon\Carbon::parse($requestSetting->first()->closed_date)->locale('id')->isoFormat('DD MMMM YYYY') }}</p>
                                    <br>
                                    <p class="lead">
                                        <a class="btn btn-info btn-lg" href="/request" role="button"><i class="lnr lnr-cart"></i> Pengajuan</a>
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="#" data-toggle="modal" data-target="#modalImageRequest">
                                            <img src="{{asset('admin/assets/img/INFOGRAF - PENGAJUAN.jpg')}}" class="img-fluid" alt="INFOGRAFIS LAPOR GANGGUAN" style="max-width: 100%; height: auto;">
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="#" data-toggle="modal" data-target="#modalImageProblem">
                                            <img src="{{asset('admin/assets/img/INFOGRAF - GANGGUAN.jpg')}}" class="img-fluid" alt="INFOGRAFIS LAPOR GANGGUAN" style="max-width: 100%; height: auto;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal 1 -->
    <div id="modalImageRequest" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-body">
            <img src="{{asset('admin/assets/img/INFOGRAF - PENGAJUAN.jpg')}}" class="img-fluid" alt="INFOGRAFIS LAPOR GANGGUAN" style="max-width: 100%; height: auto;">
        </div>
        </div>
    </div>
    </div>

    <!-- Modal 2 -->
    <div id="modalImageProblem" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-body">
            <img src="{{asset('admin/assets/img/INFOGRAF - GANGGUAN.jpg')}}" class="img-fluid" alt="INFOGRAFIS LAPOR GANGGUAN" style="max-width: 100%; height: auto;">
        </div>
        </div>
    </div>
    </div>
@stop