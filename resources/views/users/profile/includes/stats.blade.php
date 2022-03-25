<div class="card mb-3">

    <div class="card-header text-white border-bottom-0 bg-white" style="position: relative; height: 80px;">

        <div style="position: absolute; top: 0; left: 0; right: 0;">

            <h3 class="text-center ellipsis mb-3 mt-4 text-dark">
                User statistics <i class="fas fa-info-circle fa-fw mr-2" data-toggle="tooltip" data-placement="top" title="This info is only visible to you!"></i>
            </h3>

        </div>

    </div>

    <div class="card-body">

        <p class="card-text ellipsis">
                <i class="fas fa-user-clock fa-fw mr-2" data-toggle="tooltip" data-placement="top" title="The date your account got created"></i>
            Account created on: {{ date('F j, Y', strtotime($user->member->created_at)) }}.
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
