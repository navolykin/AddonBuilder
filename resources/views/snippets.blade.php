@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
<div class="container">
    <dl class="row">
        <hr>
        @if($constants)
            @foreach($constants as $constant => $description)
                <dt class="col-sm-2">@if($loop->first){{ trans('vars.constants') }}@endif</dt><dd class="col-sm-6"><strong>{{ $constant }}</strong></dd><dd class="col-sm-4"><small>{{ $description }}</small></dd>
            @endforeach
            <hr>
        @endif
        @if($controller_returns)
            @foreach($controller_returns as $return_code => $description)
                <dt class="col-sm-2">@if($loop->first){{ trans('vars.controller_returns') }}@endif</dt><dd class="col-sm-6"><strong>{{ $return_code }}</strong></dd><dd class="col-sm-4"><small>{{ $description }}</small></dd>
            @endforeach
            <hr>
        @endif
    </dl>
</div>
@endsection
