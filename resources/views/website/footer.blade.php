<footer class="main-footer bg-dark text-white" style="margin: 16px 0 0 0; padding: 16px 0;">

    <div class="container">

        <div class="row vcard">

            <div class="col-3">
                <strong>
                    <span class="fa fa-home"></span>&nbsp;&nbsp;
                    <span class="org url" href="https://www.saproto.nl/"><span
                                class="green">S.A. Proto</span></span>
                </strong>
                <br>
                <span class="adr medium-text">
                    <span class="extended-address">Zilverling A230</span><br>
                    <span class="street-address">Drienerlolaan 5</span><br>
                    <span class="postal-code">7522NB</span>
                    <span class="locality">Enschede</span><br>
                </span>
            </div>

            <div class="col-3">
                <span class=" medium-text">
                    <br>
                    <span class="fa fa-clock-o"></span>&nbsp;&nbsp;Mon-Fri, 09:30-17:30<br>
                    <span class="fa fa-phone"></span>&nbsp;&nbsp;<a class="tel white" href="tel:+31534894423">+31 (0)53 489
                        4423</a><br>
                    <span class="fa fa-paperclip"></span>&nbsp;&nbsp;
                    <a class="email white"
                       href="mailto:board@proto.utwente.nl">board@proto.utwente.nl</a>
                </span>
            </div>

            <div class="col-3" style="text-align: right;">
                <a class="white" href="https://www.facebook.com/groups/SAProto/" target="_blank">
                    Facebook&nbsp;&nbsp;<i class="fa fa-facebook-official" aria-hidden="true"></i>
                </a>
                <br>
                <a class="white" href="https://www.youtube.com/channel/UCdH2x3ObOrmLdm2OOGDBslw" target="_blank">
                    YouTube&nbsp;&nbsp;<i class="fa fa-youtube" aria-hidden="true"></i>
                </a>
                <br>
                <a class="white" href="https://www.linkedin.com/company/s-a-proto/" target="_blank">
                    LinkedIn&nbsp;&nbsp;<i class="fa fa-linkedin-square" aria-hidden="true"></i>
                </a>
                <br>
                <a class="white" href="https://www.instagram.com/s.a.proto/" target="_blank">
                    Instagram&nbsp;&nbsp;<i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
                <br>
                <a class="white" href="https://www.snapchat.com/add/sa_proto" target="_blank">
                    Snapchat&nbsp;&nbsp;<i class="fa fa-snapchat-ghost" aria-hidden="true"></i>
                </a>
            </div>

            <div class="col-3" style="text-align: right;">
                <img src="{{ asset('images/logo/inverse.png') }}" height="120px">
            </div>

        </div>

        <p style="text-align: center;">
            <sub>
                &copy; {{ date('Y') }} S.A. Proto. All rights reserved. Please familiarize yourself with our
                <a href="https://wiki.proto.utwente.nl/ict/privacy/start?do=export_pdf" target="_blank" class="white">
                    privacy policy
                </a> and <a href="https://wiki.proto.utwente.nl/ict/responsible-disclosure" class="white">
                    responsible disclosure policy
                </a>.
                The website source is available on <a href="https://github.com/saproto/saproto" arget="_blank"
                                                      class="white">
                    GitHub
                </a>.
                <br>
                This website has been created with ♥ by the folks of the
                <a href="{{ route('developers') }}" class="white">
                    {{ Committee::where('slug', '=', config('proto.rootcommittee'))->first()->name }}
                </a>.
            </sub>
        </p>

    </div>
</footer>