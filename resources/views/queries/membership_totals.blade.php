@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Actual membership totals
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    @yield('page-title')
                </div>

                <table class="table table-sm table-hover mb-0">

                    <tr>
                        <td><strong>Total number of members</strong></td>
                        <td>{{ $total }}</td>
                    </tr>

                    <tr>
                        <td><strong>Total number of primary members</strong></td>
                        <td>{{ $primary }}</td>
                    </tr>

                    <tr>
                        <td><strong>Total number of secondary members</strong></td>
                        <td>{{ $secondary }}</td>
                    </tr>

                    <tr>
                        <td><strong>Total number of members that are affiliated with the UT</strong></td>
                        <td>{{ $ut }}</td>
                    </tr>

                    <tr>
                        <td><strong>Total number of active members</strong></td>
                        <td>{{ $active }}</td>
                    </tr>

                    <tr>
                        <td><strong>Total number of lifelong members</strong></td>
                        <td>{{ $lifelong }}</td>
                    </tr>

                    <tr>
                        <td><strong>Total number of honorary members</strong></td>
                        <td>{{ $honorary }}</td>
                    </tr>

                    <tr>
                        <td>
                            <strong>Total number of donors</strong><br>
                            <sup>For this overview donors are also considered members.</sup>
                        </td>
                        <td>{{ $donor }}</td>
                    </tr>

                    <tr>
                        <td>
                            <strong>Total number of pending members</strong><br>
                            <sup>For this overview pending members are not counted as members.</sup>
                        </td>
                        <td>{{ $pending }}</td>
                    </tr>

                    <tr>
                        <td>
                            <strong>Total number of pet members</strong><br>
                            <sup>For this overview pet members are not counted as members.</sup>
                        </td>
                        <td>{{ $pet }}</td>
                    </tr>

                </table>

                <div class="card-body mt-0 pt-0">

                    <hr>

                    <p>
                        <a href="?export_subsidies" class="btn btn-success btn-block">
                            Export overview for UT subsidies.
                        </a><br>
                        This overview only includes users whose UT affiliation could be verified. UTwente numbers are
                        only included if available, and e-mail addresses are only included if they are an <code>@utwente.nl</code>
                        address.
                    </p>

                    <hr>

                    <p>
                        <a href="?export_active" class="btn btn-success btn-block">
                            Export overview of active members.
                        </a>
                    </p>

                </div>

            </div>

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    Members who were primary members according to the old system but are now secondary members
                </div>
                @if(count($membersWhoArentPrimaryAnymore)>0)
                    <table class="table table-sm table-hover mb-0">
                        @php /** @var \App\Models\User $user */ @endphp
                        @foreach($membersWhoArentPrimaryAnymore as $user)

                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>

                        @endforeach
                    </table>
                @else
                    <div class="card-body">
                        <p>
                            No differences found.
                        </p>
                    </div>
                @endif
            </div>

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    Members who were not primary members according to the old system but are now
                </div>
                @if(count($membersWhoAreNewPrimary)>0)
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>E-mail address</th>
                        </tr>
                        </thead>
                        @php /** @var \App\Models\User $user */ @endphp
                        @foreach($membersWhoAreNewPrimary as $user)

                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>

                        @endforeach
                    </table>
                @else
                    <div class="card-body">
                        <p>
                            No differences found.
                        </p>
                    </div>
                @endif
            </div>

        </div>

    </div>

@endsection
