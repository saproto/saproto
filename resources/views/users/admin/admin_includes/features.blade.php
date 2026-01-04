@php
    use App\Features\notifications;
    use App\Models\User;
    use Illuminate\Support\Str;
    use Laravel\Pennant\Feature;
    /** @var User $user */
@endphp

<div class="card mb-3">
    <div class="card-header bg-dark text-white">
        Features for {{ $user->calling_name }}
    </div>

    <div class="card-body text-white">
        <div class="table-responsive">
            <table class="table-sm table">
                <thead>
                    <tr class="text-white">
                        <th>Title</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach (Feature::all() as $key => $feature)
                        <tr class="text-nowrap">
                            <td>
                                <tr class="text-nowrap">
                                    <td>
                                        @if (Feature::for($user)->active($key))
                                            ✅
                                        @else
                                                ❌
                                        @endif
                                    </td>
                                    <td>
                                        <form
                                            method="post"
                                            action="{{ route('features::toggle', ['user' => $user, 'feature' => $key]) }}"
                                        >
                                            {{ csrf_field() }}

                                            @if (Feature::for($user)->active($key))
                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-warning"
                                                >
                                                    Turn off
                                                </button>
                                            @else
                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-primary"
                                                >
                                                    Turn on
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
