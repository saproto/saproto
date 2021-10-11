@php($name = $override_committee_name ?? $committee->name)
@include('website.layouts.macros.card-bg-image', [
            'url' =>  $committee->public || (Auth::check() && Auth::user()->can('board')) ? route( $committee->is_society ? 'society::show' : 'committee::show', ['id' => $committee->getPublicId()]) : 'javascript:void();',
            'img' => $committee->image ? $committee->image->generateImagePath(450, 300) : null,
            'html' =>
            !$committee->trashed() ?
            !$committee->public ?
            sprintf('<i class="fas fa-lock" %s></i>&nbsp;&nbsp;%s', 'data-toggle="tooltip" data-placement="top" title="This committee is hidden. You cannot see its details."', $name)
            : sprintf('<strong>%s</strong>', $name)
            : sprintf('<i class="fas fa-archive" %s></i>&nbsp;&nbsp;%s', 'data-toggle="tooltip" data-placement="top" title="This committee is archived."', $name),
            'height' => $height ?? 120,
            'classes' => !$committee->public || $committee->trashed() ? ['committee__hidden'] : null,
            'photo_pop' => $photo_pop ?? true,
            'footer' => $footer ?? null
])