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
							<table class="table table-hover" id="reqbar_table">
								<thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Ket</th>
                                </tr>
								</thead>
								<tbody>
                                @foreach ($requestBarang->request_detail as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->product->product }}</td>
                                        <td>{{ $detail->qty_request }}</td>
                                        <td>{{ $detail->description }}</td>
                                    </tr>
                                @endforeach
								</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
@stop