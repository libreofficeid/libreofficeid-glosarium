@extends('layouts.app')
@section('m-body')
    <div class="row">
        <div class="col-md-12">
            <form action="" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col">
                        <label for="asal">Kata Asal</label>
                        <input placeholder="Masukkan kata asing" type="text" name="asal" class="form-control" value="{{ $data->source }}">
                    </div>
                </div>
                <div class="row">
                        <div class="col">
                            <label for="padanan">Padanan</label>
                            <input placeholder="Masukkan padanan kata" value="{{ $data->translated }}" name="padanan" maxlength="255" class="form-control">
                        </div>
                    </div>
                <div class="row">
                    <div class="col text-right">
                        <button class="btn btn-secondary" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection