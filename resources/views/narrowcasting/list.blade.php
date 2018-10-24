@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Narrowcasting Admin
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                    <a class="badge badge-info float-right" href="{{ route('narrowcasting::add') }}">
                        Create a new campaign.</a>
                    <a class="badge badge-danger float-right mr-2" href="{{ route('narrowcasting::clear') }}">
                        Delete all past campaigns.</a>
                </div>

                <table class="table table-hover table-sm">

                    <thead>

                    <tr class="bg-dark text-white">

                        <td></td>
                        <td>Campaign name</td>
                        <td>Start</td>
                        <td>End</td>
                        <td>Slide duration</td>
                        <td>Controls</td>

                    </tr>

                    </thead>

                    @foreach($messages as $message)

                        <tr {!! ($message->campaign_end < date('U') ? 'style="opacity: 0.5;"': '') !!}>

                            <td class="pl-3">
                                @if($message->video())
                                    <i class="fab fa-youtube" aria-hidden="true"></i>
                                @elseif($message->image)
                                    <i class="fas fa-picture-o" aria-hidden="true"></i>
                                @endif
                            </td>
                            <td>{{ $message->name }}</td>
                            <td>{{ date('l F j Y, H:i', $message->campaign_start) }}</td>
                            <td>{{ date('l F j Y, H:i', $message->campaign_end) }}</td>
                            <td>
                                @if($message->video())
                                    {{ $message->videoDuration() }} seconds
                                @elseif($message->image)
                                    {{ $message->slide_duration }} seconds
                                @else
                                    <p style="color: red;">no content</p>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('narrowcasting::edit', ['id' => $message->id]) }}">
                                    <i class="fas fa-edit mr-2" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route('narrowcasting::delete', ['id' => $message->id]) }}">
                                    <i class="fas fa-trash text-danger" aria-hidden="true"></i>
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </table>

                <div class="card-footer pb-0">
                    {{ $messages->links() }}
                </div>

            </div>

        </div>

    </div>

@endsection