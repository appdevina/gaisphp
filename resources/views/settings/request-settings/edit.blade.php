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
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Edit</h3>
                            </div>
                            <div class="panel-body">
                            <form action="/request-settings/{{$requestSetting->id}}/update" method="POST">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="inputRequestDetail" class="form-label">Detail Pengajuan</label>
                                    <input name="request_detail" type="text" class="form-control" id="inputRequestDetail" value="{{ $requestSetting->request_detail }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputRequestMonth" class="form-label">Bulan Pengajuan</label>
                                    <input type="text" class="form-control float-right" value="" name="request_month" id="requestMonth" value="{{ Carbon\Carbon::parse($requestSetting->request_month)->format('m/Y') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputOpenDate" class="form-label">Tanggal Dibuka</label>
                                    <input type="text" class="form-control float-right" value="" name="open_date" id="openDate" value="{{ Carbon\Carbon::parse($requestSetting->open_date)->format('d/m/Y') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputClosedDate" class="form-label">Tanggal Ditutup</label>
                                    <input type="text" class="form-control float-right" value="" name="closed_date" id="closedDate" value="{{ Carbon\Carbon::parse($requestSetting->closed_date)->format('d/m/Y') }}" required>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-warning">UPDATE</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop