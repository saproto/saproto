@php
    use App\Models\User;
@endphp

@if(isset($templateId))
<template id="{{$templateId}}">
    @include('event.display_includes.participant_card', ['user' => null])
</template>
@endif

@foreach ($participants as $user)
    <?php $u = $user::class == User::class ? $user : $user->user; ?>
    @include('event.display_includes.participant_card', ['user' => $u])
@endforeach
