@extends('website.layouts.redesign.dashboard')

@section('page-title')
    @isset($committee)
        Create new committee
    @else
        Edit: {{ $committee->name }}
    @endisset
@endsection

@section('container')

    @php($protected = in_array($committee->id, config('proto.committee')))

    <div class="row">

        <div class="col-md-6 col-lg-4">

            @isset($committee)
                @if($protected)
                    @if(Auth::user()->can('sysadmin'))
                    <div class="alert alert-danger text-center">
                        <p>This is a protected committee. Be careful when editing!</p>
                        <small>This committee is referenced in the source code of the website.</small>
                    </div>
                    @else
                        <div class="alert alert-danger text-center">
                            <p>This is a protected committee! Editing is limited.</p>
                            <small>Please contact the <a class="text-danger font-weight-bold" href="mailto:haveyoutriedturningitoffandonagain@proto.utwente.nl">HYTTIOAOAc</a> for more information.</small>
                        </div>
                    @endif
                @endif
            @endisset

            @include('committee.include.form-committee')

        </div>

        @isset($committee)

            <div class="col-md-6 col-lg-3">
                @if(! $protected)
                    <a href="{{ route('committee::archive', ['id' => $committee->id]) }}" class="btn btn-block btn-warning mb-3">
                        <i class="fas fa-archive"></i> Archive {{ $committee->is_society ? 'Society' : 'Committee' }}
                    </a>
                @endif

                @include('committee.include.form-image')

                @include('committee.include.form-members')

            </div>

            <div class="col-lg-4">

                @include('committee.include.members-list')

            </div>

        @endif

    </div>

@endsection
