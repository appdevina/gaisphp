@extends('layouts.master')

@section('content')
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{session('success')}}
    </div>
    @endif
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                    <div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Data User</h3>
                            <!-- <div class="right">
                                <button type="button" class="btn" data-toggle="modal" data-target="#userModal">
                                    <i class="lnr lnr-plus-circle">Tambah Data User</i>
                                </button>
                            </div> -->
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
                                    <!-- <td>
                                        <a href="/user/{{$user->id}}/edit" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="/user/{{$user->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data ?')">Hapus</a>
                                    </td> -->
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
                <form action="/user/create" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="inputUser" class="form-label">Username</label>
                    <input name="username" type="text" class="form-control" id="inputUser" placeholder="Username.." required>
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