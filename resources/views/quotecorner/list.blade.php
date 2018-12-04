@extends('website.layouts.redesign.generic')

@section('page-title')
    Quote Corner
@endsection

@section('container')

    <div class="row">
        <div class="col-md-4 col-md-push-8">

            @include('quotecorner.newquote')

            @include('quotecorner.popular')

        </div>

        <div class="col-md-8 col-md-pull-4">

            @include('quotecorner.allquotes')

        </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script>

        $(".qq_like").click(function (event) {

            var id = $(event.target).parent().attr('data-id');

            if (id === undefined) { return; }

            $.ajax({
                type: "GET",
                url: '{{ route('quotes::like', ['id' => 'qid']) }}'.replace('qid', id),
                success: function () {

                    if ($(event.target).hasClass('fas')) {
                        $(event.target).next().html(parseInt($(event.target).next().html())-1);
                    } else {
                        $(event.target).next().html(parseInt($(event.target).next().html())+1);
                    }

                    $(event.target).toggleClass('fas').toggleClass('far');

                },
                error: function () {

                    window.alert('Something went wrong liking the quote. Please try again.');

                }
            });

        });

    </script>

@endsection