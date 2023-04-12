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
                                <div class="col-md-6">
                                    <h3 class="panel-title">Data Asuransi</h3>
                                    <br>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="/insurance/create" class="btn btn-info" data-toggle="modal" data-target="#addinsurancesModal" data-toggle="tooltip" data-placement="top" title="Tambah data baru"><span class="lnr lnr-plus-circle"></span></a>
                                </div>
                            </div>
                            <br><br><br>
                            <div class="panel-body table-responsive">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>No Polis</th>
                                        <th>Alamat Tertanggung</th>
                                        <th>Nama Tertanggung</th>
                                        <th>Detail Asuransi</th>
                                        <th>Alamat yg diasuransikan</th>
                                        <th>Asuransi Stok</th>
                                        <th>Nilai Stok</th>
                                        <th>Asuransi Bangunan</th>
                                        <th>Nilai Bangunan</th>
                                        <th>Kategori</th>
                                        <th>Cakupan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Berakhir</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($insurances as $insurance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $insurance->policy_number }}</td>
                                        <td>{{ $insurance->insured_address }}</td>
                                        <td>{{ $insurance->insured_name }}</td>
                                        <td>{{ $insurance->insured_detail }}</td>
                                        <td>{{ $insurance->risk_address }}</td>
                                        <td>{{ $insurance->stock_insurance_provider->insurance_provider }}</td>
                                        <td>Rp {{ number_format($insurance->stock_worth, 0, ',', '.') }}</td>
                                        <td>{{ $insurance->building_insurance_provider->insurance_provider }}</td>
                                        <td>Rp {{ number_format($insurance->building_worth, 0, ',', '.') }}</td>
                                        <td>{{ $insurance->insurance_category->insurance_category }}</td>
                                        <th>{{ $insurance->insurance_scope->insurance_scope }}</th>
                                        <td><strong>{{ Carbon\Carbon::parse($insurance->join_date)->format('d M Y') }}</strong></td>
                                        <td><strong>{{ Carbon\Carbon::parse($insurance->expired_date)->format('d M Y') }}</strong></td>
                                        <td>
                                            <a href="/insurance/{{$insurance->id}}/edit" class="btn btn-warning" data-toggle="modal" type="button"><span class="lnr lnr-pencil"></span></a>
                                            <!-- BUTTON DELETE -->
                                            <!-- <a href="/insurance/{{$insurance->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data ?')">Hapus</a> -->
                                            <a href="/insurance/{{$insurance->id}}" class="btn btn-default" type="button"><span class="lnr lnr-eye"></span></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div style="float:right">
                                    {{ $insurances->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="addinsurancesModal" role="dialog" aria-labelledby="addinsurancesModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="lnr lnr-cross"></i></button>
                    <h1 class="modal-title" id="addinsurancesModalLabel">Tambah Asuransi Baru</h1>
                </div>
                <div class="modal-body">
                    <form action="/insurance/store" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="inputPolicyNumber" class="form-label">No Polis</label>
                        <input name="policy_number" type="text" class="form-control" id="inputPolicyNumber" placeholder="No Polis.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputInsuredAddress" class="form-label">Alamat Tertanggung</label>
                        <input name="insured_address" type="text" class="form-control" id="inputInsuredAddress" placeholder="Alamat Tertanggung.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputInsuredName" class="form-label">Nama Tertanggung</label>
                        <input name="insured_name" type="text" class="form-control" id="inputInsuredName" placeholder="Nama Tertanggung.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputInsuredDetail" class="form-label">Detail Nama Tertanggung</label>
                        <input name="insured_detail" type="text" class="form-control" id="inputInsuredDetail" placeholder="Detail Nama Tertanggung.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputRiskAddress" class="form-label">Alamat yang diasuransikan</label>
                        <input name="risk_address" type="text" class="form-control" id="inputRiskAddress" placeholder="Alamat yang diasuransikan.." required>
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
                        <label for="inputInsuranceCategory" class="form-label">Kategori Asuransi</label>
                        <select class="form-control" name="insurance_category_id" required>
                            <option selected disabled>-- Pilih Kategori Asuransi --</option>
                            @foreach ($incategories as $incategory)
                                <option value="{{ $incategory->id }}">
                                    {{ $incategory->insurance_category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputInsuranceScope" class="form-label">Cakupan Asuransi</label>
                        <select class="form-control" name="insurance_scope_id" required>
                            <option selected disabled>-- Pilih Cakupan Asuransi --</option>
                            @foreach ($inscopes as $inscope)
                                <option value="{{ $inscope->id }}">
                                    {{ $inscope->insurance_scope }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputJoinDate" class="form-label">Tanggal Mulai</label>
                        <input data-format="dd/mm/yyyy" type="text" class="form-control float-right" value="" name="join_date" id="tanggalMulaiAsuransi" required>
                    </div>
                    <div class="form-group">
                        <label for="inputExpiredDate" class="form-label">Tanggal Berakhir</label>
                        <input data-format="dd/mm/yyyy" type="text" class="form-control float-right" value="" name="expired_date" id="tanggalAkhirAsuransi" required>
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