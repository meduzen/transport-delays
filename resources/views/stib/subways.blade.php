@extends('layouts.main')

@section('title', 'Subways – STIB Open Data exploration')

@section('content')

<ul class="lines">
    <li class="lines__row line__rowCalendar">
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

    @foreach ($lines as $line)
    <li class="lines__row">
        <h2 class="line__name | flex-center">{{ $line[0]->name }}</h2>

        <div class="line__rowDetail">

            {{-- @todo: Show calendar of the day here. --}}

            {{-- <ul>
                <p>Direction {{ $line[0]->various->direction }}: <code>fr</code> {{ $line[0]->direction->fr }}, <code>nl</code> {{ $line[0]->direction->nl }}</p>
                <p>Direction {{ $line[1]->various->direction }}: <code>fr</code> {{ $line[1]->direction->fr }}, <code>nl</code> {{ $line[1]->direction->nl }}</p>
            </ul> --}}

            {{-- <h4>Status</h4> --}}

            @if(!$line[0]->disruptions->count())
<<<<<<< ours
            <div class="line__rowStatus">
                <p class="visually-hidden">The line runs fine today!</p>
            </div>
            @else

            <ul class="line__rowHours line__rowStatus">
                <li class="line__rowDisruption" style="--hours: 10; --minutes: 25;">
                    <button
                        type="button" popovertarget="line-{{ $line[0]->id }}-disruptions"
                        class="line__rowDisruptionBtn" style="--hours: 10; --minutes: 25;"
                    ></button>
                </li>
            </ul>

            <div class="line__rowDisruptionDetails" popover id="line-{{ $line[0]->id }}-disruptions">
                <button type="button" popovertarget="line-{{ $line[0]->id }}-disruptions">Close</button>

                <ul>
                    @foreach($line[0]->disruptions as $disruption)
                        <li>
                            {{-- <h3>#{{ $loop->index }} at {{ $disruption->created_at }}</h3> --}}
                            {{-- <p>Status <code>type</code>: {{ $disruption->type }}</p> --}}
                            {{-- <p>Impacted lines: {{ $disruption->lines->pluck('name')->unique()->join(', ') }}</p> --}}
                            <ul>
                            @foreach ($disruption->content as $content)
                                <li>
                                    {{-- <p><code>priority</code>: {{ $disruption->priority }}</p> --}}
                                    {{-- <p>Content <code>type</code>: {{ $content['type'] }}</p> --}}

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
=======
                <p class="line__rowNoDisruption">The line runs fine today!</p>
            @else

            <div class="line__rowHours line__rowStatus">
                <button type="button" class="line__rowIncident" style="--hours: 10; --minutes: 25;"></button>
            </div>
            {{-- <ul>
                @foreach($line[0]->disruptions as $disruption)
                    <li>
                        <h3>#{{ $loop->index }} at {{ $disruption->created_at }}</h3>
                        <p><code>type</code>: {{ $disruption->type }}</p>
                        <p>Impacted lines: {{ $disruption->lines->pluck('name')->unique()->join(', ') }}</p>
                        <ul>
                        @foreach ($disruption->content as $content)
                            <li>
                                <p><code>priority</code>: {{ $disruption->priority }}</p>
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
            </ul> --}}

>>>>>>> theirs
            @endif
        </div>


    </li>
    @endforeach
</ul>

<<<<<<< ours
<p>Sample data from <a class="underline" href="https://data.stib-mivb.brussels/explore/dataset/travellers-information-rt-production">real-time Travellers Information</a> (STIB), except I’m not real-time yet.</p>
=======
<p>Sample data from <a class="underline" href="https://data.stib-mivb.brussels/explore/dataset/travellers-information-rt-production">real-time Travellers Information</a> (STIB)</p>
>>>>>>> theirs

@endsection
