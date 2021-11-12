<a @if($unlocked && !$done && $url)
   href="{{ $url }}"
   @else
   disabled
   @endif
   class="list-group-item {{ $unlocked ? ($done ? 'list-group-item-primary' : null) : 'list-group-item-dark' }}"
   style="text-decoration: none !important;">

    <h5>
    <span class="me-2">
        <i class="fa-fw {{ $done ? 'fas fa-check' : $icon }}"></i>
    </span>
    {{ $heading }}
    </h5>

    @if($unlocked)
        {{ $text }}
    @endif

</a>