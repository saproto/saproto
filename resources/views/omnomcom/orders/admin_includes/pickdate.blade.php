<form method="get" action="{{ route('omnomcom::orders::adminlist') }}">

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Orderlines from specific day
        </div>

        <div class="card-body">

            @include('website.layouts.macros.datetimepicker',[
                'name' => 'date',
                'format' => 'date',
                'placeholder' => $date ? strtotime($date) : strtotime(date('Y-m-d'))
            ])

        </div>

        <div class="card-footer">
            <input type="submit" class="btn btn-success btn-block mb-2" value="Get orders">
            <a href="{{ route('omnomcom::orders::adminlist') }}" class="btn btn-success btn-block">Today</a>
        </div>

    </div>

</form>