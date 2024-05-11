<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark light only">
    <title>STIB Open Data exploration</title>
</head>
<body>

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

</body>
</html>
