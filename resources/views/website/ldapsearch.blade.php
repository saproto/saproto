@extends('website.layouts.redesign.generic-sidebar')

@section('page-title')
    UTwente Address Book Search
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-3 col-sm-12">

            <form method="post" action="{{ route('ldap::search') }}">

                {!! csrf_field() !!}

                <div class="card mb-3">

                    <div class="card-header">
                        Search for University of Twente people
                    </div>

                    <div class="card-body">
                        <input type="text" name="query" class="form-control"
                               placeholder="Enter your search term here and hit enter..." value="{{ $term }}">
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-block">Search</button>
                    </div>

                </div>
            </form>

        </div>

        @if($term)

            <div class="col-md-9 col-sm-12">

                <div class="card">

                    <div class="card-header">
                        Search results
                    </div>

                    <div class="card-body">

                        @if (count($data) == 0 && $term != null)

                            <p class="text-center card-text">
                                Your search returned no results.
                            </p>

                        @elseif($term != null)

                            <div class="row">

                                @foreach($data as $result)

                                    <div class="col-md-4 col-sm-12 mb-3">

                                        <div class="card mb-3 h-100" style="border-left: 5px solid green;">

                                            <div class="card-body">

                                                <p class="card-text">

                                                    <i class="fas fa-id-badge fa-fw"></i>
                                                    {{ property_exists($result, 'givenname') ? $result->givenname : null }}
                                                    {{ property_exists($result, 'middlename') ? $result->middlename : null }}
                                                    {{ property_exists($result, 'sn') ? $result->sn : null }},
                                                    {{ property_exists($result, 'initials') ? $result->initials : null }}

                                                    <br>

                                                    <i class="fas fa-user-friends fa-fw"></i>
                                                    <em>
                                                        @if($result->type == 'student')
                                                            Student {{ property_exists($result, 'department') ? $result->department : null }}
                                                        @elseif($result->type == 'employee')
                                                            {{ property_exists($result, 'department') ? $result->department : null }}
                                                            Employee
                                                        @else
                                                            Functional Account
                                                            {{ property_exists($result, 'department') ? '('.$result->department.')' : null }}
                                                        @endif
                                                    </em>


                                                    @if(property_exists($result, 'userprincipalname'))
                                                        <br>
                                                        <i class="fas fa-users-cog fa-fw"></i>
                                                        {{ substr($result->userprincipalname,0,8) }}
                                                    @endif
                                                    @if(property_exists($result, 'mail'))
                                                        <br>
                                                        <i class="fas fa-envelope fa-fw"></i>
                                                        <a href="mailto:{{ $result->mail }}">{{ $result->mail }}</a>
                                                    @endif
                                                    @if(property_exists($result, 'telephonenumber'))
                                                        <br>
                                                        <i class="fas fa-phone fa-fw"></i>
                                                        <a href="tel:{{ $result->telephonenumber }}">{{ $result->telephonenumber }}</a>
                                                    @endif
                                                    @if(property_exists($result, 'physicaldeliveryofficename'))
                                                    <br>
                                                    <i class="fas fa-map-marker-alt fa-fw"></i>
                                                    Room {{ $result->physicaldeliveryofficename }}
                                                    @endif

                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        @endif

    </div>

@endsection
