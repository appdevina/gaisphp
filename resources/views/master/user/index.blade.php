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
                                <a class="btn btn-info" data-toggle="modal" data-target="#userModal">TAMBAH</a>
                            </div>
							<h3 class="panel-title">Data User</h3>
						</div>
						<div class="panel-body">
							<table class="table table-hover">
								<thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Area</th>
                                    <th>Badan Usaha</th>
                                    <th>Divisi</th>
                                    <th>Role</th>
                                    <th>Approval</th>
                                    <th>Aksi</th>
                                </tr>
								</thead>
								<tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="/user/{{$user->id}}/profile">{{ $user->fullname }}</a></td>
                                    <td><a href="/user/{{$user->id}}/profile">{{ $user->username }}</a></td>
                                    <td>{{ $user->area_id }}</td>
                                    <td>{{ $user->badan_usaha_id }}</td>
                                    <td>{{ $user->divisi_id }}</td>
                                    <td>{{ $user->role_id }}</td>
                                    <td>{{ $user->approval_id }}</td>
                                    <td>
                                        <a href="/user/{{$user->id}}/edit" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="/user/{{$user->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data ?')">Hapus</a>
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
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="userModalLabel">Tambah User</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="lnr lnr-cross"></i></button>
                </div>
                <div class="modal-body">
                <form action="/user/create" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="inputNama" class="form-label">Nama Lengkap</label>
                    <input name="fullname" type="text" class="form-control" id="inputNama" placeholder="Nama Lengkap.." required>
                </div>
                <div class="form-group">
                    <label for="inputUser" class="form-label">Username</label>
                    <input name="username" type="text" class="form-control" id="inputUser" placeholder="Username.." required>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input name="password" type="text" class="form-control" id="inputPassword" placeholder="Password.." required>
                </div>
                <div class="form-group">
                    <label for="inputArea" class="form-label">Area</label>
                    <input name="area_id" type="text" class="form-control" id="inputArea" required>
                </div>
                <div class="form-group">
                    <label for="inputBU" class="form-label">Badan Usaha</label>
                    <input name="badan_usaha_id" type="text" class="form-control" id="inputBU" required>
                </div>
                <div class="form-group">
                    <label for="divisi_id" class="form-label">Divisi</label>
                        <select class="form-control" id="divisi_id" name="divisi_id" value="-- Pilih Divisi --"
                            required>
                            @foreach ($division as $division)
                                <option value="{{ $division->id }}">
                                    {{ $division->division }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label for="inputRole" class="form-label">Role</label>
                    <input name="role_id" type="text" class="form-control" id="inputRole" required>
                </div>
                <div class="form-group">
                    <label for="inputApproval" class="form-label">Approval</label>
                    <input name="approval_id" type="text" class="form-control" id="inputApproval" required>
                </div>
                <div class="form-group">
                    <label for="inputProfile" class="form-label">Avatar</label>
                    <input type="file" name="profile_picture" class="form-control">
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                <button type="submit" class="btn btn-primary">SIMPAN</button>
            </form>
            </div>
        </div>
    </div>
@stop