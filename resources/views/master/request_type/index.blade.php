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
                            <div class="btn-group pull-right">
                                <a class="btn btn-info" data-toggle="modal" data-target="#requestTypeModal">TAMBAH</a>
                            </div>
							<h3 class="panel-title">Data Tipe Request</h3>
						</div>
						<div class="panel-body">
							<table class="table table-hover">
								<thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Tipe Request</th>
                                    <th>Approval</th>
                                    <th>Aksi</th>
                                </tr>
								</thead>
								<tbody>
                                @foreach ($request_types as $request_type)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $request_type->request_type }}</td>
                                    <td>{{ $request_type->getApproval() }}</td>
                                    <td>
                                        <a href="/requesttype/{{$request_type->id}}/edit" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="/requesttype/{{$request_type->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data ?')">Hapus</a>
                                    </td>
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

    <!-- Modal -->
    <div class="modal fade" id="requestTypeModal" tabindex="-1" role="dialog" aria-labelledby="requestTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="lnr lnr-cross"></i></button>
                    <h1 class="modal-title" id="requestTypeModalLabel">Tambah Tipe Request</h1>
                </div>
                <div class="modal-body">
                <form action="/requesttype/create" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="inputRequestType" class="form-label">Kategori</label>
                    <input name="request_type" type="text" class="form-control" id="inputRequestType" placeholder="Nama tipe request.." required>
                </div>
                <div class="form-group">
                    <label for="inputApproval" class="form-label">Approval</label>
                    <select class="form-control" id="approval_id" name="approval_id" required>
                            <option selected disabled>-- Pilih Approval --</option>
                            @foreach ($approvals as $approval)
                                <option value="{{ $approval->id }}">
                                    {{ $approval->fullname }}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                <button type="submit" class="btn btn-primary">SIMPAN</button>
            </form>
            </div>
        </div>
    </div>
@stop