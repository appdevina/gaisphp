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
                                <h3 class="panel-title">Tambah Pengajuan</h3>
                            </div>
                            <div class="panel-body">
                            <form action="/request/store" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="inputUser" class="form-label hidden">User</label>
                                <input name="user_id" type="hidden" class="form-control" id="inputUser" value="{{ auth()->user()->id }}">
                            </div>
                            <div class="form-group">
                                <label for="request_type_id" class="form-label">Tipe Pengajuan</label>
                                <select class="form-control" id="request_type_id" name="request_type_id" required>
                                    <option selected disabled>-- Pilih Tipe Pengajuan --</option>
                                    @foreach ($request_types as $reqtype)
                                        <option value="{{ $reqtype->id }}">
                                            {{ $reqtype->request_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_id" class="form-label">Barang</label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    <option selected disabled>-- Pilih Barang --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->product }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputQtyRequest" class="form-label">Kuantitas Request</label>
                                <input name="qty_request" type="number" class="form-control" id="inputQtyRequest" placeholder="Kuantitas Request.." required>
                            </div>
                            <div class="form-group">
                                <label for="inputQtyRemaining" class="form-label">Kuantitas Tersisa Saat Ini</label>
                                <input name="qty_remaining" type="number" class="form-control" id="inputQtyRemaining" placeholder="Sisa.." required>
                            </div>
                            <div class="form-group">
                                <label for="inputDescription" class="form-label">Deskripsi Pengajuan</label>
                                <input name="description" type="text" class="form-control" id="inputDescription" placeholder="Deskripsi.." required>
                            </div>
                            <div class="form-group">
                            <label for="inputRequestFile" class="form-label">File Pengajuan</label>
                            <input type="file" name="request_file" class="form-control" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-info">SIMPAN</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop