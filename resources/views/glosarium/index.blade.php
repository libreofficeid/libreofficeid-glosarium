@extends('layouts.app')
@section('title')
    Daftar Kata/Padanan
@endsection
@section('kotakcari')
  <li class="nav-item">
    <form class="form" action="{{ route('cari') }}" method="post">
      {{ csrf_field() }}
      <div class="input-group no-border input-lg">
        <div class="input-group-prepend" for="lema"><span class="input-group-text"><i class="now-ui-icons ui-1_zoom-bold"></i></span></div>
        <input class="form-control" placeholder="Cari Padanan..." type="text" name="lema" >
      </div>
    </form>
  </li>
@endsection
@section('content')
    <div class="row" >
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
        </div>
    </div>
    <hr>
    @foreach ($alphas as $karakter)
    <div class="row characters" id="{{ $karakter }}">
        <div class="col-md-4 text-center my-auto">
            {{ $karakter }}
        </div>
        <div class="col-md-8">
            <ul class="nav">
                    @foreach ($list_kata as $kata)
                    @if (strtolower($kata->source[0]) == strtolower($karakter))
                        <li class="nav-item"><a class="nav-link text-primary" href="{{ route('glosarium.show',$kata->id) }}" >{{ $kata->source }}</a></li>
                    @endif
                    @endforeach
            </ul>
        </div>
    </div>
    <hr class="characters">
    @endforeach
    <script src="{{ asset('js/filter.js') }}"></script>
@endsection
