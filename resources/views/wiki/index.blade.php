@php
    use App\Enums\PhotoEnum;use Illuminate\Support\Str;
@endphp

@extends('website.layouts.redesign.generic')

@section('page-title')
    Wiki | Index
@endsection

@section('container')
    <div class="row justify-content-end">
        <div class="col-lg-5 col-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header justify-content-between d-inline-flex align-items-center">
                    <div>
                        You are here:
                        <a
                            href="{{ route('wiki::index') }}"
                        >
                            wiki
                        </a>
                        @if($page)
                            @foreach(Str::of($page->full_path)->explode('/') as $part)
                                >>
                                <a
                                    href="{{ route('wiki::show', ['path'=>Str::before($page->full_path, $part).$part]) }}"
                                >
                                    {{$part}}
                                </a>

                            @endforeach
                        @endif
                    </div>
                    @if(Auth::user()->can('board') && $page)
                        <a
                            href="{{ route('wiki::admin::edit', ['path' => $page->full_path]) }}"
                        >
                            <i class="fas fa-edit me-2"></i>
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if(empty($page))
                    <h1 class="mb-2">S.A. Proto Wiki</h1>
                    @else
                        <h1 class="mb-2">{{$page->title}}</h1>
                        <hr>

                        <div class="mt-3">
                            {!! Markdown::convert($page->content) !!}
                        </div>
                    @endif

                    @if($children->isNotEmpty() && !$page?->content)
                        @if(empty($page))
                                <h3 class="mb-2">
                                    Sections within this Wiki
                                </h3>
                        @else
                                <h5>
                                    Sub pages
                                </h5>
                        @endif

                        <ul class="list-unstyled mb-0">
                            @foreach($children as $child)
                                <li class="mb-2">
                                    <a href="{{ route('wiki::show', ['path' => $child->full_path]) }}"
                                       class="text-decoration-none text-">
                                        <i class="fa-solid fa-link"></i> {{ $child->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-3">
            @if($children->isNotEmpty() && $page?->content)
            <div class="card mb-3">
                <div class="card-header">
                    Sub pages
                </div>
                <div class="card-body">
                <ul class="list-unstyled mb-0">
                    @foreach($children as $child)
                        <li class="mb-2">
                            <a href="{{ route('wiki::show', ['path' => $child->full_path]) }}"
                               class="text-decoration-none text-">
                                <i class="fa-solid fa-link"></i> {{ $child->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                </div>
            @endif
        </div>
    </div>

@endsection

