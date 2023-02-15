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
                            <form action="/problemReport/{{$problem->id}}/updateStatusClient" method="POST">
                                {{csrf_field()}}
                           <div class="form-group">
                                <label for="id" class="form-label">ID Pelaporan</label>
                                <input type="text" name="id" id="id" class="form-control" value="{{ $problem->id }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-label">Detail Pelaporan</label>
                                <input type="text" name="description" id="description" class="form-control" value="{{ $problem->description }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus" class="form-label">Status Client</label>
                                    <select class="form-control" id="status_client" name="status_client">
                                        <option selected value="0">MENUNGGU</option>
                                        <option value="1">SELESAI</option>
                                    </select>
                            </div>
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