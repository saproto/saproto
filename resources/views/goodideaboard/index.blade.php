@extends('website.layouts.redesign.generic')

@section('page-title')
    Good Idea Board
@endsection

@section('container')

    <div class="row">
        <div class="col-lg-3">
            @include('goodideaboard.newidea')
            @include('goodideaboard.leastvoted')
        </div>

        <div class="col-lg-9">
            @include('goodideaboard.allideas')
        </div>
    </div>

@endsection

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        $(function() {
            $('.gi_upvote').on('click', function(e) {
                let id = $(e.target).attr('data-id');
                if(id) sendVote(id, 1, e.target);
            });

            $('.gi_downvote').on('click', function(e) {
                let id = $(e.target).attr('data-id');
                if(id) sendVote(id, -1, e.target);
            });

            function sendVote(id, voteValue, target) {
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
                        switch(response.userVote) {
                            case 1:
                                $(`a[data-id='${id}'].gi_upvote`).addClass('fas').removeClass('far');
                                $(`a[data-id='${id}'].gi_downvote`).addClass('far').removeClass('fas');
                                break;
                            case -1:
                                $(`a[data-id='${id}'].gi_upvote`).addClass('far').removeClass('fas');
                                $(`a[data-id='${id}'].gi_downvote`).addClass('fas').removeClass('far');
                                break;
                            case 0:
                                $(`a[data-id='${id}']`).addClass('far').removeClass('fas');
                        }
                    },
                    error: function() {
                        window.alert('Something went wrong voting the idea. Please try again.');
                    }
                })
            }
        });
    </script>
@endpush