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
                            <form action="/unittype/{{$unit_type->id}}/update" method="POST">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="inputUnitType" class="form-label">Kategori</label>
                                    <input name="unit_type" type="text" class="form-control" id="inputUnitType" value="{{$unit_type->unit_type}}" required>
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