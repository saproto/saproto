<div class="col-md-{{ $colsize }} col-xs-6">

    <a href="{{  route('video::view', ['id'=> $video->id])  }}"
       class="album-link">
        <div class="album"
             style="background-image: url('{!! $video->youtube_thumb_url !!}'); background-color: #555;">
            <p style="color: #fff; font-size: 50px; padding-left: 30px;">
                <i class="fa fa-play" aria-hidden="true"></i>
            </p>
            <div class="album-name">
                {{ date('M j, Y', strtotime($video->video_date)) }}<br><strong>{{ $video->title }}</strong>
            </div>
        </div>
    </a>

</div>