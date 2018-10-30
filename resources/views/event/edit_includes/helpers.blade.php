@if($event && $event->activity)

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Helping committees
        </div>

        <form method="post" action="{{ route('event::addhelp', ['id'=>$event->id]) }}">

            {!! csrf_field() !!}

            <div class="card-body">

                <div class="form-group">
                    <select class="form-control committee-search" name="committee" required></select>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" name="amount" placeholder="15"
                                   min="1" required>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">people</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <input type="submit" class="btn btn-success pull-right" value="Add">
                    </div>

                </div>

                @if($event->activity->helpingCommittees->count() > 0)

                    <hr>

                    @foreach($event->activity->helpingCommittees as $committee)

                        <p>

                            <strong>{{ $committee->name }}</strong><br>
                            Helps with
                            {{ $event->activity->helpingUsers($committee->pivot->id)->count() }} people.
                            {{ $committee->pivot->amount }} are needed.
                            <a href="{{ route('event::deletehelp', ['id'=>$committee->pivot->id]) }}" class="text-danger">
                                Delete.
                            </a>

                        </p>

                    @endforeach

                @endif

            </div>

        </form>

    </div>

@endif