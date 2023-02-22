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
                            <div class="col-md-2">
                                <h3 class="panel-title">Data Pengajuan</h3>
                            </div>
                            <div class="col-md-4 text-right">
                                <form class="form-inline" id="my_form" action="/request">
                                    <div class="form-group">
                                    <input type="text" class="form-control" name="search" id="tanggal-request" placeholder="Enter your text">
                                    <a href="javascript:{}" onclick="document.getElementById('my_form').submit();" class="btn btn-info" >Cari</a>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 text-right">
                                @if (auth()->user()->role_id == 1)
                                    <div class="btn-group pull-right">
                                        <a href="#exportRequest" data-toggle="modal" class="btn btn-primary">EXPORT</a>
                                    </div>
                                @endif
                                @if (auth()->user()->role_id != 1)
                                <div class="btn-group pull-right" id="add_reqbar_button">
                                    <a href="/request/create" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Tambah pengajuan">TAMBAH</a>
                                </div>
                                @endif
                            </div>
						</div>
                        <br><br>
						<div class="panel-body table-responsive">
							<table class="table table-hover" id="reqbar_table">
								<thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Pengaju</th>
                                    <th>Diajukan pada</th>
                                    <th>Tipe Pengajuan</th>
                                    <!-- <th>Barang</th> -->
                                    <th>Lampiran</th>
                                    <th>Status PO</th>
                                    <th>Diproses oleh</th>
                                    <th>Diproses pada</th>
                                    <th>Status Akhir</th>
                                    <!-- <th>Approved by</th>
                                    <th>Approved at</th> -->
                                    <th> @if (auth()->user()->role_id >= 3) Edit Status Akhir @endif</th>
                                    <th> @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3) Aksi Proses @endif </th>
                                    <th> @if (auth()->user()->role_id == 2) Aksi @endif </th>
                                    <th></th>
                                </tr>
								</thead>
								<tbody>
                                @foreach ($requestBarangs as $reqbar)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $reqbar->user->fullname }}</td>
                                    <td>{{ Carbon\Carbon::parse($reqbar->date)->format('d M Y H:i') }}</td>
                                    <td>{{ $reqbar->request_type->request_type }}</td>
                                    <!-- <td>{{ $reqbar->request_detail }}</td> -->
                                    <td><a href="{{ asset('storage/') . '/Request_File/' . $reqbar->request_file }}">Lihat Dokumen</a></td>
                                    <td class={{ $reqbar->status_po == 0 ? "text-danger" : "text-success" }}>{{ $reqbar->status_po == 0 ? '' : 'YA' }}</td>
                                    <td>{{ $reqbar->closed_by == null ? '' : $reqbar->closedby->fullname }}</td>
                                    <td>{{ $reqbar->closed_at == null ? '' : Carbon\Carbon::parse($reqbar->closed_at)->format('d M Y H:i') }}</td>
                                    <td class={{ $reqbar->status_client == 0 ? "text-warning" : "text-success" }}> {{ $reqbar->status_client == 0 ? 'MENUNGGU' : 'DITERIMA' }}</td>
                                    <!-- <td>{{ $reqbar->approved_by == null ? '' : $reqbar->approval->fullname }}</td>
                                    <td>{{ $reqbar->approved_at == null ? '' : Carbon\Carbon::parse($reqbar->approved_at)->format('d M Y H:i') }}</td> -->
                                    <td>
                                        @if (auth()->user()->role_id >= 3 && $reqbar->closed_by != null && $reqbar->status_client == 0)
                                        <a href="/request/{{$reqbar->id}}/editStatusClient" class="btn btn-warning" data-toggle="modal" type="button">Edit</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ((auth()->user()->role_id == 1 || auth()->user()->role_id == 3) && ($reqbar->closed_by == null || $reqbar->status_client == 0))
                                        <a href="/request/{{$reqbar->id}}/editStatus" class="btn btn-warning" data-toggle="modal" type="button">Edit</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (auth()->user()->role_id == 2 && ($reqbar->closed_by == null || $reqbar->status_po == 0))
                                        <a href="/request/{{$reqbar->id}}/editStatusAcc" class="btn btn-warning" data-toggle="modal" type="button">Edit</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/request/{{$reqbar->id}}" class="btn btn-default" type="button">Lihat</a>
                                    </td>
                                </tr>
                                @endforeach
								</tbody>
							</table>
                            <div style="float:right">
                                {{ $requestBarangs->links() }}
                            </div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="addRequestBarangModal" role="dialog" aria-labelledby="addRequestBarangModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="lnr lnr-cross"></i></button>
                    <h1 class="modal-title" id="addRequestBarangModalLabel">Tambah Request</h1>
                </div>
                <div class="modal-body">
                    <form action="/request/store" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="inputUser" class="form-label hidden">User</label>
                        <input name="user_id" type="hidden" class="form-control" id="inputUser" value="{{ auth()->user()->id }}">
                    </div>
                    <div class="form-group">
                        <label for="request_type_id" class="form-label">Tipe Request</label>
                        <select class="form-control" id="request_type_id" name="request_type_id" required>
                            <option selected disabled>-- Pilih Tipe Request --</option>
                            @foreach ($request_types as $reqtype)
                                <option value="{{ $reqtype->id }}">
                                    {{ $reqtype->request_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_id" class="form-label">Barang</label>
                        <select class="form-control" id="product_id" name="product_id" required>
                            <option selected disabled>-- Pilih Barang --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->product }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputQtyRequest" class="form-label">Kuantitas Request</label>
                        <input name="qty_request" type="number" class="form-control" id="inputQtyRequest" placeholder="Kuantitas Request.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputQtyRemaining" class="form-label">Kuantitas Tersisa Saat Ini</label>
                        <input name="qty_remaining" type="number" class="form-control" id="inputQtyRemaining" placeholder="Sisa.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputDescription" class="form-label">Deskripsi Pengajuan</label>
                        <input name="description" type="text" class="form-control" id="inputDescription" placeholder="Deskripsi.." required>
                    </div>
                    <div class="form-group">
                    <label for="inputRequestFile" class="form-label">File Pengajuan</label>
                    <input type="file" name="request_file" class="form-control" required>
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
                    <!-- id nya salah -->
                    <form action="/request/{$requestBarang->id}/updateStatusClient" method="POST">
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
                     <!-- id nya salah -->
                    <form action="/request/{$requestBarang->id}/updateStatus" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="requestId" class="form-label">ID Pelaporan</label>
                        <input type="text" name="requestId" id="requestId" class="form-control" readonly/>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option selected value="PENDING">PENDING</option>
                                <option value="CLOSED">CLOSED</option>
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

    <!-- Modal Export -->
    <form action="request/export" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exportRequest" aria-labelledby="exportRequesttLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exportRequesttLabel">Export Laporan Pengajuan</h3>
                    </div>
                    <div class="modal-body">
                        <label for="date" class="form-label">Tanggal</label>
                            <div class="form-group">
                                <form action="request">
                                    <input type="text" class="form-control float-right" value="" name="exportRequest"
                                        id="tanggal-export-request" required>
                                </form>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Export</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop