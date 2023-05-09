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
                                <h3 class="panel-title">Overview</h3>
                            </div>
                            <div class="panel-body">
                                <!-- OVERVIEW -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="metric">
                                            <span class="icon"><i class="fa fa-shopping-cart"></i></span>
                                            <p>
                                                <span class="number">{{$totalRequest}}</span>
                                                <span class="title">Pengajuan</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="metric">
                                            <span class="icon"><i class="fa fa-comment"></i></span>
                                            <p>
                                                <span class="number">{{$totalProblem}}</span>
                                                <span class="title">Lapor Gangguan</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="metric">
                                            <span class="icon"><i class="fa fa-archive"></i></span>
                                            <p>
                                                <span class="number">{{$totalProduct}}</span>
                                                <span class="title">Barang</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="metric">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                            <p>
                                                <span class="number">{{$totalUser}}</span>
                                                <span class="title">User</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- END OVERVIEW -->
                                <!-- CHART -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- RECENT PURCHASES -->
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
                                                    <div class="col-md-12 text-right"><a href="/request" class="btn btn-default"><span class="lnr lnr-enter"></span></a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END RECENT PURCHASES -->
                                    </div>
                                    <div class="col-md-6">
                                        <!-- RECENT PROBLEM REPORT -->
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Laporan Pending</h3>
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
                                                    <div class="col-md-12 text-right"><a href="/request" class="btn btn-default"><span class="lnr lnr-enter"></span></a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END RECENT PROBLEM REPORT -->
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
                                <div class="jumbotron">
                                    <h2 class="display-4">Halo, {{ auth()->user()->fullname }}!</h2>
                                    <!-- <p class="lead">Pengajuan ATK untuk bulan Mei telah dibuka pada tanggal 25 - 28 April 2023 </p> -->
                                    <hr class="my-4">
                                    <p>{{ $requestSetting->first()->request_detail }} untuk bulan {{ Carbon\Carbon::parse($requestSetting->first()->request_month)->locale('id')->isoFormat('MMMM YYYY'); }} telah dibuka pada tanggal {{ Carbon\Carbon::parse($requestSetting->first()->open_date)->locale('id')->isoFormat('DD MMMM YYYY'); }} - {{ Carbon\Carbon::parse($requestSetting->first()->closed_date)->locale('id')->isoFormat('DD MMMM YYYY') }}</p>
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