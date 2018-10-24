@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Edit Newsletter
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            <form method="post"
                  action="{{ route("newsletter::text") }}">

                {!! csrf_field() !!}

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

                        <p class="card-text text-center">
                            The newsletter was last sent
                            <strong>{{ Carbon::createFromFormat('U', Newsletter::lastSent())->diffForHumans() }}</strong>
                        </p>

                        <input type="button" class="btn btn-success btn-block" data-toggle="modal"
                               data-target="#sendnewsletter"
                               value="{{ (Newsletter::canBeSent() ? 'Send the weekly newsletter!' : 'Weekly newsletter can be sent again next week.') }}"
                                {{ (!Newsletter::canBeSent() ? 'disabled' : '') }}>

                        <hr>

                        <div class="form-group">
                            <label for="newsletter-text">Text in newsletter</label>
                            @include('website.layouts.macros.markdownfield', [
                                'name' => 'text',
                                'placeholder' => 'Text goes here.',
                                'value' => Newsletter::getText()->value
                            ])
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success pull-right">Save text</button>
                        <a class="btn btn-default" target="_blank"
                           href="{{ route("newsletter::preview") }}">
                            Preview
                        </a>
                    </div>

                </div>

            </form>

        </div>

        <div class="col-md-6">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    Activities in the newsletter
                </div>

                @if (count($events) > 0)

                    <table class="table table-sm table-hover">

                        <thead>

                        <tr class="bg-dark text-white">

                            <td class="pl-3">Event</td>
                            <td>When</td>
                            <td></td>
                            <td></td>

                        </tr>

                        </thead>

                        @foreach($events as $event)

                            <tr style="opacity: {{ ($event->include_in_newsletter ? '1' : '0.4') }};">

                                <td class="pl-3">{{ $event->title }}</td>
                                <td>{{ $event->generateTimespanText('l j F, H:i', 'H:i', '-') }}</td>
                                <td>
                                    <i class="fas fa-{{ ($event->include_in_newsletter ? 'check' : 'times') }}"
                                       aria-hidden="true"></i>
                                </td>
                                <td class="pr-3">
                                    <a href="{{ route('newsletter::toggle', ['id' => $event->id]) }}">
                                        Toggle
                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    </table>

                @else

                    <div class="card-body">
                        <p class="card-text text-center">
                            There are no upcoming events. Seriously. Go fix that {{ Auth::user()->calling_name }}.
                        </p>
                    </div>

                @endif

            </div>

        </div>

    </div>

    @if(Newsletter::canBeSent())
        <div id="sendnewsletter" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send the newsletter?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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

@endsection