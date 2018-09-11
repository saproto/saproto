@extends('website.layouts.default')

@section('page-title')
    Edit Newsletter
@endsection

@section('content')

    <p style="text-align: center;">
        The newsletter was last sent
        <strong>{{ Carbon::createFromFormat('U', Newsletter::lastSent())->diffForHumans() }}</strong>
    </p>

    <input type="button" class="btn btn-success" style="width: 100%;" data-toggle="modal" data-target="#sendnewsletter"
           value="{{ (Newsletter::canBeSent() ? 'Send the weekly newsletter!' : 'Weekly newsletter can be sent again next week.') }}"
            {{ (!Newsletter::canBeSent() ? 'disabled' : '') }}>

    @if(Newsletter::canBeSent())
        <div id="sendnewsletter" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Sending the newsletter.</h4>
                    </div>
                    <div class="modal-body">
                        Are you SURE you want to send the newsletter? You can only send the newsletter once per week!
                    </div>
                    <div class="modal-footer">
                        <form method="post" action="{{ route('newsletter::send') }}">
                            {!! csrf_field() !!}
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Send</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endif

    <hr>

    <form method="post"
          action="{{ route("newsletter::text") }}">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="newsletter-text">Text in newsletter</label>
            <textarea id="newsletter-text" name="text"
                      placeholder="Enter newsletter text here...">{{ Newsletter::getText()->value }}</textarea>
        </div>

        <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Save text</button>
        <a class="btn btn-default pull-right" style="margin-left: 15px;" target="_blank"
           href="{{ route("newsletter::preview") }}">
            Preview
        </a>

    </form>

    <div class="clearfix"></div>

    <hr>

    @if (count($events) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Event</th>
                <th>When</th>
                <th>&nbsp;</th>
                <th>Controls</th>

            </tr>

            </thead>

            @foreach($events as $event)

                <tr style="opacity: {{ ($event->include_in_newsletter ? '1' : '0.4') }};">

                    <td>{{ $event->id }}</td>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->generateTimespanText('l j F, H:i', 'H:i', '-') }}</td>
                    <td>
                        <i class="fa fa-{{ ($event->include_in_newsletter ? 'check' : 'times') }}"
                           aria-hidden="true"></i>
                    </td>
                    <td>
                        <a href="{{ route('newsletter::toggle', ['id' => $event->id]) }}">
                            Toggle
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

    @else

        <p style="text-align: center;">
            There are no upcoming events. Seriously. Go fix that {{ Auth::user()->calling_name }}.
        </p>

        <p class="large-emoji" style="text-align: center;">
            😱
        </p>

    @endif

@endsection

@section('javascript')

    @parent

    <script>
        var simplemde = new SimpleMDE({
            element: $("#editor")[0],
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "image", "link", "quote", "table", "code", "|", "preview", "guide"],
            spellChecker: false
        });
    </script>

@endsection