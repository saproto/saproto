<form method="post"
      action="{{ ($email == null ? route("email::add") : route("email::edit", ['id' => $email->id])) }}"
      enctype="multipart/form-data">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            @yield('page-title')
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="description">Internal description:</label>
                        <input type="text" class="form-control" id="description" name="description"
                               placeholder="A short descritpion that only the board can see."
                               value="{{ $email->description ?? '' }}" required>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="subject">E-mail subject:</label>
                        <input type="text" class="form-control" id="subject" name="subject"
                               placeholder="The e-mail subject."
                               value="{{ $email->subject ?? '' }}" required>
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="sender_name">Sender name:</label>
                        <input type="text" class="form-control" id="sender_name" name="sender_name"
                               placeholder="{{ Auth::user()->name }}"
                               value="{{ $email->sender_name ?? Auth::user()->name }}" required>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="sender_address">Sender e-mail:</label>
                        <div class="input-group mb-3">
                            <input name="sender_address" type="text" class="form-control" placeholder="board" value="{{ $email->sender_address ?? '' }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">@ {{ config('proto.emaildomain') }}</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="form-group">
                <label for="editor">E-mail</label>
                @include('website.layouts.macros.markdownfield', [
                    'name' => 'body',
                    'placeholder' => 'Text goes here.',
                    'value' => $email ? $email->body : null
                ])
            </div>

            <div class="row">


                <div class="col-md-6">

                    <div class="form-group">
                        <label>Recipients:</label>

                        <div class="radio">
                            <label>
                                <input type="radio" name="destinationType" id="destinationMembers" required
                                       value="members" {{ ($email && $email->to_member ? 'checked' : '') }}>
                                All members
                            </label>
                        </div>

                        <div class="radio">
                            <label>
                                <input type="radio" name="destinationType" id="destinationActiveMembers"
                                       required
                                       value="active" {{ ($email && $email->to_active ? 'checked' : '') }}>
                                All active members
                            </label>
                        </div>

                        <div class="radio">
                            <label>
                                <input type="radio" name="destinationType" id="destinationEvent" required
                                       value="event" {{ ($email && $email->to_event ? 'checked' : '') }}>
                                These events:
                            </label>
                        </div>

                        @if($email && $email->to_event)
                            <p>
                                <strong>Current selection</strong>
                            </p>

                            <p>
                                <ul class="list-group">
                                    @foreach($email->events as $event)
                                        <li class="list-group-item">
                                            {{ $event->title }} ({{ $event->formatted_date->simple }})
                                        </li>
                                    @endforeach
                                </ul>
                            </p>

                            <p>
                                <strong>Replace selection</strong>
                            </p>
                        @endif

                        <div class="form-group">
                            <input class="form-control event-search" id="eventSelect" name="eventSelect[]"
                                   {{ ($email && $email->to_event ? '' : 'disabled="disabled"') }} multiple>
                        </div>

                        <div class="radio">
                            <label>
                                <input type="radio" name="destinationType" id="destinationLists" required
                                       value="lists" {{ ($email && $email->to_list ? 'checked' : '') }}>
                                These e-mail lists:
                            </label>
                        </div>

                        <select multiple name="listSelect[]" id="listSelect" class="form-control"
                                {{ ($email && $email->to_list ? '' : 'disabled="disabled"') }}>

                            @foreach(Proto\Models\EmailList::all() as $list)

                                <option value="{{ $list->id }}" {{ ($email && $email->hasRecipientList($list) ? 'selected' : '' ) }}>
                                    {{ $list->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <div class="col-md-6">
                    @include('website.layouts.macros.datetimepicker', [
                        'name' => 'time',
                        'label' => 'Scheduled:',
                        'placeholder' => $email ? $email->time : strtotime(Carbon::now()->endOfDay())
                    ])
                </div>

            </div>

        </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-success float-end">Save</button>

            <a href="{{ route("email::admin") }}" class="btn btn-default">Cancel</a>

        </div>

    </div>

</form>

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        const eventSelect = document.getElementById('eventSelect')
        const listSelect = document.getElementById('listSelect')

        document.getElementById('destinationEvent').addEventListener('click', e => disableSelect(false, true))
        document.getElementById('destinationLists').addEventListener('click', e => disableSelect(true, false))
        document.getElementById('destinationMembers').addEventListener('click', e => disableSelect(true, true))
        document.getElementById('destinationActiveMembers').addEventListener('click', e => disableSelect(true, true))

        function disableSelect(event, list) {
            eventSelect.disabled = event
            listSelect.disabled = list
        }
    </script>

@endpush