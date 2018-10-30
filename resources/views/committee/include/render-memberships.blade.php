<div class="card mb-3">

    <div class="card-header bg-dark text-white"
         style="cursor: pointer;" data-toggle="collapse" data-target="#committee_collapse_{{ $unique }}">
        {!! $title !!}
    </div>

    <div id="committee_collapse_{{ $unique }}" class="collapse {{ $display ? 'show' : null }}"
         data-parent="#committee_collapse">

        <div class="card-body">

            @foreach($memberships as $i => $membership)
                @include('committee.include.render-membership', [
                    'membership' => $membership
                ])
            @endforeach

        </div>

    </div>

</div>