<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        Order products
    </div>

    <table class="table table-borderless table-hover table-sm">

        <tbody>

        @foreach($category->products() as $product)

            <tr>
                <td class="text-right">
                    @if(!$product->is_visible)
                        <i class="fas fa-eye-slash"></i>
                    @elseif($product->stock <= 0 && !$product->is_visible_when_no_stock)
                        <i class="fas fa-exclamation-triangle"></i>
                    @endif

                </td>
                <td>
                    <a href="{{ route("omnomcom::products::edit",['id' => $product->id]) }}">
                        {{ $product->name }}
                    </a>
                </td>
                <td>
                    <a href="{{ route("omnomcom::products::rank",['category' => $category->id, 'id' => $product->id, 'direction' => 'up']) }}">
                        <i class="fa arrow fa-arrow-up" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route("omnomcom::products::rank",['category' => $category->id, 'id' => $product->id, 'direction' => 'down']) }}">
                        <i class="fa arrow fa-arrow-down" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>

        @endforeach

        </tbody>

    </table>

</div>