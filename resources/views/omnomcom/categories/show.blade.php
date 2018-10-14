@extends('website.layouts.default')

@section('page-title')
    OmNomCom Category Administration
@endsection

@section('content')

    <div class="row">

        <div class="col-md-3">

            <h3 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align: center;">

                {{ $category->name }}

            </h3>

        </div>

        <div class="col-md-9">

            <h3>Products linked to this category</h3>

            @if (count($category->products()) > 0)

                <div class="row">

                    @foreach($category->products() as $product)

                        <div class="col-md-4 col-xs-12 product__account">

                            <div class="product__account__image">

                                @if($product->image != null)

                                    <div class="product__account__image__inner"
                                         style="background-image: url('{!! $product->image->generateImagePath(500, null) !!}');">
                                    </div>

                                @endif

                            </div>

                            <div class="product__account__name">

                                <a href="{{ route("omnomcom::products::show",['id' => $product->id]) }}"
                                   title="{{ $product->name }}" style="display:block; float:none; max-height:55px; overflow:hidden;">
                                    {{ $product->name }}
                                </a>
                                <a href="{{ route("omnomcom::products::rank",['category' => $category->id, 'id' => $product->id, 'direction' => 'up']) }}">
                                    <i class="fa arrow fa-arrow-left" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route("omnomcom::products::edit",['id' => $product->id]) }}">
                                    <i class="fas fa-pencil-square" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route("omnomcom::products::rank",['category' => $category->id, 'id' => $product->id, 'direction' => 'down']) }}">
                                    <i class="fa arrow fa-arrow-right" aria-hidden="true"></i>
                                </a>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <p style="text-align: center;">
                    There are no products for this account.
                </p>

            @endif

        </div>

    </div>

@endsection