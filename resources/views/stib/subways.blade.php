@extends('layouts.main')

@section('title', 'Subways – STIB Open Data exploration')

@section('content')
<h1>STIB Open Data exploration</h1>

<p>Sample data from <a href="https://data.stib-mivb.brussels/explore/dataset/travellers-information-rt-production">Travellers Information (RT) on STIB open data poral</a></p>

<h2>Lines and stops</h2>

<ul>
    @foreach ($lines as $line)
        <h3>Line {{ $line[0]->name }}</h3>
        <ul>
            <p>Direction {{ $line[0]->various->direction }}: <code>fr</code> {{ $line[0]->direction->fr }}, <code>nl</code> {{ $line[0]->direction->nl }}</p>
            <p>Direction {{ $line[1]->various->direction }}: <code>fr</code> {{ $line[1]->direction->fr }}, <code>nl</code> {{ $line[1]->direction->nl }}</p>
        </ul>
        <h4>Status</h4>
        @if($line[0]->statuses->count())
            <ol>
            @foreach($line[0]->statuses as $status)
                <li>
                    <h3>#{{ $loop->index }} at {{ $status->created_at }}</h3>
                    <p><code>type</code>: {{ $status->type }}</p>
                    <p>Impacted lines: {{ $status->lines->pluck('name')->unique()->join(', ') }}</p>
                    <ul>
                    @foreach ($status->content as $content)
                        <li>
                            <p><code>priority</code>: {{ $status->priority }}</p>
                            <p><code>type</code>: {{ $content['type'] }}</p>

                            @foreach ($content['text'] as $text)
                                @if(Arr::has($text, 'en'))
                                    <p><code>en</code>: {{ $text['en'] }}</p>
                                @endif
                                @if(Arr::has($text, 'fr'))
                                    <p><code>fr</code>: {{ $text['fr'] }}</p>
                                @endif
                                @if(Arr::has($text, 'nl'))
                                    <p><code>nl</code>: {{ $text['nl'] }}</p>
                                @endif
                            @endforeach
                        </li>
                    @endforeach
                    </ul>
                </li>
            @endforeach
            </ol>
        @else
        <p>Everything runs fine today!</p>
        @endif
    @endforeach
</ul>
@endsection
