@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Additional Inbox Management
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-lg-5 col-md-6">

            <div class="card">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                </div>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">

                            <tbody>

                                @isset($inboxes)

                                    @foreach($inboxes as $inbox)
                                        <tr>
                                            <td>
                                                <a class="btn" href="{{ route('inbox::delete', ['inbox' => $inbox || null]) }}">
                                                    <i class="fa fa-fw fas fa-minus-circle text-danger"></i>
                                                </a>
                                                <input class="form-control-sm text-right bg-dark text-white" value="{{$inbox}}" disabled> @proto.utwente.nl
                                            </td>
                                        </tr>
                                    @endforeach

                                @endisset

                                <tr>
                                    <td>
                                        <form method="post" action="{{ route('inbox::add') }}">
                                            {!! csrf_field() !!}
                                            <button class="btn" type="submit"><i class="fa fa-fw fas fa-plus-circle text-info"></i></button>
                                            <input class="form-control-sm text-right" name="new_inbox" type="text" value=""> @proto.utwente.nl
                                        </form>
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

            </div>

        </div>

    </div>

@endsection