<div class="vh-100 bg-dark col-2 overflow-hidden p-0">
    <nav id="category-nav" class="nav p-3">
        @foreach ($categories as $category)
            <div
                class="btn btn-lg btn-category btn-block bg-omnomcom rounded-0 {{ $category == $categories[0] ? 'active' : '' }} px-2 py-2 text-start"
                data-id="{{ $category->id }}"
            >
                {{ $category->name }}
            </div>
        @endforeach

        @if (count($minors) > 0)
            <div
                class="btn btn-lg btn-category btn-block bg-omnomcom rounded-0 px-2 py-2 text-start"
                data-id="static-minors"
            >
                <strong>{{ count($minors) }}</strong>
                Minor Members
            </div>
        @endif

        @if (Auth::check())
            <form action="{{ route('login::logout') }}" method="POST">
                @csrf
                <button
                    class="btn btn-lg btn-block bg-omnomcom rounded-0 ellipsis mt-4 px-2 py-2 text-start"
                    type="submit"
                >
                    Logout
                    <strong>{{ Auth::user()->calling_name }}</strong>
                </button>
            </form>
        @endif

        <div id="reload-button" class="btn btn-block px-4 py-2">
            RELOAD BUTTON
        </div>
    </nav>
</div>

@push('javascript')
    <script nonce="{{ csp_nonce() }}">
        document.getElementById('reload-button').onclick = () =>
            window.location.reload()
    </script>
@endpush
