@include('website.layouts.macros.card-bg-image', [
    'url' => route('video::view', ['id'=> $video->id]),
    'img' => $video->youtube_thumb_url,
    'html' => sprintf('<em>%s</em><br><strong><i class="fas fa-fw fa-play text-info" aria-hidden="true"></i> %s</strong>', date("M j, Y", strtotime($video->video_date)), $video->title)
])