@extends('website.layouts.default')

@section('page-title')
    Menu Admin
@endsection

@section('content')


    @if (count($menuItems) > 0)

        <strong class="visible-sm visible-xs" style="text-align: center;">- Some columns have been hidden because the screen is too small -</strong>

        <table class="table">

            <thead>

                <tr>

                    <th>Menuname</th>
                    <th class="hidden-sm hidden-xs">URL</th>
                    <th class="hidden-sm hidden-xs">Visibility</th>
                    <th>Controls</th>

                </tr>

            </thead>

            @foreach($menuItems as $menuItem)

                <tr>
                    <td>{{ $menuItem->menuname }}</td>
                    <td class="hidden-sm hidden-xs">{{ $menuItem->getUrl() }}</td>
                    <td class="hidden-sm hidden-xs">@if($menuItem->is_member_only) Member only @else Public @endif</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('menu::edit', ['id' => $menuItem->id]) }}" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a class="btn btn-xs btn-danger"
                           href="{{ route('menu::delete', ['id' => $menuItem->id]) }}" onclick="return confirm('Are you sure?')" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>

                        @if(!$menuItem->isFirst())
                            <a class="btn btn-xs btn-default"
                               href="{{ route('menu::orderUp', ['id' => $menuItem->id]) }}" role="button">
                                <i class="fa fa-arrow-up" aria-hidden="true"></i>
                            </a>
                        @endif

                        @if(!$menuItem->isLast())
                            <a class="btn btn-xs btn-default"
                               href="{{ route('menu::orderDown', ['id' => $menuItem->id]) }}" role="button">
                                <i class="fa fa-arrow-down" aria-hidden="true"></i>
                            </a>
                        @endif
                    </td>
                </tr>
                @if($menuItem->children->count() > 0)

                    @foreach($menuItem->children()->orderBy('order')->get() as $childItem)
                        <tr>
                            <td>&mdash;{{ $childItem->menuname }}</td>
                            <td class="hidden-sm hidden-xs">@if($childItem->page) {{ $childItem->page->getUrl() }} @else {{ $childItem->url }} @endif</td>
                            <td class="hidden-sm hidden-xs">@if($childItem->is_member_only) Member only @else Public @endif</td>
                            <td>
                                <a class="btn btn-xs btn-default"
                                   href="{{ route('menu::edit', ['id' => $childItem->id]) }}" role="button">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>

                                <a class="btn btn-xs btn-danger"
                                   href="{{ route('menu::delete', ['id' => $childItem->id]) }}" onclick="return confirm('Are you sure?')" role="button">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>

                                @if(!$childItem->isFirst())
                                    <a class="btn btn-xs btn-default"
                                       href="{{ route('menu::orderUp', ['id' => $childItem->id]) }}" role="button">
                                        <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                    </a>
                                @endif

                                @if(!$childItem->isLast())
                                    <a class="btn btn-xs btn-default"
                                       href="{{ route('menu::orderDown', ['id' => $childItem->id]) }}" role="button">
                                        <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                @endif

            @endforeach

        </table>

        <p style="text-align: center;"><a href="{{ route('menu::add') }}">Create a new menu item.</a></p>

    @else

        <p style="text-align: center;">There are no menu items. <a href="{{ route('menu::add') }}">Create a new menu
                item.</a></p>

    @endif


@endsection