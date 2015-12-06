<!DOCTYPE html>
<html>

    <head>

        <title>S.A. Proto | New Website</title>

        @include('website/default/jquery')
        @include('website/default/materialize')
        @include('website/default/fontawesome')

        @include('website/default/custom')

    </head>

    <body style="display: block;">

        <div class="navbar-fixed">
            <nav>
                <div id="main-navigation" class="nav-wrapper light-green">
                    <a href="/" class="brand-logo">S.A. Proto</a>
                    <a href="#" data-activates="mobile-navbar" class="button-collapse"><i class="material-icons">menu</i></a>
                    <div id="authentication" class="right hide-on-med-and-down">
                        <a class="waves-effect waves-light btn white light-green-text" href=""><i class="fa fa-key right"></i>login</a>
                    </div>
                    <ul class="right hide-on-med-and-down">
                        @include('website/navigation/navbar')
                    </ul>
                    <ul class="side-nav" id="mobile-navbar">
                        @include('website/navigation/navbar')
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container">
        </div>

    </body>

</html>