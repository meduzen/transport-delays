@extends('layouts.main')

@section('title', 'Subways – STIB Open Data exploration')

@section('content')

<ul class="lines">

    {{-- Schedule header --}}

    <li class="lines__row line__rowSchedule">
        <div class="line__name | flex-center"></div>

        <div class="line__rowHours">
            <div class="line__rowHour" style="--hour-index: 0;">0</div>
            <div class="line__rowHour" style="--hour-index: 1;">1</div>
            <div class="line__rowHour" style="--hour-index: 2;">2</div>
            <div class="line__rowHour" style="--hour-index: 3;">3</div>
            <div class="line__rowHour" style="--hour-index: 4;">4</div>
            <div class="line__rowHour" style="--hour-index: 5;">5</div>
            <div class="line__rowHour" style="--hour-index: 6;">6</div>
            <div class="line__rowHour" style="--hour-index: 7;">7</div>
            <div class="line__rowHour" style="--hour-index: 8;">8</div>
            <div class="line__rowHour" style="--hour-index: 9;">9</div>
            <div class="line__rowHour" style="--hour-index: 10;">10</div>
            <div class="line__rowHour" style="--hour-index: 11;">11</div>
            <div class="line__rowHour" style="--hour-index: 12;">12</div>
            <div class="line__rowHour" style="--hour-index: 13;">13</div>
            <div class="line__rowHour" style="--hour-index: 14;">14</div>
            <div class="line__rowHour" style="--hour-index: 15;">15</div>
            <div class="line__rowHour" style="--hour-index: 16;">16</div>
            <div class="line__rowHour" style="--hour-index: 17;">17</div>
            <div class="line__rowHour" style="--hour-index: 18;">18</div>
            <div class="line__rowHour" style="--hour-index: 19;">19</div>
            <div class="line__rowHour" style="--hour-index: 20;">20</div>
            <div class="line__rowHour" style="--hour-index: 21;">21</div>
            <div class="line__rowHour" style="--hour-index: 22;">22</div>
            <div class="line__rowHour" style="--hour-index: 23;">23</div>
        </div>
    </li>

    {{-- Lines --}}

    @foreach ($lines as $line)
    <li class="lines__row">
        <h2 class="line__name | flex-center">{{ $line[0]->name }}</h2>

        <div class="line__rowDetail">

            @if(!$line[0]->disruptions->count() && !$line[1]->disruptions->count())

                <div class="line__rowStatus">
                    <p class="visually-hidden">The line runs fine today!</p>
                </div>

            @else

                {{-- Currently static button to open popover with line disruptions --}}

                <ul class="line__rowHours line__rowStatus">
                    <li class="line__rowDisruption" style="--hours: 10; --minutes: 25;">
                        <button
                            type="button" popovertarget="line-{{ Str::slug($line[0]->name) }}-disruptions"
                            class="line__rowDisruptionBtn" style="--hours: 10; --minutes: 25;"
                        ></button>
                    </li>
                </ul>

                {{-- Line disruptions in a popover --}}

                <div class="line__rowDisruptionDetails" popover id="line-{{ Str::slug($line[0]->name) }}-disruptions">
                    <button type="button" popovertarget="line-{{ Str::slug($line[0]->name) }}-disruptions">Close</button>

                    <ul>
                        @foreach($line[0]->disruptions->concat($line[1]->disruptions) as $disruption)
                            <li>
                                {{-- <p>Impacted lines: {{ $disruption->lines->pluck('name')->unique()->join(', ') }}</p> --}}
                                <ul>
                                @foreach ($disruption->content as $content)
                                    <li>
                                        @foreach ($content['text'] as $text)
                                            {{-- @if(Arr::has($text, 'en'))
                                                <p><code>en</code>: {{ $text['en'] }}</p>
                                            @endif --}}
                                            @if(Arr::has($text, 'fr'))
                                                <p>{{ $text['fr'] }}</p>
                                            @endif
                                            {{-- @if(Arr::has($text, 'nl'))
                                                <p><code>nl</code>: {{ $text['nl'] }}</p>
                                            @endif --}}
                                        @endforeach
                                    </li>
                                @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Details by stop for both directions --}}

                @foreach ($line as $line_direction)
                    <details>
                        <summary>View stops direction {{ $line_direction->direction->fr }}</summary>

                        <ul>
                        @foreach($line_direction->stops as $stop)
                        <li>
                            <h3>{{ $stop->name->fr }}</h3>
                            @if($stop->statuses)
                                @foreach ($stop->statuses as $status)
                                    <ul>
                                        @foreach ($status->content as $content)
                                            <li>
                                                @foreach ($content['text'] as $text)
                                                    {{-- @if(Arr::has($text, 'en'))
                                                        <p><code>en</code>: {{ $text['en'] }}</p>
                                                    @endif --}}
                                                    @if(Arr::has($text, 'fr'))
                                                        <p>{{ $text['fr'] }}</p>
                                                    @endif
                                                    {{-- @if(Arr::has($text, 'nl'))
                                                        <p><code>nl</code>: {{ $text['nl'] }}</p>
                                                    @endif --}}
                                                @endforeach
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            @endif
                        </li>

                        @endforeach
                        </ul>

                    </details>
                @endforeach

            @endif
        </div>

    </li>
    @endforeach

</ul>

<p>Sample data from <a class="underline" href="https://data.stib-mivb.brussels/explore/dataset/travellers-information-rt-production">real-time Travellers Information</a> (STIB), except I’m not real-time yet.</p>

@endsection
