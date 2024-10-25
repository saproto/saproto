name,committees
@foreach($export as $line)
    {{ $line->name }},{{ implode(',', $line->committees->pluck('name')->toArray()??$line->committees->toArray()) }}
@endforeach
