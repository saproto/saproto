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

                    <tr class="text-muted">
                        <td><strong>Total number of primary members</strong></td>
                        <td><i class="fas fa-times"></i></td>
                    </tr>

                    <tr class="text-muted">
                        <td><strong>Total number of secondary members</strong></td>
                        <td><i class="fas fa-times"></i></td>
                    </tr>

                    <tr class="text-muted">
                        <td><strong>Total number of members that are affiliated with the UT</strong></td>
                        <td><i class="fas fa-times"></i></td>
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

                </table>

                <div class="card-body mt-0 pt-0">

                    <hr>

                    <p>
                        <a href="?export_subsidies" class="btn btn-info btn-block disabled">
                            Export overview for UT subsidies.
                        </a><br>
                        <span class="badge-warning badge-pill">This feature is currently disabled</span>
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

        </div>

    </div>

@endsection