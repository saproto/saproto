@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Queries
@endsection

@section('container')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    @yield('page-title')
                </div>

                <div class="table-responsive">
                    <table class="table-sm table-hover table">
                        <thead>
                            <tr class="bg-dark text-white">
                                <td>Query</td>
                                <td>Description</td>
                                <td></td>
                            </tr>
                        </thead>

                        <tr>
                            <td>Activity overview</td>
                            <td>
                                Generates an overview of activities between two
                                dates.
                            </td>
                            <td>
                                <a
                                    href="{{ route('queries::activity_overview') }}"
                                >
                                    <i class="fas fa-running"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>Membership totals</td>
                            <td>
                                Shows an overview of a number of membership
                                totals.
                            </td>
                            <td>
                                <a
                                    href="{{ route('queries::membership_totals') }}"
                                >
                                    <i class="fas fa-running"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>Activity statistics</td>
                            <td>
                                Generates activity statistics between two dates.
                            </td>
                            <td>
                                <a
                                    href="{{ route('queries::activity_statistics') }}"
                                >
                                    <i class="fas fa-running"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>ProTube statistics</td>
                            <td>
                                Generates ProTube statistics between two dates.
                            </td>
                            <td>
                                <a
                                    href="{{ route('queries::protube_statistics') }}"
                                >
                                    <i class="fas fa-running"></i>
                                </a>
                            </td>
                        </tr>


                        <tr>
                            <td>Most liked photos</td>
                            <td>
                                Get the most liked photos between two dates
                            </td>
                            <td>
                                <a
                                    href="{{ route('queries::mostliked_photos') }}"
                                >
                                    <i class="fas fa-running"></i>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
