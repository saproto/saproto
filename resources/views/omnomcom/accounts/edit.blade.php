@extends('website.layouts.panel')

@section('page-title')
    Account Administration
@endsection

@section('panel-title')
    {{ ($account == null ? "Create new account." : "Edit account " . $account->account_number .".") }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ ($account == null ? route("omnomcom::accounts::add") : route("omnomcom::accounts::edit", ['id' => $account->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">
                    <label for="name">Account name:</label>
                    <input type="text" class="form-control" id="name" name="name"
                           placeholder="Magical Accessories" value="{{ $account->name or '' }}" required>
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">
                    <label for="account_number">Account number:</label>
                    <input type="number" class="form-control" id="account_number" name="account_number"
                           placeholder="1234" value="{{ $account->account_number or '' }}" required>
                </div>

            </div>

        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("omnomcom::accounts::list") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection