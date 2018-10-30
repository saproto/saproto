@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Menu Admin
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                    <a href="{{ route('menu::add') }}" class="badge badge-info float-right">
                        Create a new menu item.
                    </a>
                </div>

                @if (count($menuItems) > 0)

                    <table class="table table-hover table-sm">

                        <thead>

                        <tr class="bg-dark text-white">

                            <td>Menuname</td>
                            <td>URL</td>
                            <td>Visibility</td>
                            <td>Controls</td>

                        </tr>

                        </thead>

                        @foreach($menuItems as $menuItem)

                            <tr class="bg-info text-white">
                                <td><i class="fas fa-folder mr-2"></i> {{ $menuItem->menuname }}</td>
                                <td>{{ $menuItem->getUrl() }}</td>
                                <td>@if($menuItem->is_member_only) <i class="fas fa-lock"></i> @endif</td>
                                <td>
                                    <a href="{{ route('menu::edit', ['id' => $menuItem->id]) }}">
                                        <i class="fas fa-edit mr-2 text-white"></i>
                                    </a>

                                    <a href="{{ route('menu::delete', ['id' => $menuItem->id]) }}" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash mr-2 text-danger"></i>
                                    </a>

                                    @if(!$menuItem->isFirst())
                                        <a href="{{ route('menu::orderUp', ['id' => $menuItem->id]) }}">
                                            <i class="fas fa-arrow-up mr-2 text-white"></i>
                                        </a>
                                    @endif

                                    @if(!$menuItem->isLast())
                                        <a href="{{ route('menu::orderDown', ['id' => $menuItem->id]) }}">
                                            <i class="fas fa-arrow-down mr-2 text-white"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @if($menuItem->children->count() > 0)

                                @foreach($menuItem->children()->orderBy('order')->get() as $childItem)
                                    <tr>
                                        <td class="pl-5">{{ $childItem->menuname }}</td>
                                        <td>@if($childItem->page) {{ $childItem->page->getUrl() }} @else {{ $childItem->url }} @endif</td>
                                        <td>@if($childItem->is_member_only) <i class="fas fa-lock"></i> @endif</td>
                                        <td>
                                            <a href="{{ route('menu::edit', ['id' => $childItem->id]) }}">
                                                <i class="fas fa-edit mr-2"></i>
                                            </a>

                                            <a href="{{ route('menu::delete', ['id' => $childItem->id]) }}" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash mr-2 text-danger"></i>
                                            </a>

                                            @if(!$childItem->isFirst())
                                                <a href="{{ route('menu::orderUp', ['id' => $childItem->id]) }}">
                                                    <i class="fas fa-arrow-up mr-2"></i>
                                                </a>
                                            @endif

                                            @if(!$childItem->isLast())
                                                <a href="{{ route('menu::orderDown', ['id' => $childItem->id]) }}">
                                                    <i class="fas fa-arrow-down mr-2"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            @endif

                        @endforeach

                    </table>

                @else

                    <div class="card-body">
                        <p class="card-text">
                            There are no menu items.
                        </p>
                    </div>

                @endif

            </div>

        </div>

    </div>


@endsection