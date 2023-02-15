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
                                <a href="/problemReport/create" class="btn btn-info">TAMBAH</a>
                            </div>
                            @endif
							<h3 class="panel-title">Data Pelaporan</h3>
						</div>
						<div class="panel-body">
							<table class="table table-hover">
								<thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Pelapor</th>
                                    <th>Tanggal Pelaporan</th>
                                    <th>Kategori</th>
                                    <th>Detail Pelaporan</th>
                                    <th>Status</th>
                                    <th>Penjadwalan</th>
                                    <th>Diproses oleh</th>
                                    <th>Diproses pada</th>
                                    <th>Hasil Pengerjaan</th>
                                    <th>Status Akhir</th>
                                    <th> @if (auth()->user()->role_id == 4) Aksi @endif</th>
                                    <th> @if (auth()->user()->role_id != 4) Aksi @endif </th>
                                </tr>
								</thead>
								<tbody>
                                @foreach ($problems as $problem)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $problem->user->fullname }}</td>
                                    <td>{{ Carbon\Carbon::parse($problem->date)->format('d M Y H:i') }}</td>
                                    <!-- <td>{{ $problem->title }}</td> -->
                                    <td>{{ $problem->prcategory->problem_report_category }}</td>
                                    <td>{{ $problem->description }}</td>
                                    <td class={{ $problem->status == 'PENDING' ? "text-warning" : ($problem->status == 'CANCELLED' ? "text-danger" : "text-success") }}>{{ $problem->status == 'PENDING' ? 'MENUNGGU' : ( $problem->status == 'CLOSED' ? 'SELESAI' : 'DIBATALKAN' ) }}</td>
                                    <td>{{ $problem->scheduled_at == null ? '' : Carbon\Carbon::parse($problem->scheduled_at)->format('d M Y') }}</td>
                                    <td>{{ $problem->closed_by == null ? '' : $problem->closedby->fullname }}</td>
                                    <td>{{ $problem->closed_at == null ? '' : Carbon\Carbon::parse($problem->closed_at)->format('d M Y H:i') }}</td>
                                    <td>{{ $problem->result_desc }}</td>
                                    <td class={{ $problem->status_client == 0 ? "text-warning" : "text-success" }}> {{ $problem->status_client == 0 ? 'MENUNGGU' : 'SELESAI' }}</td>
                                    <td>
                                        @if (auth()->user()->role_id == 4 && $problem->status == 'CLOSED' && $problem->status_client != 1)
                                        <a href="/problemReport/{{$problem->id}}/editStatusClient" class="btn btn-warning" data-toggle="modal" type="button">Edit</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (auth()->user()->role_id != 4 && ($problem->status != 'CLOSED' || $problem->status_client != 1))
                                        <a href="/problemReport/{{$problem->id}}/editStatus" class="btn btn-warning" data-toggle="modal" type="button">Edit</a>
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
                    <label for="inputPRCategory" class="form-label">Kategori Problem Report</label>
                        <select class="form-control" id="pr_category_id" name="pr_category_id" required>
                            <option selected disabled>-- Pilih Kategori Probelm --</option>
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
                    <form action="/problemReport/{{ $dataid }}/updateStatusClient" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="dataid" class="form-label">ID Pelaporan</label>
                        <input type="text" name="dataid" id="dataid" class="form-control" readonly/>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">Detail Pelaporan</label>
                        <!-- belum ada valuenya -->
                        <input type="text" name="description" id="description" class="form-control" readonly/>
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
                    <form action="/problemReport/{{ $problemid }}/updateStatus" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="problemid" class="form-label">ID Pelaporan</label>
                        <!-- belum ada valuenya -->
                        <input type="text" name="problemid" id="problemid" class="form-control" readonly/>
                    </div>
                    <!-- belum ada if scheduled_at -->
                    <div class="form-group">
                        <label for="inputScheduledAt" class="form-label">Penjadwalan</label>
                        <input type="text" class="form-control float-right" value="" name="scheduled_at" id="tanggalScheduled" required>
                    </div>
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