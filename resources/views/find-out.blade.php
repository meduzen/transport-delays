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

    <h2>Stops by Lines</h2>

    <ul>
        @foreach ($stops_by_line as $line)
            <h3><code>lineid</code>: {{ $line->lineid }}</h3>
            <p><code>destination</code> <code>fr</code> {{ json_decode($line->destination)->fr }}, <code>nl</code> {{ json_decode($line->destination)->nl }}</p>
            <p><code>direction</code> {{ $line->direction }}</p>
            <h4><code>points</code></h4>
            <ul>
                @foreach (json_decode($line->points) as $point)
                <li><code>id</code>: {{ $point->id }}</li>
                @endforeach
            </ul>
        @endforeach
    </ul>

    <h2>Stop Details</h2>

    <ul>
        @foreach ($stop_details as $stop)
            <h3><code>id</code>: {{ $stop->id }}</h3>
            <p><code>name</code> <code>fr</code> {{ json_decode($stop->name)->fr }}, <code>nl</code> {{ json_decode($stop->name)->nl }}</p>
            <p><code>gpscoordinates</code> {{ $stop->gpscoordinates }}</p>
        @endforeach
    </ul>

    <h2>Travellers Information (RT)</h2>

    <p>Sample data from <a href="https://data.stib-mivb.brussels/explore/dataset/travellers-information-rt-production">Travellers Information (RT) on STIB open data poral</a></p>

    <ul>
        @foreach ($travellers_information as $info)
        <li>
            <h3>#{{ $loop->index }}</h3>
            <h4><code>Content</code></h4>
            <ul>
                @foreach (json_decode($info->content) as $content)
                    <li><code>type</code>: {{ $content->type }}</li>
                    @foreach ($content->text as $text)
                        @if(property_exists($text, 'en'))
                            <p><code>en</code>: {{ $text->en }}</p>
                        @endif
                        @if(property_exists($text, 'fr'))
                            <p><code>fr</code>: {{ $text->fr }}</p>
                        @endif
                        @if(property_exists($text, 'nl'))
                            <p><code>nl</code>: {{ $text->nl }}</p>
                        @endif
                    @endforeach
                @endforeach
            </ul>
            <p><code>type</code>: {{ $info->type }}</p>
            <h4><code>lines</code></h4>
            <ul>
                @foreach (json_decode($info->lines) as $line)
                <p><code>id</code>: {{ $line->id }}</p>
                @endforeach
            </ul>
            <p><code>priority</code>: {{ $info->priority }}</p>
            <h3><code>points</code></h3>
            <ul>
                @foreach (json_decode($info->points) as $point)
                <li><code>id</code>: {{ $point->id }}</li>
                @endforeach
            </ul>
        </li>
        @endforeach
    </ul>
</body>
</html>
