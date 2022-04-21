<div class="card mb-3">

    <div class="card-header text-white border-bottom-0 bg-white" style="position: relative; height: 85px;">

        <div style="position: absolute; top: 0; left: 0; right: 0;" class="text-center text-dark">
            <h3 class="mt-4 mb-0">
                User statistics <i class="fas fa-info-circle fa-fw mr-2" data-toggle="tooltip" data-placement="top" title="This info is only visible to you!"></i>
            </h3>
            <i><small>Note: These statistics are not visible to other members!</small></i>
        </div>

    </div>

    <div class="card-body">

        <p class="card-text ellipsis">
                <i class="fas fa-user-clock fa-fw mr-2" data-toggle="tooltip" data-placement="top" title="The date your account got created"></i>
            Account created on: {{ date('F j, Y', strtotime($user->created_at)) }}.
        </p>
        <p class="card-text ellipsis">
            <i class="fas fa-calendar-alt fa-fw mr-2" data-toggle="tooltip" data-placement="top" title="This is the total amount of events you have signed up for!"></i>
            Total signups: {{$signups}}
        </p>
        <p class="card-text ellipsis">
            <i class="fas fa-box fa-fw mr-2" data-toggle="tooltip" data-placement="top" title="The total amount of individual products you have purchased!"></i>
            Total products purchased: {{$totalproducts}}
        </p>
        <p class="card-text ellipsis">
            <i class="fas fa-euro-sign fa-fw mr-2" data-toggle="tooltip" data-placement="top" title="The total amount of euros you have spent at proto!"></i>
            Total money spent: €{{$spentmoney}}
        </p>

    </div>

</div>
