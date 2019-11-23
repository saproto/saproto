name,primary,email,ut_number
@foreach($export as $line)
{{ $line->name }},{{ $line->primary }},{{ $line->email }},{{ $line->ut_number }}
@endforeach