<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        <i class="fas fa-play fa-fw mr-3"></i> ProTube
        <!-- PIN //-->
        <span id="currentPin" class="float-right font-weight-bold">...</span>
    </div>

    <div class="card-body">

        <!-- Toggle & Radio Control //-->

        <div class="btn-group w-100 mb-3">

            <div class="btn-group w-50">
                <button type="button" class="btn btn-dark w-100" id="protubeToggle" id="protubeToggle">
                    ...
                </button>
            </div>

            <div class="btn-group w-50">

                <button type="button" class="btn btn-info w-75" id="shuffleRadio">
                    <i class="fas fa-random fa-fw mr-3"></i> Radio
                </button>

                <button type="button" class="btn btn-info w-25 dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>

                <div class="dropdown-menu" id="radiostationDropdown">
                    <a class="dropdown-item" href="javascript:void();">Loading...</a>
                </div>

            </div>

        </div>

        <!-- Playback Controls //-->
        <div class="btn-group w-100">

            <button type="button" class="btn btn-default w-25" id="skip">
                ...
            </button>

            <button type="button" class="btn btn-default w-25" id="playpause">
                ...
            </button>

            <button type="button" class="btn btn-default w-25" id="reload">
                <i class="fas fa-sync-alt"></i>
            </button>

            <button type="button" class="btn btn-default w-25" id="togglephotos">
                ...
            </button>

        </div>

        <hr>

        <!-- Volume Slider //-->

        <table class="table table-sm table-borderless">
            <tr>
                <td style="width: 50px;"><i class="fab fa-youtube fa-fw"></i></td>
                <td>
                    <input class="slider volumeSlider" id="youtubeV" data-slider-id="youtubeVSlider" type="text"
                           data-slider-min="0" data-slider-max="100" data-slider-step="1"/>
                </td>
            </tr>
            <tr>
                <td style="width: 50px;"><i class="fas fa-broadcast-tower fa-fw"></i></td>
                <td>
                    <input class="slider volumeSlider" id="radioV" data-slider-id="radioVSlider" type="text"
                           data-slider-min="0" data-slider-max="100" data-slider-step="1"/>
                </td>
            </tr>
            <tr>
                <td style="width: 50px;"><i class="fas fa-volume-up fa-fw"></i></td>
                <td>
                    <input class="slider volumeSlider" id="soundboardV" data-slider-id="soundboardVSlider" type="text"
                           data-slider-min="0" data-slider-max="100" data-slider-step="1"/>
                </td>
            </tr>
        </table>

    </div>

</div>

<!-- Now playing //-->
<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        <i class="fas fa-music fa-fw mr-3"></i> Now playing
    </div>

    <div id="nowPlaying" class="card-body">
        <!-- Filled by Javascript //-->
    </div>

    <div id="nowPlayingDefault" class="card-body">
        <p class="card-text text-center">
            Nothing is playing right now.
        </p>
    </div>

</div>