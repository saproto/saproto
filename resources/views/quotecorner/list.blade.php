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

        <div class="col-md-8 col-md-4">

            @include('quotecorner.allquotes')

        </div>

    </div>

@endsection

@push('javascript')

    <script type="text/javascript" nonce="{{ csp_nonce() }}">

        likeBtnList = Array.from(document.getElementsByClassName('qq_like'))
        likeBtnList.forEach(el => {
            el.addEventListener('click', e => {
                const id = el.getAttribute('data-id')
                if (id === undefined) return

                window.axios.get('{{ route('quotes::like', ['id' => ':id']) }}'.replace(':id', id))
                .then(res => {
                    const icon = el.children[0]
                    const likes = el.children[1]
                    if (icon.classList.contains('fas')) {
                        likes.innerHTML = parseInt(likes.innerHTML) - 1
                        icon.classList.replace('fas', 'far')
                    }
                    else {
                        likes.innerHTML = parseInt(likes.innerHTML) + 1
                        icon.classList.replace('far', 'fas')
                    }
                })
                .catch(error => {
                    console.error(error)
                    window.alert('Something went wrong liking the quote. Please try again.')
                })
            })
        })

    </script>

@endpush