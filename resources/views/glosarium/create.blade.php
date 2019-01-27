@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" style="display:none">
            </div><br />
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ url('/glosarium') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="asal">Kata Asal</label>
                        <input placeholder="Masukkan kata asing" type="text" name="asal" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                        <div class="col">
                            <label for="padanan">Padanan</label>
                            <input placeholder="Masukkan padanan kata" required name="padanan" maxlength="255" class="form-control">
                        </div>
                    </div>
                <div class="row">
                    <div class="col text-right">
                        <button class="btn btn-secondary" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-primary" id="btnSubmit" type="submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection