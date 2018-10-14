@extends('website.layouts.default-nobg')

@section('page-title')
    Become a member of S.A. Proto!
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body">
                    <p>Hi there! We're glad that you want to become a member of our association! Before we can make your
                        membership official, we need some more information. Please follow the steps below :)</p>
                    <p>If you have any problems, don't hesitate to come by in the Protopolis (Zilverling A230), and ask
                        one of <a href="{{ route("page::show", ['slug' => 'board']) }}">our board members</a> to help
                        you.</p>
                </div>
            </div>


            <div class="list-group">

                <a href="#" class="list-group-item">
                    <h4>First...</h4>
                </a>

                <a href="{{ route("login::register") }}?wizard=1"
                   class="list-group-item @if(Auth::check()) list-group-item-success becomeamember__done @endif">
                    <div class="row">
                        <div class="col-md-1 becomeamember__number">@if(Auth::check())<i class="fas fa-check"
                                                                                         aria-hidden="true"></i>@else
                                1 @endif
                        </div>
                        <div class="col-md-11 becomeamember__description">
                            <h4 class="list-group-item-heading">Create an account</h4>
                            <p class="list-group-item-text">In order to become a member of Study Association Proto, you
                                need a Proto account. You can create that here. After creating your account, activate it
                                by using the link mailed to you.</p>
                        </div>
                    </div>
                </a>

                <a href="#" class="list-group-item">
                    <h4>Then...</h4>
                </a>

                <a href="@if(Auth::check()) {{ route('user::edu::add', ['id' => $user->id]) }}?wizard=1 @else # @endif"
                   class="list-group-item @if($user && $user->edu_username) list-group-item-success becomeamember__done @endif @if(!Auth::check()) becomeamember__future @endif">
                    <div class="row">
                        <div class="col-md-1 becomeamember__number">@if($user && $user->edu_username)<i
                                    class="fas fa-check" aria-hidden="true"></i>@else 2 @endif</div>
                        <div class="col-md-11 becomeamember__description">
                            <h4 class="list-group-item-heading">Add a UTwente account your Proto account</h4>
                            <p class="list-group-item-text">If you are a student at the University of Twente, we would
                                appreciate it if you would add your student account to your Proto account. If you don't
                                study at the University of Twente, you can skip this step.</p>
                        </div>
                    </div>
                </a>

                <a href="@if(Auth::check()) {{ route('user::memberprofile::complete') }}?wizard=1 @else # @endif"
                   class="list-group-item @if($user && $user->hasCompletedProfile()) list-group-item-success becomeamember__done @endif @if(!Auth::check()) becomeamember__future @endif">
                    <div class="row">
                        <div class="col-md-1 becomeamember__number">@if($user && $user->hasCompletedProfile())<i
                                    class="fas fa-check" aria-hidden="true"></i>@else 3 @endif</div>
                        <div class="col-md-11 becomeamember__description">
                            <h4 class="list-group-item-heading">Complete your membership profile</h4>
                            <p class="list-group-item-text">To enter your in our member administration, you need to
                                provide is with some extra information.</p>
                        </div>
                    </div>
                </a>

                <a href="@if(Auth::check()) {{ route("user::bank::add", ["id"=>$user->id]) }}?wizard=1 @else # @endif"
                   class="list-group-item @if($user && $user->bank) list-group-item-success becomeamember__done @endif @if(!Auth::check()) becomeamember__future @endif">
                    <div class="row">
                        <div class="col-md-1 becomeamember__number">@if($user && $user->bank)<i class="fas fa-check"
                                                                                                aria-hidden="true"></i>@else
                                4 @endif</div>
                        <div class="col-md-11 becomeamember__description">
                            <h4 class="list-group-item-heading">Add a bank authorisation to your Proto account</h4>
                            <p class="list-group-item-text">We need your bank authorisation to withdraw your membership
                                fee, but also your purchases within the Omnomcom and fees of activities you attend.</p>
                        </div>
                    </div>
                </a>

                <a href="@if(Auth::check()) {{ route('user::address::add', ['id' => $user->id]) }}?wizard=1 @else # @endif"
                   class="list-group-item @if($user && $user->address) list-group-item-success becomeamember__done @endif @if(!Auth::check()) becomeamember__future @endif">
                    <div class="row">
                        <div class="col-md-1 becomeamember__number">@if($user && $user->address)<i class="fas fa-check"
                                                                                                   aria-hidden="true"></i>@else
                                5 @endif</div>
                        <div class="col-md-11 becomeamember__description">
                            <h4 class="list-group-item-heading">Add an address to your Proto account</h4>
                            <p class="list-group-item-text">To make you a member of our association, we need your postal
                                address. Please add it to your account here.</p>
                        </div>
                    </div>
                </a>

                <a href="#" class="list-group-item">
                    <h4>Finally...</h4>
                </a>

                <a href="{{ route('page::show', ['slug' => 'board']) }}"
                   class="list-group-item @if($user && $user->member) list-group-item-success becomeamember__done @endif @if(!Auth::check() || !($user->address && $user->bank)) becomeamember__future @endif">
                    <div class="row">
                        <div class="col-md-1 becomeamember__number">@if($user && $user->member)<i class="fas fa-check"
                                                                                                  aria-hidden="true"></i>@else
                                6 @endif</div>
                        <div class="col-md-11 becomeamember__description">
                            <h4 class="list-group-item-heading">Ask the board to make you a member of our
                                association!</h4>
                            <p class="list-group-item-text">That's it, you've done it! Now it's up to the board to push
                                some buttons, and make you a member. You can usually find at least one of them in the
                                Protopolis (Zilverling A230).</p>
                        </div>
                    </div>
                </a>

                <a href="#"
                   class="list-group-item @if($user && $user->member) list-group-item-success @endif @if(!Auth::check() || !$user->member) becomeamember__future @endif">
                    <div class="row">
                        <div class="col-md-1 becomeamember__number">@if($user && $user->member)<i class="fas fa-trophy"
                                                                                                  aria-hidden="true"></i>@else
                                7 @endif</div>
                        <div class="col-md-11 becomeamember__description">
                            <h4 class="list-group-item-heading">Hurray!</h4>
                            <p class="list-group-item-text">You are now a member of Study Association Proto! We're happy
                                that you're part of our community!</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
    </div>
    </div>
@endsection