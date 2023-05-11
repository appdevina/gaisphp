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
                            <div class="col-md-4">
                                <h3 class="panel-title">Perjanjian Sewa Update</h3>
                            </div>
						</div>
                        <hr>
						<div class="panel-body table-responsive">
                            <div class="col-md-12">
                                <div class="col-md-5 text-left mb-100">
                                    <h5><strong>Kode Kontrak Awal : </strong>{{ $detailRent->rent_code }}</h5>
                                    <h5><strong>Detail Bangunan : </strong>{{ $detailRent->rented_detail }}</h5>
                                    <h5><strong>Alamat yang disewakan : </strong>{{ $detailRent->rented_address }}</h5>
                                    <h5><strong>Pihak Pertama : </strong>{{ $detailRent->first_party }}</h5>
                                    <h5><strong>Pihak Kedua : </strong>{{ $detailRent->second_party }}</h5>
                                    <h5><strong>Tanggal Mulai : </strong>{{ Carbon\Carbon::parse($detailRent->join_date)->format('d M Y') }}</h5>
                                    <h5><strong>Tanggal Akhir : </strong>{{ Carbon\Carbon::parse($detailRent->expired_date)->format('d M Y') }}</h5>
                                </div>
                                <div class="col-md-4 text-left mb-100">
                                    <h5><strong>Sewa per Bulan : </strong>Rp {{ number_format($detailRent->rent_per_year, 0, ',', '.') }}</h5>
                                    <h5><strong>Dana CV.CS : </strong>Rp {{ number_format($detailRent->cvcs_fund, 0, ',', '.') }}</h5>
                                    <h5><strong>Dana Online : </strong>Rp {{ number_format($detailRent->online_fund, 0, ',', '.') }}</h5>
                                    <h5><strong>Bukti Potong : </strong>{{ $detailRent->deduction_evidence }}</h5>
                                    <h5><strong>Berkas : </strong>{{ $detailRent->document }}</h5>
                                    <h5><strong>Status : </strong>{{ $detailRent->status }}</h5>
                                    <h5><strong>Catatan : </strong>{{ $detailRent->notes }}</h5>
                                </div>
                                <div class="col-md-3 text-right">
                                    <div class="row">
                                        <a href="/rent/{{$detailRent->id}}/edit" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Kontrak Awal" type="button"><span class="lnr lnr-pencil"></span></a>
                                        <a href="/rent/{{$detailRent->id}}/exportUpdate" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Export Perjanjian Sewa"><span class="lnr lnr-download"></span></a>
                                        <a class="btn btn-success" data-toggle="modal" data-target=".importModal" data-toggle="tooltip" data-placement="bottom" title="Import Perjanjian Sewa"><span class="lnr lnr-upload"></span></a>
                                        <a href="/rent/export/templateUpdate" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Download template"><span class="lnr lnr-text-align-justify"></span></a>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <a href="/rent/createUpdate" class="btn btn-success" data-toggle="modal" data-target="#addinsuranceUpdateModal" data-toggle="tooltip" data-placement="top" title="Update Perjanjian Sewa"><span class="lnr lnr-plus-circle"></span> Update</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr><br>
                            </div>
                            <br><br>
							<table class="table table-hover">
								<thead>
                                <tr>
                                    <th>NO</th>
                                    <th>KODE</th>
                                    <th>Nama Toko</th>
                                    <th>Alamat</th>
                                    <th>Pihak Pertama</th>
                                    <th>Pihak Kedua</th>
                                    <th>Sewa perbulan</th>
                                    <th>CV.CS</th>
                                    <th>Online</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Akhir</th>
                                    <th>BukPot</th>
                                    <th>Berkas</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
								</thead>
								<tbody>
                                    @if (!$detailRent)
                                        <tr>
                                            <td colspan="9">No data found.</td>
                                        </tr>
                                    @elseif ($detailRent->rent_update->isEmpty())
                                        <tr>
                                            <td colspan="9">No updates found.</td>
                                        </tr>
                                    @else
                                        @foreach ($detailRent->rent_update->sortByDesc('expired_date') as $detail)
                                        @php
                                            $expiredDate = Carbon\Carbon::parse($detail->expired_date);
                                            $diffInDays = Carbon\Carbon::now()->diffInDays($expiredDate, false);

                                            if ($diffInDays <= 30 && $diffInDays > 14) {
                                                $rowStyle = 'background-color: #fcf8e3; color: #8a6d3b;';
                                            } elseif ($diffInDays <= 14) {
                                                $rowStyle = 'background-color: #f2dede; color: #b96564;';
                                            } else {
                                                $rowStyle = 'background-color: white;';
                                            }
                                        @endphp
                                        <tr style="{{$rowStyle}}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->rent_code }}</td>
                                            <td>{{ $detail->rented_detail}}</td>
                                            <td>{{ $detail->rented_address}}</td>
                                            <td>{{ $detail->first_party}}</td>
                                            <td>{{ $detail->second_party}}</td>
                                            <td>Rp {{ number_format($detail->rent_per_year, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($detail->cvcs_fund, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($detail->online_fund, 0, ',', '.') }}</td>
                                            <td><strong>{{ Carbon\Carbon::parse($detail->join_date)->format('d M Y') }}</strong></td>
                                            <td><strong>{{ Carbon\Carbon::parse($detail->expired_date)->format('d M Y') }}</strong></td>
                                            <td>{{ $detail->deduction_evidence}}</td>
                                            <td>{{ $detail->document}}</td>
                                            <!-- <td>{{ $diffInDays }}</td> -->
                                            <td>{{ $detail->status }}</td>
                                            <td>{{ $detail->notes }}</td>
                                            <td>
                                            <a href="/rent/{{$detail->id}}/editUpdate" class="btn btn-warning" type="button"><span class="lnr lnr-pencil"></span></a>
                                            <!-- BUTTON DELETE -->
                                            <!-- <a href="/rent/{{$detail->id}}/deleteUpdate/{{$detailRent->id}}" class="btn btn-danger" onclick="return confirm('Yakin akan menghapus data ?')"><span class="lnr lnr-trash"></span></a> -->
                                            </td> 
                                        </tr>
                                        @endforeach
                                    @endif
								</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="addRentUpdateModal" role="dialog" aria-labelledby="addRentUpdateModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="lnr lnr-cross"></i></button>
                    <h1 class="modal-title" id="addRentModalLabel">Tambah Update Perjanjian Sewa</h1>
                </div>
                <div class="modal-body">
                    <form action="/rent/storeUpdate" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <input name="rent_id" type="hidden" class="form-control" value="{{ $detailRent->id }}">
                    </div>
                    <div class="form-group">
                        <label for="inputFirstParty" class="form-label">Nama Pihak Pertama</label>
                        <input name="first_party" type="text" class="form-control" id="inputFirstParty" placeholder="Pihak Pertama.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputSecondParty" class="form-label">Nama Pihak Kedua</label>
                        <input name="second_party" type="text" class="form-control" id="inputSecondParty" placeholder="Pihak Kedua.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputRentPerYear" class="form-label">Nilai Sewa per Tahun</label>
                        <input name="rent_per_year" type="number" class="form-control" id="inputRentPerYear" placeholder="Sewa per Tahun.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputCvcsFund" class="form-label">Dana CV.CS</label>
                        <input name="cvcs_fund" type="number" class="form-control" id="inputCvcsFund" placeholder="Dana CV.CS.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputOnlineFund" class="form-label">Dana Online</label>
                        <input name="online_fund" type="number" class="form-control" id="inputOnlineFund" placeholder="Dana Online.." required>
                    </div>
                    <div class="form-group">
                        <label for="inputJoinDate" class="form-label">Tanggal Mulai</label>
                        <input data-format="dd/mm/yyyy" type="text" class="form-control float-right" value="" name="join_date" id="tanggalMulaiSewa" required>
                    </div>
                    <div class="form-group">
                        <label for="inputExpiredDate" class="form-label">Tanggal Berakhir</label>
                        <input data-format="dd/mm/yyyy" type="text" class="form-control float-right" value="" name="expired_date" id="tanggalAkhirSewa" required>
                    </div>
                    <div class="form-group">
                        <label for="inputDeductionEvidence" class="form-label">Bukti Potong</label>
                        <select class="form-control" name="deduction_evidence" required>
                            <option selected disabled>-- Pilih --</option>
                                <option value="ADA">ADA</option>
                                <option value="TIDAK ADA">TIDAK ADA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputDocument" class="form-label">Berkas</label>
                        <select class="form-control" name="document" required>
                            <option selected disabled>-- Pilih --</option>
                                <option value="ADA">ADA</option>
                                <option value="TIDAK ADA">TIDAK ADA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus" class="form-label">Status</label>
                        <select class="form-control" name="status" required>
                            <option selected disabled>-- Pilih --</option>
                                <option value="BERJALAN" selected>BERJALAN</option>
                                <option value="PEMBAHARUAN">PEMBAHARUAN</option>
                                <option value="TUTUP">TUTUP</option>
                                <option value="REFUND">REFUND</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputNotes" class="form-label">Catatan</label>
                        <input name="notes" type="text" class="form-control" id="inputNotes" placeholder="Catatan.." required>
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
    <!-- Modal -->
    <form action="/rent/importUpdate" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="lnr lnr-cross"></i></button>
                    <h1 class="modal-title" id="importModalLabel">Import Data Perjanjian Sewa Update</h1>
                </div>
                <div class="form-group">
                    <input name="rent_id" type="hidden" class="form-control" value="{{ $detailRent->id }}">
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Pilih File</label>
                        <input type="file" class="form-control" name="fileImport">
                        <h5>*Pastikan data yang diinput adalah data sewa perpanjangan</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-primary">IMPORT</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop