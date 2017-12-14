@extends('website.layouts.panel')

@section('page-title')
    RFID Card
@endsection

@section('panel-title')
    {{ ($card == null ? "Add new RFID card." : "Edit existing RFID card.") }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ ($card == null ? route("user::rfid::add") : route("user::rfid::edit", ['id' => $card->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="row">

            <div class="col-md-12">

                <div class="form-group">
                    <label for="name">Card name:</label>
                    <input type="text" class="form-control" id="name" name="name"
                           placeholder="My Albert Heijn Bonus Card" value="{{ $card->name or '' }}" required>
                </div>

            </div>

        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("user::dashboard", ['id' => $card->user->id]) }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection