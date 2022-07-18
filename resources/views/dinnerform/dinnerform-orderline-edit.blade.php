@extends('website.layouts.redesign.generic')

@section('page-title')
    Edit Dinner Form Orderline
@endsection

@section('container')
    <div class="row justify-content-center">
        <div class="col-6">
            <form method="post" action="{{ route('dinnerform::orderline::update', ['id'=>$dinnerformOrderline->id]) }}">
                {!! csrf_field() !!}

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">
                        Edit dinner form orderline from {{$dinnerformOrderline->user()->name}}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="order">What have they ordered?</label>
                            <input class="form-control" value="{{$dinnerformOrderline->description}}" id="order" name="order" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input class="form-control" value="{{$dinnerformOrderline->price}}" id="price" name="price" type="number" min="1" step="any"
                                   required>
                        </div>
                        <div class="form-group">
                           Where they a helper?
                            <input class="form-check-inline" checked="{{$dinnerformOrderline->helper}}" id="helper" name="helper" type="checkbox">
                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" class="btn btn-success btn-block" value="Edit">
                    </div>

                </div>
            </form>
        </div>
    </div>

@endsection