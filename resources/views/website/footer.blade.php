<footer class="main-footer bg-dark text-white pt-3" style="position: absolute; bottom: 0; width: 100%;">

    <div class="container">

        <div class="row vcard ellipsis">

            <div class="col-md-3 col-sm-6 col-6">
                <strong>
                    <span class="fas fa-home"></span>&nbsp;&nbsp;
                    <span class="org url" href="https://www.saproto.nl/"><span
                                class="green">S.A. Proto</span></span>
                </strong>
                <br>
                <span class="adr">
                    <span class="extended-address">Zilverling A230</span><br>
                    <span class="street-address">Drienerlolaan 5</span><br>
                    <span class="postal-code">7522NB</span>
                    <span class="locality">Enschede</span><br>
                </span>
            </div>

            <div class="col-md-3 col-sm-6 col-6">
                <br>
                <span class="fas fa-clock fa-fw"></span>&nbsp;&nbsp;Mon-Fri, 09:30-17:30<br>
                <span class="fas fa-phone fa-fw"></span>&nbsp;&nbsp;<a class="tel text-white" href="tel:+31534894423">
                    +31 (0)53 489 4423
                </a><br>
                <span class="fas fa-envelope fa-fw"></span>&nbsp;&nbsp;
                <a class="email text-white"
                   href="mailto:board@proto.utwente.nl">board@proto.utwente.nl</a>
            </div>

            <div class="col-3 d-none d-lg-block" style="text-align: right;">
                <a class="text-white" href="https://www.facebook.com/groups/SAProto/" target="_blank">
                    Facebook&nbsp;&nbsp;<i class="fab fa-fw fa-facebook" aria-hidden="true"></i></a><br>
                <a class="text-white" href="https://www.youtube.com/channel/UCdH2x3ObOrmLdm2OOGDBslw" target="_blank">
                    YouTube&nbsp;&nbsp;<i class="fab fa-fw fa-youtube" aria-hidden="true"></i></a><br>
                <a class="text-white" href="https://www.linkedin.com/company/s-a-proto/" target="_blank">
                    LinkedIn&nbsp;&nbsp;<i class="fab fa-fw fa-linkedin" aria-hidden="true"></i></a><br>
                <a class="text-white" href="https://www.instagram.com/s.a.proto/" target="_blank">
                    Instagram&nbsp;&nbsp;<i class="fab fa-fw fa-instagram" aria-hidden="true"></i></a><br>
                <a class="text-white" href="https://www.snapchat.com/add/sa_proto" target="_blank">
                    Snapchat&nbsp;&nbsp;<i class="fab fa-fw fa-snapchat" aria-hidden="true"></i>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 d-none d-md-block" style="text-align: right;">
                <img src="{{ asset('images/logo/inverse.png') }}" height="120px">
            </div>

        </div>

        <p class="text-center mt-3 ellipsis">
            <sub>
                &copy; {{ date('Y') }} S.A. Proto. All rights reserved. Please familiarize yourself with our
                <a href="https://wiki.proto.utwente.nl/ict/privacy/start?do=export_pdf" target="_blank"
                   class="text-white">
                    privacy policy
                </a> and <a href="https://wiki.proto.utwente.nl/ict/responsible-disclosure" class="text-white">
                    responsible disclosure policy
                </a>.
                The website source is available on <a href="https://github.com/saproto/saproto" arget="_blank"
                                                      class="text-white">
                    GitHub
                </a>.
                <br>
                This website has been created with ♥ by the folks of the
                <a href="{{ route('developers') }}" class="text-white">
                    {{ Committee::where('slug', '=', config('proto.rootcommittee'))->first()->name }}
                </a>.
            </sub>
        </p>

    </div>
</footer>