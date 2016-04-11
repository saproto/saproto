@foreach($members['editions'] as $edition)
    <div class="panel panel-default">
        <div class="panel-heading">{{ $committee->name }}
            <strong>{{ $edition[0]->pivot->edition }}</strong>
        </div>
        <div class="panel-body">
            @foreach($edition as $i => $member)
                <a href="{{ route('user::profile', ['id' => $member->id]) }}">{{ $member->name }}</a>
                @if(Route::current()->getName() == "committee::edit")
                    <a href="{{ route("committee::membership::delete", ['id' => $member->pivot->id]) }}">
                        <span class="label label-danger pull-right">
                            <i class="fa fa-trash"></i>
                        </span>
                    </a>
                    <a href="{{ route("committee::membership::edit", ['id' => $member->pivot->id]) }}">
                        <span class=" label label-success pull-right" style="margin-right: 5px;">
                    <i class="fa fa-pencil"></i>
                    </span>
                    </a>
                @endif
                <br>
                {{ ($member->pivot->role ? $member->pivot->role : 'General Member') }}
                @if ($member->pivot->end)
                    between {{ date('M \'y',strtotime($member->pivot->start)) }}
                    and {{ date('M \'y',strtotime($member->pivot->end)) }}.
                @else
                    since {{ date('M \'y',strtotime($member->pivot->start)) }}.
                @endif
                @if($i != count($edition) - 1)
                    <hr class="committee-seperator">
                @endif
            @endforeach
        </div>
    </div>
@endforeach

@if(count($members['members']['current']) > 0)
    <div class="panel panel-default">
        <div class="panel-heading">Current members</strong>
        </div>
        <div class="panel-body">
            @foreach($members['members']['current'] as $i => $member)
                <a href="{{ route('user::profile', ['id' => $member->id]) }}">{{ $member->name }}</a>
                @if(Route::current()->getName() == "committee::edit")
                    <a href="{{ route("committee::membership::delete", ['id' => $member->pivot->id]) }}">
                        <span class="label label-danger pull-right">
                            <i class="fa fa-trash"></i>
                        </span>
                    </a>
                    <a href="{{ route("committee::membership::edit", ['id' => $member->pivot->id]) }}">
                        <span class=" label label-success pull-right" style="margin-right: 5px;">
                    <i class="fa fa-pencil"></i>
                    </span>
                    </a>
                @endif
                <br>
                {{ ($member->pivot->role ? $member->pivot->role : 'General Member') }}
                @if ($member->pivot->end)
                    between {{ date('M \'y',strtotime($member->pivot->start)) }}
                    and {{ date('M \'y',strtotime($member->pivot->end)) }}.
                @else
                    since {{ date('M \'y',strtotime($member->pivot->start)) }}.
                @endif
                @if($i != count($members['members']['current']) - 1)
                    <hr class="committee-seperator">
                @endif
            @endforeach
        </div>
    </div>
@endif

@if(count($members['members']['past']) > 0)
    <div class="panel panel-default">
        <div class="panel-heading">Past members</strong>
        </div>
        <div class="panel-body">
            @foreach($members['members']['past'] as $i => $member)
                <a href="{{ route('user::profile', ['id' => $member->id]) }}">{{ $member->name }}</a>
                @if(Route::current()->getName() == "committee::edit")
                    <a href="{{ route("committee::membership::delete", ['id' => $member->pivot->id]) }}">
                        <span class="label label-danger pull-right">
                            <i class="fa fa-trash"></i>
                        </span>
                    </a>
                    <a href="{{ route("committee::membership::edit", ['id' => $member->pivot->id]) }}">
                        <span class=" label label-success pull-right" style="margin-right: 5px;">
                    <i class="fa fa-pencil"></i>
                    </span>
                    </a>
                @endif
                <br>
                {{ ($member->pivot->role ? $member->pivot->role : 'General Member') }}
                @if ($member->pivot->end)
                    between {{ date('M \'y',strtotime($member->pivot->start)) }}
                    and {{ date('M \'y',strtotime($member->pivot->end)) }}.
                @else
                    since {{ date('M \'y',strtotime($member->pivot->start)) }}.
                @endif
                @if($i != count($members['members']['past']) - 1)
                    <hr class="committee-seperator">
                @endif
            @endforeach
        </div>
    </div>
@endif