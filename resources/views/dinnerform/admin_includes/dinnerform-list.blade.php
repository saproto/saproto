@php($dinnerforms = Proto\Models\Dinnerform::all())

<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        Dinner form list
    </div>
    <div class="card-body">
        @if(count($dinnerforms) > 0)

            @foreach($dinnerforms as $dinnerform)

                @include('dinnerform.dinnerform_block')

            @endforeach

        @endif
    </div>
</div>
