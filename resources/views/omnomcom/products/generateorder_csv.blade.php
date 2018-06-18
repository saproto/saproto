@foreach($orders as $order)
{{ $order->product->supplier_id or 'NO_SUPPLIER_ID' }};{{ $order->order_collo }};OmNomCom Auto Order - {{ $order->product->name }}&#13;&#10;
@endforeach