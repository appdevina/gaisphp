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
                            <form action="/insurance/{{$insurance->id}}/update" method="POST">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="inputInsuredAddress" class="form-label">Alamat Tertanggung</label>
                                    <input name="insured_address" type="text" class="form-control" value="{{$insurance->insured_address}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputInsuredName" class="form-label">Nama Tertanggung</label>
                                    <input name="insured_name" type="text" class="form-control" value="{{$insurance->insured_name}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputWarehouseCode" class="form-label">Kode Gudang</label>
                                    <input name="warehouse_code" type="text" class="form-control" id="inputWarehouseCode" value="{{$insurance->warehouse_code}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputInsuredDetail" class="form-label">Detail Nama Tertanggung</label>
                                    <input name="insured_detail" type="text" class="form-control" value="{{$insurance->insured_detail}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputRiskAddress" class="form-label">Alamat yang diasuransikan</label>
                                    <input name="risk_address" type="text" class="form-control" value="{{$insurance->risk_address}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputInsuranceCategory" class="form-label">Kategori Asuransi</label>
                                    <select class="form-control" name="insurance_category_id" required>
                                        <option selected disabled>-- Pilih Kategori Asuransi --</option>
                                        @foreach ($incategories as $incategory)
                                            <option value="{{ $incategory->id }}"
                                                {{ $incategory->id === $insurance->insurance_category_id ? 'selected' : '' }}>
                                                {{ $incategory->insurance_category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputInsuranceScope" class="form-label">Cakupan Asuransi</label>
                                    <select class="form-control" name="insurance_scope_id" required>
                                        <option selected disabled>-- Pilih Cakupan Asuransi --</option>
                                        @foreach ($inscopes as $inscope)
                                            <option value="{{ $inscope->id }}"
                                                {{ $inscope->id === $insurance->insurance_scope_id ? 'selected' : '' }}>
                                                {{ $inscope->insurance_scope }}</option>
                                        @endforeach
                                    </select>
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