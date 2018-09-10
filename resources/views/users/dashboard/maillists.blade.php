<div class="panel panel-default">
    <div class="panel-heading"><strong>E-mail lists</strong></div>
    <div class="panel-body">

        @if(EmailList::all()->count() > 0)
            @foreach(EmailList::all() as $i => $list)

                <p>
                    <strong>
                        {{ $list->name }}
                    </strong>

                    @if($list->isSubscribed($user))
                        <a href="{{ route('togglelist', ['id'=>$list->id]) }}"
                           class="label label-danger pull-right">Unsubscribe</a>
                    @elseif(!$list->is_member_only || $user->member)
                        <a href="{{ route('togglelist', ['id'=>$list->id]) }}"
                           class="label label-success pull-right">Subscribe</a>
                    @else
                        <span class="label label-info pull-right">Members only</span>
                    @endif

                    <br>

                    {!! Markdown::convertToHtml($list->description) !!}
                </p>

                <hr>

            @endforeach
        @else

            <p>
                There currently are no e-mail lists to subscribe to.
            </p>

        @endif

    </div>

    <div class="panel-footer">

    </div>

</div>