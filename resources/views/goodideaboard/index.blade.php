@extends('website.layouts.redesign.generic')

@section('page-title')
    Good Idea Board
@endsection

@section('container')

    <div class="row">
        <div class="col-lg-3">
            @include('goodideaboard.newidea')
        </div>

        <div class="col-lg-9">
            @include('goodideaboard.allideas')
        </div>
    </div>

@endsection

@section('javascript')
    @parent
    <script type="text/javascript">
        $(function() {
            $('.gi_upvote').on('click', function(e) {
                let id = $(e.target).attr('data-id');
                if ($(e.target).hasClass('fas')) {
                    if (id) sendVote(id, 0);
                }
                else {
                    if (id) sendVote(id, 1);
                }
            });

            $('.gi_downvote').on('click', function(e) {
                let id = $(e.target).attr('data-id');
                if ($(e.target).hasClass('fas')) {
                    if (id) sendVote(id, 0);
                }
                else {
                    if (id) sendVote(id, -1);
                }
            });

            $('.gi_vote').on('hover', function(e) {

            });

            function sendVote(id, voteValue) {
                let data = new FormData();
                data.append('id', id);
                data.append('voteValue', voteValue);
                data.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('goodideas::vote') }}',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $(`span[data-id='${id}']`).html(response.voteScore);
                        let upvote = $(`a[data-id='${id}'].gi_upvote`);
                        let downvote = $(`a[data-id='${id}'].gi_downvote`);
                        switch(response.userVote) {
                            case 1:
                                upvote.addClass('fas').removeClass('far');
                                downvote.addClass('far').removeClass('fas');
                                break;
                            case -1:
                                upvote.addClass('far').removeClass('fas');
                                downvote.addClass('fas').removeClass('far');
                                break;
                            case 0:
                                upvote.addClass('far').removeClass('fas');
                                downvote.addClass('far').removeClass('fas');
                        }
                    },
                    error: function() {
                        window.alert('Something went wrong voting the idea. Please try again.');
                    }
                })
            }
        });
    </script>
@endsection