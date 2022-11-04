@extends('website.layouts.redesign.generic')

@section('page-title')
    Edit Dinnerform Orderline
@endsection

@section('container')
    <div class="row justify-content-center">
        <div class="col-6">
            <form method="post" action="{{ route('dinnerform::orderline::update', ['id'=>$dinnerformOrderline->id]) }}">
                {!! csrf_field() !!}

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">
                        Edit order by {{ $dinnerformOrderline->user->name }} for dinnerform at {{ $dinnerformOrderline->dinnerform->restaurant }}
                    </div>

                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="order">What have they ordered?</label>
                            <input class="form-control" value="{{$dinnerformOrderline->description}}" id="order" name="order" type="text" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="price">What did it cost?</label>
                            <input class="form-control" value="{{$dinnerformOrderline->price}}" id="price" name="price" type="number" min="1" step="any"
                                   required>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="helper" name="helper" type="checkbox" {{$dinnerformOrderline->helper ? 'checked' : ''}}>
                            <label for="helper">Were they a helper?</label>
                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" class="btn btn-success" value="Edit">
                        <a class="btn btn-danger ms-2" href="{{ route('dinnerform::admin', ['id' => $dinnerformOrderline->dinnerform->id]) }}">Cancel</a>
                    </div>

                </div>
            </form>
        </div>
    </div>

@endsection