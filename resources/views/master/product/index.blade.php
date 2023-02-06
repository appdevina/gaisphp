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
                                <a class="btn btn-info" data-toggle="modal" data-target="#productModal">TAMBAH</a>
                            </div>
							<h3 class="panel-title">Data Barang</h3>
						</div>
						<div class="panel-body">
							<table class="table table-hover">
								<thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Barang</th>
                                    <th>Kategori</th>
                                    <th>Tipe Unit</th>
                                    <th>Harga</th>
                                    <th>Deskripsi</th>
                                    <th>Image</th>
                                    <th>Stok</th>
                                    <th>Diupdate pada</th>
                                    <th>Aksi</th>
                                </tr>
								</thead>
								<tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->product }}</td>
                                    <td>{{ $product->category_id }}</td>
                                    <td>{{ $product->unit_type_id }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td><img src="{{ $product->getProductImage() }}" class="img" width="100px" alt="Barang"></td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->updated_at->formatLocalized('%A, %d %b %Y') }}</td>
                                    <td>
                                        <a href="/product/{{$product->id}}/edit" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="/product/{{$product->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data ?')">Hapus</a>
                                    </td>
                                </tr>
                                @endforeach
								</tbody>
							</table>
                            <div style="float:right">
                                {{ $products->links() }}
                            </div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="lnr lnr-cross"></i></button>
                    <h1 class="modal-title" id="productModalLabel">Tambah Barang</h1>
                </div>
                <div class="modal-body">
                <form action="/product/create" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="inputProduct" class="form-label">Nama Barang</label>
                    <input name="product" type="text" class="form-control" id="inputProduct" placeholder="Nama barang.." required>
                </div>
                <div class="form-group">
                    <label for="inputCategory" class="form-label">Kategori</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option selected disabled>-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->category }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label for="inputUnitType" class="form-label">Tipe Unit</label>
                    <select class="form-control" id="unit_type_id" name="unit_type_id" required>
                            <option selected disabled>-- Pilih Tipe Unit --</option>
                            @foreach ($unit_types as $unit_type)
                                <option value="{{ $unit_type->id }}">
                                    {{ $unit_type->unit_type }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label for="inputPrice" class="form-label">Harga</label>
                    <input name="price" type="number" class="form-control" id="inputPrice" placeholder="Harga.." required>
                </div>
                <div class="form-group">
                    <label for="inputDescription" class="form-label">Keterangan</label>
                    <input name="description" type="text" class="form-control" id="inputDescription" placeholder="Keterangan.." required>
                </div>
                <div class="form-group">
                    <label for="inputProductImage" class="form-label">Foto Barang</label>
                    <input type="file" name="product_image" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputStock" class="form-label">Stok</label>
                    <input name="stock" type="number" class="form-control" id="inputStock" placeholder="Stok.." required>
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