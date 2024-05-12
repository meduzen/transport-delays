@extends('layouts.main')

@section('title', 'All lines and stops – STIB Open Data exploration')

@section('content')
<h1>STIB Open Data exploration</h1>

<h2>Lines and stops</h2>

<ul>
    @foreach ($lines as $line)
        <h3>Line {{ $line->name }}</h3>
        <p>To: <code>fr</code> {{ $line->direction->fr }}, <code>nl</code> {{ $line->direction->nl }}</p>
        <p>direction {{ $line->various->direction }}</p>
        <h4>Stops</h4>
        <ul>
            @foreach ($line->stops as $stop)
            <li>
                {{-- @todo: how to access stop->pivot->order? --}}
                <h5>Stop order: {{ $stop->order }}, id <strong>{{ $stop->internal_id }}</strong></h5>
                @if ($stop->name)
                <p>Name: <code>fr</code> {{ $stop->name?->fr }}, <code>nl</code> {{ $stop->name?->nl }}</p>
                @else
                <p><strong>missing stop name</strong></p>
                @endif
            </li>
            @endforeach
        </ul>
    @endforeach
</ul>
@endsection
