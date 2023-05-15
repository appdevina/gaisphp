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
                            <div class="col-md-12">
                                <h3 class="panel-title">Detail Pengajuan - {{ $requestBarang->user->fullname }}</h3>
                            </div>
						</div>
                        <br><br>
						<div class="panel-body table-responsive">
							<table class="table table-hover" id="reqbar_table">
								<thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Barang</th>
                                    <th>Harga</th>
                                    <th>Keterangan</th>
                                    <th>@if ( auth()->user()->role_id < 4 || in_array(auth()->user()->division->area_id, [3, 4, 5, 11])) Sisa @endif</th>
                                    <th>Request</th>
                                    <th>@if ((auth()->user()->role_id < 4) || in_array(auth()->user()->division->area_id, [3, 4, 5, 11])) Jml disetujui @endif</th>
                                    <th>@if ((auth()->user()->role_id < 4) || in_array(auth()->user()->division->area_id, [3, 4, 5, 11])) Total @endif</th>
                                    <th>@if (auth()->user()->role_id == 3 && auth()->user()->division_id == 9) Revisi @endif</th>
                                </tr>
								</thead>
								<tbody>
                                @foreach ($requestBarang->request_detail as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->product->product }}</td>
                                        <td>Rp {{ number_format($detail->product->price, 0, ',', '.') }}</td>
                                        <td>{{ $detail->description }}</td>
                                        <td>@if ((auth()->user()->role_id < 4) || in_array(auth()->user()->division->area_id, [3, 4, 5, 11])){{ $detail->qty_remaining }} @endif</td>
                                        <td>{{ $detail->qty_request }}</td>
                                        <td>@if ((auth()->user()->role_id < 4) || in_array(auth()->user()->division->area_id, [3, 4, 5, 11])) {{ $detail->qty_approved }} @endif</td>
                                        <td>@if ((auth()->user()->role_id < 4) || in_array(auth()->user()->division->area_id, [3, 4, 5, 11])) 
                                                @if (in_array($requestBarang->user->division->area_id, [4, 5, 11]))
                                                    Rp {{ $detail->qty_approved === null ? number_format($detail->qty_request * $detail->product->price, 0, ',', '.') : $detail->qty_approved === 0 ? number_format($detail->qty_approved * $detail->product->price, 0, ',', '.') : number_format($detail->qty_approved * $detail->product->price, 0, ',', '.') }}
                                                @else 
                                                    Rp {{ number_format($detail->qty_request * $detail->product->price, 0, ',', '.') }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                        @if (auth()->user()->role_id == 3 && in_array(auth()->user()->division_id, [9, 12, 80]))
                                        <a href="/editRequest/{{$detail->id}}" class="btn btn-warning" type="button"><span class="lnr lnr-pencil"></span></a>
                                        @endif   
                                        </td> 
                                    </tr>
                                    @endforeach
								</tbody>
							</table>
                            <br><br><br>
                            <div class="col-md-12 text-left">
                                <h4>Catatan GA : {{ $requestBarang->notes }}</h4>
                                <h4>Catatan User : {{ $requestBarang->user_notes }}</h4>
                            </div>
                            <div class="col-md-11 text-right">
                                <h4>Total Biaya : Rp {{ number_format($grandTotal, 0, ',', '.') }}</h4>
                            </div>
                            <br><br><br>
                            <div class="text-right">
                                <form action="/fixRequest/{{$requestBarang->id}}" method="POST">
                                    {{csrf_field()}}
                                    @if (auth()->user()->role_id == 3 && in_array(auth()->user()->division_id, [9, 12, 80]))
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