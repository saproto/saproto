@extends('website.layouts.redesign.generic')

@section('page-title')
    Become a member of S.A. Proto!
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    @yield('page-title')
                </div>

                <div class="card-body">
                    <p class="card-text">
                        Hi there! We're glad that you want to become a member of our association! Before we can make
                        your membership official, we need some more information. Please follow the steps below :)
                    </p>
                    <p class="card-text">
                        If you have any problems, don't hesitate to come by in the Protopolis (Zilverling A230), and ask
                        one of <a href="{{ route("page::show", ['slug' => 'board']) }}">our board members</a> to help
                        you.
                    </p>
                </div>

                <ul class="list-group list-group-flush">

                    @include('users.becomeamember_include', [
                        'url' => sprintf('%s?wizard=1', route("login::register")),
                        'unlocked' => true,
                        'done' => Auth::check(),
                        'heading' => "Create an account",
                        'icon' => "fas fa-user-plus",
                        'text' => "In order to become a member of Study Association Proto, you need a Proto account. You can create that here. After creating your account, activate it by using the link mailed to you."
                    ])

                    @include('users.becomeamember_include', [
                        'url' => Auth::check() ? sprintf('%s?wizard=1', route('user::edu::add', ['id' => $user->id])) : null,
                        'unlocked' => Auth::check(),
                        'done' => Auth::check() && Auth::user()->edu_username,
                        'heading' => "Link your UTwente account",
                        'icon' => "fas fa-university",
                        'text' => "If you are a student at the University of Twente, we would appreciate it if you would add your student account to your Proto account. If you don't study at the University of Twente, you can skip this step."
                    ])

                    @include('users.becomeamember_include', [
                        'url' => Auth::check() ? sprintf('%s?wizard=1', route('user::memberprofile::complete')) : null,
                        'unlocked' => Auth::check(),
                        'done' => Auth::check() && Auth::user()->hasCompletedProfile(),
                        'heading' => "Provide some personal details",
                        'icon' => "fas fa-id-card",
                        'text' => "To enter your in our member administration, you need to provide is with some extra information."
                    ])

                    @include('users.becomeamember_include', [
                        'url' => Auth::check() ? sprintf('%s?wizard=1', route("user::bank::add", ["id"=>$user->id])) : null,
                        'unlocked' => Auth::check(),
                        'done' => Auth::check() && Auth::user()->bank,
                        'heading' => "Provide payment details",
                        'icon' => "fas fa-euro-sign",
                        'text' => "We need your bank authorisation to withdraw your membership fee, but also your purchases within the Omnomcom and fees of activities you attend."
                    ])

                    @include('users.becomeamember_include', [
                        'url' => Auth::check() ? sprintf('%s?wizard=1', route('user::address::add', ['id' => $user->id])) : null,
                        'unlocked' => Auth::check(),
                        'done' => Auth::check() && Auth::user()->address,
                        'heading' => "Provide contact details",
                        'icon' => "fas fa-home",
                        'text' => "To make you a member of our association, we need your postal address. Please add it to your account here."
                    ])

                    @include('users.becomeamember_include', [
                        'url' => sprintf('%s?wizard=1', route('page::show', ['slug' => 'board'])),
                        'unlocked' => Auth::check() && Auth::user()->hasCompletedProfile() && Auth::user()->bank && Auth::user()->address,
                        'done' => Auth::check() && Auth::user()->member,
                        'heading' => "Become a member!",
                        'icon' => "fas fa-trophy",
                        'text' => "That's it, you've done it! Now it's up to the board to push some buttons, and make you a member. You can usually find at least one of them in the Protopolis (Zilverling A230)."
                    ])

                </ul>

            </div>

        </div>

    </div>

@endsection