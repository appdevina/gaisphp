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
                            <div class="col-md-2">
                                <h3 class="panel-title">Detail Pengajuan</h3>
                            </div>
                            <div class="col-md-4 text-right">
                            </div>
                            <div class="col-md-6 text-right">
                            </div>
						</div>
                        <br><br>
						<div class="panel-body table-responsive">
							<form action="/request/{{$detail->id}}/updateRequest" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="text" name="id" id="id" class="form-control" value="{{ $detail->id }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label for="inputRequestId" class="form-label">ID REQUEST</label>
                                <input type="text" name="request_id" id="request_id" class="form-control" value="{{ $detail->request_id }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label for="inputProduct" class="form-label">Nama Barang</label>
                                <input type="text" name="product_id" id="product_id" class="form-control" value="{{ $detail->product->product }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label for="inputProduct" class="form-label">Jumlah Request</label>
                                <input type="text" name="qty_request" id="qty_request" class="form-control" value="{{ $detail->qty_request }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label for="inputProduct" class="form-label">Jumlah yang disetujui</label>
                                <input type="text" name="qty_approved" id="qty_approved" class="form-control" value="{{ $detail->qty_approved }}"/>
                            </div>
                                <button type="submit" class="btn btn-warning">REVISI</button>
                            </form>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
@stop