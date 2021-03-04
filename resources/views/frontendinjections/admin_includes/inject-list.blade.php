<div class="card mb-3">

    <div class="card-header bg-dark text-white mb-1">
        Injects overview
    </div>

    <div class="card-body">

        @if(count($injects) > 0)
            <table class="table table-sm">
                <thead>
                <tr class="bg-dark text-white">
                    <td>name</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                @foreach($injects as $inject)
                    <tr>
                        <td style="max-width: 100px;"><a href="{{ route('inject::edit', ['id'=>$inject->id]) }}">{{$inject->name}}</a></td>
                        <td><i class="fa {{ $inject->enabled ? 'fa-check' : 'fa-times' }} fa-"> </i></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <span class="text-muted">There are no front-end injects.</span>
        @endif

    </div>

</div>