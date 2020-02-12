<div class="card mb-3">

    <div class="card-header bg-dark text-white mb-1">
        Dinnerform overview
    </div>

    <table class="table table-sm">

        <thead>

        <tr class="bg-dark text-white">

            <td>Restaurant</td>
            <td>Open</td>
            <td>Start</td>
            <td>End</td>
        </tr>

        </thead>
        <tbody>

        @if(count($dinnerformList) > 0)
            @foreach($dinnerformList as $dinnerform)
                <tr>

                    <td class="align-middle">{{ $dinnerform->restaurant }} <span class="text-muted">(#{{ $dinnerform->id }})</span></td>
                    <td class="align-middle">
                        @if($dinnerform->isCurrent())
                            <i class="far fa-clock text-success"></i>
                        @else
                            <i class="fas fa-ban text-danger"></i>
                        @endif
                    </td>
                    <td class="align-middle">{{ $dinnerform->start->format('Y m-d H:i') }}</td>
                    <td class="align-middle">{{ $dinnerform->end->format('Y m-d H:i') }}</td>
                    <td class="align-middle">
                        @if($dinnerform->isCurrent())
                            <a class="btn btn-warning" href="{{ route('dinnerform::close', ['id' => $dinnerform->id]) }}">
                                close now
                            </a>
                        @endif
                    </td>
                    <td class="text-left align-middle">
                        <a href="{{ route('dinnerform::edit', ['id' => $dinnerform->id]) }}">
                            <i class="fas fa-edit mr-2"></i>
                        </a>
                        <a onclick="return confirm('Remove dinnerform from \'{{ $dinnerform->start }}\' at \'{{ $dinnerform->restaurant }}\'?');"
                           href="{{ route("dinnerform::delete", ['id' => $dinnerform->id]) }}">
                            <i class="fas fa-trash text-danger"></i>
                        </a>
                    </td>

                </tr>
            @endforeach
        @else
            <tr>
                <td>There are no dinnerforms available.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif

        </tbody>

    </table>
</div>

