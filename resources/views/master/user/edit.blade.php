@extends('layouts.master')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
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
                                <h3 class="panel-title">Edit</h3>
                            </div>
                            <div class="panel-body">
                            <form action="/user/{{$user->id}}/update" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="inputNama" class="form-label">Nama Lengkap</label>
                                    <input name="fullname" type="text" class="form-control" id="inputNama" value="{{$user->fullname}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputUsername" class="form-label">Username</label>
                                    <input name="username" type="text" class="form-control" id="inputUsername" value="{{$user->username}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputArea" class="form-label">Area</label>
                                    <input name="area_id" type="text" class="form-control" id="inputArea" value="{{$user->area_id}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputBU" class="form-label">Badan Usaha</label>
                                    <input name="badan_usaha_id" type="text" class="form-control" id="inputBU" value="{{$user->badan_usaha_id}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="divisi_id" class="form-label col-lg-12">Divisi</label>
                                        <select class="form-control" id="divisi_id" name="divisi_id"
                                            required>
                                            @foreach ($division as $division)
                                                <option value="{{ $division->id }}"
                                                    {{ $division->id === $user->divisi_id ? 'selected' : '' }}>
                                                    {{ $division->division }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputRole" class="form-label">Role</label>
                                    <input name="role_id" type="text" class="form-control" id="inputRole" value="{{$user->role_id}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputApproval" class="form-label">Approval</label>
                                    <input name="approval_id" type="text" class="form-control" id="inputApproval" value="{{$user->approval_id}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputApproval" class="form-label">Avatar</label>
                                    <input type="file" name="profile_picture" class="form-control">
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