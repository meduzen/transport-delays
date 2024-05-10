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
            <h3>Line {{ $line[0]->name }}</h3>
            <ul>
                <p>Direction {{ $line[0]->various->direction }}: <code>fr</code> {{ $line[0]->direction->fr }}, <code>nl</code> {{ $line[0]->direction->nl }}</p>
                <p>Direction {{ $line[1]->various->direction }}: <code>fr</code> {{ $line[1]->direction->fr }}, <code>nl</code> {{ $line[1]->direction->nl }}</p>
            </ul>
        @endforeach
    </ul>

    <hr>

    <h2>Travellers Information (RT)</h2>

    <p>Sample data from <a href="https://data.stib-mivb.brussels/explore/dataset/travellers-information-rt-production">Travellers Information (RT) on STIB open data poral</a></p>

    <ul>
        @foreach ($travellers_information as $info)
        <li>
            <h3>#{{ $loop->index }}</h3>
            <h4><code>Content</code></h4>
            <ul>
                @foreach ($info['content'] as $content)
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
            <p><code>type</code>: {{ $info['type'] }}</p>
            <h4><code>lines</code></h4>
            <ul>
                @foreach ($info['lines'] as $line)
                <p><code>id</code>: {{ $line->id }}</p>
                @endforeach
            </ul>
            <p><code>priority</code>: {{ $info['priority'] }}</p>
            <h3><code>points</code></h3>
            <ul>
                @foreach ($info['stops'] as $stop)
                <li><code>id</code>: {{ $stop->id }}</li>
                @endforeach
            </ul>
        </li>
        @endforeach
    </ul>
</body>
</html>
