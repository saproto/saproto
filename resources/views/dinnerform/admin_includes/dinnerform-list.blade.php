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
            <td>Admin</td>
            <td>Controls</td>
            <td></td>
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
                        @elseif($dinnerform->closed)
                            <i class="fas fa-close text-danger"></i>
                            @else
                            <i class="fas fa-ban text-warning"></i>
                        @endif
                    </td>
                    <td class="align-middle">{{ $dinnerform->start->format('Y m-d H:i') }}</td>
                    <td class="align-middle">{{ $dinnerform->end->format('Y m-d H:i') }}</td>
                    <td class="align-middle"><a class="btn btn-info" href="{{ route('dinnerform::admin', ['id' => $dinnerform->id]) }}">
                                View orders
                            </a></td>

                        @if($dinnerform->isCurrent())
                        <td class="align-middle">
                            <a class="btn btn-warning" href="{{ route('dinnerform::close', ['id' => $dinnerform->id]) }}">
                                close now
                            </a>
                    </td>
                        @endif

                    <td class="text-start align-middle">
                        @if(!$dinnerform->closed)
                        <a href="{{ route('dinnerform::edit', ['id' => $dinnerform->id]) }}">
                            <i class="fas fa-edit me-2"></i>
                        </a>
                        @include('website.layouts.macros.confirm-modal', [
                            'action' => route("dinnerform::delete", ['id' => $dinnerform->id]),
                            'text' => '<i class="fas fa-trash text-danger"></i>',
                            'title' => 'Confirm Delete',
                            'message' => "Are you sure you want to remove the dinnerform opening $dinnerform->start ordering at $dinnerform->restaurant?",
                            'confirm' => 'Delete',

                        ])
                        @endif
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
                <td></td>
            </tr>
        @endif

        </tbody>

    </table>
</div>

