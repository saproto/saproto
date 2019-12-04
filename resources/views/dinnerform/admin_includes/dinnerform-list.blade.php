<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        Dinner form list
    </div>
    <div class="card-body">
        @if(count($dinnerformList) > 0)

            @foreach($dinnerformList as $dinnerform)

                @include('dinnerform.dinnerform_block', ['canEdit' => true])

            @endforeach

        @endif
    </div>
</div>
