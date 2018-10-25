@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Welcome Messages
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    @yield('page-title')
                </div>

                <div class="card-body">

                    @include('welcomemessages.addmessage')

                </div>

                @if (count($messages) > 0)

                    <table class="table table-sm table-hover">

                        <thead>

                        <tr class="bg-dark text-white">

                            <td style="min-width: 200px;">User</td>
                            <td>Message</td>
                            <td>Date Set</td>
                            <td></td>

                        </tr>

                        </thead>

                        @foreach($messages as $message)

                            <tr>

                                <td>
                                    @if($message->user->isMember)
                                        <a href="{{ route('user::profile', ['id' => $message->user->getPublicId()]) }}">{{ $message->user->name }}</a>
                                    @else
                                        {{ $message->user->name }}
                                    @endif
                                </td>

                                <td>{{ $message->message }}</td>

                                <td>{{ $message->updated_at->format('d/m/Y') }}</td>

                                <td>
                                    <a href="{{ route('welcomeMessages::delete', ['id' => $message->id]) }}">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    </table>

                @endif

            </div>

        </div>

    </div>

@endsection