@extends('website.layouts.redesign.dashboard')

@section('page-title')
    @if($new) New temporary admin @else Edit temporary admin @endif
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            <form method="post"
                  action="{{ ($new ? route("tempadmin::add") : route("tempadmin::edit", ['id' => $item->id])) }}"
                  enctype="multipart/form-data">

                {!! csrf_field() !!}

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="menuname">User:</label>
                            @if($new)
                                <div class="input-group" style="width: 100%;">
                                    <select class="form-control user-search" name="user_id" required></select>
                                </div>
                            @else
                                <div class="input-group">
                                    <strong>{{ $item->user->name }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="url">Start at:</label>
                            @include('website.layouts.macros.datetimepicker', [
                                'name' => 'start_at',
                                'format' => 'datetime',
                                'placeholder' => $new ? strtotime(Carbon::now()) : strtotime($item->start_at)
                            ])
                        </div>

                        <div class="form-group">
                            <label for="url">End at:</label>
                            @include('website.layouts.macros.datetimepicker', [
                                'name' => 'end_at',
                                'format' => 'datetime',
                                'placeholder' => $new ? strtotime(Carbon::now()->endOfDay()) : strtotime($item->end_at)
                            ])
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success float-right">Submit</button>
                        <a href="{{ route("tempadmin::index") }}" class="btn btn-default">Cancel</a>
                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection