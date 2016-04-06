<!-- Extra style //-->
<style type="text/css">

    html, body {
        background-color: #333;
        height: 100%;
    }

    #wrap {
        min-height: 100%;
    }

    #main {
        overflow:auto;
        padding-bottom:120px; /* this needs to be bigger than footer height*/
    }

    #navbar {
        transition: all 0.5s;

    }
    .navbar-scroll {
        background-color: #222;
    }
    #navbar {
        text-shadow: 0 0 5px #000;
    }
    #navbar .dropdown-menu {
        text-shadow: none;
    }

    #header {
        background: #333 url('{{ asset('images/application/headerbg.jpg') }}') no-repeat center center;
        background-size: cover;
        height: 400px;
        border-bottom: 5px solid #C1FF00;
    }
    #header .container {
        color: #fff !important;
        padding-top: 100px;
        text-shadow: 0 0 10px #000;
        text-align: center;
    }

    #container {
        background-color: #fff;
        margin-top: -200px;
        padding: 50px;
        box-shadow: 0 0 20px;
    }
    #container.home-container {
        margin-top: 50px;
    }
    #container.container-nobg {
        background-color: transparent;
        box-shadow: none;
        padding: 15px 0;
    }

    #footer {
        position: relative;
        margin-top: -120px;
        height: 120px;
        clear:both;
        padding-top:20px;

        background-color: #111;
        color: #fff;
    }

    .green {
        color: #C1FF00 !important;
    }
    .white {
        color: #fff !important;
    }
    .dark {
        background-color: #333 !important;
    }
    .light {
        background-color: #fafafa !important;
    }

</style>

<!-- Bootstrap overrides //-->
<style type="text/css">

    .borderless td, .borderless th {
        border: none !important;
    }

    .panel {
        border-width: 0;
        box-shadow: 0px 0px 20px -7px #333;
    }
    .panel .panel {
        border-width: 1px;
    }

    .container-panel {
        background-color: #fff;
        box-shadow: 0 0 20px;
    }

    .container-panel .panel-header, .container-panel .panel-footer {
        padding: 10px 50px;
    }

    .container-panel .panel-body {
        padding: 50px;
    }

</style>