@extends('website.layouts.redesign.generic')

@section('page-title')
    advent
@endsection

@section('container')

    @if($date->timestamp<Carbon::now()->timestamp)
        <div class="p-5">
        <div class="row justify-content-start">
            <h1>12 'VO</h1>
        </div>
        <div class="row justify-content-between">
            @foreach($eventsArray as $colIndex=>$column)
                <div class="col">
                    @foreach($column as $rowIndex=>$event)
                        @if($event->isPublished())
                        <div>
                            @include('event.display_includes.event_block', ['event'=> $event])
                        </div>
                        @else
                            <a class="card mb-3 leftborder leftborder-info text-decoration-none text-primary">
                            <div>
                                <div unix-time="{{$event->publication}}" class="h1 col text-center countdown">Loading...</div>
                            </div>
                            </a>
                        @endif
                        {{$event->title}}
                    @endforeach
                </div>
            @endforeach
        </div>
        </div>
        @else
            <div class="container fluid" style="min-height: 100%; min-height: 100vh; display: flex; align-items: center;">
                <div unix-time="{{$date->timestamp}}" class="h1 col text-center countdown">Loading...</div>
            </div>
            @endif
    </div>
@endsection
@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">

        let timers=Array.from(document.getElementsByClassName("countdown"));
        timers.forEach((timer)=>{
        var timing = setInterval( // you're making an interval - a thing, that is updating content after number of miliseconds, that you're writing after comma as second parameter
        function () {
        let dt = new Date(timer.getAttribute("unix-time")*1000);
            let currentDate = new Date().getTime(); //same thing as above
            let timeLeft = dt - currentDate; //difference between time you set and now in miliseconds

            let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24)); //conversion miliseconds on days
        if (days < 10) days="0"+days; //if number of days is below 10, programm is writing "0" before 9, that's why you see "09" instead of "9"
            let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)); //conversion miliseconds on hours
        if (hours < 10) hours="0"+hours;
            let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60)); //conversion miliseconds on minutes
        if (minutes < 10) minutes="0"+minutes;
            let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);//conversion miliseconds on seconds
        if (seconds < 10) seconds="0"+seconds;

        timer.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s"; // putting number of days, hours, minutes and seconds in div,

        if (timeLeft <= 0) {
        clearInterval(timing);
        document.getElementById("countdown").innerHTML = "It's over"; //if there's no time left, program in this 2 lines is clearing interval (nothing is counting now)
            window.location.reload();
        //and you see "It's over" instead of time left
        }
        }, 1000);
        })
    </script>
@endpush