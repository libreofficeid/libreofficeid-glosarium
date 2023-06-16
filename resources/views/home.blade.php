@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                  <div class="card-title">Dashboard</div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!<br><br>
                    Pilih berkas CSV untuk mulai impor data atau klik Tambah untuk menambahkan manual
                    <div class="card-description">
                    <form action="{{ url('glosarium/upload') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-control" type="file" name="uploadfile">
                                <input class="btn btn-primary" type="submit" name="submit" value="Upload CSV">
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary modalMd" type="button" value="{{ action('\App\Http\Controllers\GlosariumController@create') }}" title="Padanan Kata Baru" data-toggle="modal" data-target="#modalMd">Tambah</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav">
                    @php
                        $alphas = range('A', 'Z');
                    @endphp
                    @foreach ($alphas as $kar)
                        <li class="nav-item"><a class="nav-link text-primary navigasi" onclick="filter(this)" data-karakter="{{ $kar }}">{{ $kar }}</a></li>
                    @endforeach
                    <li class="nav-item"><a class="nav-link text-primary navigasi"  onclick="filter(this)" data-karakter="semua">Semua</a></li>
            </ul>
            <table class="table table-hover">
                <thead class="thead-dark bg-primary">
                    <tr>
                        <th>No</th>
                        <th>Asal Kata</th>
                        <th>Padanan</th>
                        <th>Operasi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1
                    @endphp
                    @foreach ($list_kata as $kata)
                        @php
                            $firstAlpha = substr($kata->source, 0,1)
                        @endphp
                        <tr class="characters {{$firstAlpha}}">
                            <td>{{ $i }}</td>
                            <td>{{ $kata->source }}</td>
                            <td>{{ $kata->translated }}</td>
                            <td class="td-actions">
                                <button href="#" title="Edit Data" data-toggle="modal" data-target="#modalMd" value="{{ action('\App\Http\Controllers\GlosariumController@edit',['glosarium'=>$kata->id]) }}" class="btn btn-sm btn-success modalMd"><i class="now-ui-icons ui-2_settings-90"></i></button>
                                <form action="{{ action('\App\Http\Controllers\GlosariumController@destroy',['glosarium'=>$kata->id]) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-sm btn-danger" title="Delete InspTemuanItem" onclick="return confirm('Confirm delete?')" type="submit">
                                    <i class="now-ui-icons ui-1_simple-remove"></i>
                                    </button>   
                                </form> 
                            </td>
                        </tr>
                        @php
                            $i++
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('js/filter.js') }}"></script>
