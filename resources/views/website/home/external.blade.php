@extends('website.home.shared')

@section('greeting')

    <h1>
        <strong>Welcome to Study Association Proto</strong>
    </h1>
    <h3>
        S.A. Proto is the study association for Creative Technology at the University of Twente.
    </h3>

@endsection

@section('visitor-specific')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body" style="padding: 30px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="media">
                              <div class="media-left">
                                <span class="media__icon"><i class="fa fa-3x fa-asterisk" aria-hidden="true"></i></span>
                              </div>
                              <div class="media-body">
                                <h4 class="media-heading">Prototyping</h4>
                                <p class="medium-text">Throughout the whole curriculum, Creative Technology students are faced with big ideas and little time. With project groups ranging from 2 to 15 people, this calls for dynamical schedules and different prototyping techniques. Through experience, the students learn to what extend they can develop their prototypes. From quick electrical circuits just to show that it works to advanced prototypes that only need better building materials: CreaTe students have seen it all.</p>
                                <p class="medium-text">Next to creating working prototypes with little design, students also learn to develop lo-fi prototypes to quickly test their designs on the potential user groups.</p>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media">
                              <div class="media-left">
                                  <span class="media__icon"><i class="fa fa-3x fa-asterisk" aria-hidden="true"></i></span>
                              </div>
                              <div class="media-body">
                                <h4 class="media-heading">Community</h4>
                                <p class="medium-text">One thing Creative Technology stands out for is its diverse, but close community. Students with different nationalities, experiences, interests and skills form the basis on which this community is built. Active and eager students have come together and founded Study Association Proto, which currently consists of circa 500 members and 33 committees, all held together by a full-time student board.</p>
                                <p class="medium-text">Besides organising lots of interesting activities for entertainment and/or educational purposes, the community also strengthens itself with its various ways of thinking: whether it’s more practical and technical, focused on design or art, or even business: everyone can deliver his or her input.</p>
                              </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="media">
                              <div class="media-left">
                                  <span class="media__icon"><i class="fa fa-3x fa-asterisk" aria-hidden="true"></i></span>
                              </div>
                              <div class="media-body">
                                <h4 class="media-heading">Creative</h4>
                                <p class="medium-text">
                                    Where time is always the issue, creativity most certainly is not. With knowledge of user group habits, the latest sensors, interfaces, databases and their advantages and limits, Creative Technology students learn how to connect the right dots. Thanks to many brainstorm lessons and sessions, the students know how to step outside the box and let their ideas flow, whether it is on their own or within a (multidisciplinary) project group.
                                </p>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media">
                              <div class="media-left">
                                  <span class="media__icon"><i class="fa fa-3x fa-asterisk" aria-hidden="true"></i></span>
                              </div>
                              <div class="media-body">
                                <h4 class="media-heading">Innovation</h4>
                                <p class="medium-text">Combine creativity with technical knowledge and the possibilities are endless. Now include entrepreneurial mindsets and an eye for missing products and new innovations arise. Innovation and improvement of our daily life is the key feature to a CreaTer’s philosophy.</p>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <a type="button" class="btn btn-success btn-lg btn-block" href="{{ route('page::show', ['slug' => 'board']) }}"><span class="fa fa-user"></span> Contact</a>
        </div>

        <div class="col-md-6">
            <a class="btn btn-success btn-lg btn-block" href="{{ route('event::list') }}"><span class="fa fa-calendar"></span> Activities</a>
        </div>
    </div>

    <hr>

    @include('website.home.recentphotos')

@endsection
