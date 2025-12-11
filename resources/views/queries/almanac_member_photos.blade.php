@php
    use App\Enums\PhotoEnum;
@endphp

@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Actual membership totals
@endsection

@section('container')
    <div class="row d-inline-flex justify-content-center w-100">
        <div class="col-10">
            <div class="card mb-3">
                <div
                    class="card-header d-inline-flex justify-content-between justify-center"
                >
                    <div class="dropdown">
                        <div
                            class="btn btn-secondary dropdown-toggle"
                            data-bs-toggle="dropdown"
                            role="button"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            Select membership year
                        </div>

                        <ul class="dropdown-menu dropdown">
                            @foreach ($availableYears as $availableYear)
                                <a
                                    class="dropdown-item {{ $availableYear == $year ? 'active' : '' }}"
                                    href="{{ route('queries::almanac_member_photos', ['year' => $availableYear]) }}"
                                >
                                    {{ $availableYear }}/{{ $availableYear + 1 }}
                                </a>
                            @endforeach
                        </ul>
                    </div>
                    <div>Showing the users for {{ $year }}/{{ $year + 1 }}</div>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Photo url</th>
                                <th scope="col">Photo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        {{ $user->getFirstMediaUrl('profile_picture') }}
                                    </td>
                                    <td class="col-1">
                                        <img
                                            src="{{ $user->getFirstMediaUrl('profile_picture', 'preview') }}"
                                            alt="{{ $user->name }}'s photo"
                                        />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
