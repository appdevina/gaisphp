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
                            <form action="/request/{{$requestBarang->id}}/updateStatus" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="hidden" name="id" id="id" class="form-control" value="{{ $requestBarang->id }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option selected value="PENDING">MENUNGGU</option>
                                        <option value="CLOSED">SELESAI</option>
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