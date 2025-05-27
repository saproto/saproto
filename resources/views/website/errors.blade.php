@if ($errors->any())
    <div class="card bg-danger mb-3">
        <div class="card-body">
            <ul class="list-group p-3">
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
