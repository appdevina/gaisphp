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
						</div>
                        <br><br>
						<div class="panel-body table-responsive">
							<table class="table table-hover" id="reqbar_table">
								<thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Barang</th>
                                    <th>Keterangan</th>
                                    <th>Jml Request</th>
                                    <th>@if ((auth()->user()->role_id == 3 && auth()->user()->division_id == 9) || in_array(auth()->user()->division->area_id, [4, 5])) Jml disetujui @endif</th>
                                    <th>@if (auth()->user()->role_id == 3 && auth()->user()->division_id == 9) Revisi @endif</th>
                                </tr>
								</thead>
								<tbody>
                                @foreach ($requestBarang->request_detail as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->product->product }}</td>
                                        <td>{{ $detail->description }}</td>
                                        <td>{{ $detail->qty_request }}</td>
                                        <td>@if ((auth()->user()->role_id == 3 && auth()->user()->division_id == 9) || in_array(auth()->user()->division->area_id, [4, 5])) {{ $detail->qty_approved }} @endif</td>
                                        <td>
                                        @if (auth()->user()->role_id == 3 && auth()->user()->division_id == 9)
                                        <a href="/editRequest/{{$detail->id}}" class="btn btn-warning" type="button">Check</a>
                                        @endif   
                                        </td> 
                                    </tr>
                                    @endforeach
								</tbody>
							</table>
                            <br><br>
                            <div class="text-right">
                                <form action="/fixRequest/{{$requestBarang->id}}" method="POST">
                                    {{csrf_field()}}
                                    @if (auth()->user()->role_id == 3 && auth()->user()->division_id == 9)
                                    <button type="submit" class="btn btn-info" onclick="return confirm('Pengajuan ini tanpa revisi, apakah semua sudah disetujui ?')">SELESAI</button>
                                    @endif
                                </form>
                            </div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
@stop