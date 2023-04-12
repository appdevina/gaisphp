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
                            <div class="col-md-4">
                                <h3 class="panel-title">Asuransi Update</h3>
                            </div>
						</div>
                        <hr>
						<div class="panel-body table-responsive">
                            <div class="col-md-12">
                                <div class="col-md-10 text-left mb-100">
                                    <h5><strong>Detail Asuransi : </strong>{{ $detailInsurance->insured_detail }}</h5>
                                    <h5><strong>Nama Tertanggung : </strong>{{ $detailInsurance->insured_name }}</h5>
                                    <h5><strong>Alamat Tertanggung : </strong>{{ $detailInsurance->insured_address }}</h5>
                                    <h5><strong>Alamat yang diasuransikan : </strong>{{ $detailInsurance->risk_address }}</h5>
                                    <hr>
                                </div>
                                <div class="col-md-2 text-right">
                                    <a href="/insurance/createUpdate" class="btn btn-success" data-toggle="modal" data-target="#addinsuranceUpdateModal" data-toggle="tooltip" data-placement="top" title="Update Asuransi"><span class="lnr lnr-plus-circle"></span> Update</a>
                                </div>
                            </div>
                            <br><br>
							<table class="table table-hover">
								<thead>
                                <tr>
                                    <th>NO</th>
                                    <th>No Polis</th>
                                    <th>Asuransi Stok</th>
                                    <th>Nilai Stok</th>
                                    <th>Asuransi Bangunan</th>
                                    <th>Nilai Bangunan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>Aksi</th>
                                </tr>
								</thead>
								<tbody>
                                    @if (!$detailInsurance)
                                        <tr>
                                            <td colspan="9">No data found.</td>
                                        </tr>
                                    @elseif ($detailInsurance->insurance_update->isEmpty())
                                        <tr>
                                            <td colspan="9">No updates found.</td>
                                        </tr>
                                    @else
                                        @foreach ($detailInsurance->insurance_update as $detail)
                                        @php
                                            $expiredDate = Carbon\Carbon::parse($detail->expired_date);
                                            $diffInDays = Carbon\Carbon::now()->diffInDays($expiredDate, false);

                                            if ($diffInDays <= 30 && $diffInDays > 14) {
                                                $rowStyle = 'background-color: #fcf8e3; color: #8a6d3b;';
                                            } elseif ($diffInDays <= 14) {
                                                $rowStyle = 'background-color: #f2dede; color: #b96564;';
                                            } else {
                                                $rowStyle = 'background-color: white;';
                                            }
                                        @endphp
                                        <tr style="{{$rowStyle}}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->policy_number }}</td>
                                            <td>{{ $detail->stock_insurance_provider->insurance_provider }}</td>
                                            <td>Rp {{ number_format($detail->stock_worth, 0, ',', '.') }}</td>
                                            <td>{{ $detail->building_insurance_provider->insurance_provider }}</td>
                                            <td>Rp {{ number_format($detail->building_worth, 0, ',', '.') }}</td>
                                            <td><strong>{{ Carbon\Carbon::parse($detail->join_date)->format('d M Y') }}</strong></td>
                                            <td><strong>{{ Carbon\Carbon::parse($detail->expired_date)->format('d M Y') }}</strong></td>
                                            <!-- <td>{{ $diffInDays }}</td> -->
                                            <td>
                                            <a href="/insurance/{{$detail->id}}/editUpdate" class="btn btn-warning" type="button"><span class="lnr lnr-pencil"></span></a>
                                            </td> 
                                        </tr>
                                        @endforeach
                                    @endif
								</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="addinsuranceUpdateModal" role="dialog" aria-labelledby="addinsuranceUpdateModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="lnr lnr-cross"></i></button>
                    <h1 class="modal-title" id="addinsurancesModalLabel">Tambah Update Asuransi</h1>
                </div>
                <div class="modal-body">
                    <form action="/insurance/storeUpdate" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <input name="insurance_id" type="text" class="form-control" value="{{ $detailInsurance->id }}">
                    </div>
                    <div class="form-group">
                        <label for="inputPolicyNumber" class="form-label">No Polis</label>
                        <input name="policy_number" type="text" class="form-control" id="inputPolicyNumber" placeholder="No Polis.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputStockInprov" class="form-label">Asuransi Stok</label>
                        <select class="form-control" name="stock_inprov_id" required>
                            <option selected disabled>-- Pilih Provider Asuransi --</option>
                            @foreach ($inprovs as $inprov)
                                <option value="{{ $inprov->id }}">
                                    {{ $inprov->insurance_provider }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputStockWorth" class="form-label">Nilai Stok</label>
                        <input name="stock_worth" type="number" class="form-control" id="inputStockWorth" placeholder="Nilai Stok.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputBulldingInprov" class="form-label">Asuransi Bangunan</label>
                        <select class="form-control" name="building_inprov_id" required>
                            <option selected disabled>-- Pilih Provider Asuransi --</option>
                            @foreach ($inprovs as $inprov)
                                <option value="{{ $inprov->id }}">
                                    {{ $inprov->insurance_provider }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputBuildingWorth" class="form-label">Nilai Bangunan</label>
                        <input name="building_worth" type="number" class="form-control" id="inputBuildingWorth" placeholder="Nilai Bangunan.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputJoinDate" class="form-label">Tanggal Mulai</label>
                        <input type="text" class="form-control float-right" value="" name="join_date" id="tanggalMulaiAsuransi" required>
                    </div>
                    <div class="form-group">
                        <label for="inputExpiredDate" class="form-label">Tanggal Berakhir</label>
                        <input type="text" class="form-control float-right" value="" name="expired_date" id="tanggalAkhirAsuransi" required>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop