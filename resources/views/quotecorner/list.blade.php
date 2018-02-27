@extends('website.layouts.default-nobg')

@section('page-title')
    Quote Corner
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4 col-md-push-8">

            @include('quotecorner.newquote')

            @include('quotecorner.popular')

        </div>

        <div class="col-md-8 col-md-pull-4">

            <div class="panel panel-default container-panel">

                <div class="panel-body">

                    <div id="qq_latest">

                        @if(count($data) > 0)
                            <?php $entry = $data[0] ?>
                            <h4 style="margin-top: 0;">
                                <a href="{{ route('user::profile', ['id' => $entry->user->getPublicId()]) }}">{{ $entry->user->name }}</a>
                                <span class="qq_timestamp">{{ $entry->created_at->format("j M Y, H:i")  }}</span>
                            </h4>
                            <div id="qq_bigquote">
                                <div><h1>{!! $entry["quote"] !!}</h1></div>
                            </div>
                            <div class="qq_like" data-id="{{ $entry->id }}">
                                <i class="fa fa-thumbs-up {{ $entry->liked(Auth::user()->id) ? "qq_liked" : "" }}"></i>
                                <span>{{ count($entry->likes()) }}</span>
                            </div>
                            @if (Auth::check() && Auth::user()->can("board"))
                                <a href="{{ route('quotes::delete', ['id' => $entry->id]) }}" style="float:right;">Remove</a>
                            @endif
                        @else
                            <h2>No quotes available. Add some yourself!</h2>
                        @endif

                    </div>

                </div>

            </div>

            @if(count($data) > 1)

                <div class="panel panel-default container-panel">

                    <div class="panel-body">

                        @foreach($data as $key => $entry)
                            @if($key > 1)
                                <hr>
                            @endif
                            @if($key > 0)
                                <div>
                                    <p>
                                        <a href="{{ route('user::profile', ['id' => $entry->user->getPublicId()]) }}">{{ $entry->user->name }}</a>
                                        <span class="qq_timestamp">{{ $entry->created_at->format("j M Y, H:i") }}</span>
                                    </p>
                                    <h4>{!! $entry["quote"] !!}</h4>
                                    <div class="qq_like" data-id="{{ $entry->id }}">
                                        <i class="fa fa-thumbs-up {{ $entry->liked(Auth::user()->id) ? "qq_liked" : "" }}"></i>
                                        <span>{{ count($entry->likes()) }}</span>
                                    </div>
                                    @if (Auth::check() && Auth::user()->can("board"))
                                        <a href="{{ route('quotes::delete', ['id' => $entry->id]) }}"
                                           style="float:right;">Remove</a>
                                    @endif
                                    <br>
                                </div>
                            @endif
                        @endforeach

                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script>

        $(".qq_like").click(function (event) {
            var id = $(event.target).parent().attr('data-id');
            if (id === undefined) throw new Error("Can\'t find id");
            if ($(event.target).hasClass('qq_liked')) {
                $(event.target).next().html(parseInt($(event.target).next().html())-1);
            } else {
                $(event.target).next().html(parseInt($(event.target).next().html())+1);
            }
            $(event.target).toggleClass('qq_liked');
            $.ajax({
                type: "GET",
                url: '/quotes/like/' + id,
                success: function () {
                    console.log('(Un)Liked quote ' + id);
                },
                error: function () {
                    console.log('Couldn\'t (un)like quote ' + id);
                    window.alert('Couldn\'t (un)like quote!');
                    if ($(event.target).hasClass('qq_liked')) {
                        $(event.target).next().html(parseInt($(event.target).next().html())-1);
                    } else {
                        $(event.target).next().html(parseInt($(event.target).next().html())+1);
                    }
                    $(event.target).toggleClass('qq_liked');
                }
            });
        });

    </script>

@endsection