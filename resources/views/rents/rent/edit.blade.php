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
                            <form action="/rent/{{$rent->id}}/update" method="POST">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <input name="rent_id" type="hidden" class="form-control" value="{{$rent->id}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputRentedAddress" class="form-label">Alamat Bangunan</label>
                                    <input name="rented_address" type="text" class="form-control" id="inputRentedAddress" value="{{$rent->rented_address}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputRentedDetail" class="form-label">Detail/Nama Bangunan</label>
                                    <input name="rented_detail" type="text" class="form-control" id="inputRentedDetail" value="{{$rent->rented_detail}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputFirstParty" class="form-label">Nama Pihak Pertama</label>
                                    <input name="first_party" type="text" class="form-control" id="inputFirstParty" value="{{$rent->first_party}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputSecondParty" class="form-label">Nama Pihak Kedua</label>
                                    <input name="second_party" type="text" class="form-control" id="inputSecondParty" value="{{$rent->second_party}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputRentPerYear" class="form-label">Nilai Sewa per Tahun</label>
                                    <input name="rent_per_year" type="number" class="form-control" id="inputRentPerYear" value="{{$rent->rent_per_year}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputCvcsFund" class="form-label">Dana CV.CS</label>
                                    <input name="cvcs_fund" type="number" class="form-control" id="inputCvcsFund" value="{{$rent->cvcs_fund}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputOnlineFund" class="form-label">Dana Online</label>
                                    <input name="online_fund" type="number" class="form-control" id="inputOnlineFund" value="{{$rent->online_fund}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputJoinDate" class="form-label">Tanggal Mulai</label>
                                    <input data-format="dd/mm/yyyy" type="text" class="form-control float-right" value="{{ Carbon\Carbon::parse($rent->join_date)->format('d/m/Y') }}" name="join_date" id="tanggalMulaiSewa" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputExpiredDate" class="form-label">Tanggal Berakhir</label>
                                    <input data-format="dd/mm/yyyy" type="text" class="form-control float-right" value="{{ Carbon\Carbon::parse($rent->expired_date)->format('d/m/Y') }}" name="expired_date" id="tanggalAkhirSewa" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputDeductionEvidence" class="form-label">Bukti Potong</label>
                                    <select class="form-control" name="deduction_evidence" required>
                                        <option selected disabled>-- Pilih --</option>
                                            <option value="ADA"
                                                {{ $rent->deduction_evidence === 'ADA' ? 'selected' : '' }}>
                                                ADA</option>
                                            <option value="TIDAK ADA"
                                                {{ $rent->document === 'TIDAK ADA' ? 'selected' : '' }}>
                                                TIDAK ADA</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputDocument" class="form-label">Berkas</label>
                                    <select class="form-control" name="document" required>
                                        <option selected disabled>-- Pilih --</option>
                                            <option value="ADA"
                                                {{ $rent->deduction_evidence === 'ADA' ? 'selected' : '' }}>
                                                ADA</option>
                                            <option value="TIDAK ADA"
                                                {{ $rent->document === 'TIDAK ADA' ? 'selected' : '' }}>
                                                TIDAK ADA</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputStatus" class="form-label">Status</label>
                                    <select class="form-control" name="status" required>
                                        <option selected disabled>-- Pilih --</option>
                                            <option value="BERJALAN"
                                                {{ $rent->status === 'BERJALAN' ? 'selected' : '' }}>
                                                BERJALAN</option>
                                            <option value="PEMBAHARUAN"
                                                {{ $rent->status === 'PEMBAHARUAN' ? 'selected' : '' }}>
                                                PEMBAHARUAN</option>
                                            <option value="TUTUP"
                                                {{ $rent->status === 'TUTUP' ? 'selected' : '' }}>
                                                TUTUP</option>
                                            <option value="REFUND"
                                                {{ $rent->status === 'REFUND' ? 'selected' : '' }}>
                                                REFUND</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputNotes" class="form-label">Catatan</label>
                                    <input name="notes" type="text" class="form-control" id="inputNotes" value="{{$rent->notes}}" required>
                                </div>
                                <br>
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