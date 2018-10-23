@extends('website.home.shared')

@section('greeting')

    <strong>Welcome to Study Association Proto</strong><br>
    S.A. Proto is the study association for Creative Technology at the University of Twente.

@endsection

@section('left-column')

    <div class="row row-eq-height mb-3">

        <div class="col-md-12 col-xl-6">

            <div class="card leftborder leftborder-info h-100">
                <div class="card-body">
                    <h5 class="card-title">Prototyping</h5>
                    <p class="card-text">
                        Throughout the whole curriculum, Creative Technology students are faced with big ideas and
                        little time. With project groups ranging from 2 to 15 people, this calls for dynamical schedules
                        and different prototyping techniques. Through experience, the students learn to what extend they
                        can develop their prototypes. From quick electrical circuits just to show that it works to
                        advanced prototypes that only need better building materials: CreaTe students have seen it all.
                    </p>
                    <p class="card-text">
                        Next to creating working prototypes with little design, students also learn to develop lo-fi
                        prototypes to quickly test their designs on the potential user groups.
                    </p>
                </div>
            </div>

        </div>

        <div class="col-md-12 col-xl-6">

            <div class="card leftborder leftborder-info h-100">
                <div class="card-body">
                    <h5 class="card-title">Community</h5>
                    <p class="card-text">
                        One thing Creative Technology stands out for is its diverse, but close community. Students with
                        different nationalities, experiences, interests and skills form the basis on which this
                        community is built. Active and eager students have come together and founded Study Association
                        Proto, which currently consists of circa 500 members and 33 committees, all held together by a
                        full-time student board.
                    </p>
                    <p class="card-text">
                        Besides organising lots of interesting activities for entertainment and/or educational purposes,
                        the community also strengthens itself with its various ways of thinking: whether it’s more
                        practical and technical, focused on design or art, or even business: everyone can deliver his or
                        her input.
                    </p>
                </div>
            </div>

        </div>

    </div>

    <div class="row row-eq-height mb-3">

        <div class="col-md-12 col-xl-6">

            <div class="card leftborder leftborder-info h-100">
                <div class="card-body">
                    <h5 class="card-title">Creative</h5>
                    <p class="card-text">
                        Where time is always the issue, creativity most certainly is not. With knowledge of user group
                        habits, the latest sensors, interfaces, databases and their advantages and limits, Creative
                        Technology students learn how to connect the right dots. Thanks to many brainstorm lessons and
                        sessions, the students know how to step outside the box and let their ideas flow, whether it is
                        on their own or within a (multidisciplinary) project group.
                    </p>
                </div>
            </div>

        </div>

        <div class="col-md-12 col-xl-6">

            <div class="card leftborder leftborder-info h-100">
                <div class="card-body">
                    <h5 class="card-title">Innovation</h5>
                    <p class="card-text">
                        Combine creativity with technical knowledge and the possibilities are endless. Now include
                        entrepreneurial mindsets and an eye for missing products and new innovations arise. Innovation
                        and improvement of our daily life is the key feature to a CreaTer’s philosophy.
                    </p>
                </div>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-12 col-xl-6">
            <a href="{{ route('page::show', ['slug' => 'board']) }}" class="btn btn-info btn-block">
                <i class="fas fa-user mr-2" aria-hidden="true"></i> Contact
            </a>
        </div>

        <div class="col-md-12 col-xl-6">
            <a href="{{ route("event::list") }}" class="btn btn-info btn-block">
                <i class="far fa-calendar-alt mr-2" aria-hidden="true"></i> Upcoming events
            </a>
        </div>

    </div>

@endsection
