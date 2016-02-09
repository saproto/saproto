@extends('website.default.default')

@section('content')

    <div class="container">

    @forelse($users as $user)
        <p><a href="/test/edit/{{ $user->id }}">{{ $user->name }}</a></p>
    @empty
        <h2>No users exist.</h2>
    @endforelse

    {!! $users->render() !!}

    </div>

@endsectiond