<a href="{{ !$unlocked || $done || !$url ? 'javascript:void();' : $url}}"
   class="list-group-item {{ $unlocked ? ($done ? 'list-group-item-primary' : null) : 'list-group-item-dark' }}">

    <h5>
    <span class="mr-2">
        <i class="fa-fw {{ $done ? 'fas fa-check' : $icon }}"></i>
    </span>
    {{ $heading }}
    </h5>

    @if($unlocked)
        {{ $text }}
    @endif

</a>