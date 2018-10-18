@include('website.layouts.macros.card-bg-image', [
            'url' => $committee->public || (Auth::check() && Auth::user()->can('board')) ? route('committee::show', ['id' => $committee->getPublicId()]) : 'javascript:void();',
            'img' => $committee->image->generateImagePath(450, 300),
            'html' => !$committee->public ? sprintf('<i class="fas fa-lock"></i>&nbsp;&nbsp;%s', $committee->name) : sprintf('<strong>%s</strong>', $committee->name),
            'height' => isset($height) ? $height : 120,
            'classes' => !$committee->public ? ['committee__hidden'] : null,
            'photo_pop' => isset($photo_pop) ? $photo_pop : true,
            'footer' => isset($footer) ? $footer : null
])