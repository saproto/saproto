@extends('website.layouts.default')

@section('page-title')
    Generate Supplier Order
@endsection

@section('content')

    @if (count($products) > 0)

        <p>
            This table shows how much of each products needs to be ordered to reach the preferred stock as set for that
            product. This list <strong>only</strong> includes products that are set to 'be in stock by default' and that
            need to be re-ordered to have sufficient stock. This is determined by the <i>Visible in the OmNomCom even
                when out of stock</i> checkbox in the product's settings. To include or exclude products from this list,
            head over to that product's page and change the setting.
        </p>

        <hr>

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Product Name</th>
                <th>Collo</th>
                <th>Stock</th>
                <th>Target</th>
                <th>&nbsp;</th>
                <th colspan="2">Collo to Order</th>
                <th colspan="2">Stock After Order</th>

            </tr>

            </thead>

            <?php
            $category = null;
            ?>

            @while(count($products) > 0)

                <?php $category = $products->first()->category; ?>

                <th colspan="10"><?echo $category;?></th>

                @foreach($products as $key => $product)

                    @if($product->category == $category)

                        <?php

                        if ($product->supplier_collo == 0) {
                            $needToOrder = 999999;
                        } else {
                            $needToOrder = ceil(($product->preferred_stock - $product->stock) / $product->supplier_collo);
                        }

                        ?>

                        <tr>

                            <td>{{ $product->id }}</td>
                            <td>
                                <a href="{{ route('omnomcom::products::edit', ['id' => $product->id]) }}">{{ $product->name }}</a>
                            </td>
                            <td style="opacity: 0.5;">{{ $product->supplier_collo }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->preferred_stock }}</td>
                            <td>&nbsp;</td>
                            <td><strong>{{ $needToOrder }}</strong></td>
                            <td style="opacity: 0.5;">{{ ($needToOrder * $product->supplier_collo) }} units</td>
                            <td>{{ $product->stock + ($product->supplier_collo * $needToOrder) }}</td>
                            <td style="opacity: 0.5;">
                                + {{ ($product->stock + ($product->supplier_collo * $needToOrder)) - $product->preferred_stock }}
                            </td>

                        </tr>

                        <?php unset($products[$key]); ?>

                    @endif

                @endforeach

            @endwhile

        </table>

    @else

        <p style="text-align: center;">
            No products need to be reordered.
        </p>

    @endif

@endsection