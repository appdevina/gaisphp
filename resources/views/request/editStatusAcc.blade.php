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
                            <form action="/request/{{$requestBarang->id}}/updateStatusAcc" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="hidden" name="id" id="id" class="form-control" value="{{ $requestBarang->id }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label for="inputStatusPO" class="form-label">Status PO</label>
                                    <select class="form-control" id="status_po" name="status_po">
                                        <option selected value="1">YA</option>
                                        <option value="0">TIDAK</option>
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