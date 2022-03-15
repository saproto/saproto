name,committees
@foreach($export as $line)
{{ $line->name }},{{ implode(',', $line->committees->toArray()) }}
@endforeach