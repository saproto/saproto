@extends('website.layouts.panel')

@section('page-title')
    Product Administration
@endsection

@section('panel-title')
    {{ ($product == null ? "Create new product." : "Edit product " . $product->name .".") }}
@endsection

@section('panel-body')

    <form method="post"
          action="{{ ($product == null ? route("omnomcom::products::add") : route("omnomcom::products::edit", ['id' => $product->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">
                    <label for="name">Product name:</label>
                    <input type="text" class="form-control" id="name" name="name"
                           placeholder="Bertie Bott's Every Flavour Beans" value="{{ $product->name or '' }}" required>
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">
                    <label for="nicename">Nicename:</label>
                    <input type="text" class="form-control" id="nicename" name="nicename"
                           placeholder="every-flavor-beans" value="{{ $product->nicename or '' }}" required>
                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">
                    <label for="price">Unit price:</label>
                    <div class="input-group">
                        <span class="input-group-addon">&euro;</span>
                        <input type="text" class="form-control" id="price" name="price"
                               placeholder="0" value="{{ $product->price or '' }}" required>
                    </div>
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">
                    <label for="supplier_collo">
                        Collo size
                        <span data-toggle="tooltip" data-placement="top"
                              title="The amount of units in a package when bought. (e.g.: there are 24 cans in a tray)">(?)</span>
                        :
                    </label>
                    <input type="number" class="form-control" id="supplier_collo" name="supplier_collo"
                           placeholder="0" value="{{ $product->supplier_collo or '' }}">
                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-4">

                <div class="form-group">
                    <label for="stock">Current stock:</label>
                    <input type="number" class="form-control" id="stock" name="stock"
                           placeholder="0" value="{{ $product->stock or '' }}">
                </div>

            </div>

            <div class="col-md-4">

                <div class="form-group">
                    <label for="preferred_stock">Preferred stock:</label>
                    <input type="number" class="form-control" id="preferred_stock" name="preferred_stock"
                           placeholder="0" value="{{ $product->preferred_stock or '' }}">
                </div>

            </div>

            <div class="col-md-4">

                <div class="form-group">
                    <label for="max_stock">Maximum stock:</label>
                    <input type="number" class="form-control" id="max_stock" name="max_stock"
                           placeholder="0" value="{{ $product->max_stock or '' }}">
                </div>

            </div>

        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox"
                       name="is_visible" {{ ($product != null && $product->is_visible ? 'checked' : '') }}>
                Visible in OmNomCom.
            </label>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox"
                       name="is_visible_when_no_stock" {{ ($product != null && $product->is_visible_when_no_stock ? 'checked' : '') }}>
                Visible in OmNomCom even when out of stock.
            </label>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox"
                       name="is_alcoholic" {{ ($product != null && $product->is_alcoholic ? 'checked' : '') }}>
                Product contains alcohol.
            </label>
        </div>

        <hr>

        <div class="row">

            <div class="col-md-6">

                <label for="max_stock">Product categories:</label>

                <select multiple name="product_categories[]" class="form-control">

                    @foreach($categories as $catogory)

                        <option value="{{ $catogory->id }}" {{ ($product != null && $product->categories->contains($catogory) ? 'selected' : '') }}>
                            {{ $catogory->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-6">

                <label for="max_stock">Financial account:</label>

                <select name="account_id" class="form-control" required>

                    @foreach($accounts as $account)

                        <option value="{{ $account->id }}" {{ ($product != null && $account->id == $product->account_id ? 'selected' : '') }}>
                            {{ $account->name }} ({{ $account->account_number }})
                        </option>

                    @endforeach

                </select>

            </div>

        </div>

        <hr>

        <div class="form-group">
            <label for="image">Product image:</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>

        @if($product != null && $product->image != null)

            <div class="product__edit__image">
                <div class="product__edit__image__inner"
                     style="background-image: url('{!! $product->image->generateImagePath(500, null) !!}');"></div>
            </div>

        @endif

        @endsection

        @section('panel-footer')

            @if($product)
                <a class="btn btn-danger"
                   onclick="return confirm('Remove product \'{{ $product->name }}\'?');"
                   href="{{ route('omnomcom::products::delete', ['id' => $product->id]) }}"
                   role="button">
                    Delete
                </a>
            @endif

            <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

            <a href="{{ route("omnomcom::products::list") }}" class="btn btn-default pull-right">Cancel</a>

    </form>

@endsection