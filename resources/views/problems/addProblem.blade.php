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
                                <h3 class="panel-title">Tambah Pelaporan</h3>
                            </div>
                            <div class="panel-body">
                            <form action="/problemReport/store" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="inputUser" class="form-label hidden">User</label>
                                <input name="user_id" type="hidden" class="form-control" id="inputUser" value="{{ auth()->user()->id }}">
                            </div>
                            <!-- <div class="form-group">
                                <label for="inputTitle" class="form-label">Judul Pelaporan</label>
                                <input name="title" type="text" class="form-control" id="inputTitle" placeholder="Judul.." required>
                            </div> -->
                            <div class="form-group">
                            <label for="inputPRCategory" class="form-label">Jenis Gangguan</label>
                                <select class="form-control" id="pr_category_id" name="pr_category_id" required>
                                    <option selected disabled>-- Pilih Jenis Gangguan --</option>
                                    @foreach ($prcategories as $prcategory)
                                        <option value="{{ $prcategory->id }}">
                                            {{ $prcategory->problem_report_category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputDescription" class="form-label">Deskripsi Pelaporan</label>
                                <input name="description" type="text" class="form-control" id="inputDescription" placeholder="Deskripsi.." required>
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
@stop