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
                                    <div class="col-md-2">
                                        <h3 class="panel-title">Data Asuransi</h3>
                                        <br>
                                    </div>
                                    <div class="col-md-3 text-center">
                                    <form class="form-inline" id="search_form" action="/insurance">
                                        <div class="form-group">
                                        <input type="text" class="form-control" name="search" placeholder="Cari ..." style="width: 140px;">
                                        <a href="javascript:{}" onclick="document.getElementById('search_form').submit();" class="btn btn-info" ><span class="lnr lnr-magnifier"></span></a>
                                        </div>
                                    </form>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <form class="form-inline" id="inputStatus" action="/insurance">
                                            <div class="form-group">
                                            <select class="form-control" name="selectStatus">
                                                <option selected value="">-- Status --</option>
                                                <option value="BERJALAN">BERJALAN</option>
                                                <option value="PEMBAHARUAN">PEMBAHARUAN</option>
                                                <option value="TUTUP">TUTUP</option>
                                                <option value="REFUND">REFUND</option>
                                            </select>
                                            <a href="javascript:{}" onclick="document.getElementById('inputStatus').submit();" class="btn btn-info" ><span class="lnr lnr-magnifier"></span></a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <a href="/insurance/create" class="btn btn-info" data-toggle="modal" data-target="#addinsurancesModal" data-toggle="tooltip" data-placement="top" title="Tambah data baru"><span class="lnr lnr-plus-circle"></span></a>
                                        <a href="/insurance/export" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Export Asuransi"><span class="lnr lnr-download"></span></a>
                                        <a class="btn btn-success" data-toggle="modal" data-target=".importModal" data-toggle="tooltip" data-placement="top" title="Import Asuransi"><span class="lnr lnr-upload"></span></a>
                                        <a href="/insurance/export/template" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Download template"><span class="lnr lnr-text-align-justify"></span></a>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <br><br><br>
                            <div class="panel-body table-responsive">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>No Polis</th>
                                        <!-- <th>Alamat Tertanggung</th>
                                        <th>Nama Tertanggung</th> -->
                                        <th>Kode</th>
                                        <th>Detail Asuransi</th>
                                        <th>Alamat yg diasuransikan</th>
                                        <th>Asuransi Stok</th>
                                        <th>Nilai Stok</th>
                                        <th>Aktual Stok</th>
                                        <th>Selisih</th>
                                        <th>Asuransi Bangunan</th>
                                        <th>Nilai Bangunan</th>
                                        <th>Kategori</th>
                                        <th>Cakupan</th>
                                        <!-- <th>Tanggal Mulai</th> -->
                                        <th>Tanggal Berakhir</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($insurances as $insurance)
                                        @php
                                            $expiredDate = Carbon\Carbon::parse($insurance->insurance_update->last()->expired_date ?? now());

                                            $diffInDays = Carbon\Carbon::now()->diffInDays($expiredDate, false);
                                            $rowStyle = ''; // initialize the variable

                                            if ($diffInDays <= 30 && $diffInDays > 14) {
                                                $rowStyle = 'background-color: #fcf8e3; color: #8a6d3b;';
                                            } elseif ($diffInDays <= 14) {
                                                    $status = $insurance->insurance_update->last()->status ?? '';
                                                    
                                                    if ($status === 'BERJALAN' || $status === 'PEMBAHARUAN') {
                                                        $rowStyle = 'background-color: #f2dede; color: #b96564;';
                                                    } else {
                                                        $rowStyle = 'background-color: #EAECEA; color: #000000;';
                                                    }
                                            } else {
                                                $rowStyle = 'background-color: white;';
                                            }
                                        @endphp
                                    <tr style="{{$rowStyle}}">
                                        <td>{{ $loop->iteration }}</td>
                                        <!-- NO POLIS -->
                                        <td data-toggle="tooltip" data-placement="top" data-container="body" title="{{ $insurance->insurance_update->last()->policy_number ?? '' }}">{!! Str::limit($insurance->insurance_update->last()->policy_number ?? '', 12, '...') !!}</td>
                                        <!-- <td data-toggle="tooltip" data-placement="top" data-container="body" title="{{ $insurance->insured_address }}">{!! Str::limit($insurance->insured_address, 30, '...') !!}</td>
                                        <td data-toggle="tooltip" data-placement="top" data-container="body" title="{{ $insurance->insured_name }}">{{ $insurance->insured_name }}</td> -->
                                        <!-- KODE -->
                                        <td>{{ $insurance->warehouse_code }}</td>
                                        <!-- DETAIL ASURANSI -->
                                        <td data-toggle="tooltip" data-placement="top" data-container="body" title="{{ $insurance->insured_detail }}">{!! Str::limit($insurance->insured_detail, 15, '...') !!}</td>
                                        <!-- ALAMAT YANG DIASURANSIKAN -->
                                        <td data-toggle="tooltip" data-placement="top" data-container="body" title="{{ $insurance->risk_address }}">{!! Str::limit($insurance->risk_address, 24, '...') !!}</td>
                                        <!-- ASURANSI STOK (child latest) -->
                                        <td>
                                                {{ $insurance->insurance_update->last()->stock_insurance_provider->insurance_provider ?? '' }}
                                        </td>
                                        <!-- NILAI STOK -->
                                        <td>
                                                Rp {{ number_format($insurance->insurance_update->last()->stock_worth ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td>
                                                Rp {{ number_format($insurance->insurance_update->last()->actual_stock_worth ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td><strong style="color: #b96564;">
                                                Rp {{ number_format((($insurance->insurance_update->last()->stock_worth ?? 0) - ($insurance->insurance_update->last()->actual_stock_worth ?? 0)), 0, ',', '.') }}
                                        </strong></td>
                                        <td>
                                                {{ $insurance->insurance_update->last()->building_insurance_provider->insurance_provider ?? '' }}
                                        </td>
                                        <td>
                                                Rp {{ number_format($insurance->insurance_update->last()->building_worth ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td>{{ $insurance->insurance_category->insurance_category }}</td>
                                        <th>{{ $insurance->insurance_scope->insurance_scope }}</th>
                                        <!-- <td><strong>{{ Carbon\Carbon::parse($insurance->join_date)->format('d M Y') }}</strong></td> -->
                                        <td><strong>
                                                {{ Carbon\Carbon::parse($insurance->insurance_update->last()->expired_date ?? '')->format('d M Y') }}
                                            </strong>
                                        </td>
                                        <td>
                                                {{ $insurance->insurance_update->last()->status ?? '' }}
                                        </td>
                                        <td>
                                            <a href="/insurance/{{$insurance->id}}/edit" class="btn btn-warning" data-toggle="modal" type="button"><span class="lnr lnr-pencil"></span></a>
                                            <!-- BUTTON DELETE -->
                                            <!-- <a href="/insurance/{{$insurance->id}}/delete" class="btn btn-danger" onclick="return confirm('Yakin akan menghapus data ?')"><span class="lnr lnr-trash"></span></a> -->
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
                        <label for="inputWarehouseCode" class="form-label">Kode Gudang</label>
                        <input name="warehouse_code" type="text" class="form-control" id="inputWarehouseCode" placeholder="Kode Gudang.." required>
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
                        <label for="inputActualStockWorth" class="form-label">Nilai Aktual Stok</label>
                        <input name="actual_stock_worth" type="number" class="form-control" id="inputActualStockWorth" placeholder="Nilai Aktual Stok.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputStockPremium" class="form-label">Premi Stok</label>
                        <input name="stock_premium" type="number" class="form-control" id="inputStockPremium" placeholder="Premi Stok.." required>
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
                        <label for="inputBuildingPremium" class="form-label">Premi Bangunan</label>
                        <input name="building_premium" type="number" class="form-control" id="inputBuildingPremium" placeholder="Premi Bangunan.." required>
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
                    <div class="form-group">
                        <label for="inputNotes" class="form-label">Catatan</label>
                        <input name="notes" type="text" class="form-control" id="inputNotes" placeholder="Catatan.." required>
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
    <!-- Modal -->
    <form action="/insurance/import" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="lnr lnr-cross"></i></button>
                    <h1 class="modal-title" id="importModalLabel">Import Data Asuransi Awal</h1>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Pilih File</label>
                        <input type="file" class="form-control" name="fileImport">
                        <h5>*Pastikan data yang diinput adalah data asuransi yang pertama kali didaftarkan</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-primary">IMPORT</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop