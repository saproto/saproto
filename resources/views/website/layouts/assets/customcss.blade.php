<style type="text/css">

    html, body {
        background-color: #222;
    }

    #header {
        background: #333 url('{{ asset('images/application/headerbg.jpg') }}') no-repeat center center;
        background-size: cover;
        height: 400px;
        border-bottom: 15px solid #99E502;
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

    .borderless td, .borderless th {
        border: none !important;
    }

    .panel {
        border: none;
    }
    .panel .panel {
        border: 1px solid #ddd;
    }

</style>