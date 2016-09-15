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
        overflow: auto;
        padding-bottom: 120px; /* this needs to be bigger than footer height*/
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

    #footer {
        position: relative;
        margin-top: -120px;
        height: 120px;
        clear: both;
        padding-top: 20px;

        background-color: #111;
        color: #fff;
    }

    .green {
        color: #C1FF00 !important;
    }

    .white {
        color: #fff !important;
    }

    .gray {
        color: #333 !important;
    }

    .dark {
        background-color: #333 !important;
    }

    .light {
        background-color: #fafafa !important;
    }

    .member {
        height: 40px;
        line-height: 30px;
        padding: 5px 20px 5px 5px;
        text-align: left;
    }
    .member:nth-child(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }
    .member-picture {
        width: 30px;
        height: 30px;
        background-size: cover;
        background-position: center center;
        float: left;
        background-color: #333;
        border-radius: 15px;
        margin-right: 10px;
    }

</style>

<!-- Bootstrap overrides //-->
<style type="text/css">

    .borderless td, .borderless th {
        border: none !important;
    }

    .panel {
        border-width: 0;
    }

    .panel .panel {
        border-width: 1px;
    }

    .container-panel {
        background-color: #fff;
    }

    .container-panel .panel-header, .container-panel .panel-footer {
        padding: 10px 50px;
    }

    .container-panel .panel-body {
        padding: 50px;
    }

</style>

<!-- jQuery UI Theme //-->
<style>

    .ui-autocomplete {
        position: absolute;
        top: 0;
        left: 0;

        list-style-type: none;

        background-color: #fff;
        padding: 10px 0;
        border-top: 5px solid #C1FF00;

        box-shadow: 0px 0px 20px -7px #000;
    }

    .ui-menu-item {
        padding: 5px 20px;

        transition: all 0.2s;
    }

    .ui-menu-item:hover {
        background-color: rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

</style>
