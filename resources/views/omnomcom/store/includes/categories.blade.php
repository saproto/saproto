<div class="vh-100 bg-dark col-2 p-0">
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
            <a
                id="logout-button"
                href="{{ route('login::logout::redirect', ['route' => 'omnomcom::store::show']) }}"
                class="btn btn-lg btn-block bg-omnomcom rounded-0 ellipsis mt-4 px-2 py-2 text-start"
            >
                Log out
                <strong>{{ Auth::user()->calling_name }}</strong>
            </a>
        @endif

        <div id="reload-button" class="btn btn-block px-4 py-2">
            RELOAD BUTTON
        </div>
    </nav>
</div>

@push('javascript')
    <script nonce="{{ csp_nonce() }}">
        document.getElementById('logout-button').onclick = () =>
            (window.location = '{{ route('login::logout') }}')
        document.getElementById('reload-button').onclick = () =>
            window.location.reload()
    </script>
@endpush
