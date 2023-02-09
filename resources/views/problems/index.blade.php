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
                            @if (auth()->user()->role_id != 1)
                            <div class="btn-group pull-right">
                                <a class="btn btn-info" data-toggle="modal" data-target="#addProblemsModal">TAMBAH</a>
                            </div>
                            @endif
							<h3 class="panel-title">Data Pelaporan</h3>
						</div>
						<div class="panel-body">
							<table class="table table-hover">
								<thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Client</th>
                                    <th>Tanggal Ajuan</th>
                                    <th>Judul</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Penjadwalan</th>
                                    <th>Closed by</th>
                                    <th>Closed at</th>
                                    <th>Status Client</th>
                                    <th> @if (auth()->user()->role_id == 3) Aksi @endif</th>
                                    <th> @if (auth()->user()->role_id != 3) Aksi @endif </th>
                                </tr>
								</thead>
								<tbody>
                                @foreach ($problems as $problem)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $problem->getUsername() }}</td>
                                    <td>{{ Carbon\Carbon::parse($problem->date)->format('d M Y H:i') }}</td>
                                    <td>{{ $problem->title }}</td>
                                    <td>{{ $problem->description }}</td>
                                    <td class={{ $problem->status == 'PENDING' ? "text-warning" : ($problem->status == 'CLOSED' ? "text-success" : "text-danger") }}>{{ $problem->status }}</td>
                                    <td>{{ $problem->scheduled_at == null ? '' : Carbon\Carbon::parse($problem->scheduled_at)->format('d M Y') }}</td>
                                    <td>{{ $problem->closed_by == null ? '' : $problem->getClosedByname() }}</td>
                                    <td>{{ $problem->closed_at == null ? '' : Carbon\Carbon::parse($problem->closed_at)->format('d M Y H:i') }}</td>
                                    <td class={{ $problem->status_client == 0 ? "text-warning" : "text-success" }}> {{ $problem->status_client == 0 ? 'PENDING' : 'CLOSED' }}</td>
                                    <td>
                                        @if (auth()->user()->role_id == 3 && $problem->status == 'CLOSED' && $problem->status_client != 1)
                                        <a class="btn btn-warning" data-toggle="modal" type="button" data-id="{{ $problem->id }}" onclick="$('#dataid').val($(this).data('id')); $('#editStatusClientModal').modal('show');">Edit</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (auth()->user()->role_id != 3)
                                        <a class="btn btn-warning" data-toggle="modal" type="button" data-id="{{ $problem->id }}" onclick="$('#problemid').val($(this).data('id')); $('#editStatusModal').modal('show');">Edit</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
								</tbody>
							</table>
                            <div style="float:right">
                                {{ $problems->links() }}
                            </div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="addProblemsModal" role="dialog" aria-labelledby="addProblemsModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="lnr lnr-cross"></i></button>
                    <h1 class="modal-title" id="addProblemsModalLabel">Tambah Pelaporan</h1>
                </div>
                <div class="modal-body">
                    <form action="/problemReport/create" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="inputUser" class="form-label hidden">User</label>
                        <input name="user_id" type="hidden" class="form-control" id="inputUser" value="{{ auth()->user()->id }}">
                    </div>
                    <div class="form-group">
                        <label for="inputTitle" class="form-label">Judul Pelaporan</label>
                        <input name="title" type="text" class="form-control" id="inputTitle" placeholder="Judul.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputDescription" class="form-label">Deskripsi Pelaporan</label>
                        <input name="description" type="text" class="form-control" id="inputDescription" placeholder="Deskripsi.." required>
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

    <!-- Modal Edit Status Client-->
    <div class="modal fade" id="editStatusClientModal" role="dialog" aria-labelledby="editStatusClientModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="lnr lnr-cross"></i></button>
                    <h1 class="modal-title" id="editStatusClientModalLabel">Ubah Status by Client</h1>
                </div>
                <div class="modal-body">
                    <form action="/problemReport/{{$problem->id}}/updateStatusClient" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="dataid" class="form-label">ID Pelaporan</label>
                        <input type="text" name="dataid" id="dataid" class="form-control" readonly/>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus" class="form-label">Status Client</label>
                            <select class="form-control" id="status_client" name="status_client">
                                <option selected value="0">PENDING</option>
                                <option value="1">CLOSED</option>
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
        </div>
    </div>

    <!-- Modal Edit Status -->
    <div class="modal fade" id="editStatusModal" role="dialog" aria-labelledby="editStatusModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="lnr lnr-cross"></i></button>
                    <h1 class="modal-title" id="editStatusModalLabel">Ubah Status</h1>
                </div>
                <div class="modal-body">
                    <form action="/problemReport/{{$problem->id}}/updateStatus" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="problemid" class="form-label">ID Pelaporan</label>
                        <input type="text" name="problemid" id="problemid" class="form-control" readonly/>
                    </div>
                    @if ($problem->scheduled_at == null)
                    <div class="form-group">
                        <label for="inputScheduledAt" class="form-label">Penjadwalan</label>
                        <input type="text" class="form-control float-right" value="" name="scheduled_at" id="tanggalScheduled" required>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="inputStatus" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option selected value="PENDING">PENDING</option>
                                <option value="CLOSED">CLOSED</option>
                                <option value="CANCELLED">CANCELLED</option>
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
        </div>
    </div>
@stop