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
        const upvoteList = Array.from(document.getElementsByClassName('gi_upvote'))
        upvoteList.forEach(el => {
            el.addEventListener('click', e => {
                let id = e.target.getAttribute('data-id')
                if (id) sendVote(id, 1, e.target)
            })
        })

        const downvoteList = Array.from(document.getElementsByClassName('gi_downvote'))
        downvoteList.forEach(el => {
            el.addEventListener('click', e => {
                let id = e.target.getAttribute('data-id')
                if(id) sendVote(id, -1, e.target)
            })
        })

        function sendVote(id, voteValue, target) {
            window.axios.post(
                '{{ route('goodideas::vote') }}',
                {
                    id: id,
                    voteValue: voteValue
                }
            )
                .then(res => {
                    const data = res.data
                    const votes = document.querySelector(`span[data-id='${id}']`)
                    const upvote = document.querySelector(`.gi_upvote[data-id='${id}']`)
                    const downvote = document.querySelector(`.gi_downvote[data-id='${id}']`)
                    votes.innerHTML = data.voteScore
                    switch(data.userVote) {
                        case 1:
                            upvote.classList.replace('far', 'fas')
                            downvote.classList.replace('fas', 'far')
                            break
                        case -1:
                            upvote.classList.replace('fas', 'far')
                            downvote.classList.replace('far', 'fas')
                            break
                        case 0:
                            votes.classList.replace('fas', 'far')
                    }
                })
                .catch(error => {
                    console.error(error)
                    window.alert('Something went wrong voting the idea. Please try again.')
                })
        }
    </script>
@endpush