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
                                <h3 class="panel-title">Edit</h3>
                            </div>
                            <div class="panel-body">
                            <form action="/product/{{$product->id}}/update" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="inputProduct" class="form-label">Nama Barang</label>
                                    <input name="product" type="text" class="form-control" id="inputProduct" value="{{$product->product}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputCategory" class="form-label">Kategori id</label>
                                    <input name="category_id" type="text" class="form-control" id="inputCategory" value="{{$product->category_id}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputUnitType" class="form-label">Unit type id</label>
                                    <input name="unit_type_id" type="text" class="form-control" id="inputUnitType" value="{{$product->unit_type_id}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputPrice" class="form-label">Harga</label>
                                    <input name="price" type="text" class="form-control" id="inputPrice" value="{{$product->price}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputDescription" class="form-label">Keterangan</label>
                                    <input name="description" type="text" class="form-control" id="inputDescription" value="{{$product->description}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputProductImage" class="form-label">Foto Barang</label>
                                    <input type="file" name="product_image" class="form-control" value="{{$product->product_image}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputStock" class="form-label">Stok</label>
                                    <input name="stock" type="text" class="form-control" id="inputStock" value="{{$product->stock}}" required>
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