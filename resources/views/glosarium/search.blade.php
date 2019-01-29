@extends('layouts.app')
@section('title')
    Cari {{ $lema }}
@endsection
@section('kotakcari')
  <li class="nav-item" >
    <form class="form" action="{{ route('cari') }}" method="post">
      {{ csrf_field() }}
      <div class="input-group no-border input-lg">
        <div class="input-group-prepend" for="lema"><span class="input-group-text"><i class="now-ui-icons ui-1_zoom-bold"></i></span></div>
        <input class="form-control" placeholder="Cari Padanan ..." type="text" name="lema" value="{{ $lema }}">
      </div>
    </form>
  </li>
@endsection
@section('content')
  <div class="row" >
    <div class="col-md-12">
      <h5 class="text-left">Menampilkan padanan untuk kata: <i>{{ $lema }}</i></h5>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      {{-- <hr> --}}
        @if (count($padanan) == 0)
            <div class="text-center" style="color:red">
              <p>Padanan Kata/Istilah tidak ditemukan. :"(<br>
              <a class="btn btn-primary" href="https://goo.gl/forms/ImukgcQcGzdqx8SC2">Usulkan Kata/Istilah</a>
            </p>
            </div>
        @else
        <table class="table table-borderless">
          <thead>
            <tr class="border-bottom">
              <th>#</th>
              <th>Kata</th>
              <th>Padanan</th>
            </tr>
          </thead>
          <tbody>
            @php $i=0; $curr= ""; @endphp
            @foreach ($padanan as $p)
            @php $curr = $p->source[0]; @endphp
                <tr>
                  @if ($lema[0] == $p->source[0] && $i == 0)
                    <td>@php echo strtoupper($lema[0]); $i++; @endphp</td>
                  @else
                  @if ($lema[0] !== $p->source[0])
                    <td class="border-bottom">@php echo strtoupper($p->source[0]); @endphp</td>
                    @else
                    <td></td>
                    @endif
                  @endif
                  <td class="border-bottom">{{ $p->source }}</td>
                  <td class="border-bottom">{{ $p->translated }}</td>
                </tr>
            @endforeach
          </tbody>
        </table>
        @endif
    </div>
  </div>
@endsection
