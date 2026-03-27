name,path_to_image
@foreach ($users as $user)
    {!! $user->name !!} ,{{ \Illuminate\Support\Str::replace('http://localhost:8080', '',  $user->getFirstMediaUrl('profile_picture', 'preview')) }}
@endforeach

