@php($name = isset($override_committee_name) && $override_committee_name ? $override_committee_name : $committee->name)
@include('website.layouts.macros.card-bg-image', [
            'url' => $committee->public || (Auth::check() && Auth::user()->can('board')) ? route('committee::show', ['id' => $committee->getPublicId()]) : 'javascript:void();',
            'img' => $committee->image ? $committee->image->generateImagePath(450, 300) : null,
            'html' => !$committee->public ? sprintf('<i class="fas fa-lock" %s></i>&nbsp;&nbsp;%s',
            'data-toggle="tooltip" data-placement="top" title="This activity is hidden. You cannot see its details."',
            $name) : sprintf('<strong>%s</strong>', $name),
            'height' => isset($height) ? $height : 120,
            'classes' => !$committee->public ? ['committee__hidden'] : null,
            'photo_pop' => isset($photo_pop) ? $photo_pop : true,
            'footer' => isset($footer) ? $footer : null
])